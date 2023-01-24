	<?php $baseUrl = Yii::app()->request->baseUrl; ?>
	<nav class="navbar navbar-default" role="navigation" style="z-index: 888888;">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			
			
			<ul id="sample" class="nav navbar-nav yii-adjustment hidden-xs">
				<li id="home" class="home active"><a href="<?php echo $baseUrl; ?>/index.php"><span class="glyphicon glyphicon-home"></span> <Br /> &nbsp;</a></li>
				<li id ="about" class="about"><a href="<?php echo $baseUrl; ?>/aboutUs.php">About Us <Br /> &nbsp;</a></li>
				<li id="leasing" class="leasing"><a href="<?php echo $baseUrl; ?>/leasingBenefits.php">Leasing <br /> Benefits</a></li>
				<!--<li class="faq"><a href="faq.php">FAQs</a></li>-->
				<li id="markets" class="markets"><a href="<?php echo $baseUrl; ?>/microMarkets.php">Micro <Br /> Markets</a></li>
				<li id="office-furniture" class="office-furniture"><a href="<?php echo $baseUrl; ?>/officeFurniture.php">Office <Br /> Furniture</a></li>
				<li id="vendor" class="vendor"><a href="<?php echo $baseUrl; ?>/vendorPrograms.php">Vendor <Br /> Programs</a></li>				
				<li id="contact" class="contact"><a href="<?php echo $baseUrl; ?>/contactUs.php">Contact Us <Br /> &nbsp;</a></li>
				<hr>
			</ul>
			
			<div class="nav navbar-nav visible-xs" style="background-color:#2787ED;">
				<div class="navigation-small-item"><a href="<?php echo $baseUrl; ?>/index.php"><span class="glyphicon glyphicon-home"></span> Home</a></div>
				<div class="navigation-small-item"><a href="<?php echo $baseUrl; ?>/aboutUs.php">About Us </a></div>
				<div class="navigation-small-item"><a href="<?php echo $baseUrl; ?>/leasingBenefits.php">Leasing Benefits</a></div>
				<div class="navigation-small-item"><a href="<?php echo $baseUrl; ?>/microMarkets.php">Micro Markets</a></div>
				<div class="navigation-small-item"><a href="<?php echo $baseUrl; ?>/officeFurniture.php">Office Furniture</a></div>
				<div class="navigation-small-item"><a href="<?php echo $baseUrl; ?>/vendorPrograms.php">Vendor Programs</a></div>
				<div class="navigation-small-item"><a href="<?php echo $baseUrl; ?>/contactUs.php">Contact Us</a></div>
			</div>
			
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
	
