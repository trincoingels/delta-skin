<?php //include file for type 0 - home page in deltaskin ?>
			
			<div id="body">
<?php if($sections):?>				
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