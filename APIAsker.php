<?php
/** 
 * This singleton class is for querying SMW using the SMW Ask API.
 * API access happens internally (no http call).
 *
 * @author WME 201411
 */
class APIAsker{
	
	const QUERYRESULTLIMIT = 5000;
	private static $instance;			//the singleton instance
	
	private function __construct(){}	//remember the singleton
	
	/**
	 * Singleton function
	 */
	public static function getInstance(){
		if(!isset(self::$instance))
			self::$instance = new APIAsker();
		return self::$instance;
	}
	
	/**
	 * This function executes the given SMW ask query
	 * API access happens internally
	 *
	 * @author WME
	 * @param String $query	the SMW ask query
	 * @return associative array with the query result
	 */
	function ask($query)
	{
		$params = new FauxRequest(
				array(
						'action' => 'ask',
						'query' => $query."|limit=" . self::QUERYRESULTLIMIT
				)
		);
		$api = new ApiMain( $params );
		$api->execute();
		$result = &$api->getResultData();
		return $result;
	}
	
	/**
	 * This function executes the given query
	 * api.php?action=query&titles=File:Banner-big-aquacultuur.jpg&prop=imageinfo&&iiprop=url
	 */
	function queryImageUrl($img){
		$params = new FauxRequest(
				array(
						'action' => 'query',
						'titles' => 'File:'.$img,		//TODO: is File: namespace always recognized?
						'prop' => 'imageinfo',
						'iiprop' => 'url'
				)
		);
		$api = new ApiMain( $params );
		$api->execute();
		$result = &$api->getResultData();
		//possible since: mw1.25
		//$result = $api->getResult->getResultData(array('query','pages'));
		return array_pop(array_pop($result['query']['pages'])['imageinfo'])['url'];
	}
}
?>