<?php
/*TODO's:
 * - transform to object oriented structure (started with APIAsker.php and BreadCrumbBuilder.php), e.g.:
 * 		- Start properly with DeltaSkin.skin.php
 * 		- DSConstants (use better name ;-)
 * 		- ConfigLoader
 * 		- DSPage with subclasses Home, Subhome, Search, Default
 * 		- Debugger
 * 		- 20141201: DONE! use APIAsker and remove function apiAskQuery() below
 * - each and every page that is being requested by this skin should be checked: if it is not a proper
 * 		VN page then the skin should retrieve a (the default? what about language?) corresponding VN page.
 * - the algorithm for page naming (page titles H1 and links to pages) is now only for H1 title ($pagename)
 * 		but should also be universally (skin-wide) applied to all places where pagetitles are used (links,
 * 		breadcrumbs, H1 title etc.)
 * */

// register another autoloader for loading classes
spl_autoload_register(function($classname){
	include_once $classname . '.php';
});

//Constants for the semantic properties used, the first 11 should be of type string
	const BANNERPROPERTY = "DS page banner";				//deltaskin specific //img file, now prepended with imgUrl //TODO
	const TITLEPROPERTY = "DS page title";					//deltaskin specific
	const ISSUBHOMEPROPERTY = "DS is subhome";				//deltaskin specific
	const SECTIONHEADERPROPERTY = "DS section header";		//deltaskin specific
	const SECTIONSMSGPROPERTY = "DS sections wikimsg";		//deltaskin specific
	const AUDIENCEMSGPROPERTY = "DS audience wikimsg";		//deltaskin specific
	const PROCESSESMSGPROPERTY = "DS processes wikimsg";	//deltaskin specific
	const PROFILELOGOPROPERTY = "DS profile logo";			//deltaskin specific //img file, now prepended with imgUrl //TODO
	const PROFILETXTMSGPROPERTY = "DS profiletxt wikimsg";	//deltaskin specific
	const MAINHEADERCLASSPROPERTY = "DS mainheaderclass";	//deltaskin specific
	const BRANDINGPROPERTY = "DS branding logo";			//deltaskin specific //img file, now prepended with imgUrl //TODO
	const CONTEXTPROPERTY = "Context";						//from EMont
	const SUPERCONTEXTPROPERTY = "Supercontext"; 			//from EMont
	const SKOSBROADERPROPERTY = "Skos:broader";				//from SKOS		//not used?
	const SKOSSCHEMEPROPERTY = "Skos:inScheme";				//from SKOS		//not used?
	const SKOSEMBROADERPROPERTY = "Skosem:broader";			//from Skosem	//used for bradcrumb
	const MODELLINKPROPERTY = "Model link";					//from VN pages
	const PARHEADINGPROPERTY = "Heading ";					//from Paragraph template, append lower case lang code!
	const TMP_BREADCRUMB = "DS tempcrumb";		//FIXME: 	Temporary hack for breadcrumb on subhome pages (just above title), should be defined of type string
															//format: wouter1:URL:wouturl1>>wouter2:URL:wouturl2
	//for new breadcrumb
	const PARTOFPROPERTY = "Part of";						//from EMont
// 	const SELECTLINKPROPERTY = "Selection link";			//from EMont select practices?
// 	const PRACTICEBACKLINKPROPERTY = "Practice back link";	//from EMont ?

//Other constants used
	const HOMEPAGE = "Home";
	const SEARCHPAGE = "Zoeken";

//Language
	$lng = $this->getSkin()->getLanguage();					//lng object, used in header.php (service nav lang link)

//URLS
	$indexUrl = $this->data["wgScript"];
	$skinUrl = dirname($this->getSkin()->getSkinStylePath(""));	//$this->data['stylepath']."/".$this->data['stylename'];
	$imgUrl = $skinUrl . "/img";
	$bannerUrl = $imgUrl . "/banners";

//Servicenav definition
	$servicenav = array(wfMessage( 'deltaskin-home' )->text(),
		wfMessage( 'deltaskin-about' )->text(),
		wfMessage( 'deltaskin-help' )->text(),
		wfMessage( 'deltaskin-contact' )->text(),
		wfMessage( 'deltaskin-sitemap' )->text()
	);

//Load deltaskin specific configuration properties for this page
	$pagename = $this->data['title'];	//used below and in defaultpage.php, maybe altered below
	$config = loadDeltaskinConfigProperties($pagename);
	
	//hack to enable reusability of the search engine
	$searchconfigfile = wfMessage( 'deltaskin-searchconfigfile' )->plain();		//used in search/search_settings.php (external project...)
	
	//set site logo
	global $wgLogo; 														//default logo from LocalSettings.php
	if($siteLogoFileName = wfMessage( 'deltaskin-sitelogo' )->plain()){
		$wikiImageUrl = APIAsker::getInstance()->queryImageUrl($siteLogoFileName);
		if($wikiImageUrl) 	//override default logo with given thing
			$wgLogo = $wikiImageUrl;
		else
			wfDebug("DELTASKIN: (sitelogo) error: $siteLogoFileName is not a valid uploaded wiki image.");
	}
	
	//banner selection
	$banner = getBanner($this->data['title'], $bannerUrl);
	if($banner)
		$banner = "style=\"background-image: url('".$banner."');\"";
	else{	//defaultbanner from mediawiki system message
		if($defaultBanner = wfMessage( 'deltaskin-default-banner')->plain()){
			$uploadedDefaultBanner = APIAsker::getInstance()->queryImageUrl($defaultBanner);
			$banner = ($uploadedDefaultBanner) ? $uploadedDefaultBanner : $bannerUrl."/".$defaultBanner;
			$banner = "style=\"background-image: url('".$banner."');\"";
		}
		else 
			$banner="";		//for now: fallback to the banner in the css... TODO: ask norman to remove it.
	}
	
//Determine page type and load additional configuration
	if( $this->data['title'] == HOMEPAGE )			//TODO multi language?
	{
		$home = true;						//homepage indicator, this var is used in Deltaskin.skin.php
		$sections = getNavBlocks($config, $pagename, $this->getSkin(), SECTIONSMSGPROPERTY);
		$audience = getNavBlocks($config, $pagename, $this->getSkin(), AUDIENCEMSGPROPERTY);
		$processes = getNavBlocks($config, $pagename, $this->getSkin(), PROCESSESMSGPROPERTY);
	}
	elseif( $this->data['title'] == SEARCHPAGE )		//TODO multi language?
	{
		$search=true;
	}
	else
	{
		//Is this page subhome?
		$subhome = getConfigPropertyValue($config, $pagename, ISSUBHOMEPROPERTY); 	//FIXME: false will not work
		$breadCrumbBuilder = new BreadCrumbBuilder();
		if($subhome)
		{
			$sections = getNavBlocks($config, $pagename, $this->getSkin(), SECTIONSMSGPROPERTY);
			$audience = getNavBlocks($config, $pagename, $this->getSkin(), AUDIENCEMSGPROPERTY);

			//set sectionHeader, used in header.php
			$sectionHeader = getConfigPropertyValue($config, $pagename, SECTIONHEADERPROPERTY);
			if(!$sectionHeader)
				$sectionHeader = str_replace(" VN", "", $pagename);
			$sectionHeader = '<h1 id="sectionHeader">'.$sectionHeader.'</h1>';

			//set mainHeaderclass, used in header.php, TODO: remove since not used anymore, was used for deltares landing page
			$mainHeaderclass = getConfigPropertyValue($config, $pagename, MAINHEADERCLASSPROPERTY);
			if($mainHeaderclass)
				$mainHeaderclass = "class=\"".$mainHeaderclass."\"";

			//set profile logo if present
			$profilelogo = getConfigPropertyValue($config, $pagename, PROFILELOGOPROPERTY);
			$profilemsg = getConfigPropertyValue($config, $pagename, PROFILETXTMSGPROPERTY);
			if($profilelogo && $profilemsg)
			{
				$sectionHeader = '<h1 id="sectionHeader"></h1>';
				$h2profile = "
						<h2 id='profile'>
							<img src='".$imgUrl."/".$profilelogo."'/>
							<p>".wfMessage($profilemsg)->text()."</p>
						</h2>
						";
			}
		}
		else{ 		//if not subhome, do breadcrumb generation:
			$breadCrumbTrails = $breadCrumbBuilder->getBreadCrumbs($this->data['title']);
		}

 		//FIXME Temporary breadcrumb hack for going live, summer 2014, see header.php
		$tempBreadCrumb2 = $breadCrumbBuilder->getTmpBCHack( getConfigPropertyValue($config, $pagename, TMP_BREADCRUMB) );
	}

	if($home)										//if on home page
		echo '<div id="canvas" class="index">';			//for big banner (height 340px)
	elseif($subhome)								//elseif on subhome page
	{
		if( $subhome == "landing" ) $landing = " landingspagina";
		echo "<div id=\"canvas\" class=\"index$landing\">";			//for big banner (height 340px)
	}
	else
	{	 											//else
		echo '<div id="canvas">';						//for less big banner (height 212px)
	}

	//is user logged in? o is closed lock, p is open lock
	if($this->data['loggedin'])		//$this->getSkin()->getUser()->mId > 0
		$lockIcon = "p";
	else
		$lockIcon = "o";

	//$pagename used in defaultpage.php, in some cases altered below.
	$pagename = setPageTitle($pagename, $config, $lng->mCode);

/////////////////////////////////// FUNCTIONS ///////////////////////////////////////////
	/**
	 * Function to set the page title. It is set to the semantic property TITLEPROPERTY,
	 * if set. Else the value of property 'Heading <languagecode>' is returned, where
	 * <languagecode> is the current language code (e.g. nl by default). Query used for the
	 * latter: e.g. [[-Model link::Waterveiligheid VN]]|?Heading nl
	 *
	 * @author WME 201411
	 * @param $pagename	string containing the current wiki page title ($this->data['title'])
	 * @param $config	the config array from loadDeltaskinConfigProperties()
	 * @return string	containing the possibly altered $pagename.
	 */
	function setPageTitle($pagename, $config, $langCode){
		if( $ptpropval = getConfigPropertyValue($config, $pagename, TITLEPROPERTY) )
			$pagename = $ptpropval;
		else{		//FIXME: this code snippet is duplicated in BreadCrumbBuilder::getBreadCrumbs()
			$parheadpluslang = PARHEADINGPROPERTY.strtolower($langCode);
			//get value(s!) of MODELLINKPROPERTY on page $pagename
			$query = "[[-".MODELLINKPROPERTY."::".$pagename."]]|?".$parheadpluslang;
			$result = APIAsker::getInstance()->ask($query);
			$result = array_shift($result['query']['results']);
			$paragraphHeading = $result['printouts'][$parheadpluslang][0];
			if($paragraphHeading)
				$pagename = $paragraphHeading;
		}

		//remove VN suffix if present in page name
		$pagename = str_replace(" VN", "", $pagename);

		return $pagename;
	}

	/**
	 * This function searches for banner property values in the page and its context closure.
	 * It returns the first one in row for now 		(TODO finishing: add selection logic, ask BB)
	 *
	 * @author WME 20140324
	 * @param String $page the title of the page to get a banner for
	 * @return a filename which can be used as banner (it should be prefixed with $bannerUrl),
	 * 			or nothing/null/false
	 */
	function getBanner($page, $bannerPath)
	{
		//determine context closure of $page, include $page itself too
		$clos = array($page);
		getContextClosure($page, $clos);
		//get values of banner properties in closure (max one per page!)
		$banners = array();
		$query = "[[".implode(']] OR [[', $clos) . "]]";
		$query = $query."|?".BANNERPROPERTY;
		$result = APIAsker::getInstance()->ask($query);
		foreach($result["query"]["results"] as $pagina)
		{
			if($bannerFileName = $pagina["printouts"][BANNERPROPERTY][0]){		//als property niet als String type gedefinieerd: gaat fout!
				// er wordt alleen gekeken naar de eerste occurence van banner property (dus max 1 def heeft zin).
				$wikiImageUrl = APIAsker::getInstance()->queryImageUrl($bannerFileName);
				$banners[] = ($wikiImageUrl) ? $wikiImageUrl : $bannerPath."/".$bannerFileName;
			}
		}
		return $banners[0];		//return the first one for now
								//Note that, if present, that is the value of BANNERPROPERTY of the current page (see first code line).
	}

	/**
	 * This function recursively determines the entire context closure of the given $element.
	 * After recursion ends, the given $closure array will contain the context closure.
	 *
	 * The context closure of an element is defined as the set of all (recursively) related
	 * contexts (related either through semantic property ?Context for Intentional Element
	 * elements or property ?Supercontext for Context elements).
	 *
	 * @author WME 20140324
	 * @param String $element	The element (page) of which the context closure will be determined
	 * @param array $closure	The array to which all closure elements are added
	 * 							(pass by ref since it is expanded). This should
	 * 							typically take an empty array.
	 */
	function getContextClosure($element, &$closure)
	{
		$query = "[[$element]]|?".CONTEXTPROPERTY."|?".SUPERCONTEXTPROPERTY;	//get Context and Supercontext property of $element
		$result = APIAsker::getInstance()->ask($query);
		$result = $result['query']['results'][$element]['printouts'];
		$neighbours = array_merge($result[CONTEXTPROPERTY], $result[SUPERCONTEXTPROPERTY]);
		foreach ($neighbours as $neighbour)
		{
			if( !in_array($neighbour["fulltext"], $closure) )
			{
				$closure[] = $neighbour["fulltext"];
				getContextClosure($neighbour["fulltext"], $closure);
			}
		}
	}

	/**
	 * Load all deltaskin specific configuration properties (semantic properties)
	 * @author WME
	 * @return associative array with the result
	 */
	function loadDeltaskinConfigProperties($pagename){
		//query for all deltaskin configuration properties (should be of type String!)
		$query = "[[".$pagename."]]".
				"|?".TITLEPROPERTY.
				"|?".SECTIONSMSGPROPERTY.
				"|?".AUDIENCEMSGPROPERTY.
				"|?".PROCESSESMSGPROPERTY.
				"|?".ISSUBHOMEPROPERTY.
				"|?".SECTIONHEADERPROPERTY.
				"|?".MAINHEADERCLASSPROPERTY.
				"|?".PROFILELOGOPROPERTY.
				"|?".PROFILETXTMSGPROPERTY.
				"|?".BRANDINGPROPERTY.
				"|?".TMP_BREADCRUMB;
		//execute query
		$result = APIAsker::getInstance()->ask($query);
		return $result;
	}

	/**
	 * Get navigation blocks from a mediawiki system message (support for multilanguage)
	 * The name of the system message is retrieved using the given semantic property
	 * @author WME
	 * @param array $config
	 * @param string $pagename
	 * @param IContextSource $ctx
	 * @param string $property
	 * @return array or NULL
	 */
	function getNavBlocks($config, $pagename, $ctx, $property){
		$msgWithBlockContent = getConfigPropertyValue($config, $pagename, $property);
		if($msgWithBlockContent)
			return $ctx->addToSidebarPlain($sections, wfMessage( $msgWithBlockContent )->plain() );
		else
			return null;
	}

	/**
	 * Returns the value of the given property in the given config array
	 * @author WME
	 * @param array $config the result of the semantic query to load config
	 * @param string $pagename
	 * @param string $property
	 */
	function getConfigPropertyValue($config, $pagename, $property){
		return $config['query']['results'][$pagename]['printouts'][$property][0];
	}

	include 'debug.php';
?>
