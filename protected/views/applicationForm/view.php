<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();

Yii::app()->clientScript->registerCss('formStyles', "
	.active .back1, .active .back2, .active .back3 {margin-right:4px;}
        .container {font-size:14px;}
	.row-padding {margin-bottom:5px;}
	.form-style {border:1px solid silver; padding: 5px; color: #555; border-radius:4px;}
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

<div >
    
	<div class="row">
		<div class="col-xs-12">
			<h2 class="title">Credit Application</h2>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-6">
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('legal_name'); ?>:</label>
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->legal_name; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('dba_name'); ?>:</label>
				</div>
				<div class="col-xs-8">
                                    <div class="form-style"><?php echo (!empty($app_form->dba_name))? $app_form->dba_name: "&nbsp"; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('address'); ?></label>:
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->address; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('city'); ?></label>:
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->city; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('state'); ?></label>:
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->state; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('zip'); ?></label>:
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->zip; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('phone'); ?></label>:
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->phone; ?></div>
				</div>
			</div>

			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('fax'); ?></label>:
				</div>
				<div class="col-xs-8">
                                    <div class="form-style"><?php echo (!empty($app_form->fax))? $app_form->fax: "&nbsp"; ?></div>
				</div>
			</div>
			
			<?php /*
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('mobile'); ?></label>:
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->mobile; ?></div>
				</div>
			</div>
			*/ ?>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('email'); ?></label>:
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->email; ?></div>
				</div>
			</div>
		</div>
		
		<div class="col-xs-6">
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label">Sales Tax Exempt:</label>
				</div>
				<div class="col-xs-8">
					<label class="checkbox-inline">
						<?php echo $form->radioButton($app_form,'tax_exempt', array('value'=>'Y','uncheckValue'=>null, 'checked' => ($app_form->tax_exempt == "Y")? true: false ,'class' => 'tax-exempt-yes', 'disabled' => true)); ?>
						Yes
					</label>
					<label class=" checkbox-inline">
						<?php echo $form->radioButton($app_form,'tax_exempt', array('value'=>'N','uncheckValue'=>null, 'checked' => ($app_form->tax_exempt == "N")? true: false, 'class' => 'tax-exempt-no', 'disabled' => true)); ?>
						No
					</label>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('fed_tax_id'); ?>:</label>
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->fed_tax_id; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('mailing_address'); ?>:</label>
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->mailing_address; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('contact_name_title'); ?>:</label>
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->contact_name_title; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('business_start'); ?>:</label>
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->business_start; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('business_incorporate'); ?>:</label>
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->business_incorporate; ?></div>
				</div>
			</div>
			
			<div class="row row-padding">
				<div class="col-xs-4">
					<label class="control-label"><?php echo $app_form->getAttributeLabel('business_description'); ?>:</label>
				</div>
				<div class="col-xs-8">
					<div class="form-style"><?php echo $app_form->business_description; ?></div>
				</div>
			</div>
		</div>
	</div>

	<br />
	<div class="row">
		<div class="col-xs-12">
			<strong><?php echo $app_form->getAttributeLabel('business_structure'); ?>:</strong>
		</div>
	</div>
	
	<br />
	<div class="row">			
		<div class="col-xs-3">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'SP','uncheckValue'=>null, 'disabled' => true)); ?>
					Sole Proprietorship
				</label>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'P','uncheckValue'=>null, 'disabled' => true)); ?>
					Partnership
				</label>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'C','uncheckValue'=>null, 'disabled' => true)); ?>
					Corporation
				</label>
			</div>
		</div>
		<div class="col-xs-3">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'LLC','uncheckValue'=>null, 'disabled' => true)); ?>
					Limited Liability Company (LLC)
				</label>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'O','uncheckValue'=>null, 'disabled' => true)); ?>
					Other
				</label>
			</div>
		</div> 
	</div>
	
	<br />
	<div class="row">
		<div class="col-xs-6">
				<label class="control-label"><?php echo $app_form->getAttributeLabel('business_check_account'); ?>:</label>
		</div>
		<div class="col-xs-6">
				<label class="control-label"><?php echo $app_form->getAttributeLabel('business_loan_types'); ?>:</label>
		</div>
		<div class="col-xs-6">
			<div class="form-style"><?php echo $app_form->business_check_account; ?></div>
		</div>
		<div class="col-xs-6">
			<div class="form-style"><?php echo $app_form->business_loan_types; ?></div>
		</div>				
	</div>
	<br />
	<div class="row">
		<div class="col-xs-12" >
			<label><strong>Other Banking Information: </strong></label>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3" >
			<div class="form-group">
				<label><?php echo $app_form->getAttributeLabel('other_banking_name'); ?>: </label>
				<div class="form-style"><?php echo $app_form->other_banking_name; ?></div>	
			</div>
		</div>
		<div class="col-xs-3" >
			<div class="form-group">
				<label><?php echo $app_form->getAttributeLabel('other_banking_contact'); ?>: </label>
				<div class="form-style"><?php echo $app_form->other_banking_contact; ?></div>
			</div>
		</div>
		<div class="col-xs-3" >
			<div class="form-group">
				<label><?php echo $app_form->getAttributeLabel('other_banking_phone'); ?>: </label>
				<div class="form-style"><?php echo $app_form->other_banking_phone; ?></div>
			</div>
		</div>
		<div class="col-xs-3" >
			<div class="form-group">
				<label><?php echo $app_form->getAttributeLabel('other_banking_account_number'); ?>: </label>
				<div class="form-style"><?php echo $app_form->other_banking_account_number; ?></div>
			</div>
		</div>
	</div>
	
</div>


<div >

	<div class="row">
		<div class="col-xs-12">
			<h2 class="title">Principal Information</h2>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="col-xs-3">
				<h3 class="small-title"></h3>
			</div>
			<div class="col-xs-3 text-center"><span class="badge">1</span></div>
			<div class="col-xs-3 text-center"><span class="badge">2</span></div>
			<div class="col-xs-3 text-center"><span class="badge">3</span></div>
		</div>
		<br style="clear:both;" /><br />
		<div class="col-sm-12">
			<div class="form-group" style="height: 30px;">
				<label class="col-xs-3 control-label">Principal Name(s) and Title(s)</label>
			
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal1->name_title))? $principal1->name_title : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal2->name_title))? $principal1->name_title : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal3->name_title))? $principal1->name_title : "&nbsp"; ?></div>
				</div>
			</div>

			<div class="form-group" style="height: 30px;">
				<label class="col-xs-3 control-label">Home Address</label>
			
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal1->address))? $principal1->address : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal2->address))? $principal1->address : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal3->address))? $principal1->address : "&nbsp"; ?></div>
				</div>
			</div>

			<div class="form-group" style="height: 30px;">
				<label class="col-xs-3 control-label">City/State/Zip Code</label>
			
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal1->location))? $principal1->location : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal2->location))? $principal1->location : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal3->location))? $principal1->location : "&nbsp"; ?></div>
				</div>
			</div>

			<div class="form-group" style="height: 30px;">
				<label class="col-xs-3 control-label">% of Ownership</label>
			
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal1->ownership))? $principal1->ownership : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal2->ownership))? $principal1->ownership : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal3->ownership))? $principal1->ownership : "&nbsp"; ?></div>
				</div>
			</div>			

			<div class="form-group" style="height: 30px;">
				<label class="col-xs-3 control-label">Social Security Number</label>
			
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal1->security_number))? $principal1->security_number : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal2->security_number))? $principal1->security_number : "&nbsp"; ?></div>
				</div>
				<div class="col-xs-3">
					<div class="form-style"><?php echo (!empty($principal3->security_number))? $principal1->security_number : "&nbsp"; ?></div>
				</div>
			</div>
			
			<div class="form-group" style="height: 30px;">
				<label class="col-xs-3 control-label">I agree to the credit release below.</label>
			
				<div class="col-xs-3">
					<?php echo CHtml::checkBox('', ($principal1->check_flag == 1 OR $principal1 == '1')? true : false, array('disabled' => true)); ?>
				</div>
				<div class="col-xs-3">
					<?php echo CHtml::checkBox('', ($principal2->check_flag == 1 OR $principal1 == '1')? true : false, array('disabled' => true)); ?>
				</div>
				<div class="col-xs-3">
					<?php echo CHtml::checkBox('', ($principal3->check_flag == 1 OR $principal1 == '1')? true : false, array('disabled' => true)); ?>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">Credit Release</h3>
			<p>Each individual signing as principal certifies that the information provided in this app is accurate and complete. Each individual signing as principal authorizes Essex Funding, Inc. or any of its lending partners to obtain information from the references listed herein and obtain consumer credit reports that will be ongoing and relate not only to the evaluation and/or extension of the business credit requested, but also for purpose of reviewing the account, increasing the credit line, taking collection action on the account and for any other legitimate purpose associated with the account as needed. Each individual signing as principal further waives any right or claim which such individual would otherwise have under the Fair Credit Reporting Act in the absence of this continuing consent.</p>
		</div>
	</div>
</div>

<div >

	<div class="row">
		<div class="col-xs-12">
			<h2 class="title">Equipment Vendor Information</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">Trade References</h3>
			<br>
			<div class="col-xs-3">
				<div class="form-group">
					<label class="control-label"><?php echo $trade->getAttributeLabel('trade_name'); ?>:</label>
					<div class="form-style"><?php echo (!empty($trade->trade_name))? $trade->trade_name : "&nbsp"; ?></div>	
				</div>
				<div class="form-group">
					<div class="form-style"><?php echo (!empty($trade2->trade_name))? $trade2->trade_name : "&nbsp"; ?></div>
				</div>
			</div>

			<div class="col-xs-3">
				<div class="form-group">
					<label class="control-label"><?php echo $trade->getAttributeLabel('trade_location'); ?>:</label>
					<div class="form-style"><?php echo (!empty($trade->trade_location))? $trade->trade_location : "&nbsp"; ?></div>	
				</div>
				<div class="form-group">
					<div class="form-style"><?php echo (!empty($trade2->trade_location))? $trade2->trade_location : "&nbsp"; ?></div>
				</div>
			</div>

			<div class="col-xs-2">
				<div class="form-group">
					<label class="control-label"><?php echo $trade->getAttributeLabel('trade_phone'); ?>:</label>
					<div class="form-style"><?php echo (!empty($trade->trade_phone))? $trade->trade_phone : "&nbsp"; ?></div>	
				</div>
				<div class="form-group">
					<div class="form-style"><?php echo (!empty($trade2->trade_phone))? $trade2->trade_phone : "&nbsp"; ?></div>
				</div>
			</div>

			<div class="col-xs-2">
				<div class="form-group">
					<label class="control-label"><?php echo $trade->getAttributeLabel('trade_contact'); ?>:</label>
					<div class="form-style"><?php echo (!empty($trade->trade_contact))? $trade->trade_contact : "&nbsp"; ?></div>	
				</div>
				<div class="form-group">
					<div class="form-style"><?php echo (!empty($trade2->trade_contact))? $trade2->trade_contact : "&nbsp"; ?></div>
				</div>
			</div>

			<div class="col-xs-2">
				<div class="form-group">
					<label class="control-label"><?php echo $trade->getAttributeLabel('trade_account_number'); ?>:</label>
					<div class="form-style"><?php echo (!empty($trade->trade_account_number))? $trade->trade_account_number : "&nbsp"; ?></div>	
				</div>
				<div class="form-group">
					<div class="form-style"><?php echo (!empty($trade2->trade_account_number))? $trade2->trade_account_number : "&nbsp"; ?></div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<p style="font-style:italic; font-size:14px;">
			Non-refundable credit application fee provision.</p>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">Equipment Vendor / Manufacturer Information</h3>
			<br>
			<div class="col-xs-4">
				<label class="control-label"><?php echo $vendor->getAttributeLabel('name'); ?>:</label>
				<div class="form-style"><?php echo (!empty($vendor->name))? $vendor->name : "&nbsp"; ?></div>	
			</div>
			<div class="col-xs-4">
				<label class="control-label"><?php echo $vendor->getAttributeLabel('address'); ?>:</label>
				<div class="form-style"><?php echo (!empty($vendor->address))? $vendor->address : "&nbsp"; ?></div>	
			</div>
			<div class="col-xs-4">
				<label class="control-label"><?php echo $vendor->getAttributeLabel('location'); ?>:</label>
				<div class="form-style"><?php echo (!empty($vendor->location))? $vendor->location : "&nbsp"; ?></div>	
			</div>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-xs-6">
			<div class="form-horizontal">
			
				<div class="form-group">
					<label class="col-xs-4 control-label"><?php echo $vendor->getAttributeLabel('contact_person'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($vendor->contact_person))? $vendor->contact_person : "&nbsp"; ?></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-4 control-label"><?php echo $vendor->getAttributeLabel('equipment_description'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($vendor->equipment_description))? $vendor->equipment_description : "&nbsp"; ?></div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-4 control-label"><?php echo $vendor->getAttributeLabel('monthly_payment'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style">$ <?php echo (!empty($vendor->monthly_payment))? number_format($vendor->monthly_payment, 2)  : "&nbsp"; ?></div>
					</div>	
				</div>
				

				
				<div class="form-group">
					<label class="col-xs-4 control-label">Desired Term</label>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<input value="12" name="VendorInfo[term]" id="VendorInfo_term" disabled="disabled" checked="<?php echo ($vendor->term == 12)? "checked": "";  ?>" type="radio">								12mo
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<input value="24" name="VendorInfo[term]" id="VendorInfo_term" disabled="disabled" checked="<?php echo ($vendor->term == 24)? "checked": "";  ?>" type="radio">								24mo
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<input value="36" name="VendorInfo[term]" id="VendorInfo_term" disabled="disabled" checked="<?php echo ($vendor->term == 36)? "checked": "";  ?>" type="radio">								36mo
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<input value="46" name="VendorInfo[term]" id="VendorInfo_term" disabled="disabled" checked="<?php echo ($vendor->term == 46)? "checked": "";  ?>" type="radio">								46mo
							</label>
						</div>
					</div>
					<div class="col-xs-2 col-xs-offset-4">
						<div class="radio">
							<label>
								<input value="60" name="VendorInfo[term]" id="VendorInfo_term" disabled="disabled" checked="<?php echo ($vendor->term == 60)? "checked": "";  ?>" type="radio">								60mo
							</label>
						</div>
					</div> 
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-horizontal">

				<div class="form-group">
					<label class="col-xs-12 control-label"><?php 
						$equipmentLocation = str_replace('<Br />', ' ', $vendor->getAttributeLabel('equipment_location') );
						echo $equipmentLocation; 
					?>:</label>
					<div class="col-xs-12">
						<div class="form-style"><?php echo (!empty($vendor->equipment_location))? $vendor->equipment_location : "&nbsp"; ?></div>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-4 control-label" style="text-align:right"><?php echo $vendor->getAttributeLabel('contact_phone'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($vendor->contact_phone))? $vendor->contact_phone : "&nbsp"; ?></div>
					</div>	
				</div>
				
				<div class="form-group">
					<label class="col-xs-4 control-label" style="text-align:right"><?php echo $vendor->getAttributeLabel('total_invoice'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style">$ <?php echo (!empty($vendor->total_invoice))? number_format($vendor->total_invoice, 2)  : "&nbsp"; ?></div>					
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-4 control-label" style="text-align:right">Equipment Type:</label>
					<div class="col-xs-4 phone">
						<div class="radio">
							<label>
									<input value="1" name="VendorInfo[new_flag]" id="VendorInfo_new_flag" disabled="disabled" <?php echo (($vendor->new_flag == 1) OR ($vendor->new_flag == "1"))? 'checked="checked"': "";  ?> type="radio">	New
							</label>
						</div>
					</div>
					<div class="col-xs-4 phone">
						<div class="radio">
							<label>
								<input value="0" name="VendorInfo[new_flag]" id="VendorInfo_new_flag" disabled="disabled" <?php echo (($vendor->new_flag == 0) OR ($vendor->new_flag == "0"))? 'checked="checked"': "";  ?> type="radio"> Used
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
					If applying for a line of credit to buy multiple pieces of equipment, indicate size of line needed:
				</label>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="radio">
				<label>
						<input value="50,000" name="VendorInfo[line_of_credit]" id="VendorInfo_line_of_credit" disabled="disabled" <?php echo ($vendor->line_of_credit == "50,000")? 'checked="checked"': "";  ?> type="radio">					$50, 000
				</label>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="radio">
				<label>
					<input value="100,000" name="VendorInfo[line_of_credit]" id="VendorInfo_line_of_credit" disabled="disabled" <?php echo ($vendor->line_of_credit == "100,000")? 'checked="checked"': "";  ?> type="radio">					$100, 000
				</label>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="radio">
				<label>
					<input value="250,000" name="VendorInfo[line_of_credit]" id="VendorInfo_line_of_credit" disabled="disabled" <?php echo ($vendor->line_of_credit == "250,000")? 'checked="checked"': "";  ?> type="radio">					$250, 000
				</label>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<label class="col-xs-2 control-label" style="padding-top: 10px;"><?php echo $vendor->getAttributeLabel('other'); ?>:</label>
				<div class="col-xs-8" style="padding-top: 7px;">
					<div class="form-style"><?php echo (!empty($other_line))? $other_line  : "&nbsp"; ?></div>					
				</div>
			</div>
		</div>
	</div>
</div>

<div >

	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">ECOA Notice (to be retained by applicant[s])</h3>
			<p>Thank you for your business credit application. We will review it carefully and get back to your promptly. If your application for business credit is denied, you have the right to a written statement of the specific reasons for the denial. To obtain that statement, please contact us within 60 days from the date you were notified of our decision. We will send you a written statement of the reasons for the denial within 30 days of your request for the statement provided we receive such statement from our applicable leading partner. Contact Essex Funding Inc., 101 East Kennedy Blvd. Suite 1820, Tampa, Florida, 33602, phone number 813.443.4632. NOTICE: The Federal Equal Credit Opportunity Act prohibits creditors from discriminating against credit applications on the basis of race, color, religion, national origin, sex, marital status, age (provided the applicant has the capacity to enter into a binding contract), because all or part of the applicant's income derives from any public assistance program; or because the applicant has in good faith exercised any right under the Consumer Credit Protection Act. The Federal Agency that administers our lending partner's compliance with this law is the Federal Reserve Bank of Chicago, P.O Box 1200, Minneapolis, MN, 55480.</p>
		</div>
		<br>
		<br>
		<div class="col-xs-12">
			<p class="col-xs-4 small pull-left">For bank use only</p>
		</div>
		<div class="col-xs-6">
			<div class="form-horizontal">

				<div class="form-group" style="height: 30px;">
					<label class="col-xs-4 control-label"><?php echo $ecoa->getAttributeLabel('name'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($ecoa->name))? $ecoa->name : "&nbsp"; ?></div>	
					</div>
				</div>
				
				<div class="form-group" style="height: 30px;">
					<label class="col-xs-4 control-label"><?php echo $ecoa->getAttributeLabel('phone'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($ecoa->phone))? $ecoa->phone : "&nbsp"; ?></div>	
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-horizontal">

				<div class="form-group" style="height: 30px;">
					<label class="col-xs-4 control-label"><?php echo $ecoa->getAttributeLabel('banker_id'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($ecoa->banker_id))? $ecoa->banker_id : "&nbsp"; ?></div>	
					</div>
				</div>
				
				<div class="form-group" style="height: 30px;">
					<label class="col-xs-4 control-label"><?php echo $ecoa->getAttributeLabel('fax'); ?>:</label>
					<div class="col-xs-8">
						<div class="form-style"><?php echo (!empty($ecoa->fax))? $ecoa->fax : "&nbsp"; ?></div>	
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">Consent and Authorization</h3>
			<p >The undersigned Lessee (hereinafter "Lessee") expressly authorizes Essex Funding, Inc. to obtain, directly or through an agent or its assignees, the Lessee's credit, background, and financial responsibility reports ("Reports") from any appropriate Reporting Agency and understand that such Reports may be used by Essex Funding, Inc. in the determination of whether or not to enter into a lease with Lessee. Lessee understands that such investigations may include seeking information as to the background, credit and financial responsibility of Lessee's officers and principals, or any of them. Lessee understands and consents that its credit information may be transmitted via the Internet, that such information may be accessible by unintended 3rd parties, that it is being submitted at our own risk, and that Lessee waives any right to any punitive damages arising out of or associated with the transmission, interception, use or misuse of the application. Lessee may request the status of this application to be transmitted by electronic mail and Lessee expressly authorizes Essex Funding, Inc. or its nominee(s) to transmit such message to the electronic mail address, which Lessee may provide. Lessee hereby consents to allowing Essex Funding, Inc. to obtain any and all Reports from any and all appropriate Reporting Agencies and agrees that such information maintained by such Reporting Agencies will be supplied to Essex Funding, Inc. and/or any other companies which subscribe to said services. Lessee therefore authorizes the procurement of said Reports by Essex Funding, Inc. and, if Lessee enters into a lease agreement with Essex Funding, Inc., Lessee understands that this authorization shall remain on file and shall serve as on-going authorization for Essex Funding, Inc. to procure additional Reports at any other time during the lease agreement.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<p style="font-size:14px;"><i>**Application Fee: This application must be submitted with a non-refundable application fee in the amount of $_____, which will not be refunded under any circumstance (including, but not limited to, if you choose to withdraw your Application or your Application is not approved for financing by our applicable lending partner).**</i></p>
		</div>
		<div class="col-xs-12">
			<p style="font-size:14px;"><i>**This application is subject to the terms of our <a href="https://www.essexfunding.com/privacyPolicy.php" target="_blank">Privacy Policy.</a></i></p>
		</div>
	</div>
</div>


<?php $this->endWidget(); ?>