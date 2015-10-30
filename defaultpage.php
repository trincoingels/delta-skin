<?php
//include file for type 1 page in deltaskin (About, Contact e.d.), maar ook VN pages? ?>			
			
			<div id="body">
				
				<?php if( !in_array($this->data['title'], $servicenav) ) { ?>
					<div id="breadcrumb">
						<ul>
							<?php 
								if($tempBreadCrumb2){		//user-defined is preferred! FIXME: tempbreadcrumb shizzle
									$breadCrumbTrails[] = $tempBreadCrumb2;
								}
								$breadCrumbTrails = array_slice($breadCrumbTrails, 0, 2);			//FIXME: limit to 2 trails for now
								foreach($breadCrumbTrails as $crumbTrail){
									$maxLength = 90;	//geteld by Ameland VN
									$trailLength = 0;
									foreach ($crumbTrail as $n => $u)
										$trailLength += strlen($n) +3; //+3 because of separating chars (spaces and arrows)
									foreach($crumbTrail as $name => $url){
										if($name=="Waterveiligheid") $name="Hoogwaterbescherming";	//FIXME dirty hack
										if($trailLength > $maxLength){
											$shortname = substr($name, 0, 7) ."&hellip;";
											$trailLength = $trailLength - (strlen($name) - strlen($shortname) + 3);
										}	
										else 
											$shortname = $name;
										echo "<li><a href=\"$url\" title=\"$name\">$shortname</a></li>";		//title attribute for shortened
									}
									echo "\n<BR/>";
								}
							?>
						</ul>
					</div>
				<?php } ?>
				
				<?php echo "<h1>$pagename</h1>"; ?>
				
				<?php if($this->data['loggedin'] && $_GET["action"] != 'edit'): ?><div id="editlink"><a href="?action=edit">wijzig</a></div><?php endif?>
			
				<?php  
					//output the body content of the page (uses QuickTemplate::function html( $str )) )
					
					wfDebug("DELTASKIN: Start buffering 'bodytext' output, for postprocessing");
					ob_start();								//turn on output buffer
					$this->html('bodytext');				//do output 
					$bodytextHtml = ob_get_contents();		//store output for post-processing 
					ob_end_clean();							//clean and turn off output buffer
					
					//http://stackoverflow.com/questions/11309194/php-domdocument-failing-to-handle-utf-8-characters-%E2%98%86
					//this preserves special characters...
					$bodytextHtml = mb_convert_encoding($bodytextHtml, 'HTML-ENTITIES');
					
					//post-process the output: if not <div id="page"> used, insert it.
					$domdoc = new DOMDocument();			
					if( $domdoc->loadHTML($bodytextHtml) )
					{
						$mwContentDiv = $domdoc->getElementById('mw-content-text');
						if( !$domdoc->getElementById('page'))		//Ids are unique, the one and only element with id=page should be a div... if present.
						{
							wfDebug("DELTASKIN: postprocess output: no element with id=page found, inserting <div id='page'>");
							$pageDiv = $domdoc->createElement('div');
							$pageDiv->setAttribute('id', 'page');
							
							wfDebug("DELTASKIN: start moving children - mw-content children vs. pagediv children: {$mwContentDiv->childNodes->length} vs. {$pageDiv->childNodes->length}");
							while($child = $mwContentDiv->firstChild)		//cannot use foreach and childList because of references
							{
								//skip the div for the sidebar, this should be a sibling rather than a child of div id=page
								if($child->hasAttributes() && $child->getAttribute('class') == "aside")
								{	
									wfDebug("DELTASKIN: moving children - skipping div class=aside (see Template:Sidebar)");
									$sidebardiv = $mwContentDiv->removeChild($child);	
								}
								else
								{
									$pageDiv->appendChild($child);
								}
							}
							
							$mwContentDiv->insertBefore($pageDiv, $mwContentDiv->firstChild);
							if($sidebardiv) 	//re-append asidediv as sibling of pagediv
								$mwContentDiv->appendChild($sidebardiv);
							wfDebug("DELTASKIN: end moving children - mw-content children vs. pagediv children: {$mwContentDiv->childNodes->length} vs. {$pageDiv->childNodes->length}");
						}
						else{
							wfDebug("DELTASKIN: id=page found in a {$domdoc->getElementById('page')->nodeName}");
						}
						wfDebug('DELTASKIN: Start output mw-content-text div');
						print($domdoc->saveHTML($mwContentDiv));
						wfDebug('DELTASKIN: Finished output mw-content-text div');
						
					}
					else
					{
						wfDebug("DELTASKIN: error postprocessing bodycontent - DOMDocument->loadHTML() error... in defaultpage.php");
					}
				?>

			</div>