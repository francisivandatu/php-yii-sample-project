<?php
switch($vendor->line_of_credit) {
	case "50,000": case "100,000": case "250,000":
			
		break;
	default:
			$other_line = $vendor->line_of_credit;
		break;
}

$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();

Yii::app()->clientScript->registerCss('formStyles', "
	.active .back1, .active .back2, .active .back3 {margin-right:4px;}
	body {background:#C7D9E9;}
	.container {background:#FFFFFF; font-size:14px; page-break-after: always; width: 768px;}
	.row-padding {margin-bottom:5px;}
	.form-style {border:1px solid silver; padding: 5px; color: #555; border-radius:4px; min-height:32px;word-wrap:break-word; }
	label { margin-bottom: 0px; }
	table, label {font-size:12px;}
");

$this->pageTitle=Yii::app()->name . ' - Application Form';

$form=$this->beginWidget('CActiveForm',array('id'=>'application-form', 
 'enableAjaxValidation'=>true,
 'clientOptions'=>array(
	'validateOnSubmit'=>true
 ),
'htmlOptions'=>array(
		'enctype' => 'multipart/form-data',
		)));
$baseUrl = Yii::app()->request->baseUrl;
?>

<div class="container">
	
	<div class="row" style="margin-top: 10px;">
		<div class="col-xs-12">
			<a href="/essex2/index.php" class="pull-left"><img src="<?php echo $baseUrl; ?>/images/logo.png" style="height:50px;"></a>
			<h1 class="pull-left" style="margin: 10px 0px 15px 20px; font-weight: bold; font-size: 30px;">EQUIPMENT LEASE APPLICATION </h1>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12" style="background:#6092c1;">
			<h2 class="title" style="margin:0px; float:left; background:#FFFFFF; padding: 0px 15px; font-size:24px;">CUSTOMER INFORMATION</h2>
		</div>
	</div>
	
	<table width="100%" border="1" style="border:1px solid #ffffff; margin-top:5px;" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%">
				<label><?php echo $app_form->getAttributeLabel('legal_name'); ?>:</label> <br />
				<div class="text-center"><?php echo (!empty($app_form->legal_name))? $app_form->legal_name : "adasdasd adadasd asdasd&nbsp"; ?></div>
			</td>
			<td width="50%"> &nbsp;
				<label>Sales Tax Exempt:</label>
				<label>
					<?php echo $form->radioButton($app_form,'tax_exempt', array('value'=>'Y','uncheckValue'=>null, 'checked' => ($app_form->tax_exempt == "Y")? true: false ,'class' => 'tax-exempt-yes')); ?>
					Yes
				</label>
				<label>
					<?php echo $form->radioButton($app_form,'tax_exempt', array('value'=>'N','uncheckValue'=>null, 'checked' => ($app_form->tax_exempt == "N")? true: false, 'class' => 'tax-exempt-no')); ?>
					No
				</label> <Br />
				&nbsp; <span style="font-size:10px;">"If Yes, exemption certificate must be attached"</span>
			</td>
		</tr>
		<tr>
			<td>
				<label><?php echo $app_form->getAttributeLabel('dba_name'); ?>:</label> <br />
				<div class="text-center"><?php echo $app_form->dba_name; ?></div>
			</td>
			<td> &nbsp;
				<label><?php echo $app_form->getAttributeLabel('fed_tax_id'); ?>:</label> <Br />
				<div class="text-center"><?php echo $app_form->fed_tax_id; ?></div>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $app_form->getAttributeLabel('address'); ?> <Br />
				<div class="text-center"><?php echo $app_form->address; ?></div>
			</td>
			<td> &nbsp;
				<?php echo $app_form->getAttributeLabel('mailing_address'); ?> <br />
				<?php echo $app_form->mailing_address; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $app_form->getAttributeLabel('city'); ?>, <?php echo $app_form->getAttributeLabel('state'); ?>, <?php echo $app_form->getAttributeLabel('zip'); ?> <br />
				<div class="text-center"><?php echo $app_form->getCityTextValue($app_form->city); ?>, <?php echo $app_form->getStateTextValue($app_form->state); ?>, <?php echo $app_form->zip; ?></div>
			</td>
			<td> &nbsp;
				<?php echo $app_form->getAttributeLabel('contact_name_title'); ?> <br />
				<div class="text-center"><?php echo $app_form->contact_name_title; ?> &nbsp;</div>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td width="50%"><?php echo $app_form->getAttributeLabel('phone'); ?> <?php echo $app_form->phone; ?></td>
						<td width="50%"><?php echo $app_form->getAttributeLabel('fax'); ?> <?php echo $app_form->fax; ?></td>
					</tr>
				</table>
			</td>
			<td> 
				<table width="100%">
					<tr>
						<td width="50%"> &nbsp; <?php echo $app_form->getAttributeLabel('business_start'); ?> <Br /> <?php echo $app_form->business_start; ?></td>
						<td width="50%"><?php echo $app_form->getAttributeLabel('business_incorporate'); ?> <br /> <?php echo $app_form->business_incorporate; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $app_form->getAttributeLabel('email'); ?> <?php echo $app_form->email; ?>
			</td>
			<td> &nbsp;
				<?php echo $app_form->getAttributeLabel('business_description'); ?> <br />
				<div class="text-center"><?php echo $app_form->business_description; ?></div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%">
					<tr>
						<td><?php echo $form->radioButton($app_form,'business_structure',array('value'=>'SP','uncheckValue'=>null)); ?> Sole Proprietorship</td>
						<td><?php echo $form->radioButton($app_form,'business_structure',array('value'=>'P','uncheckValue'=>null)); ?> Partnership</td>
						<td><?php echo $form->radioButton($app_form,'business_structure',array('value'=>'C','uncheckValue'=>null)); ?> Corporation</td>
						<td><?php echo $form->radioButton($app_form,'business_structure',array('value'=>'LLC','uncheckValue'=>null)); ?> Limited Liability Company (LLC)</td>
						<td><?php echo $form->radioButton($app_form,'business_structure',array('value'=>'O','uncheckValue'=>null)); ?> Other</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $app_form->getAttributeLabel('business_check_account'); ?> <br />
				<div class="text-center"><?php echo $app_form->business_check_account; ?></div>
			</td>
			<td> &nbsp;
				<?php echo $app_form->getAttributeLabel('business_loan_types'); ?> <br />
				<div class="text-center"><?php echo $app_form->business_loan_types; ?></div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%">
					<tr>
						<td>Other Banking <br /> Information</td>
						<td><?php echo $app_form->getAttributeLabel('other_banking_name'); ?> <br /> <?php echo $app_form->other_banking_name; ?> &nbsp;</td>
						<td><?php echo $app_form->getAttributeLabel('other_banking_contact'); ?> <br /> <?php echo $app_form->other_banking_contact; ?> &nbsp;</td>
						<td><?php echo $app_form->getAttributeLabel('other_banking_phone'); ?> <Br /> <?php echo $app_form->other_banking_phone; ?> &nbsp;</td>
						<td><?php echo $app_form->getAttributeLabel('other_banking_account_number'); ?> <br /> <?php echo $app_form->other_banking_account_number; ?> &nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>	
	
	<div class="row">
		<div class="col-xs-12" style="background:#6092c1;">
			<h2 class="title" style="margin:0px; float:left; background:#FFFFFF; padding: 0px 15px; font-size:24px;">Principal Information</h2>
		</div>
	</div>
	
	<table width="100%" border="1" style="border:1px solid #ffffff; margin-top:5px;" cellpadding="0" cellspacing="0">
		<tr>
			<td width="22%">Principal Name(s) and Title(s)</td>
			<td><?php echo (!empty($principal1->name_title))? $principal1->name_title : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal2->name_title))? $principal2->name_title : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal3->name_title))? $principal3->name_title : "&nbsp"; ?></td>
		</tr>
		<tr>
			<td>Home Address</td>
			<td><?php echo (!empty($principal1->address))? $principal1->address : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal2->address))? $principal2->address : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal3->address))? $principal3->address : "&nbsp"; ?></td>
		</tr>
		<tr>
			<td>City / State / Zip Code</td>
			<td><?php echo (!empty($principal1->location))? $principal1->location : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal2->location))? $principal2->location : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal3->location))? $principal3->location : "&nbsp"; ?></td>
		</tr>
		<tr>
			<td>% of Ownership</td>
			<td><?php echo (!empty($principal1->ownership))? $principal1->ownership : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal2->ownership))? $principal2->ownership : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal3->ownership))? $principal3->ownership : "&nbsp"; ?></td>
		</tr>
		<tr>
			<td>Social Security Number</td>
			<td><?php echo (!empty($principal1->security_number))? $principal1->security_number : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal2->security_number))? $principal2->security_number : "&nbsp"; ?></td>
			<td><?php echo (!empty($principal3->security_number))? $principal3->security_number : "&nbsp"; ?></td>
		</tr>
		<tr>
			<td><div style="padding:10px 0px;">Signature of Principals</td>
			<td>
				<table width="100%">
					<tr>
						<td><span style="font-size:10px;">Signature</span></td>
						<td width="30%"><span style="font-size:10px;">Date</span></td>
					</tr>
				</table>
			</td>
			<td>
				<table width="100%">
					<tr>
						<td><span style="font-size:10px;">Signature</span></td>
						<td width="30%"><span style="font-size:10px;">Date</span></td>
					</tr>
				</table>
			</td>
			<td>
				<table width="100%">
					<tr>
						<td><span style="font-size:10px;">Signature</span></td>
						<td width="30%"><span style="font-size:10px;">Date</span></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<div class="row">
		<div class="col-xs-12" style="background:#6092c1;">
			<h2 class="title" style="margin:0px; float:left; background:#FFFFFF; padding: 0px 15px; font-size:24px;">CREDIT RELEASE</h2>
		</div>
	</div>
	
	<p style="font-size:8px; margin-bottom: 0px;">
		Each individual listed as a principal above in this application certifies on behalf of the applicant company (the “Applicant”) and himself or herself as a principal of the Applicant (with the Applicant, each a “Credit Party” and collectively, the “Credit Parties”), that the information provided in this application is accurate and complete.  Each Credit Party expressly authorizes Essex Funding, Inc. (the “Company”) and/or any of its lending partners to obtain, directly or indirectly through its nominees, information from the references listed in this application and a Credit Party’s credit and/or background reports (collectively, "Reports") and understands that such Reports may be used by the lending partners of the Company in the determination of whether or not to enter into a credit agreement with the Credit Parties. Each Credit Party further expressly authorizes the Company and/or any of its lending partners to share any such Reports with the equipment vendor/manufacturer listed in this application. If the Applicant enters into a credit agreement with any of the Company’s lending partners, each of the Credit Parties consents to this authorization remaining on file and serving as on-going authorization for the Company and/or its lending partners to procure additional Reports at any other time during such time such credit agreement is in place for purposes of reviewing the account, increasing the credit line, taking collection action on the account and/or for any other legitimate purpose associated with the account as needed.  Each Credit Party understands that and consents to its credit information and this application being transmitted via the Internet, that such information may be accessible by unintended third parties and that such information is being submitted at such Credit Party’s own risk. Each Credit Party waives any right to any punitive damages arising out of or associated with the transmission, interception, use or misuse of such information.  Each Credit Party further waives any right or claim which such person would otherwise have under the Fair Credit Reporting Act in the absence of this continuing consent.  Each Credit Party, on behalf of the Applicant, may request the status of this application to be transmitted by electronic mail, and each Credit Party expressly authorizes the Company or its nominee(s) to transmit such message to the electronic mail address, which such Credit Party provides. 
	</p>
	
	<div class="row">
		<div class="col-xs-12" style="background:#6092c1;">
			<h2 class="title" style="margin:0px; float:left; background:#FFFFFF; padding: 0px 15px; font-size:24px;">TRADE REFERENCES</h2>
		</div>
	</div>
	
	<table width="100%" border="1" style="border:1px solid #ffffff; border-bottom:1px solid #000000; margin-top:5px;" cellpadding="0" cellspacing="0">
		<tr>
			<td><?php echo $trade->getAttributeLabel('trade_name'); ?></td>
			<td><?php echo $trade->getAttributeLabel('trade_location'); ?></td>
			<td><?php echo $trade->getAttributeLabel('trade_phone'); ?></td>
			<td><?php echo $trade->getAttributeLabel('trade_contact'); ?></td>
			<td><?php echo $trade->getAttributeLabel('trade_account_number'); ?></td>
		</tr>
		<tr>
			<td><?php echo (!empty($trade->trade_name))? $trade->trade_name : "&nbsp"; ?> &nbsp;</td>
			<td><?php echo (!empty($trade->trade_location))? $trade->trade_location : "&nbsp"; ?> &nbsp;</td>
			<td><?php echo (!empty($trade->trade_phone))? $trade->trade_phone : "&nbsp"; ?> &nbsp;</td>
			<td><?php echo (!empty($trade->trade_contact))? $trade->trade_contact : "&nbsp"; ?> &nbsp;</td>
			<td><?php echo (!empty($trade->trade_account_number))? $trade->trade_account_number : "&nbsp"; ?> &nbsp;</td>
		</tr>
		<tr>
			<td><?php echo (!empty($trade2->trade_name))? $trade2->trade_name : "&nbsp"; ?> &nbsp;</td>
			<td><?php echo (!empty($trade2->trade_location))? $trade2->trade_location : "&nbsp"; ?> &nbsp;</td>
			<td><?php echo (!empty($trade2->trade_phone))? $trade2->trade_phone : "&nbsp"; ?> &nbsp;</td>
			<td><?php echo (!empty($trade2->trade_contact))? $trade2->trade_contact : "&nbsp"; ?> &nbsp;</td>
			<td><?php echo (!empty($trade2->trade_account_number))? $trade2->trade_account_number : "&nbsp"; ?> &nbsp;</td>
		</tr>
	</table>
	
	<Br />
	<div class="row">
		<div class="col-xs-12" style="background:#6092c1; margin-bottom:5px;">
			<h2 class="title" style="margin:0px; float:left; background:#FFFFFF; padding: 0px 15px; font-size:24px;">Equipment Vendor / Manufacturer Information</h2>
		</div>
	</div>
	
	<table width="100%">
		<td><?php echo $vendor->getAttributeLabel('name'); ?> <?php echo (!empty($vendor->name))? $vendor->name : "&nbsp"; ?></td>
		<td><?php echo $vendor->getAttributeLabel('address'); ?> <?php echo (!empty($vendor->address))? $vendor->address : "&nbsp"; ?></td>
		<td><?php echo $vendor->getAttributeLabel('location'); ?> <?php echo (!empty($vendor->location))? $vendor->location : "&nbsp"; ?></td>
	</table>
	
	<table width="100%" border="1" style="border:1px solid #ffffff; border-bottom:1px solid #000000; margin-top:5px;" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%"><?php echo $vendor->getAttributeLabel('contact_person'); ?> <?php echo (!empty($vendor->contact_person))? $vendor->contact_person : "&nbsp"; ?></td>
			<td>&nbsp; asdsad</td>
		</tr>
		<tr>
			<td><?php echo $vendor->getAttributeLabel('equipment_description'); ?> <?php echo (!empty($vendor->equipment_description))? $vendor->equipment_description : "&nbsp"; ?></td>
			<td>&nbsp; asdasd</td>
		</tr>
		<tr>
			<td><?php echo $vendor->getAttributeLabel('monthly_payment'); ?> $<?php echo (!empty($vendor->monthly_payment))? number_format($vendor->monthly_payment, 2)  : "&nbsp"; ?></td>
			<td>&nbsp; asdasd</td>
		</tr>
		<tr>
			<td>Desired Term 
				<input value="12" name="VendorInfo[term]" id="VendorInfo_term" <?php echo ($vendor->term == 12)? 'checked="checked"': "";  ?> type="radio"> 12mo
				<input value="24" name="VendorInfo[term]" id="VendorInfo_term" <?php echo ($vendor->term == 24)? 'checked="checked"': "";  ?> type="radio"> 24mo
				<input value="36" name="VendorInfo[term]" id="VendorInfo_term" <?php echo ($vendor->term == 36)? 'checked="checked"': "";  ?> type="radio"> 36mo
				<input value="46" name="VendorInfo[term]" id="VendorInfo_term" <?php echo ($vendor->term == 46)? 'checked="checked"': "";  ?> type="radio"> 46mo
				<input value="60" name="VendorInfo[term]" id="VendorInfo_term" <?php echo ($vendor->term == 60)? 'checked="checked"': "";  ?> type="radio"> 60mo
			</td>
			<td>&nbsp; asdasd</td>
		</tr>
		<tr>
			<td colspan="2">
				If applying for a line of credit to buy multiple pieces of equipment, indicate size of line needed:

				<label>
						<input value="50,000" name="VendorInfo[line_of_credit]" id="VendorInfo_line_of_credit" <?php echo ($vendor->line_of_credit == "50,000") ? 'checked="checked"' : "";  ?> type="radio">$50,000
				</label>

				<label>
					<input value="100,000" name="VendorInfo[line_of_credit]" id="VendorInfo_line_of_credit" <?php echo ($vendor->line_of_credit == "100,000") ? 'checked="checked"' : "";  ?> type="radio">$100,000
				</label>

				<label>
					<input value="250,000" name="VendorInfo[line_of_credit]" id="VendorInfo_line_of_credit" <?php echo ($vendor->line_of_credit == "250,000") ? 'checked="checked"' : "";  ?> type="radio">$250,000
				</label>
			
				<label><?php echo $vendor->getAttributeLabel('other'); ?>:</label>
					<span ><?php echo (!empty($other_line))? $other_line :"_____"; ?></span>					
			</td>
		</tr>
	</table>
	
	<Br />
	<div class="row">
		<div class="col-xs-12" style="background:#6092c1; margin-bottom:5px;">
			<h2 class="title" style="margin:0px; float:left; background:#FFFFFF; padding: 0px 15px; font-size:24px; text-transform:none;">ECOA Notice <span style="font-size:20px;">(to be retained by applicant[s])</span></h2>
		</div>
	</div>
	
	<p style="font-size:8px; margin-bottom: 0px;">Thank you for your business credit application. We will review it carefully and get back to your promptly. If your application for business credit is denied, you have the right to a written statement of the specific reasons for the denial. To obtain that statement, please contact us within 60 days from the date you were notified of our decision. We will send you a written statement of the reasons for the denial within 30 days of your request for the statement provided we receive such statement from our applicable leading partner. Contact Essex Funding Inc., 101 East Kennedy Blvd. Suite 1820, Tampa, Florida, 33602, phone number 813.443.4632. NOTICE: The Federal Equal Credit Opportunity Act prohibits creditors from discriminating against credit applications on the basis of race, color, religion, national origin, sex, marital status, age (provided the applicant has the capacity to enter into a binding contract), because all or part of the applicant's income derives from any public assistance program; or because the applicant has in good faith exercised any right under the Consumer Credit Protection Act. The Federal Agency that administers our lending partner's compliance with this law is the Federal Reserve Bank of Chicago, P.O Box 1200, Minneapolis, MN, 55480.</p>
	<Br />
	
	<span style="background:#6092C1; padding:0px 5px;">For bank use only</span>
	<label><?php echo $ecoa->getAttributeLabel('name'); ?>:</label> <?php echo (!empty($ecoa->name))? '<span style="text-decoration:underline;">'.$ecoa->name.'</span>' : "_____________"; ?>
	<label><?php echo $ecoa->getAttributeLabel('banker_id'); ?>:</label> <?php echo (!empty($ecoa->banker_id))? '<span style="text-decoration:underline;">'.$ecoa->banker_id.'</span>' : "_________"; ?>	
	<label><?php echo $ecoa->getAttributeLabel('phone'); ?>:</label> <?php echo (!empty($ecoa->phone))? '<span style="text-decoration:underline;">'.$ecoa->phone.'</span>' : "_______________"; ?>
	<label><?php echo $ecoa->getAttributeLabel('fax'); ?>:</label> <?php echo (!empty($ecoa->fax))? '<span style="text-decoration:underline;">'.$ecoa->fax.'</span>' : "___________"; ?>
	
	
</div>

<div class="container">
	
	<br />
	<div class="row">
		<div class="col-xs-6">
			<div class="form-horizontal">
				
				
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-horizontal">
				
				<div class="form-group">
					<label class="col-xs-4 control-label" style="text-align:right"><?php echo $vendor->getAttributeLabel('contact_phone'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($vendor->contact_phone))? $vendor->contact_phone : "&nbsp"; ?></div>
					</div>	
				</div>
				
				<div class="form-group" style="margin-bottom:3px;">
					<label class="col-xs-4 control-label" style="text-align:right;"><?php 
						$equipmentLocation = str_replace('<Br />', ' ', $vendor->getAttributeLabel('equipment_location') );
						echo $equipmentLocation; 
					?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($vendor->equipment_location))? $vendor->equipment_location : "&nbsp"; ?></div>
					</div>
					
					<div class="col-sm-8 col-sm-offset-4 text-center" style="margin-top:4px;">(If different from company location) </div>
				</div>

				<div class="form-group">
					<label class="col-xs-4 control-label" style="text-align:right"><?php echo $vendor->getAttributeLabel('total_invoice'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style">$ <?php echo (!empty($vendor->total_invoice))? number_format($vendor->total_invoice, 2)  : "&nbsp"; ?></div>					
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-4 control-label" style="text-align:right; padding-top:20px;">Equipment Type:</label>
					<div class="col-xs-4 phone">
						<div class="radio" style="padding-top:20px">
							<label>
									<input value="1" name="VendorInfo[new_flag]" id="VendorInfo_new_flag" <?php echo ((int)$vendor->new_flag == 1)? 'checked="checked"': "";  ?> type="radio">	New
							</label>
						</div>
					</div>
					<div class="col-xs-4 phone">
						<div class="radio" style="padding-top:20px">
							<label>
								<input value="0" name="VendorInfo[new_flag]" id="VendorInfo_new_flag" <?php echo ((int)$vendor->new_flag == 0)? 'checked="checked"': "";  ?> type="radio"> Used
							</label>
						</div>
					</div>
				</div>

				<?php /*
				<div class="form-group">
					<label class="col-xs-4 control-label">End of Lease Option</label>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<input value="1" name="VendorInfo[lease_option]" id="VendorInfo_lease_option" checked="<?php echo ($vendor->lease_option == 1)? "checked": "";  ?>" type="radio">									FMV
							</label>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="radio">
							<label>
								<input value="2" name="VendorInfo[lease_option]" id="VendorInfo_lease_option" checked="<?php echo ($vendor->lease_option == 2)? "checked": "";  ?>" checked="checked" type="radio">									10% Option
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<input value="3" name="VendorInfo[lease_option]" id="VendorInfo_lease_option" checked="<?php echo ($vendor->lease_option == 3)? "checked": "";  ?>" type="radio">									$1.00
							</label>
						</div>
					</div>
					<div class="col-xs-3 col-xs-offset-4">
						<div class="radio">
							<label>
									<input value="4" name="VendorInfo[lease_option]"  id="VendorInfo_lease_option" checked="<?php echo ($vendor->lease_option == 4)? "checked": "";  ?>" type="radio">									10% PUT
							</label>
						</div>
					</div>
				</div>
				*/ ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
				<label>
					asdasdasdasdasssssssssssssssssssssssssssss
				</label>
			</div>
		</div>
		
	</div>
	
</div>

<div class="container">

	<div class="row" style="margin-top: 20px;">
		<div class="col-xs-12">
			<a href="/essex2/index.php"><img src="<?php echo $baseUrl; ?>/images/logo.png"></a>
		</div>
	</div>
	<hr />

	<div class="row">
		<div class="col-xs-12">
			<h2 class="title">Consent and Authorization</h2>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<h3 class="small-title">CREDIT CONSENT AND AUTHORIZATION</h3>
			
		</div>
		<div class="col-sm-12">
			<div class="checkbox">
				<label>
					 <?php

						// if($app_form->isNewRecord){
							echo CHtml::CheckBox('agree',1, array ('value'=>'1','class' => 'agree', 'disabled' => true));
							echo "<span style=\"line-height:26px; font-size:18px;\">All principals listed above in this application hereby AGREE to the Credit Consent and Authorization above.</span>";
						// }
						// else
							// echo CHtml::CheckBox('agree',true, array ('value'=>'1','class' => 'agree', 'style' => 'display: none;')); 
					?>
							
				</label>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">ECOA Notice</h3>
			
		</div>
		<br>
		<br>
		
	</div>
</div>

<?php $this->endWidget(); ?>