			<div id="body">
<?php if($processes || $cases || $concepts || $facts):?>			
				<div class="navigation  mb+">

					<!-- row processen/cases -->
		
					<div class="layout  mobile-mb  tablet-mb0">
		
						<div class="layout__item  u-1/2-tablet  u-2/3-desktop  section-processen">
		
							<div class="navigation__label  navigation__label--first  hide-on-mobile"><span class="p"><?php echo wfMessage( 'deltaskin-theory' )->text();?></span></div>
<?php if($processes):?>		
							<div class="box">
		
								<h2 class="section-titel  section-title--first"><?php echo wfMessage( 'deltaskin-processes' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-theory' )->text();?>)</span></h2>
		
								<div class="layout">
		
								<?php 
									//TODO: explode target, label and image -> to remove code duplic
									//TODO: img in and imgurl out -> removes code duplic
									$moreProcessesUrl = "";
									foreach($processes as $process => $subProcessLinks)
									{
										//split in 3 strings: first being the target, the 2nd being the label of the link, 3rd being the block background image
										$processLink = explode("|", $process, 3);
										$processLink = array_map("trim", $processLink);	//trim whitespace
										$blockImgUrl = false;
										list($processTarget, $processLabel, $processImg) = $processLink;
										if($processLabel=="more"){
											$moreProcessesUrl = $processTarget;	//set url for 'more processes', used below
											continue;	//skip rest of this iteration
										}
										//the images can be either a skin image (found at bannerUrl) or a wiki upload (prefered)
										if($processImg){
											$wikiImageUrl = APIAsker::getInstance()->queryImageUrl($processImg);
											$blockImgUrl = ($wikiImageUrl) ? $wikiImageUrl : $bannerUrl."/".$processImg;
										}
									//important: no new lines or spacing must be present between begin and end of this foreach loop... see EMT-365:
									?><div class="layout__item  u-1/1-tablet  u-1/2-desktop">
		
											<a href="<?php echo $processTarget;?>">	
												<div class="box  navigation__item   mb cover" style="background-image: url(<?php echo $blockImgUrl;?>)">
												<h3 class="navigation__item--title"><?php echo $processLabel;?></h3>
		
											<?php
												if(is_array($subProcessLinks) && count($subProcessLinks)>0){
													echo '<ul class="list-bare  navigation__list">';
													foreach ($subProcessLinks as $key => $value)
														echo $this->makeListItem( $key, $value, array('link-class'=>'navigation__subitem')) . "\n"; 
													echo '</ul>';
												}
											?>
												</div>
											</a>
		
									</div><?php } //important: no new lines or spacing must be present between begin and end of this foreach loop... see EMT-365?>
									
									<a href="<?php echo $moreProcessesUrl;?>"  class="blocklink fr">
										<?php echo wfMessage( 'deltaskin-more' )->text()." ".strtolower(wfMessage( 'deltaskin-processes' )->text()); ?>&nbsp;&raquo;
									</a>
		
								</div>
		
							</div>
<?php endif;?>	
						</div
						><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
		
							<div class="navigation__label  hide-on-mobile"><span class="p"><?php echo wfMessage( 'deltaskin-practice' )->text();?></span></div>
<?php if($cases):?>	
							<div class="box">
		
								<h2 class="section-titel"><?php echo wfMessage( 'deltaskin-cases' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-practice' )->text();?>)</span></h2>
		
								<div class="scroller">
		
									<div class="scroller__inner">
		
										<ul class="list-bare  case-list">
										<?php foreach($cases as $case => $subCases):
											//NB: $subCases is not used at the moment (will not be dealt with in the code below).
											//split in 3 strings: first being the target, the 2nd being the label of the link, 3rd being the block background image
											$caseLink = explode("|", $case, 3);
											$caseLink = array_map("trim", $caseLink);	//trim whitespace
											$blockImgUrl = false;
											list($caseTarget, $caseLabel, $caseImg) = $caseLink;
											//the images can be either a skin image (found at bannerUrl) or a wiki upload (prefered)
											if($caseImg){
												$wikiImageUrl = APIAsker::getInstance()->queryImageUrl($caseImg);
												$blockImgUrl = ($wikiImageUrl) ? $wikiImageUrl : $bannerUrl."/".$caseImg;
											}
										?>
											<li class="mb"><a href="<?php echo $caseTarget;?>" style="background-image: url(<?php echo $blockImgUrl;?>)" class="case-list__item  p"><?php echo $caseLabel;?></a></li>
										<?php endforeach;?>
										</ul>
		
									</div>
		
								</div>
		
							</div>
<?php endif;?>
						</div>
		
					</div>
		
					<!-- row begrippen/feiten -->
		
					<div class="layout  layout--devider  mobile-pt  tablet-pt0">
		
						<div class="layout__item  u-1/2-tablet  u-2/3-desktop  section-begrippen">
<?php if($concepts):?>		
							<div class="box  pt-">
		
								<h2 class="section-titel"><?php echo wfMessage( 'deltaskin-concepts' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-theory' )->text();?>)</span></h2>
		
								<div class="">
		
									<ul class="list-block  terms">
									<?php 
									$moreConceptsUrl = "";
									foreach($concepts as $concept => $subConcepts):
											//NB: $subConcepts is not used at the moment (will not be dealt with in the code below).
											//split in 3 strings: first being the target, the 2nd being the label of the link, 3rd being the block background image
												//NB: images are not dealt with in the code below
											$conceptLink = explode("|", $concept, 3);
											$conceptLink = array_map("trim", $conceptLink);	//trim whitespace
											list($conceptTarget, $conceptLabel, $conceptImg) = $conceptLink;
											if($conceptLabel=="more"){
												$moreConceptsUrl = $conceptTarget;	//set url for 'more concepts', used below
												continue;	//skip rest of this iteration
											}
									?>
										<li><a href="<?php echo $conceptTarget;?>"><?php echo $conceptLabel;?></a></li>
									<?php endforeach;?>
									</ul>
									<a href="<?php echo $moreConceptsUrl;?>" class="blocklink fr">
										<?php echo wfMessage( 'deltaskin-more' )->text()." ".strtolower(wfMessage( 'deltaskin-concepts' )->text()); ?>&nbsp;&raquo;
									</a>
		
								</div>
		
							</div>
<?php endif;?>
						</div><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
<?php if($facts):?>		
							<div class="box">
		
								<h2 class="section-titel"><?php echo wfMessage( 'deltaskin-facts' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-practice' )->text();?>)</span></h2>
		
								<div class="scroller">
		
									<div class="scroller__inner">
		
										<ul class="list-bare  case-list">
										<?php 
											foreach($facts as $fact => $subFacts):
												//NB: $subFacts is not used at the moment (will not be dealt with in the code below).
												//split in 3 strings: first being the target, the 2nd being the label of the link, 3rd being the block background image
												$factLink = explode("|", $fact, 3);
												$factLink = array_map("trim", $factLink);	//trim whitespace
												$blockImgUrl = false;
												list($factTarget, $factLabel, $factImg) = $factLink;
												//the images can be either a skin image (found at bannerUrl) or a wiki upload (prefered)
												if($factImg){
													$wikiImageUrl = APIAsker::getInstance()->queryImageUrl($factImg);
													$blockImgUrl = ($wikiImageUrl) ? $wikiImageUrl : $bannerUrl."/".$factImg;
												}
											?>
												<li class="mb"><a href="<?php echo $factTarget;?>" style="background-image: url(<?php echo $blockImgUrl?>)" class="case-list__item  p"><?php echo $factLabel;?></a></li>
											<?php endforeach;?>
										</ul>
		
									</div>
		
								</div>
		
							</div>
<?php endif;?>
						</div>
		
					</div>
		
				</div>
<?php /*		
				<div class="navigation  mb">
		
					<div class="box  pb0">
		
						<div class="layout">
		
							<div class="layout__item  u-1/2-tablet  u-1/3-desktop">
		
								<div class="box  navigation__item  cover" style="background-image: url(img/testbeeld.jpg)">
		
									<a href="#"><h3 class="navigation__item--title">verzorgen</h3></a>
		
									<ul class="list-bare  navigation__list">
										<li><a href="#" class="navigation__subitem">Waterstromen</a></li>
										<li><a href="#" class="navigation__subitem">Zuiveringstechnieken</a></li>
										<li><a href="#" class="navigation__subitem">Soorten</a></li>
									</ul>
		
								</div>
		
							</div
							><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
		
								<div class="box  navigation__item  cover" style="background-image: url(img/testbeeld.jpg)">
		
									<a href="#"><h3 class="navigation__item--title">verzorgen</h3></a>
		
									<ul class="list-bare  navigation__list">
										<li><a href="#" class="navigation__subitem">Waterstromen</a></li>
										<li><a href="#" class="navigation__subitem">Zuiveringstechnieken</a></li>
										<li><a href="#" class="navigation__subitem">Soorten</a></li>
									</ul>
		
								</div>
		
							</div
							><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
		
								<div class="box  navigation__item  cover" style="background-image: url(img/testbeeld.jpg)">
		
									<a href="#"><h3 class="navigation__item--title">verzorgen</h3></a>
		
									<ul class="list-bare  navigation__list">
										<li><a href="#" class="navigation__subitem">Waterstromen</a></li>
										<li><a href="#" class="navigation__subitem">Zuiveringstechnieken</a></li>
										<li><a href="#" class="navigation__subitem">Soorten</a></li>
									</ul>
		
								</div>
		
							</div>
		
						</div>
		
					</div>
		
				</div>
*/
endif;
//wme: oldhome starts here
if($sections):?>	
				<section class="sections">
					<ul>
						<?php 
							foreach($sections as $name => $content){
								echo "\n<li>\n";
								//split in 3 strings: first being the target, the 2nd being the label of the link, 3rd being the nav-block-banner
								$link = explode("|", $name, 3);
								$link = array_map("trim", $link);	//trim whitespace
								list($target, $label, $navblockbanner) = $link;
								if($navblockbanner){
									$wikiImageUrl = APIAsker::getInstance()->queryImageUrl($navblockbanner);
									$blockImgUrl = ($wikiImageUrl) ? $wikiImageUrl : $bannerUrl."/".$navblockbanner;
									$style = "style=\"background: url(".$blockImgUrl.");\"";
								}
								else 
									$style = "";
								echo "\n<h3 $style><a href=\"$target\">". ($label ? $label : $target) ."</a></h3>\n<ul>\n";
								
								if(is_array($content)){
									foreach ($content as $key => $value)
										echo $this->makeListItem( $key, $value) . "\n"; //, array( 'text-wrapper' => array( 'tag' => 'span' ))  ) . "\n";
								}
								else{
									echo $content . "\n";
								}
								echo "<li class=\"more\"><a href=\"$link[0]\">" . wfMessage( 'deltaskin-more' )->text() ." ". strtolower( ($label ? $label : $target) ) . "</a></li>\n";
								echo "</ul>\n</li>\n";
							}
						?>
					</ul>
				</section>
<?php
	endif; 
	if($audience):?>
				<section class="audience">
					<ul>
						<?php 
							foreach($audience as $name => $content){
								echo "\n<li>\n";
								//split in 3 strings: first being the target, the 2nd being the label of the link, 3rd being the nav-block-banner
								$link = explode("|", $name, 3);
								$link = array_map("trim", $link);	//trim whitespace
								list($target, $label, $navblockbanner) = $link;
								if($navblockbanner){
									$wikiImageUrl = APIAsker::getInstance()->queryImageUrl($navblockbanner);
									$blockImgUrl = ($wikiImageUrl) ? $wikiImageUrl : $bannerUrl."/".$navblockbanner;
									$style = "style=\"background: url(".$blockImgUrl.");\""; 
								}
								else 
									$style = "";
								echo "\n<h3 $style><a href=\"$target\">". ($label ? $label : $target) ."</a></h3>\n<ul>\n";
								
								if(is_array($content)){
									foreach ($content as $key => $value)
										echo $this->makeListItem( $key, $value) . "\n"; //, array( 'text-wrapper' => array( 'tag' => 'span' ))  ) . "\n";
								}
								else{
									echo $content . "\n";
								}
								echo "<li class=\"more\"><a href=\"$link[0]\">" . wfMessage( 'deltaskin-more' )->text() ." ". strtolower( ($label ? $label : $target) ) . "</a></li>\n";
								echo "</ul>\n</li>\n";
							}
						?>
					</ul>
				</section>
<?php endif;
if( !$sections && !$audience )		//if no sections and no audience, print page content TODO extend this with new nav msgs
{
	$this->html('bodytext');
	if($this->data['loggedin'] && $_GET["action"] != 'edit')
		echo "<div id=\"editlink\"><a href=\"?action=edit\">wijzig</a></div>";
}
?>
				
			</div>