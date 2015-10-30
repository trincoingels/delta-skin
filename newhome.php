			<div id="body">
			
				<div class="navigation  mb+">

					<!-- row processen/cases -->
		
					<div class="layout  mobile-mb  tablet-mb0">
		
						<div class="layout__item  u-1/2-tablet  u-2/3-desktop  section-processen">
		
							<div class="navigation__label  navigation__label--first  hide-on-mobile"><span class="p"><?php echo wfMessage( 'deltaskin-theory' )->text();?></span></div>
		
							<div class="box">
		
								<h2 class="section-titel  section-title--first"><?php echo wfMessage( 'deltaskin-processes' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-theory' )->text();?>)</span></h2>
		
								<div class="layout">
		
								<?php 
								foreach($processes as $process => $subProcessLinks)
								{
									//split in 3 strings: first being the target, the 2nd being the label of the link, 3rd being the block background image
									$processLink = explode("|", $process, 3);
									$processLink = array_map("trim", $processLink);	//trim whitespace
									list($processTarget, $processLabel, $processImg) = $processLink;
									//the images can be either a skin image (found at bannerUrl) or a wiki upload (prefered)
									if($processImg){
										$wikiImageUrl = APIAsker::getInstance()->queryImageUrl($processImg);
										$blockImgUrl = ($wikiImageUrl) ? $wikiImageUrl : $bannerUrl."/".$processImg;
									}
								?>
									<div class="layout__item  u-1/1-tablet  u-1/2-desktop">
		
										<div class="box  navigation__item   mb cover" style="background-image: url(<?php echo $blockImgUrl;?>)">
		
											<a href="<?php echo $processTarget?>">
												<h3 class="navigation__item--title"><?php echo $processLabel;?></h3>
		
											<ul class="list-bare  navigation__list">
											<?php //foreach($processLinks as)
												if(is_array($subProcessLinks)){
													foreach ($subProcessLinks as $key => $value)
														echo $this->makeListItem( $key, $value) . "\n"; //, array( 'text-wrapper' => array( 'tag' => 'span' ))  ) . "\n";
												}
												else{
													echo $subProcessLinks . "\n";
												}
											?>
												<li><a href="#" class="navigation__subitem">Waterstromen</a></li>
												<li><a href="#" class="navigation__subitem">Zuiveringstechnieken</a></li>
												<li><a href="#" class="navigation__subitem">Soorten</a></li>
											</ul>
		
											</a>
										</div>
		
									</div>
								<?php } ?>
									<a href="#"  class="blocklink fr">
										<?php echo wfMessage( 'deltaskin-more' )->text()." ".strtolower(wfMessage( 'deltaskin-processes' )->text()); ?>&nbsp;&raquo;
									</a>
		
								</div>
		
							</div>
		
						</div
						><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
		
							<div class="navigation__label  hide-on-mobile"><span class="p"><?php echo wfMessage( 'deltaskin-practice' )->text();?></span></div>
		
							<div class="box">
		
								<h2 class="section-titel"><?php echo wfMessage( 'deltaskin-cases' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-practice' )->text();?>)</span></h2>
		
								<div class="scroller">
		
									<div class="scroller__inner">
		
										<ul class="list-bare  case-list">
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Zuid-Beveland</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Zeeuws-Vlaanderen</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Tholen</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Vlaanderen</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Zuid-Beveland</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Zeeuws-Vlaanderen</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Tholen</a></li>
										</ul>
		
									</div>
		
								</div>
		
							</div>
		
						</div>
		
					</div>
		
					<!-- row begrippen/feiten -->
		
					<div class="layout  layout--devider  mobile-pt  tablet-pt0">
		
						<div class="layout__item  u-1/2-tablet  u-2/3-desktop  section-begrippen">
		
							<div class="box  pt0">
		
								<h2 class="section-titel"><?php echo wfMessage( 'deltaskin-concepts' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-theory' )->text();?>)</span></h2>
		
								<div class="">
		
									<ul class="list-block  terms">
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
										<li><a href="#">Hydraulische belasting</a></li>
									</ul>
		
									<a href="#" class="blocklink fr">
										<?php echo wfMessage( 'deltaskin-more' )->text()." ".strtolower(wfMessage( 'deltaskin-concepts' )->text()); ?>&nbsp;&raquo;
									</a>
		
								</div>
		
							</div>
		
						</div><div class="layout__item  u-1/2-tablet  u-1/3-desktop">
		
							<div class="box">
		
								<h2 class="section-titel"><?php echo wfMessage( 'deltaskin-facts' )->text();?><span class="mobile-only"> (<?php echo wfMessage( 'deltaskin-practice' )->text();?>)</span></h2>
		
								<div class="scroller">
		
									<div class="scroller__inner">
		
										<ul class="list-bare  case-list">
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Zuid-Beveland</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Zeeuws-Vlaanderen</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Tholen</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Vlaanderen</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Zuid-Beveland</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Zeeuws-Vlaanderen</a></li>
											<li class="mb"><a href="#" style="background-image: url(img/testbeeld.jpg)" class="case-list__item  p">Tholen</a></li>
										</ul>
		
									</div>
		
								</div>
		
							</div>
		
						</div>
		
					</div>
		
				</div>
		
				<div class="navigation  mb+">
		
					<div class="box">
		
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
		
<?php 
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
if( !$sections && !$audience )		//if no sections and no audience, print page content
{
	$this->html('bodytext');
	if($this->data['loggedin'] && $_GET["action"] != 'edit')
		echo "<div id=\"editlink\"><a href=\"?action=edit\">wijzig</a></div>";
}
?>
				
			</div>