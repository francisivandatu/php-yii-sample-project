<?php include('includes/header.php'); ?>
	<div class="container content-container">
		<div class="row form-group">
			<div class="col-xs-12">
				<ul class="nav nav-pills nav-justified thumbnail setup-panel">
					<li class="active" style="padding:0px 2px;"><a href="#step-1">
						<h4 class="list-group-item-heading">Step 1</h4>
						<p class="list-group-item-text text-center">Customer Information</p>
					</a></li>
					<li class="active" style="padding:0px 2px;"><a href="#step-2">
						<h4 class="list-group-item-heading">Step 2</h4>
						<p class="list-group-item-text text-center">Principal Information</p>
					</a></li>
					<li class="active" style="padding:0px 2px;"><a href="#step-3">
						<h4 class="list-group-item-heading">Step 3</h4>
						<p class="list-group-item-text text-center" style="font-size:16px">Equipment Vendor Information</p>
					</a></li>
					<li class="disabled"><a href="#step-4">
						<h4 class="list-group-item-heading">Step 4</h4>
						<p class="list-group-item-text text-center">ECO Notice</p>
					</a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3 class="small-title">Trade References</h3>
				<br />
				<div class="col-sm-3">
					<div class="form-group">
						<label>
							Name of Reference
						</label>
						<input class="form-control" type="text" style="margin-bottom:2px;"></input>
						<input class="form-control" type="text"></input>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>
							City / State
						</label>
						<input class="form-control" type="text" style="margin-bottom:2px;"></input>
						<input class="form-control" type="text"></input>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label>
							Phone
						</label>
						<input class="form-control" type="text" style="margin-bottom:2px;"></input>
						<input class="form-control" type="text"></input>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label>
							Contact
						</label>
						<input class="form-control" type="text" style="margin-bottom:2px;"></input>
						<input class="form-control" type="text"></input>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label>
							Account No.
						</label>
						<input class="form-control" type="text" style="margin-bottom:2px;"></input>
						<input class="form-control" type="text"></input>
					</div>
				</div>
				<div class="col-sm-8">
					<p style="font-style:italic; font-size:14px;">
					<a href="refundPolicy.php">Non-refundable credit application fee provision.</a>
				</p>
				</div>
			</div>
			<div class="col-md-12">
				<h3 class="small-title">Equipment Vendor / Manufacturer Information</h3>
				<br />
				<div class="col-sm-4">
					<div class="form-group">
						<label>
							Vendor Name
						</label>
						<input class="form-control" type="text"></input>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>
							Street Address
						</label>
						<input class="form-control" type="text"></input>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>
							City, State, Zip
						</label>
						<input class="form-control" type="text"></input>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-4 control-label">Contact Person</label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Equipment Description</label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Desired Monthly Payment</label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input class="form-control" type="text" placeholder=""></input>

							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Desired Term</label>
						<div class="col-sm-2">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									12mo
								</label>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									24mo
								</label>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									36mo
								</label>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									46mo
								</label>
							</div>
						</div>
						<div class="col-sm-2 col-sm-offset-4">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									60mo
								</label>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-4 control-label">Phone Number</label>
						<div class="col-sm-4">
							<input type="text" class="form-control"></input>
						</div>
						<div class="col-sm-2 phone">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
									New
								</label>
							</div>
						</div>
						<div class="col-sm-2 phone">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
									Old
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Equipment Location</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" placeholder="(if different than vendor location)" style="line-height:30px;">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Total Invoice Amount Without Tax</label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input class="form-control" type="text" placeholder=""></input>

							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">End of Lease Option</label>
						<div class="col-sm-2">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									FMV
								</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									10% Option
								</label>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									$1.00
								</label>
							</div>
						</div>
						<div class="col-sm-3 col-sm-offset-4">
							<div class="radio">
								<label>
									 <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
									10% PUT
								</label>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>
						If applying for a line of credit to buy multiple pieces of equipment, indicate size of line needed:
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="radio">
					<label>
						<input id="optionsRadios1" type="radio" checked="" value="option1" name="optionsRadios"></input>
						$50, 000
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="radio">
					<label>
						<input id="optionsRadios1" type="radio" checked="" value="option1" name="optionsRadios"></input>
						$100, 000
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="radio">
					<label>
						<input id="optionsRadios1" type="radio" checked="" value="option1" name="optionsRadios"></input>
						$250, 000
					</label>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="form-group">
					<label class="col-sm-2 control-label other">Other:</label>
					<div class="col-sm-8 col-md-8 other-input">
						<input type="text" class="form-control">
					</div>
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-sm-12">
				<button class="btn btn-primary orange-btn pull-right" type="submit">Next</button>
			</div>
		</div>
	</div>
	
<?php include('includes/footer.php'); ?>