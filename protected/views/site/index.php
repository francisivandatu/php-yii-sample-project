<?php 
$baseUrl = Yii::app()->baseUrl;
$this->pageTitle=Yii::app()->name; ?>    

<?php $this->widget('Header') ;?>
<?php /*<div class="container content-banner hidden-xs hidden-sm">
	<div class="row">
		<img alt="First slide" src="images/essex-banner1.jpg" class="img-responsive">
		<h1 class="top1">100%</h1><h1 class="top2">FINANCING</h1>
		<h1 class="top3">IS AVAILABLE</h1>
		<h4>We are a nationwide provider of equipment financing for growing businesses.</h4>
	</div>
</div> */ ?>
<div class="container">
		<div class="row">
			<img alt="First slide" src="images/home_banner2.png" class="img-responsive">
		</div>
	</div>
<div class="container lead-container equip">
	<div class="row">
		<div class="col-md-7 col-sm-8 col-xs-12 ">
			<h2>NEED EQUIPMENT FINANCING FOR YOUR BUSINESS?</h2>
		</div>
		<div class="col-md-5 col-sm-4 col-xs-12 text-right">
			
			
			<a class="btn btn-primary btn-lg orange-btn hidden-xs" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication" style="padding:5px 25px; margin-bottom:5px;">Apply Now</a>
			
			<a class="btn btn-primary btn-lg orange-btn hidden-xs" role="button" href="<?php echo $baseUrl; ?>/leaseCalculator" style="padding:5px 20px; margin-bottom:5px;">Lease Calculator</a>
			
			<br class="hidden-lg hidden-md hidden-sm" />
			
			
			<a class="btn btn-primary btn-lg pull-right orange-btn hidden-lg hidden-md hidden-sm" role="button" href="<?php echo $baseUrl; ?>/applicationForm/creditApplication" style="width:100%; margin-bottom:5px;">Apply Now</a>
			<a class="btn btn-primary btn-lg pull-right orange-btn hidden-lg hidden-md hidden-sm" role="button" href="<?php echo $baseUrl; ?>/leaseCalculator" style="width:100%;">Lease Calculator</a>
			
		</div>
	</div>
</div>

<div class="container content-container">
	<div class="row">
		<div class="col-md-12">
			<p align="justify">Essex Funding, Inc. offers a full range of financing solutions for equipment acquisitions in a variety of industries including vending, healthcare, construction, technology and hospitality to name a few. Our simple, straightforward process allows clients to expand their business through more rapid equipment acquisition than might otherwise be possible using their existing credit facilities.</p>
			<br />
			<p align="justify">An Essex Funding financing program can provide:</p>
		</div>
		<div class="col-md-11 col-md-offset-1">
			<div class="bullet one">
				<p align="justify">A pre-approved credit facility to purchase up to a specified dollar amount of equipment.</p>
				<ul>
					<li>Up to $100,000 line of credit with a simple, one page application.</li>
					<li>When you are ready to buy, the capital is already allocated for the purchase.</li>
				</ul>
			</div>
			<div class="bullet two">
				<p align="justify">Financing for 100% of the total cost of equipment acquisitions.</p>
			</div>
			<div class="bullet three">
				<p align="justify">48 hour credit approval.</p>
			</div>
			<div class="bullet four">
				<p align="justify">Lease terms up to 60 months to improve cash flow with a $1.00 buyout at the end.</p>
				<ul>
					<li>You use the equipment for the lease term and own it upon completion.</li>
				</ul>
			</div>
		</div>
	
		<div class="col-md-12">
			<br />
			<?php /*<p>Essex Funding, Inc., is an affiliate company of <a href="http://www.essexcapitalgroup.com/" target="_blank">Essex Capital Group, Inc.</a> a diversified corporate finance firm that has arranged over $400 million in varying debt transactions for scores of small and mid-market companies located across the United States. </p>*/?>
			<p align="justify">To find out if you qualify, simply click on the "Apply Now" link above and complete our simple application or, for more information, <a href="contactUs.php">email</a> or call us at <strong class="green" style="font-weight:bold; font-color:#02417a">(813) 443-4632</strong>.</p>
		</div> 
		
		
		
		<style>
		/* Base styles (regardless of theme) */
		.bs-callout {
		  margin: 20px 0;
		  padding: 15px 30px 15px 15px;
		  border-left: 5px solid #5a8b04;
		}
		
		/* Themes for different contexts */
		.bs-callout-green {
		  background-color: #D3F26D;
		  /* border-color: #dFb5b4; */
		  color:#02417a;
		}
		</style>
		
	</div>
</div>
<?php $this->widget('Footer') ;?>