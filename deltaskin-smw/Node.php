<?php
/**
 * This class describes a node in the DAG of the delta-expertise content (which in turn is based on EMont).
 * A node represents an entity which is a wiki-page with a name and a URL, and a breadcrumb value
 * which is an object of this class (recursive definition).
 *  
 * This is a helper class, created for use with the breadcrumb algorithm (see BreadCrumbBuilder.php)
 * 
 * @author WME 201411
 */
class Node{
	private $name;
	private $url;
	private $breadCrumb;
	
	public function __construct($name, $url, $bcnode=null){
		$this->name = $name;
		$this->url = $url;
		$this->breadCrumb = ($bcnode)? $bcnode : $this;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getUrl(){
		return $this->url;
	}
	
	public function getBreadCrumb(){
		return $this->breadCrumb;
	}
	
	public function setBreadCrumb($node){
		$this->breadCrumb = $node;
	}
}