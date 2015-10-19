<?php //include file for header of all pagetypes in deltaskin ?>
			
			<div class="banner" <?php echo $banner;?>><span></span></div>

			<header id="mainHeader" <?php echo $mainHeaderclass;?>>
						
				<a href="#" id="toggleMenu" class="icon-menu"><span><?php echo wfMessage( 'deltaskin-tglmenutxt' )->text();?></span></a>
				
				<a href="#" id="toggleSearch" class="icon-menu"><span><?php echo wfMessage( 'deltaskin-tglsearchtxt' )->text();?></span></a>
					
				<h1 id="idTag">
					<span title="<?php echo wfMessage( 'deltaskin-logolnktxt' )->text();?>"
						  style="background: url('<?php echo $wgLogo;?>') no-repeat center top;">
				<?php 
					if(!$home) echo "<a href='".$indexUrl."/".$servicenav[0]."'>";		//url was std mediawiki home: $this->data['nav_urls']['mainpage']['href']
					echo wfMessage( 'deltaskin-logolnktxt' )->text();
					if(!$home) echo	"</a>";
				?>
					</span>
				</h1>
				
				<?php echo $h2profile; //this is defined in helper.php for a profile header h2 over the banner ?>
				
				<nav>
					<ul>
					<?php 
					foreach ($servicenav as $title){?>
						<li <?php if($this->data['title']==$title) echo 'class="active"';?>><a href="<?php echo $indexUrl."/".$title?>"><?php echo $title?></a></li>
					<?php }?>
						
						<?php 
						/* 
						<li class="language"><a href="#" class="lang-selected" data-icon-after="w"><?php echo $lng->mCode?></a>
						   <ul>
						   	   <li class="select-language" data-language="nl"><a href="?setlang=nl"><?php echo wfMessage( 'deltaskin-langnl' )->text();?></a></li>
							   <li class="select-language" data-language="en"><a href="?setlang=en"><?php echo wfMessage( 'deltaskin-langen' )->text();?></a></li>
							   <?php 
							   //<li class="select-language" data-language="nl"><input type="checkbox" id="nederlands" checked /><a href="?setlang=nl"><label for="nederlands"><?php echo wfMessage( 'deltaskin-langnl' )->text();?></label></a></li>
							   //<li class="select-language" data-language="en"><input type="checkbox" id="english" /><a href="?setlang=en"><label for="english"><?php echo wfMessage( 'deltaskin-langen' )->text();?></label></a></li> 
							   ?>
						   </ul>
						</li>
						*/
						$loginouturl = ($this->data['loggedin']) ? SpecialPage::getTitleFor( 'Userlogout' )->getLocalURL() : SpecialPage::getTitleFor( 'Userlogin' )->getLocalURL();
						$loginouttxt = ($this->data['loggedin']) ? wfMessage( 'logout' )->text() : wfMessage( 'login' )->text();
						?>
						<li class="login"><a href="<?php echo $loginouturl?>" data-icon="<?php echo $lockIcon?>" title="<?php echo $loginouttxt?>" alt="<?php echo $loginouttxt?>"><span><?php echo $loginouttxt?></span></a></li>
					</ul>
				</nav>
				<div id="searchBoxFront">
					<form action="<?php $this->text( 'wgScript' ); ?>" id="searchform">
						<fieldset>
							<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
							<?php echo $this->makeSearchInput(array('id'=>'searchInput', 'placeholder'=> $this->translator->translate( 'searchbutton' ), 'alt' => wfMessage( 'deltaskin-tglsearchtxt' )->text(), 'autocomplete' => 'off' )); ?>
							<button data-icon="q"><span><?php $this->translator->translate( 'searchbutton' ) ?></span></button>
						</fieldset>
						<ul class="suggestions">
				        </ul>
					</form>
				</div>
				<?php if($subhome && $tempBreadCrumb2): /* FIXME temporary hack for breadcrumb on subhome's */?>
					<div id="breadcrumb">
							<ul>
								<?php 
								foreach($tempBreadCrumb2 as $label => $lblurl)
									echo "<li><a href=\"$lblurl\">$label</a></li>";
								?>
							</ul>
						</div>
				<?php endif /* FIXME end of temporary hack for breadcrumb on subhome's */?>
				
				<?php echo $sectionHeader;?>
				
			</header>