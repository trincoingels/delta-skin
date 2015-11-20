<?php //include file for type 0 & 1 - home page and sub home pages in deltaskin ?>
			<div id="body">
<?php 
	if($blockdata["processes"] || $blockdata["cases"] || $blockdata["concepts"] || $blockdata["facts"]):?>			
				<div class="navigation  mb+">

					<!-- row processen/cases -->
		
					<div class="layout  mobile-mb  tablet-mb0  section-processen-cases">
		
						<div class="layout__item  u-1/2-tablet  u-2/3-desktop  section-processen">
		
							<div class="navigation__label  navigation__label--first  hide-on-mobile"><span class="p"><?php echo wfMessage( 'deltaskin-theory' )->text();?></span></div>
<?php 	if($blockdata["processes"]):?>		
							<div class="box">
		
								<h2 class="section-titel  section-title--first"><a href="<?php echo $blockdata["processes"]["more"];?>"><?php echo wfMessage( 'deltaskin-processes' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-theory' )->text();?>)</span></a></h2>
		
								<div class="layout">
		
								<?php 
									foreach($blockdata["processes"] as $pk=>$process):
										if($pk==="more") continue;	//skip the more link for now, used elders (above & below)
									//important: no new lines or spacing must be present between begin and end of this foreach loop... see EMT-365:
								?><div class="layout__item  u-1/1-tablet  u-1/2-desktop">
		
											<a href="<?php echo $process[0];?>">	
												<div class="box  navigation__item   mb cover" style="background-image: url(<?php echo $process[2];?>)">
												<h3 class="navigation__item--title"><?php echo $process[1];?></h3>
		
											<?php
												if(is_array($process["subs"]) && count($process["subs"])>0){
													echo '<ul class="list-bare  navigation__list">';
													foreach ($process["subs"] as $key => $value)
														echo $this->makeListItem( $key, $value, array('link-class'=>'navigation__subitem')) . "\n"; 
													echo '</ul>';
												}
											?>
												</div>
											</a>
		
									</div><?php endforeach; //important: no new lines or spacing must be present between begin and end of this foreach loop... see EMT-365?>
									
									<a href="<?php echo $blockdata["processes"]["more"];?>"  class="blocklink fr">
										<?php echo wfMessage( 'deltaskin-more' )->text()." ".strtolower(wfMessage( 'deltaskin-processes' )->text()); ?>&nbsp;&raquo;
									</a>
		
								</div>
		
							</div>
<?php 	endif;?>	
						</div
						><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
		
							<div class="navigation__label  hide-on-mobile"><span class="p"><?php echo wfMessage( 'deltaskin-practice' )->text();?></span></div>
<?php 	if($blockdata["cases"]):?>	
							<div class="box">
		
								<h2 class="section-titel"><a href="<?php echo $blockdata["cases"]["more"];?>"><?php echo wfMessage( 'deltaskin-cases' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-practice' )->text();?>)</span></a></h2>
		
								<div class="scroller">
		
									<div class="scroller__inner">
		
										<ul class="list-bare  case-list">
										<?php 
											foreach($blockdata["cases"] as $ck=>$case):
												if($ck==="more") continue;	//skip the more link for now, used elders (above)
												//NB: $case["subs"] is not used at the moment (will not be dealt with in the code below).
										?>
											<li class="mb"><a href="<?php echo $case[0];?>" style="background-image: url(<?php echo $case[2];?>)" class="case-list__item  p"><?php echo $case[1];?></a></li>
										<?php endforeach;?>
										</ul>
		
									</div>
		
								</div>
		
							</div>
<?php 	endif;?>
						</div>
		
					</div>
		
					<!-- row begrippen/feiten -->
		
					<div class="layout  layout--devider  mobile-pt  tablet-pt0  section-begrippen-feiten">
		
						<div class="layout__item  u-1/2-tablet  u-2/3-desktop  section-begrippen">
<?php 	if($blockdata["concepts"]):?>		
							<div class="box  pt-">
		
								<h2 class="section-titel"><a href="<?php echo $blockdata["concepts"]["more"];?>"><?php echo wfMessage( 'deltaskin-concepts' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-theory' )->text();?>)</span></a></h2>
		
								<div class="">
		
									<ul class="list-block  terms">
									<?php 
										foreach($blockdata["concepts"] as $ck=>$concept):
											if($ck==="more") continue;	//skip the more link for now, used elders (above & below)
											//NB: $concept["subs"] is not used at the moment (will not be dealt with in the code below).
									?>
										<li><a href="<?php echo $concept[0];?>"><?php echo $concept[1];?></a></li>
									<?php endforeach;?>
									</ul>
									<a href="<?php echo $blockdata["concepts"]["more"];?>" class="blocklink fr">
										<?php echo wfMessage( 'deltaskin-more' )->text()." ".strtolower(wfMessage( 'deltaskin-concepts' )->text()); ?>&nbsp;&raquo;
									</a>
		
								</div>
		
							</div>
<?php 	endif;?>
						</div><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
<?php 	if($blockdata["facts"]):?>		
							<div class="box">
		
								<h2 class="section-titel"><a href="<?php echo $blockdata["facts"]["more"];?>"><?php echo wfMessage( 'deltaskin-facts' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-practice' )->text();?>)</span></a></h2>
		
								<div class="scroller">
		
									<div class="scroller__inner">
		
										<ul class="list-bare  case-list">
										<?php 
											foreach($blockdata["facts"] as $fk=>$fact):
												if($fk==="more") continue;	//skip the more link for now, used elders (above)
												//NB: $fact["subs"] is not used at the moment (will not be dealt with in the code below).
										?>
												<li class="mb"><a href="<?php echo $fact[0];?>" style="background-image: url(<?php echo $fact[2]?>)" class="case-list__item  p"><?php echo $fact[1];?></a></li>
										<?php endforeach;?>
										</ul>
		
									</div>
		
								</div>
		
							</div>
<?php 	endif;?>
						</div>
		
					</div>
		
				</div>
<?php 
	endif;	
	if($blockdata["moreblocks"]):?>				
				<div class="navigation  mb">
		
					<div class="box  pb0">
		
						<div class="layout">
								<?php 
									//TODO: this block of code is the almost the same as for processes (except for: u-1/2-tablet u-/1/3-desktop) - remove codedupl?
									foreach($blockdata["moreblocks"] as $mk=>$anotherblock):
										if($mk==="more") continue;	//skip the more link for now, not used elders at the moment
								//important: no new lines or spacing must be present between begin and end of this foreach loop... see EMT-365:
								?><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
		
											<a href="<?php echo $anotherblock[0];?>">	
												<div class="box  navigation__item   cover" style="background-image: url(<?php echo $anotherblock[2];?>)">
												<h3 class="navigation__item--title"><?php echo $anotherblock[1];?></h3>
		
											<?php
												if(is_array($anotherblock["subs"]) && count($anotherblock["subs"])>0){
													echo '<ul class="list-bare  navigation__list">';
													foreach ($anotherblock["subs"] as $key => $value)
														echo $this->makeListItem( $key, $value, array('link-class'=>'navigation__subitem')) . "\n"; 
													echo '</ul>';
												}
											?>
												</div>
											</a>
		
								  </div><?php endforeach; //important: no new lines or spacing must be present between begin and end of this foreach loop... see EMT-365?>
		
						</div>
		
					</div>
		
				</div>
<?php	
	endif;
	if($blockdata["sections"]):
?>				<!-- Sections section -->
				<section class="section">
					<div class="box  pb0">
						<div class="layout">
						<?php 
							foreach($blockdata["sections"] as $sk=>$section):
								if($sk==="more") continue;	//skip the more link for now, not used elders at the moment
						?><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
								<div class="section__item">
									<h3 class="section__title" style="background-image: url(<?php echo $section[2];?>);"><a href="<?php echo $section[0];?>"><?php echo ($section[1] ?: $section[0]);?></a></h3>
									<ul class="section__list">
									<?php 
									if(is_array($section["subs"])){
										foreach ($section["subs"] as $key => $value)
											echo $this->makeListItem( $key, $value) . "\n";
									}
									else{
										echo $section["subs"] . "\n";
									}
									echo "<li class=\"more\"><a href=\"{$section[0]}\">" . wfMessage( 'deltaskin-more' )->text() ." ". strtolower( ($section[1] ?: $section[0]) ) . "</a></li>\n";
									echo "</ul>\n";
								?>
								</div>
						  </div><?php endforeach;?>
						</div>
					</div>
				</section>
<?php 
	endif;
	if($blockdata["audience"]):
?>				<!-- Audience section -->
				<section class="section">
					<div class="box  pb0">
						<div class="layout">
							<?php
								foreach($blockdata["audience"] as $ak=>$audienceItem):
									if($ak==="more") continue;	//skip the more link for now, not used elders at the moment
							?><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
									<div class="section__item">
										<h3 class="section__title" style="background-image: url(<?php echo $audienceItem[2];?>);"><a href="<?php echo $audienceItem[0];?>"><?php echo ($audienceItem[1] ?: $audienceItem[0]);?></a></h3>
										<ul class="section__list">
										<?php 
										if(is_array($audienceItem["subs"])){
											foreach ($audienceItem["subs"] as $key => $value)
												echo $this->makeListItem( $key, $value) . "\n";
										}
										else{
											echo $audienceItem["subs"] . "\n";
										}
										echo "<li class=\"more\"><a href=\"$audienceItem[0]\">" . wfMessage( 'deltaskin-more' )->text() ." ". strtolower( ($audienceItem[1] ?: $audienceItem[0]) ) . "</a></li>\n";
										echo "</ul>\n";
									?>
									</div>
							  </div><?php endforeach;?>
						</div>
					</div>
				</section>
<?php 
	endif;
	if( !($blockdata["sections"] || $blockdata["audience"] || $blockdata["processes"] || $blockdata["cases"] || $blockdata["concepts"] || $blockdata["facts"]) )		//if none of the msgs is set, just print the page content
	{
		$this->html('bodytext');
		if($this->data['loggedin'] && $_GET["action"] != 'edit')
			echo "<div id=\"editlink\"><a href=\"?action=edit\">wijzig</a></div>";
	}
?>
				
			</div>