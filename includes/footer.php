		<div class="footer">
			<?php /* <div class="container bottom">
				<div class="row">
					<div class="col-xs-9">
						<h2>Interested in other types of business capital?</h2>
						<p class="footer3">Essex Funding, Inc., is an affiliate company of <a href="http://www.essexcapitalgroup.com/" target="_blank">Essex Capital Group, Inc.</a>, a diversified corporate finance firm that has raised over $400 million in varying debt transactions for scores of small and mid-market companies located across the United States.</p>
					</div>
					<div class="col-xs-3">
						<a href="http://www.essexcapitalgroup.com/" target="_blank"><img src="<?php echo $baseUrl; ?>images/logo-footer.png" class="pull-right" style="margin-top:10px;"></a>
					</div>
				</div>
			</div> */ ?>
			<div class="container" style="padding-top:15px;">
				<div class="row">
					<div class="col-md-6">
						<ul class="footer-links hidden-xs">
							<li><a href="<?php echo $baseUrl; ?>/termsOfUse.php" style="padding-left:0;">Terms Of Use</a></li>
							<li><a href="<?php echo $baseUrl; ?>/privacyPolicy.php">Privacy Policy</a></li>
							<li><a href="<?php echo $baseUrl; ?>/refundPolicy.php" style="border-right:none;">Refund Policy</a></li>
						</ul>
						<div class="hidden-lg hidden-md hidden-sm">
							<p><a href="<?php echo $baseUrl; ?>/termsOfUse.php" style="padding-left:0;">Terms Of Use</a></p>
							<p><a href="<?php echo $baseUrl; ?>/privacyPolicy.php">Privacy Policy</a></p>
							<p><a href="<?php echo $baseUrl; ?>/refundPolicy.php" style="border-right:none;">Refund Policy</a></p>
						</div>
						<br />
						<p>All Rights Reserved. © Essex Funding, Inc.</p>
						
					
		
	
					</div>
					<div class="col-md-2 col-md-offset-2">
						<p>Phone:<br /><span class="glyphicon glyphicon-earphone"></span>&nbsp;&nbsp;&nbsp;&nbsp;(813)443-4632</p>
					</div>
					<div class="col-md-2" style="padding-right: 10px; margin-top: -5px;">
						<p><strong class="footer-title">Essex Funding, Inc.</strong><br />101 East Kennedy Blvd.<br /> Suite 1820<br />Tampa, Florida 33602 </p>
					</div>
					
				</div>
			</div>
		</div>
		
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/simple.js"></script>
		<script>
		</script>
		<script>
		
			$(document).ready(function(){
				
				var activeLi = $('#sample li.active');
				var hr = $('#sample hr');
				
				if(  activeLi.prop('id') == 'home' ) {
					
					hr.css({'margin-left':'0'});
					
				}
				if(  activeLi.prop('id') == 'about' ) {
					
					hr.css({'margin-left':'14.2857%'});
					
				}
				if(  activeLi.prop('id') == 'leasing' ) {
					
					hr.css({'margin-left':'28.5714%'});
					
				}
				if(  activeLi.prop('id') == 'markets' ) {
					
					hr.css({'margin-left':'42.8571%'});
					
				}
				if(  activeLi.prop('id') == 'office-furniture' ) {
					
					hr.css({'margin-left':'57.1428%'});
					
				}
				if(  activeLi.prop('id') == 'vendor' ) {
					
					hr.css({'margin-left':'71.4285%'});
					
				}
				if(  activeLi.prop('id') == 'contact' ) {
					
					hr.css({'margin-left':'85.7142%'});
					
				}
				
				
			});
			
		</script>
		
		<!--<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-29209734-9', 'auto');
		  ga('send', 'pageview');

		</script> -->
		
	</body>
</html>