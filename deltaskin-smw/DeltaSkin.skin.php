<?php
/**
 * Skin file for skin Delta Skin.
*
* @file
* @ingroup Skins
* @author Wouter M. Everse (http://www.hz.nl)
*/


/**
 * SkinTemplate class for Delta Skin skin
 * @ingroup Skins
 */
class SkinDeltaSkin extends SkinTemplate {

	var $skinname = 'deltaskin', $stylename = 'deltaskin',
	$template = 'DeltaSkinTemplate', $useHeadElement = true;

	
	
	/**
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ){
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( "skins.deltaskin" );
	}

	public function initPage( OutputPage $out ) {
		global $wgLocalStylePath, $wgFavicon;
		parent::initPage($out);

// 		global $wgAppleTouchIcon;
// 		$httpurl = "http://".$_SERVER["HTTP_HOST"];
// 		$wgAppleTouchIcon[] = $httpurl.dirname($this->getSkin()->getSkinStylePath("")) . "/apple-touch-icon.png";
				
//ICONS SHIZZLE	
		$ICON = "icon";
		$linkRelIconsAndSizes = array(	//WME: assumed square icons
				"apple-touch-icon" => array("57", "60", "72", "76", "114", "120", "144", "152", "180"),
				$ICON => array("32", "194", "96","192", "16")
		);
		//TODO: find out how to use getSkinStylePath(), we now need to pass "" to prevent warnings...
		$urlpath = dirname($this->getSkin()->getSkinStylePath("")) ."/icons/";
		foreach($linkRelIconsAndSizes as $iconType => $sizes){
			foreach($sizes as $size){
				$sizeString = $size ."x". $size;
				$hrefString = $iconType ."-". $sizeString .".png";
				$attributes = array("rel"=>$iconType, "sizes" => $sizeString, "href" => $hrefString);
				if($iconType==$ICON){	//little tweaking :)
					$attributes["type"] = "image/png";
					if($size==192)
						$attributes["href"] = str_replace($ICON,"android-chrome", $attributes["href"]);
					else
						$attributes["href"] = "fav".$attributes["href"];
					
				}
				$attributes["href"] = $urlpath . $attributes["href"];
				//see OutputPage reference: https://doc.wikimedia.org/mediawiki-core/master/php/classOutputPage.html
				$out->addLink($attributes);
			}
		}
		$out->addLink(array("rel"=>"manifest", "href" => $urlpath."manifest.json"));
		$out->addMeta('msapplication-TileColor', "#ffffff");
		$out->addMeta('msapplication-TileImage', $urlpath."mstile-144x144.png");
		$out->addMeta('theme-color', "#ffffff");
		$wgFavicon = $urlpath . "favicon.ico";
//END ICONS SHIZZLE
	
		$viewport_meta = 'width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no';
		$out->addMeta('viewport', $viewport_meta);
		
		//<link rel="shortcut icon" href="http://deltaexpertise.pixelkings.nl/deltasmw/favicon.ico" type="image/vnd.microsoft.icon" />
		
		$out->addModuleScripts('skins.deltaskin');

// 				echo '<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
// 		<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
// 		<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
// 		<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->'."\n";

	}

	//public function addToBodyAttributes()
}


/**
 * BaseTemplate class for Delta Skin skin
 * @ingroup Skins
 */
class DeltaSkinTemplate extends BaseTemplate {

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

                $this->html( 'headelement' );
?>
<!-- WME start of custom skin code (everything within the body tag) below -->

		<!--[if lt IE 8]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

<?php
		include 'helper.php';		//helper script with urls, vars, banners, etc.

		include 'search/search_settings.php';	//convert parameters.yml to javascript

		include 'header.php';		//header div

		if($home)
		{
			include 'newhome.php';		//main homepage
		}
		elseif($search)
		{
			include 'search/search_page.php';		//search page
		}
		elseif($subhome)
		{
				include 'subhome.php';		//include sub homepage
		}
		else
		{
			include 'defaultpage.php';		//include defaultpages
		}

		include 'footer.php';		//include footer div
?>

		</div>						<?php //this is the main div, started in helper.php ?>

<?php
		/*WME TODO: is there a better way to add google analytics code for mediawikiskins??
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
		*/
?>

<!-- WME end of custom skin code (after body tag) below -->

<?php $this->printTrail(); ?>

	</body>
</html>

<?php
                wfRestoreWarnings();
        }

}
?>
