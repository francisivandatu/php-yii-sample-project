<?php
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	
	Yii::app()->clientScript->registerCss('formStyles', "
		.active .back1, .active .back2, .active .back3 {margin-right:4px;}
		/* body {background:#C7D9E9;} */
		.container {background:#FFFFFF; font-size:14px;}
		.form-style {border:1px solid silver; padding: 5px; color: #555; border-radius:4px;}
	");
	
	$this->pageTitle=Yii::app()->name . ' - Application Form';

?>

<div class="">							

<?php 
	$form=$this->beginWidget('CActiveForm',array('id'=>'application-form', 
						 'enableAjaxValidation'=>true,
						 'clientOptions'=>array(
						 	'validateOnSubmit'=>true
						 ),
						'htmlOptions'=>array(
								'enctype' => 'multipart/form-data',
							)));
?>
							
<div class="step1 steps">
		<div class="row">
			<div class="col-xs-12">
				<h2 class="title">Credit Application</h2>
			</div>
		</div>
	
		<div class="row">
			<div class="col-xs-6">
				<div class="form-horizontal">
					<div class="form-group">
						<div class="col-xs-4">
							<label class="control-label"><?php echo $app_form->getAttributeLabel('legal_name'); ?></label>:
						</div>
						<div class="col-xs-8">
							<div class="form-style"><?php echo $app_form->legal_name; ?></div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-xs-4">
							<label class="control-label"><?php echo $app_form->getAttributeLabel('dba_name'); ?></label>:
						</div>
						<div class="col-xs-8">
							<div class="form-style"><?php echo $app_form->dba_name; ?></div>
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-horizontal">
					
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<!-- Tried using radio button list  but used radio buttons instead because of different classes used for each div. --> 
					<?php //echo $form->radioButtonList($app_form, 'business_structure', array('SP'=>'Sole Proprietorship', 'P'=>'Partnership', 'C' => 'Corporation', 'LLC' => 'Limited Liabilty Company (LLC)','O' => 'Other'), array('separator' => ' ','template'=> '<div class="col-xs-2"><div class="radio"><label>{input} {label}</label></div></div>'));?>
					<div class="col-xs-3">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'SP','uncheckValue'=>null)); ?>
								Sole Proprietorship
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'P','uncheckValue'=>null)); ?>
								Partnership
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'C','uncheckValue'=>null)); ?>
								Corporation
							</label>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'LLC','uncheckValue'=>null)); ?>
								Limited Liability Company (LLC)
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'O','uncheckValue'=>null)); ?>
								Other
							</label>
						</div>
					</div> 
				</div>
			</div>
			
			<div class="col-xs-6">
				<div class="form-group">
					<?php echo $form->labelEx($app_form,'business_check_account', array('class' => 'control-label')); ?>
					<?php echo $form->textField($app_form,'business_check_account', array('class' => 'form-control')); ?>
					<?php echo $form->error($app_form,'business_check_account'); ?>
				</div>
			</div>			
			<div class="col-xs-6">				
				<div class="form-group">
					<?php echo $form->labelEx($app_form,'business_loan_types', array('class' => 'control-label')); ?>
					<?php echo $form->textField($app_form,'business_loan_types', array('class' => 'form-control')); ?>
					<?php echo $form->error($app_form,'business_loan_types'); ?>
				</div>
			</div>
			
			
				
			<div class="col-xs-12">
				<div class="form-group">
					<label>
						Other Banking Information:
					</label>
				</div>
			</div>
			<div class="col-xs-3">
			<?php echo $form->textField($app_form,'other_banking_name', array('class' => 'form-control','placeholder' => 'Bank Name')); ?>
			<?php echo $form->error($app_form,'other_banking_name'); ?>
			</div>
			
			<div class="col-xs-3">
			<?php echo $form->textField($app_form,'other_banking_contact', array('class' => 'form-control','placeholder' => 'Contact Number')); ?>
			<?php echo $form->error($app_form,'other_banking_contact'); ?>
			</div>
			
			<div class="col-xs-3">
			<?php echo $form->textField($app_form,'other_banking_phone', array('class' => 'form-control','placeholder' => 'Phone Number')); ?>
			<?php echo $form->error($app_form,'other_banking_phone'); ?>
			</div>
			
			<div class="col-xs-3">
			<?php echo $form->textField($app_form,'other_banking_account_number', array('class' => 'form-control','placeholder' => 'Account Number')); ?>
			<?php echo $form->error($app_form,'other_banking_account_number'); ?>
			</div>
			<br style="clear:both;" />
			<br style="clear:both;" />
		</div>
</div>


	<!--Step 2-->
<div class="step2 steps">
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
				<label class="col-xs-3 control-label">Principal Name(s) and Title(s)</label>
				
				<div class="col-xs-3">
					<?php echo $form->textField($principal1,'[1]name_title', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]name_title'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal2,'[2]name_title', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]name_title'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal3,'[3]name_title', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]name_title'); ?>
				</div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-xs-3 control-label">Home Address</label>
				<div class="col-xs-3">
					<?php echo $form->textField($principal1,'[1]address', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]address'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal2,'[2]address', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]address'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal3,'[3]address', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]address'); ?>
				</div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-xs-3 control-label">City/State/Zip Code</label>
				<div class="col-xs-3">
					<?php echo $form->textField($principal1,'[1]location', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]location'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal2,'[2]location', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]location'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal3,'[3]location', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]location'); ?>
				</div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-xs-3 control-label">% of Ownership</label>
				<div class="col-xs-3">
					<?php echo $form->textField($principal1,'[1]ownership', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]ownership'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal2,'[2]ownership', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]ownership'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal3,'[3]ownership', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]ownership'); ?>
				</div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-xs-3 control-label">Social Security Number</label>
				<div class="col-xs-3">
					<?php echo $form->textField($principal1,'[1]security_number', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]security_number'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal2,'[2]security_number', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]security_number'); ?>
				</div>
				<div class="col-xs-3">
					<?php echo $form->textField($principal3,'[3]security_number', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]security_number'); ?>
				</div>
			</div>
			<br />
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">Credit Release</h3>
			<p>Each individual signing as principal certifies that the information provided in this application is accurate and complete. Each individual signing as principal authorizes Essex Funding, Inc. or any of its lending partners to obtain information from the references listed below and obtain consumer credit reports that will be ongoing and relate not only to the evaluation and/or extension of the business credit requested, but also for purpose of reviewing the account, increasing the credit line, taking collection action on the account and for any other legitimate purpose associated with the account as needed. Each individual signing as principal further waives any right or claim which such individual would otherwise have under the Fair Credit Reporting Act in the absence of this continuing consent.</p>
		</div>
	</div>
</div>

	<!-- page 3 -->
<div class="step3 steps">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">Trade References</h3>
			<br />
				<div class="col-xs-3">
					<div class="form-group">
						<?php echo $form->labelEx($trade,'[1]trade_name'); ?>
						<?php echo $form->textField($trade,'[1]trade_name', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade,'[1]trade_name'); ?>
					</div>
					<div class="form-group">
						<?php echo $form->textField($trade2,'[2]trade_name', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade2,'[2]trade_name'); ?>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="form-group">
						<?php echo $form->labelEx($trade,'[1]trade_location'); ?>
						<?php echo $form->textField($trade,'[1]trade_location', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade,'[1]trade_location'); ?>
					</div>
					<div class="form-group">
						<?php echo $form->textField($trade2,'[2]trade_location', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade2,'[2]trade_location'); ?>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<?php echo $form->labelEx($trade,'[1]trade_phone'); ?>
						<?php echo $form->textField($trade,'[1]trade_phone', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade,'[1]trade_phone'); ?>
					</div>
					<div class="form-group">
						<?php echo $form->textField($trade2,'[2]trade_phone', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade2,'[2]trade_phone'); ?>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<?php echo $form->labelEx($trade,'[1]trade_contact'); ?>
						<?php echo $form->textField($trade,'[1]trade_contact', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade,'[1]trade_contact'); ?>
					</div>
					<div class="form-group">
						<?php echo $form->textField($trade2,'[2]trade_contact', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade2,'[2]trade_contact'); ?>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<?php echo $form->labelEx($trade,'[1]trade_account_number'); ?>
						<?php echo $form->textField($trade,'[1]trade_account_number', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade,'[1]trade_account_number'); ?>
						
					</div>
					<div class="form-group">
						<?php echo $form->textField($trade2,'[2]trade_account_number', array('class' => 'form-control')); ?>
						<?php echo $form->error($trade2,'[2]trade_account_number'); ?>
					</div>
				</div>
				
		</div>
		<div class="col-xs-12">
					<p style="font-style:italic; font-size:14px;">
					<?php echo CHtml::link('Non-refundable credit application fee provision.','#refundPolicy')?>
				</p>
		</div>
		<div class="col-xs-12">
			<h3 class="small-title">Equipment Vendor / Manufacturer Information</h3>
			<br />
			<div class="col-xs-4">
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'name'); ?>
					<?php echo $form->textField($vendor,'name', array('class' => 'form-control')); ?>
					<?php echo $form->error($vendor,'name'); ?>
				</div>
			</div>
			<div class="col-xs-4">
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'address'); ?>
					<?php echo $form->textField($vendor,'address', array('class' => 'form-control')); ?>
					<?php echo $form->error($vendor,'address'); ?>
				</div>
			</div>
			<div class="col-xs-4">
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'location'); ?>
					<?php echo $form->textField($vendor,'location', array('class' => 'form-control')); ?>
					<?php echo $form->error($vendor,'location'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="form-horizontal">
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'contact_person', array('class' => 'col-xs-4 control-label')); ?>
					<div class="col-xs-8">
					<?php echo $form->textField($vendor,'contact_person', array('class' => 'form-control')); ?>
					</div>
					<?php echo $form->error($vendor,'contact_person'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'equipment_description', array('class' => 'col-xs-4 control-label')); ?>
					<div class="col-xs-8">
					<?php echo $form->textField($vendor,'equipment_description', array('class' => 'form-control')); ?>
					</div>
					<?php echo $form->error($vendor,'equipment_description'); ?>
					
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'monthly_payment', array('class' => 'col-xs-4 control-label')); ?>
					<div class="col-xs-8">
						<div class="input-group">
						<span class="input-group-addon">$</span>
						<?php echo $form->textField($vendor,'monthly_payment', array('class' => 'form-control')); ?>
						</div>
					</div>
					<?php echo $form->error($vendor,'monthly_payment'); ?>
					
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">Desired Term</label>
					<?php // echo $form->radioButtonList($vendor, 'term', array('12'=>'12mo', '24'=>'24mo', '36' => '36mo', '46' => '46mo','60' => '60mo'), array('separator' => ' ','template'=> '<div class="col-xs-2"><div class="radio"><label>{input} {label}</label></div></div>'));?>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>12,'uncheckValue'=>null)); ?>
								12mo
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>24,'uncheckValue'=>null)); ?>
								24mo
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>36,'uncheckValue'=>null)); ?>
								36mo
							</label>
						</div>
					</div>
					<div class="col-xs-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>46,'uncheckValue'=>null)); ?>
								46mo
							</label>
						</div>
					</div>
					<div class="col-xs-2 col-xs-offset-4">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>60,'uncheckValue'=>null)); ?>
								60mo
							</label>
						</div>
					</div> 
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-horizontal">
					<div class="form-group">
						<?php echo $form->labelEx($vendor,'contact_phone',array('class' => 'col-xs-4  control-label')); ?>
						<div class="col-xs-4">
						<?php echo $form->textField($vendor,'contact_phone', array('class' => 'form-control')); ?>
						<?php echo $form->error($vendor,'contact_phone'); ?>
						</div>
						
						
						<div class="col-xs-2 phone">
						<div class="radio">
							<label>
									<?php echo $form->radioButton($vendor,'new_flag',array('value'=>1,'uncheckValue'=>null)); ?>	New
							</label>
						</div>
					</div>
					<div class="col-xs-2 phone">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'new_flag',array('value'=>0,'uncheckValue'=>null)); ?> Old
							</label>
						</div>
					</div>
					</div>
					
					<div class="form-group">
						<?php echo $form->labelEx($vendor,'equipment_location',array('class' => 'col-xs-4 control-label')); ?>
						<div class="col-xs-8">
						<?php echo $form->textField($vendor,'equipment_location', array('class' => 'col-xs-4 form-control')); ?>
						<?php echo $form->error($vendor,'equipment_location'); ?>
						</div>
					</div>
					<div class="form-group">
						<?php echo $form->labelEx($vendor,'total_invoice', array('class' => 'col-xs-4 control-label')); ?>
						<div class="col-xs-8">
							<div class="input-group">
							<span class="input-group-addon">$</span>
							<?php echo $form->textField($vendor,'total_invoice', array('class' => 'form-control')); ?>
							</div>
						</div>
						<?php echo $form->error($vendor,'monthly_payment'); ?>
					</div>
					<div class="form-group">
						<label class="col-xs-4 control-label">End of Lease Option</label>
						<div class="col-xs-2">
							<div class="radio">
								<label>
									<?php echo $form->radioButton($vendor,'lease_option',array('value'=>1,'uncheckValue'=>null)); ?>
									FMV
								</label>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="radio">
								<label>
									<?php echo $form->radioButton($vendor,'lease_option',array('value'=>2,'uncheckValue'=>null)); ?>
									10% Option
								</label>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="radio">
								<label>
									<?php echo $form->radioButton($vendor,'lease_option',array('value'=>3,'uncheckValue'=>null)); ?>
									$1.00
								</label>
							</div>
						</div>
						<div class="col-xs-3 col-xs-offset-4">
							<div class="radio">
								<label>
										<?php echo $form->radioButton($vendor,'lease_option',array('value'=>4,'uncheckValue'=>null)); ?>
									10% PUT
								</label>
							</div>
						</div>
					</div>
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
						<?php echo $form->radioButton($vendor,'line_of_credit',array('value'=>'50,000','uncheckValue'=>null)); ?>
					$50, 000
				</label>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($vendor,'line_of_credit',array('value'=>'100,000','uncheckValue'=>null)); ?>
					$100, 000
				</label>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($vendor,'line_of_credit',array('value'=>'250,000','uncheckValue'=>null)); ?>
					$250, 000
				</label>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<label class="col-xs-2 control-label">Other:</label>
				<div class="col-xs-8">
					<?php //echo $form->textField($vendor,'other', array('class' => 'form-control')); ?>
					<?php echo CHtml::textField('other',$other_line,array('class' => 'form-control other-line-credit'));?>
				</div>
			</div>
		</div>
	</div>
</div>

	<!-- page 4-->

<div class="step4">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">ECOA Notice (to be retained by applicants[s])</h3>
			<p>Thank you for your business credit application. We will review it carefully and get back to your promptly. If your application for business credit is denies, you have the right to a written statement of the specific reasons for the denial. To obtain that statement, please contact us within 60 days from the date you were notified of our decision. We will send you a written statement of the reasons for the denial within 30 days of your requesr for the statement. Contact Essex Funding Inc., 101 East Kennedy Blvd. Suite 1820 Tampa, Florida 33602, phone number 813.443.4632. NOTICE: The Federal Equal Credit Opportunity Act prohibits creditors from discrimination against credit applications on the basis of race, color, religion, national origin, sex, marital status, age (provided the applicant has the capacity to enter into a binding contract), because all part or part of the applicant's income derives from any public assistance program; or because the applicant has in good faith exercised any right under the Consumer Credit Protection Act. The Federal Agency that administers our lending partner's compliance with this law is the Federal Reserve of Chicago, P.O Box 1200, Minneapolis, MN, 55480.</p>
		</div>
		<br />
		<br />
		<div class="col-xs-12">
			<p class="col-xs-4 small pull-left">For bank use only</p>
		</div>
		<div class="col-xs-6">
			<div class="form-horizontal">
				<?php echo $form->labelEx($ecoa,'name', array('class' => 'col-xs-4 control-label')); ?>
				<div class="col-xs-8">
				<?php echo $form->textField($ecoa,'name', array('class' => 'form-control')); ?>
					<?php echo $form->error($ecoa,'name'); ?>
				</div>
			
				
				<?php echo $form->labelEx($ecoa,'phone', array('class' => 'col-xs-4 control-label')); ?>
				<div class="col-xs-8">
				<?php echo $form->textField($ecoa,'phone', array('class' => 'form-control')); ?>
				<?php echo $form->error($ecoa,'phone'); ?>
				</div>
				
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-horizontal">
				<?php echo $form->labelEx($ecoa,'banker_id', array('class' => 'col-xs-4 control-label')); ?>
				<div class="col-xs-8">
				<?php echo $form->textField($ecoa,'banker_id', array('class' => 'form-control')); ?>
				<?php echo $form->error($ecoa,'banker_id'); ?>
				</div>
				
				
				<?php echo $form->labelEx($ecoa,'fax', array('class' => 'col-xs-4 control-label')); ?>
				<div class="col-xs-8">
				<?php echo $form->textField($ecoa,'fax', array('class' => 'form-control')); ?>
				<?php echo $form->error($ecoa,'fax'); ?>
				</div>
				
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h3 class="small-title">Consent and Authorization</h3>
			<p >The undersigned Lessee (hereinafter "Lessee") expressly authorizes Essex Funding, Inc. to obtain, directly or through an agent or its assignees, the Lessee's credit, background, and financial responsibility reports ("Reports") from any appropriate Reporting Agency and understand that such Reports may be used by Essex Funding, Inc. in the determination of whether or not to enter into a lease with Lessee. Lessee understands that such investigations may include seeking information as to the background, credit and financial responsibility of Lessee's officers and principals, or any of them. Lessee understands and consents that its credit information may be transmitted via the Internet, that such information may be accessible by unintended 3rd parties, that it is being submitted at our own risk, and that Lessee waives any right to any punitive damages arising out of or associated with the transmission, interception, use or misuse of the application. Lessee may request the status of this application to be transmitted by electronic mail and Lessee expressly authorizes Essex Funding, Inc. or its nominee(s) to transmit such message to the electronic mail address, which Lessee may provide. Lessee hereby consents to allowing Essex Funding, Inc. to obtain any and all Reports from any and all appropriate Reporting Agencies and agrees that such information maintained by such Reporting Agencies will be supplied to Essex Funding, Inc. and/or any other companies which subscribe to said services. Lessee therefore authorizes the procurement of said Reports by Essex Funding, Inc. and, if Lessee enters into a lease agreement with Essex Funding, Inc., Lessee understands that this authorization shall remain on file and shall serve as on-going authorization for Essex Funding, Inc. to procure additional Reports at any other time during the lease agreement.</p>
		</div>
		<br />
	</div>
	<br/>
	<div class="row">
		<div class="col-xs-12">
			<p style="font-size:14px;"><i>**Application Fee: This application must be submitted with a non-refundable application fee in the amount of $_____, which will not be refunded under any circumstance (including, but not limited to, if you choose to withdraw your Application or your Application is not approved for financing by our applicable lending partner).**</i></p>
		</div>
		<div class="col-xs-12">
			<p style="font-size:14px;"><i>**This application is subject to the terms of our <?php echo CHtml::link('Privacy Policy.', '#PrivacyPolicy') ?></i></p>
		</div>
	</div>
	
</div>
<?php $this->endWidget(); ?>

</div>
	
	