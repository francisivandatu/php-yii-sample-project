<?php
    if(!isset($active))
      $active = 'home';
?>
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
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
		<ul id="sample" class="nav navbar-nav margin-adjustment hidden-xs">
			<li id="home" class="home <?php echo ($active == "home")? "active" : ""; ?> "><a href="index.php"><span class="glyphicon glyphicon-home"></span> <br />&nbsp;</a></li>
			<li id="about" class="about <?php echo ($active == "about")? "active" : ""; ?>"><a href="aboutUs.php">About Us <br />&nbsp;</a></li>
			<li id="leasing" class="leasing <?php echo ($active == "leasing")? "active" : ""; ?>"><a href="leasingBenefits.php">Leasing <br /> Benefits</a></li>
			<!--<li class="faq"><a href="faq.php">FAQs</a></li>-->
			<li id="markets" class="markets <?php echo ($active == "markets")? "active" : ""; ?>"><a href="microMarkets.php">Micro <br /> Markets</a></li>
			<li id="office-furniture" class="office-furniture <?php echo ($active == "office-furniture")? "active" : ""; ?>"><a href="officeFurniture.php">Office <Br /> Furniture</a></li>
			<li id="vendor" class="vendor <?php echo ($active == "vendor")? "active" : ""; ?>"><a href="vendorPrograms.php">Vendor <Br /> Programs</a></li>			
			<li id="contact" class="contact <?php echo ($active == "contact")? "active" : ""; ?>"><a href="contactUs.php">Contact Us <br />&nbsp;</a></li>
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
