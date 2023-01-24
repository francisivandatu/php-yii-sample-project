<?php include('includes/header.php'); ?>
	<div class="container content-container">
		<div class="row form-group">
			<div class="col-xs-12">
				<ul class="nav nav-pills nav-justified thumbnail setup-panel">
					<li class="active"><a href="#step-1">
						<h4 class="list-group-item-heading">Step 1</h4>
						<p class="list-group-item-text text-center">Customer Information</p>
					</a></li>
					<li class="disabled"><a href="#step-2">
						<h4 class="list-group-item-heading">Step 2</h4>
						<p class="list-group-item-text text-center">Principal Information</p>
					</a></li>
					<li class="disabled"><a href="#step-3">
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
				<h2 class="title">Credit Application</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-4 control-label">Business Legal Name <font style="color:red;">*</font></label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">DBAName (if any)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Street Address</label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">City, State</label>
						<div class="col-sm-4">
							<select>
								<option>City</option>
							</select>
						</div>
						<div class="col-sm-4">
							<select>
								<option>State</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Zip</label>
						<div class="col-sm-4">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Phone</label>
						<div class="col-sm-4">
							<input type="text" class="form-control">
						</div>
						<label class="col-sm-2 control-label">Fax</label>
						<div class="col-sm-4">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Cell</label>
						<div class="col-sm-4">
							<input type="text" class="form-control">
						</div>
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-4">
							<input type="text" class="form-control">
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-4 control-label">Sales Tax Exempt:</label>
						<label class="checkbox-inline">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> Yes
						</label>
						<label class=" checkbox-inline">
							<input type="checkbox" id="inlineCheckbox1" value="option1"> No
						</label>
						<p class="col-sm-4 small pull-right exempt">If "Yes", exemption certificate must be submitted.</p>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Fed Tax ID</label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" style="font-size:11px">Mailing Address or PO Box</label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Contact Name & Title <font style="color:red;">*</font></label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Date Business Started <font style="color:red;">*</font></label>
						<div class="col-sm-3">
							<select>
								<option>--</option>
							</select>
						</div>
						<label class="col-sm-3 control-label">Date Business Incorporated</label>
						<div class="col-sm-3">
							<select>
								<option>--</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Description of Business</label>
						<div class="col-sm-8">
							<input type="text" class="form-control">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="row">
				<div class="col-md-8">
					<label class="col-sm-4 control-label" style="padding-top: 10px;">Business Type <font style="color:red;">*</font></label>
				</div>
			</div>
			<div class="col-md-2">
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
						Sole Proprietorship
					</label>
				</div>
			</div>
			<div class="col-md-2">
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
						Partnership
					</label>
				</div>
			</div>
			<div class="col-md-2">
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
						Corporation
					</label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
						Limited Liability Company (LLC)
					</label>
				</div>
			</div>
			<div class="col-md-2">
				<div class="radio">
					<label>
						<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
						Other
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>
						Business Checking Account #
					</label>
					<input class="form-control" type="text"></input>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>
						Business Loan Type(s), Account # (s)
					</label>
					<input class="form-control" type="text"></input>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="col-sm-12">
					<label>
						Other Banking Information:
					</label>
				</div>
				<div class="col-sm-3">
					<input class="form-control" type="text" placeholder="Bank Name"></input>
				</div>
				<div class="col-sm-3">
					<input class="form-control" type="text" placeholder="Contact Number"></input>
				</div>
				<div class="col-sm-3">
					<input class="form-control" type="text" placeholder="Phone Number"></input>
				</div>
				<div class="col-sm-3">
					<input class="form-control" type="text" placeholder="Account Number"></input>
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-sm-6 pull-left">
				<label>
						<font style="color:red; padding-top:10px;">*</font><i>Required Fields</i>
				</label>
			</div>
			<div class="col-sm-6">
				<button class="btn btn-primary orange-btn pull-right" type="submit">Next</button>
			</div>
		</div>
	</div>
	
<?php include('includes/footer2.php'); ?>