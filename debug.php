<?php
if(isset($_GET['stop'])) //for debugging, end querystring with '?stop' or '&stop'
{
	echo "DEBUGGING\n<pre>";
	echo $indexUrl."<br>";
	echo $skinUrl."<br>";
	echo $imgUrl."<br>";
	echo $bannerUrl."<br>";
	
	//echo "SECTIONS:";
// 	var_dump($sections);
	echo "BLOCKDATA: ";
	var_dump($blockdata);
	
	echo "PROCESSES: ";
	echo PROCESSESMSGPROPERTY."\n";
	var_dump($processes);
	
	echo "MOREBLOCKS: ";
	echo MOREBLOCKSMSGPROPERTY;
	var_dump($moreblocks);
	
	//testing calling the api
	//all pages with half-height Waterveiligheidsbanner
// 	global $wgLocalStylePath, $wgFavicon, $wgAppleTouchIcon;
// 	echo $wgFavicon;// = $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].$wgFavicon;
// 	echo $wgAppleTouchIcon;
// 	http://localhost/~woutereverse/devwiki/api.php?action=ask&query=[[Supercontext::Waterveiligheid%20VN]]&format=json
// 	$apiUrl = "http://".$_SERVER['HTTP_HOST'].dirname($indexUrl)."/api.php";
// 	$apiAction = "ask";
// 	$query = urlencode("[[Supercontext::Waterveiligheid VN]]");
// 	$apiFormat = "json";
// 	var_dump($apiCall = "$apiUrl?action=$apiAction&query=$query&format=$apiFormat");
// 	$result = file_get_contents($apiCall);
// // 	var_dump($result);
// 	var_dump(json_decode($result));
// 	print_r(dirname($indexUrl)."\n");
// 	print_r($imgUrl."\n");
// 	echo $skinUrl."\n";
// 	echo $subRubric;
// 	echo dirname($this->getSkin()->getSkinStylePath()) . "\n";
// 	echo $this->getSkin()->getSkinStylePath("") . "\n";
// 	SpecialPage::getTitleFor( 'Userlogin' )->getLocalURL();
// 	var_dump($this->getSkin());
// 	var_dump($this->getSidebar());
// 	$this->msg( 'tagline' );
// 	echo wfMessage( 'deltaskin-nav1' )->text();
// 	echo "<br/>";
// 	echo wfMessage( 'submit' )->text();
// 	echo "<br/>";
// 	$this->html( 'subtitle' );
// 	$bar = $this->getSkin()->addToSidebarPlain( $bar, "* test" );
// 	$bar = $this->getSkin()->addToSidebarPlain( $bar, wfMessage( 'deltaskin-nav1-links' )->inContentLanguage()->plain() );
// 	$bar = $this->getSkin()->addToSidebar( $bar, 'submit' ); //werkt niet meer? zou zelfde als hierboven moeten zijn
// 	var_dump($bar);
// 	echo $this->getSkin()->getCategories(); //skin div for getting category sections
// 	if(in_array("Rubriek", $this->getSkin()->getOutput()->getCategories())){
// 		echo "rubriekpagina!";
// 	}
	
	//getTrailParents([$this->data['title']]);
// 	echo "getBreadCrumb() call";
// 	getBreadCrumb($this->data['title']);

// $fs = spl_autoload_functions ();
// print_r($fs);
// 	spl_autoload_register(function($classname){
//  		include_once $classname . '.php';
// 	});

// 	include "BreadCrumbBuilder.php";
	$debuggingBreadCrumbBuildr = new BreadCrumbBuilder(true);	//create a breadcrumbbuilder in debug mode
// 	$breadcrumbies = $debuggingBreadCrumbBuildr->getNaiveSimpleBC($this->data['title']);
// 	print_r($breadcrumbies);

	$breadCrumbTrailies = $debuggingBreadCrumbBuildr->getBreadCrumbs($this->data['title']);
	echo "Breadcrumb trails:"; print_r($breadCrumbTrailies);
// 	echo "BCTs: "; print_r($breadCrumbTrails);
// 	print_r($this->getSkin()->getWikiPage());
// 	$this->msg( 'ds_' . $this->data['title']);
// 	print_r($this->data['nav_urls']);
// 	var_dump($GLOBALS);
// 	$this->getSkin()->getContext()->setLanguage('nl');
// 	print_r($lng = $this->getSkin()->getLanguage());
// 	print_r($lng);
// 	$lng->capitalizeAllNouns();
// 	print_r($wgLang);
// 	print_r($this->data['language_urls']);
// 	print_r(get_class_methods($this->getSkin()));
// 	print_r($this->getSkin()->getUser()->mId);
// 	var_dump($this->data);
//  	var_dump($this->getSkin());
// 	global $wgScriptPath, $wgLocalStylePath;
// 	echo $wgScriptPath."\n";
// 	echo $wgLocalStylePath."\n";
// 	echo $_SERVER['PHP_SELF']."\n";
// 	var_dump($_SERVER);
// 	echo $this->data['title'];
// 	var_dump($this->data['headelement']);
	//$this->html( 'title' );
// 	echo $GLOBALS['wgStylePath']."\n";
// 	echo $GLOBALS['wgStyleDirectory'];
	// 	$this->html() en $this->title() zijn functies die keys uit de $this->data array afdrukken.
// 	 	print_r($GLOBALS);
	echo "<pre>";
	exit;
}
?>
