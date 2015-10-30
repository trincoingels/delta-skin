<?php //include file for footer of all pagetypes in deltaskin ?>	
		
			<footer id="siteFooter">
				<?php 
				//load footer content from (default: list of logo's)
				$parsedFooterContent = wfMessage( 'deltaskin-footer' )->parse();
				echo $parsedFooterContent;
				?>
			</footer>
<?php
/* 			
<script type="text/javascript">
	jQuery(function($) {
		if (/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())) {
			$('body').css('opacity', '1.0') 
		}
	})
</script>
*/
?>