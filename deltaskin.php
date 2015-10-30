<?php

/**
 * Delta Skin mediawiki skin for delta EMM wiki HZ
*
* @file
* @ingroup Skins
* @author Wouter M. Everse (http://www.hz.nl)
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

if( !defined( 'MEDIAWIKI' ) )
	die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['skin'][] = array(
		'path' => __FILE__,
		'version' => '1.0 + semantic search',
		'name' => 'Delta Skin',
		'url' => "",
		'author' => "[http://www.simpliphi.nl Wouter M. Everse]",
		'descriptionmsg' => 'deltaskin-desc',
);

$wgValidSkinNames['deltaskin'] = 'DeltaSkin';
$wgAutoloadClasses['SkinDeltaSkin'] = dirname(__FILE__).'/DeltaSkin.skin.php';
$wgExtensionMessagesFiles['DeltaSkin'] = dirname(__FILE__).'/DeltaSkin.i18n.php';

$wgResourceModules['skins.deltaskin'] = array(
		'scripts' => array(
// 				'deltaskin/js/vendor/jquery-1.10.1.min.js',
				'deltaskin/js/vendor/modernizr-2.6.2.min.js',
				'deltaskin/js/vendor/respond.js',
				'deltaskin/js/vendor/jquery.simplemodal.js',
				'deltaskin/js/main.js',
				'deltaskin/search/js/search-ck.js',
				'deltaskin/js/plugins.js'
		),
		'styles' => array(
// 				'deltaskin/css/screen.css' => array( 'media' => 'screen' ), //this results in IE crash!!
// 				'deltaskin/css/custom.css' => array( 'media' => 'screen' )	//this results in IE crash!!
				'deltaskin/css/screen.css',
				'deltaskin/search/css/search.css',
				'deltaskin/css/custom.css'
		),
		'remoteBasePath' => &$GLOBALS['wgStylePath'],
		'localBasePath' => &$GLOBALS['wgStyleDirectory']
);
