<?php

/**
 * Class for building breadcrumb trails, which are somewhat complicated, given the expertise model.
 * It also holds the previous naive way to generate the breadcrumb trail, as well as the 
 * temporary breadcrumb hack
 * 
 * Known issue: the algorithm generates a lot of breadcrumb trails for pages that are not part 
 * of EMont entities...? It should generate nothing! 
 * UPDATE: Solved: See if(!$page)return; in $this->getBreadCrumbs($page)
 * 
 * @author WME 201411
 */
class BreadCrumbBuilder
{
	private $askAPI;
	private $recCnt;
	private $debugging;
	
	public function __construct($debugging=false){
		$this->askAPI = APIAsker::getInstance();
		$this->recCnt = 0;
		$this->debugging = $debugging;
	}
	
	//FIXME, and delete (old simple naive breadcrumb)
	public function getNaiveSimpleBC($page){
		$breadcrumbs = array();			//used in defaultpage.php
		$query = "[[".$page."]]|?".SKOSSCHEMEPROPERTY."|?".CONTEXTPROPERTY."|?".SKOSEMBROADERPROPERTY;
		$result = $this->askAPI->ask($query);
		$result = $result['query']['results'][$page]['printouts'];
		foreach($result as $prop)
		{
			foreach($prop as $inst)
			{
				$name = str_replace(" VN", "", $inst["fulltext"]);
				if($name=="Waterveiligheid") $name="Hoogwaterbescherming";	//FIXME dirty hack
				$breadcrumbs[$name] = $inst["fullurl"];
			}
		}
		return $breadcrumbs;
	}
	
	//FIXME, and delete
	public function getTmpBCHack($tempBreadCrumb){
		//FIXME Temporary breadcrumb hack for going live, summer 2014, see header.php
		//format: wouter1:URL:wouturl1>>wouter2:URL:wouturl2
		$tempBreadCrumb = explode(">>", $tempBreadCrumb);
		foreach($tempBreadCrumb as $labelurl){
			list($l,$u) = explode(":URL:", $labelurl);
			if($l && $u) $tempBreadCrumb2[$l] = $u; //this array is used in header.php
		}
		return $tempBreadCrumb2;
	}
	
	/**
	 * This function recursively (depth-first) determines all paths (trails) to
	 * the 'root' in the DAG that is formed by the EMM content based on EMont
	 * elements (wiki pages).
	 *
	 * A trail is defined as a sequence (array) of EMont elements (nodes)
	 * The parents of a trail are defined as the parents of the last node in the trail
	 * The parents of a node are defined as the connected elements through certain
	 * properties (see documentation of the getNodeParents() function).
	 *
	 * This function is used for bread crumb generation: this starts with a trail
	 * with only one node (representing the page currently being viewed)
	 *
	 * (Add to array using []= since array_push() causes call overhead (php manual))
	 *
	 * Algorithm:
	 * 1. get last $node of given trail
	 * 2. get its parents
	 * 3. a. if no parents: add finished trail to trail set
	 *    b. else foreach parent: clone the trail, add parent to it and call getTrails recursively.
	 *
	 * Optimization: first check for parents that are Practices (pointing to $node as a context).
	 * At first, this was part of getNodeParents() but a Context may be skipped in the trail if
	 * there are practices pointing to it.
	 *
	 * @author WME 201410-201411
	 * @param Node array $trail	an array of nodes, representing the trail to start with
	 * @param array $trails		an array that eventually contains all trails to the 'root' (passed
	 * 								by reference)
	 */
	private function getTrails($trail, &$trails)
	{
		$this->recCnt++;
		//pop last element of the trail
		$node = array_pop($trail);
		
		if($this->recCnt > 100){	//TODO: make recursion detection less naive 
			if($this->debugging)
				echo "Over 100 recursion loops detected, aborting.";
			return;
		}

		 if($this->debugging)
			echo $node->getName()."\n";

		//if $node is a context with practice(s) pointing to it (through their context prop),
		//find these practices and let them replace $node in the trail.
		$query = "[[Category:Practice]][[Context::{$node->getName()}]]";
		$result = $this->askAPI->ask($query);
		$result = $result['query']['results'];
		if(is_array($result) && count($result) > 0){
			//NB: all practices (parents) found will have $node as breadcrumb value.
			$parents = $this->getNodesFromQueryResult($result, $node);	//practices found are the parents
		}
		else{	// $node is not a Context to which practices are pointing
			$parents = $this->getNodeParents($node);		//try to find parents through other ways (this may change $node!)
			$trail[] = $node;								//push the node back on the trail
		}
	
		if(count($parents) > 0)								//if parents found:
		{
			foreach ($parents as $parent)					//foreach parent element found, do:
			{
				$trailClone = $trail;						//clone the trail (this is not a ref, but a real clone in php!)
				$trailClone[] = $parent;					//add the parent element to the cloned trail
				$this->getTrails($trailClone, $trails); 	//recursive call
			}
		}
		else{	//finished trail, no parents left.
			$trails[] = $trail;								//add to trails collection
		}
	}
	
	/**
	 * Get the parents of a node (selected by certain semantic properties), which
	 * are defined as follows:
	 *
	 * Algorithm to find parents of a $node:
	 * If $node is an IE with part-of prop value(s): these values are its parents
	 * ElseIf $node is an IE with Context prop value(s): these values are its parents
	 * ElseIf $node is a Context:
	 * 	 If $node has Supercontext prop value(s): these values are its parents
	 *   ElseIf $node is a Practice with Part-of prop value(s):  these values are its parents
	 *   Else $node has no parents.
	 *
	 * NB: For optimization purposes, it is already checked in the caller whether this $node
	 * is a Context with Practices pointing to it, that is not the case if this function is called.
	 * 
	 * NB2: In the case $node being a practice which has a part-of, this function also sets the 
	 * correct breadcrumb value of $node. 
	 *
	 * @author WME 201410-201411
	 * @param Node &$node	a Node object (representing a wiki page), passed by ref for its
	 * 						breadcrumb value may change
	 * @return Node array	containing the parent nodes found
	 */
	private function getNodeParents(&$node)
	{
		// It is already checked in the caller whether this $node is a context with Practices
		// pointing to it, that is not the case since this function is called.
	
		// Is $node an IE with Part-of, skosembroader or Context prop?
		$query = "[[Category:Intentional Element]][[{$node->getName()}]]|?".PARTOFPROPERTY."|?".SKOSEMBROADERPROPERTY."|?".CONTEXTPROPERTY;
		//FIXME: SKOSEMBROADER should be SKOSBROADER, but will not work in printout section, use page selection part, possibly reversed query for the prop? prop::thispage?
		$result = $this->askAPI->ask($query);
		if(count($result['query']['results']) > 0){
			$result = $result['query']['results'][$node->getName()]['printouts'];
			
			/* EXPERIMENTAL! JIRA EMT-276 Background: if there are contexts (of this IE $node), they  
			 * should be prefered (before taking partofs and skosembroaders into account) 
			 * TODO WME: discuss with HdB*/
			$parents = $this->getNodesFromQueryResult($result[CONTEXTPROPERTY]);
			
			if(count($parents) == 0){	
				$parents = $this->getNodesFromQueryResult($result[PARTOFPROPERTY]);
			}
			if(count($parents) == 0){
				$parents = $this->getNodesFromQueryResult($result[SKOSEMBROADERPROPERTY]);
			}
		}
		else{
			//not an IE and no practices pointing to it, is it a context which has a supercontext?
			$query = "[[Category:Context]][[{$node->getName()}]]|?".SUPERCONTEXTPROPERTY;
			$result = $this->askAPI->ask($query);
			if(count($result['query']['results']) > 0){
				$result = $result['query']['results'][$node->getName()]['printouts'];
				$parents = $this->getNodesFromQueryResult($result[SUPERCONTEXTPROPERTY]);
			}
			else{	//no: is it a practice which has a part-of?
				//NB add contextproperty for breadcrumb fixing, see below
				$query = "[[Category:Practice]][[{$node->getName()}]]|?".PARTOFPROPERTY."|?".CONTEXTPROPERTY;
				$result = $this->askAPI->ask($query);
				if(count($result['query']['results']) > 0){
					$result = $result['query']['results'][$node->getName()]['printouts'];
					//breadcrumb fixing: if this node has breadcrumb value "practice" then replace it by a list 
					//of Context property values (there may be more than one Context value, isn't it?)
					if($node->getBreadCrumb() == "practice")
						$node->setBreadCrumb($this->getNodesFromQueryResult($result[CONTEXTPROPERTY]));
					$parents = $this->getNodesFromQueryResult($result[PARTOFPROPERTY], "practice");
				}
				// else: NO PARENTS FOUND
			}
		}
		return $parents;	//return array with parent elements found
	}
	
	/**
	 * Helper function to put each 'fulltext' and 'fullurl' value in the given 
	 * property result (printouts part of a query using the ASK api) into an 
	 * array of nodes. Optionally set the breadcrumb value for each node.
	 *
	 * NB: a property may be defined multiple times and therefore may contain 
	 * multiple values for the 'fulltext' and 'fullurl' elements (hence the foreach).
	 *
	 * @author WME 201411
	 * @param array $propResult	The result array (or no array if no result) of querying
	 * 							a property
	 * @param Node $node		Optional Node object to set as the breadcrumb value for 
	 * 							all returned nodes
	 * @return Node array		an array of Node objects corresponding to the given query
	 * 							result part
	 */
	private function getNodesFromQueryResult($propResult, $node=null){	
		if(is_array($propResult)){
			foreach ($propResult as $value){
				 $values[] = new Node($value['fulltext'], $value['fullurl'], $node);
			}
		}
		return $values;
	}
	
	/**
	 * Breadcrumb Visualizer
	 * //TODO DOC!
	 * NB a trail of breadcrumbs is a recursive structure: a trail of so-called nodes, each node having a 
	 * breadcrumb value. This is either a single node or an array of nodes, in both cases a node may 
	 * refer to itself (due to the complex content structure)
	 *
	 * @author WME201411
	 * @param string $page	the page to construct the breadcrumbtrails for
	 */
	public function getBreadCrumbs($page){
		if(substr($page, -3) == " VN"){
			$query = "[[$page]]|?".MODELLINKPROPERTY;
			$result = $this->askAPI->ask($query);
			$page = $result['query']['results'][$page]['printouts'][MODELLINKPROPERTY][0]['fulltext'];
		}
		
		if(!$page)
			return;	//if page is empty or not set, quit.
		
		//create empty trailset
		$trailset=array();
		
		//fill trailset
		$this->getTrails( array( new Node($page, false) ), $trailset);
		
		//extract the bread crumb trails from the trails found
		foreach($trailset as $trail){
			$bcTrail = array();											//start with an empty array!
			foreach($trail as $node){
				$bc = $node->getBreadCrumb();							//NB bc may be an array
				if( is_array($bc) )
					$bc = $bc[0];	//assume there is only one! FIXME?: use all? -But a practice always has at most one context
				if(is_a($bc, "Node") && $bc->getUrl()){					//the starting $node has value false for url (see getTrails call a few lines above) 
					$name = $bc->getName();
					$url = $bc->getUrl();

					//change to VN url if available
					$query = "[[".MODELLINKPROPERTY."::$name]]";		//get all (VN) pages that refer to this page through MODELLINK
					$result = $this->askAPI->ask($query);				//check with code Thijs (search engine, how VN's are found)
					$result = array_pop($result['query']['results']);	//assume there is only one (always take first VN page found)
					if($result){
						$url = $result['fullurl'];
					}
					
					//Change name to 'heading <lng>' property value, if available
					//FIXME: this is duplicate code, from function setPagetitle() in helper.php 
					//Mooiere oplossing: zie todo regel 12 helper.php: elke link die de skin laat zien moet door het page naming algorithm worden gehaald
					$langCode="NL";
					$page = $name;
					$parheadpluslang = PARHEADINGPROPERTY.strtolower($langCode);
					$query = "[[".$page."]]|?".$parheadpluslang; 	//get value(s!) of heading property on page $pagename
					$result = APIAsker::getInstance()->ask($query);
					$result = array_shift($result['query']['results']);
					$paragraphHeading = $result['printouts'][$parheadpluslang][0];
					if($paragraphHeading)
						$name = $paragraphHeading;
					
					$bcTrail[$name] = $url;								//this eliminates doubles in the bcTrail! That's a good thing!
				}
			}
			if( !in_array(array_reverse($bcTrail), $bcTrailSet) )
				$bcTrailSet[] = array_reverse($bcTrail);
		}

		/*FIXME/TODO some thoughts:
		- l. {$bcTrail[$name] = $url;} eliminates doubles in $bcTrail (by page name): however: structures with doubles are wrong models? Notification of this?
		- l. is_a() needed because of Ontwerpen van een kleidijk (Activity), see textEdit, $bc may still contain: "practice"
		- l. {$bcTrail = array();} is very important: start looping over nodes with an empty array!
		- this code may also result in empty arrays $bcTrail in $bcTrailSet... (e.g. Building_with_Nature_interventies_VN)
		- also tested with (incl VN): Delta-ecosysteem, Ameland, Waterkering, Zeeweringen_Begrippen_VN
		- VN checking of links should be done automatically and generally for all links by the skin (i.e. for search results too, etc?)
		- page naming algorithm should be used for linklabels too
		- prevent doubles in the trailset bij the finishing if(!array())...?
		- Moet er nog in volgens bauke: broader en part-of  - Duinsuppletie - hans? for now: used SKOSEMBROADER property, see getNodeParents()
		- ...
		*/
		
		return $bcTrailSet;
	}
}
?>
