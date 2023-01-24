<?php
	$baseUrl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile('//code.jquery.com/ui/1.11.0/jquery-ui.js');
	$cs->registerCssFile('//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css');
	
	Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/bootbox.min.js');
	// Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/bootstrap.min.js');

	$popupMessage = "If you haven\'t already created an account with login information, please do so now.";
	
	$processingFeeBtn = 'Create login';
	$processingFeeBtn2 = 'Create Login and Pay App Fee';
	
	$saveFormBtn = 'Save my Credit Application';
	$cancelFormBtn = 'Cancel and Edit Credit Application';
	
	if(!Yii::app()->user->isGuest)
	{
		$popupMessage = "Please select an option to complete your credit application.";
		
		$processingFeeBtn = 'Proceed to application submission';
		$processingFeeBtn2 = 'Proceed to fee processing'; 
		
		$saveFormBtn = 'Save my credit application';
		
		$cancelFormBtn = 'Cancel and Edit Credit Application';
	}
	
	Yii::app()->clientScript->registerScript('formSubmit',"
		$('body').on('click', '.app-submit', function(e){
			e.preventDefault();
			var thisButton = $(this);

			if(!$(\".agree:checked\").length) {
				alert(\"You need to AGREE to Consent and Authorization\");

				bootbox.hideAll();
				
				//stop the form from submitting
				return false;
			}
			
			if ( $('#validated_promo_code').length == '1' )
			{
				var processingFeeBtn = '".$processingFeeBtn."';
			}
			else
			{
				var processingFeeBtn = '".$processingFeeBtn2."';
			}
			
			if(clear == true) {
				bootbox.dialog({
					message: '<div class=\"dialog-message-container\">".$popupMessage."<br /><br /> <p class=\"text-center\"><span class=\"btn btn-success btn-pay-application\">'+processingFeeBtn+'</span> <span class=\"btn btn-warning btn-save-application\">".$saveFormBtn."</span></p></div>',
					title: 'Credit Application Submission',
					buttons: {
						cancel: {
							label: '".$cancelFormBtn."',
							className: 'btn-default btn-cancel-application',
							callback: function()
							{
								
							}
						}
					} 
				}); 
			}
			else {
				validateInputs($('form').serialize(), 4, thisButton);
			}

			
		});
		
		$('body').on('click', '.btn-pay-application', function(e){

			

			$('.applicationCreditFormProcess').val(1);
			$('.btn-cancel-application').hide();
			$('.dialog-message-container').html('Please wait...');
			$('#application-form').submit();
		});
		
		$('body').on('click', '.btn-save-application', function(e){


			$('.applicationCreditFormProcess').val(2);
			$('.btn-cancel-application').hide();
			$('.dialog-message-container').html('Please wait...');
			$('#application-form').submit();
		});
	");
	
	$cs->registerScript('form_script','

			var clear = false;

			function validateInputs(inputs, step, elem) {

				elem.button("loading");

				inputs = inputs + "&ajax=1" + "&validate=1" + "&step=" + step;
				$.ajax({
					url: "'.Yii::app()->createAbsoluteUrl('/applicationForm/creditApplication').'",
					dataType: "json",
					type: "post",
					data: inputs,
					success: function(res) {

						

						if(res != "underfined") {
							var errorString = "";
							$.each(res, function(indx, val){
								$.each(val, function(index, error){
									errorString += "<li>" + error + "</li>";
								});
							}); 
						}


						if(errorString != "") {
							errorString = "<ul style=\"font-size: 15px; color: red;\">" + errorString + "</ul>";
							errorString = "<p>Please fix the following input errors below: </p>" + errorString;
							errorString = "<h3 class=\"text-center\">Input Validations</h3>" + errorString;
							bootbox.hideAll();
							bootbox.alert(errorString);
							elem.button("reset");
							return false;
						}


						
						switch (step) {
							case "1": case 1:
									$(".step1").toggle("slide");
									$(".step2").toggle("slide");
									// $(".step3").click(false);
								
									$("#step-nav2").toggleClass("disabled active");	
								break;

							case "2": case 2:
									$(".step2").toggle("slide");
									$(".step3").toggle("slide");
									$("#step-nav3").toggleClass("disabled active");
								break;

							case "3": case 3:
									 $(".step3").toggle("slide");
									 $(".step4").toggle("slide");
									 $("#step-nav4").toggleClass("disabled active");
								break;

							case "4": case 4:
									
									// if(method == "save") {

									// 	$(\'.applicationCreditFormProcess\').val(2);
									// 	$(\'.dialog-message-container\').html(\'Please wait...\');
									// 	$(\'#application-form\').submit();

									// }
									// else {
									// 	$(\'.applicationCreditFormProcess\').val(1);
									// 	$(\'.dialog-message-container\').html(\'Please wait...\');
									// 	$(\'#application-form\').submit();
									// }

									clear = true;
									
									if ( $("#validated_promo_code").length == "1" )
									{
										var processingFeeBtn = "'.$processingFeeBtn.'";
									}
									else
									{
										var processingFeeBtn = "'.$processingFeeBtn2.'";
									}
									
									bootbox.dialog({
										message: \'<div class="dialog-message-container">'.$popupMessage.'<br /><br /> <p class="text-center"><span class="btn btn-success btn-pay-application">\'+processingFeeBtn+\'</span> <span class="btn btn-warning btn-save-application">'.$saveFormBtn.'</span></p></div>\',
										title: \'Application Submission\',
										buttons: {
											cancel: {
												label: \''.$cancelFormBtn.'\',
												className: \'btn-default btn-cancel-application\',
												callback: function()
												{
													
												}
											}
										} 
									});

									// $(".app-submit").trigger("click");
								break;
							
							default:
								
								break;
						}

						elem.button("reset");

					}
				});
			}

			$(document).ready(function(){
			  $(".step2").hide();
			  $(".step3").hide();
			  $(".step4").hide();
			
			 /*   $( ".business-start-date" ).datepicker({
				  changeMonth: true,
				  changeYear: true,
				  maxDate: "+0d"
				});	
			
			  $( ".business-inc-date" ).datepicker({
				  changeMonth: true,
				  changeYear: true,
				  maxDate: "+0d"
				}); */

			
			  
			  $(".btn-step1").click(function(e){

			  	var self = $(this);
			  	validateInputs($("form").serialize(), 1, self);

			 	// $(".step1").toggle("slide");
				// $(".step2").toggle("slide");
				// $(".step3").click(false);
			
				// $("#step-nav2").toggleClass("disabled active");	
				 
			  });
			  
			  $(".btn-step2").click(function(e){

			  	var self = $(this);
				validateInputs($("form").serialize(), 2, self);				  	

				 // $(".step2").toggle("slide");
				 // $(".step3").toggle("slide");
				 // $("#step-nav3").toggleClass("disabled active");
			  });
			  
			  $(".btn-step3").click(function(e){
			  	var self = $(this);
			  	validateInputs($("form").serialize(), 3, self);
				 // $(".step3").toggle("slide");
				 // $(".step4").toggle("slide");
				 // $("#step-nav4").toggleClass("disabled active");
			  });
			  
			  $(".back1").click(function(e){
				 $(".step1").show("slide");
				 $(".step2").hide("slide");
				 $(".step3").hide("slide");
				 $(".step4").hide("slide");
				 $("#step-nav2").attr("class", "disabled");
				 $("#step-nav3").attr("class", "disabled");
				 $("#step-nav4").attr("class", "disabled");
			  });
			  
			  $(".back2").click(function(e){
				 if ( $(e.target).closest(".disabled").length ) return false;
				 $(".step2").show("slide");
				 $(".step3").hide("slide");
				 $(".step4").hide("slide");
				 $("#step-nav3").attr("class", "disabled");
				 $("#step-nav4").attr("class", "disabled");
			  });
			  
			  $(".back3").click(function(e){
				 if ( $(e.target).closest(".disabled").length ) return false;
				 $(".step3").show("slide");
				 $(".step4").hide("slide");
				 $("#step-nav4").attr("class", "disabled");
			  });
			  
			  $(".tax-exempt-no").change(function(e){
				 if (this.checked) {
						$(".exempt-cert-div").hide();
						$(".tax-exempt-yes").removeAttr("checked","checked");
					} 	
				else{
					$(".exempt-cert-div").show();
					$(".tax-exempt-yes").attr("checked","checked");
				}
			  });
			  
			   $(".tax-exempt-yes").change(function(e){
				 if (this.checked) {
						$(".exempt-cert-div").show();
						$(".tax-exempt-no").removeAttr("checked","checked");
					} 	
				else{
					$(".exempt-cert-div").hide();
					$(".tax-exempt-yes").removeAttr("checked","checked");
				}
			  });
			  
			  /*$("#application-form").submit(function(e) {

				// if(!$(".agree:checked").length) {
				// 	alert("You need to AGREE to Consent and Authorization");

				// 	bootbox.hideAll();
					
				// 	//stop the form from submitting
				// 	return false;
				// }
				// return true;
			  });*/
                          
                            $(".vendorInfo_line_of_credit").change(function(){
                                var self = $(this);
                                
                                if(self.is(":checked")) {
                                    $(".other_line_of_credit").val("");
                                }
                                
                            });
			 
				$(".other-line-credit").bind("propertychange change keyup paste input", function(){
					$("input:radio[name=\'VendorInfo[line_of_credit]\']").prop("checked", false);
				});

				$(".btn-back").click(function(e){

					var self = $(this);
					var parent = self.parent().parent().parent();
					var previous = parent.prev();

					if(parent.hasClass("step1")) {

						$("#step-nav2").attr("class", "disabled");
						$("#step-nav3").attr("class", "disabled");
						$("#step-nav4").attr("class", "disabled");

					}else if(parent.hasClass("step2")) {

						$("#step-nav2").attr("class", "disabled");
						$("#step-nav3").attr("class", "disabled");
						$("#step-nav4").attr("class", "disabled");

					}else if(parent.hasClass("step3")) {

						$("#step-nav3").attr("class", "disabled");
				 		$("#step-nav4").attr("class", "disabled");

					}else if(parent.hasClass("step4")){
						$("#step-nav4").attr("class", "disabled");
					}
					else {}


					previous.toggle("slide");
					parent.hide();
					
				});
				
				$("#ApplicationForm_exempt_certificate_path").change(function(){
					var self = $(this);
					$("#ytApplicationForm_exempt_certificate_path").val(self.val());
				});

		});

                function promoCodeUpdate(res){
                    $(".application-note").html("($0 application processing fee)"); 
                }

	',CClientScript::POS_END);

	if($app_form->tax_exempt == "N") {
		Yii::app()->clientScript->registerScript('exempt_tax_script', '
			$(document).ready(function(){
				$(".exempt-cert-div").hide();
			});
		', CClientScript::POS_END);	
	}
	
	
	Yii::app()->clientScript->registerCss('formStyles', "
		.active .back1, .active .back2, .active .back3 {margin-right:4px;}
	");
        
        // promocode session
        if(isset($_SESSION['ap_frm_promo_code'])) {

            $promoCode = $_SESSION['ap_frm_promo_code'];
            unset($_SESSION['ap_frm_promo_code']);
        }
        else {

            $promoCode = $app_form->promo_code;

        }
	
	$this->pageTitle=Yii::app()->name . ' - Application Form';
?>


<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>


	<div class="row form-group">
		<div class="col-xs-12">
			<ul class="nav nav-pills nav-justified thumbnail setup-panel" style="font-size:14px;">
				<li class="active" id="step-nav1"><a class="back1">
					<h4 class="list-group-item-heading">Step 1</h4>
					<p class="list-group-item-text text-center">Customer Information</p>
				</a></li>
				<li class="disabled" id="step-nav2" ><a class="back2">
					<h4 class="list-group-item-heading">Step 2</h4>
					<p class="list-group-item-text text-center">Principal/Equipment Information</p>
				</a></li>
				<li class="disabled" id="step-nav3"><a class="back3">
					<h4 class="list-group-item-heading">Step 3</h4>
					<p class="list-group-item-text text-center">Consent and Authorization</p>
				</a></li>
				<li class="disabled" id="step-nav4"><a class="back4">
					<h4 class="list-group-item-heading">Step 4</h4>
					<p class="list-group-item-text text-center">Fee Processing</p>
				</a></li>
			</ul>
		</div>
	</div>

	<?php $form=$this->beginWidget('CActiveForm',array('id'=>'application-form', 
						'enableAjaxValidation'=>true,
						'htmlOptions'=>array(
								'enctype' => 'multipart/form-data',
							))); ?>
				
				<?php echo $form->errorSummary($model, null, null, array('class' => 'alert alert-danger')); ?>
				<?php $this->widget('Flash', array('flashes'=>Yii::app()->user->getFlashes())); ?>
				
<div class="step1 steps">
		<div class="row">
			<div class="col-md-12">
				<h2 class="title">Credit Application</h2>
				<div class="application-note">
					<?php if(empty($promoCode)): ?>
						(A $<?php echo PaymentAPI::PAYMENT_CREDIT_APPLICATION_PRICE; ?> non-refundable application processing fee will be charged)
					<?php else: ?>
						($0 application processing fee)
					<?php endif; ?>
				</div> 
				<br />
			</div>
		</div>
		
		<div class="row <?php echo ($devMode == false) ? 'hide' : ''; ?> alert alert-info" style="border-left:5px solid #428BCA;">
			<div class="col-md-5">
				<?php 
					$this->widget('PromoCode', array(
						'promoCode' => $promoCode
					)); 
				?>
			</div>
		</div>
		<hr />
	
		<div class="row">
			<div class="col-md-6">
				
				<div class="form-horizontal">
					<?php //echo $form->errorSummary(array($app_form, $principal1, $principal2, $principal3, $trade,$vendor, $ecoa ); ?>
					<div class="form-group">
						<?php echo $form->labelEx($app_form,'legal_name', array('class' => 'col-sm-4 control-label',)); ?>
						
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'legal_name', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'legal_name'); ?>
						</div>
						
					</div>
					<div class="form-group">
						<?php echo $form->labelEx($app_form,'dba_name', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'dba_name', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'dba_name'); ?>
						</div>
						
					</div>
					<div class="form-group">
						<?php echo $form->labelEx($app_form,'address', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'address', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'address'); ?>
						</div> 
						
					</div>	
					
					
					<div class="form-group ">
						<div class="col-sm-4 control-label">
							Country
						</div>
						<div class="col-md-8">
								<select class="form-control" name="ApplicationForm[country]" id="ApplicationForm_country">
								<option value="">Country</option>
								<?php 
								$countryArray = State::getCountries();
								foreach($countryArray as $index => $country)
								{	
								
								if($app_form->country == $index && !empty($app_form->country) )
								{
								?>									
									<option value="<?php echo $index; ?>" selected><?php echo $country; ?></option>
								<?php } else if(empty($app_form->country) && $index == 191  && empty($app_form->state)) { ?> 
									<option value="<?php echo $index; ?>" selected><?php echo $country; ?></option>
								<?php } else { ?> 
									<option value="<?php echo $index; ?>" ><?php echo $country; ?></option>
								<?php } } ?>	
								</select>								
							</div>						
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo $form->labelEx($app_form,'state'); ?></label>
						<div class="col-sm-8">
						<?php echo $form->dropDownList($app_form,'state', CHtml::listData($state,'abbrev','name'), array('prompt'=>'State', 'class' => 'form-control'));
								
							$cityValues = array();
							if ( $app_form->state )
							{
								$data=Cities::model()->findAll('state_code=:s_code',
									array(':s_code'=> $app_form->state));										
								$cityValues = CHtml::listData($data,'id','city');
							}
							
						?>
						</div>
						
					</div>
					
					<div class="form-group other-state-div" style="display:none;"> 
						<div class="col-sm-4"></div>
						<div class="col-md-8 " >
							<?php echo $form->textField($app_form,'other_state', array('class' => 'form-control', 'placeholder'=>"Specify your State here")); ?>
						</div>						
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label">City / Zip</label>
						<div class="col-sm-4 city-container">
							<?php echo $form->dropDownList($app_form,'city',$cityValues, array('prompt'=>'City', 'class' => 'form-control')); ?>
								<div class="loading-city" style="color: rgb(154, 154, 154);font-size: 15px;border: 1px solid rgb(204, 204, 204);padding: 7px 10px;border-radius: 5px;display:none;">Loading...</div>
						</div>
						<div class="col-sm-4 ">
							<?php echo $form->textField($app_form,'zip', array('class' => 'form-control',)); ?>
							<?php echo $form->error($app_form,'zip'); ?>
						</div>
					</div>
						
					
					<div class="form-group">
						<?php echo $form->labelEx($app_form,'phone', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'phone', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'phone'); ?>
						</div>
					</div>
						
					<div class="form-group">	
						<?php echo $form->labelEx($app_form,'fax', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'fax', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'fax'); ?>
						</div>
					</div>
					
					<?php /*<div class="form-group">
						<?php echo $form->labelEx($app_form,'mobile', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'mobile', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'mobile'); ?>
						</div>
					</div> */ ?>
					
					<div class="form-group">	
						<?php echo $form->labelEx($app_form,'email', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'email', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'email'); ?>
						</div>
						
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-4 control-label">Sales Tax Exempt:</label>
						<label class="checkbox-inline">
							<?php echo $form->radioButton($app_form,'tax_exempt', array('value'=>'Y','uncheckValue'=>null, 'checked' => (($app_form->tax_exempt == "Y")? true : false), 'class' => 'tax-exempt-yes')); ?>
							Yes
							<?php echo $form->error($app_form,'tax_exempt'); ?>
						</label>
						<label class=" checkbox-inline">
							<?php echo $form->radioButton($app_form,'tax_exempt', array('value'=>'N','uncheckValue'=>null, 'checked' => (($app_form->tax_exempt == "N")? true : false), 'class' => 'tax-exempt-no')); ?>
							No
							<?php echo $form->error($app_form,'tax_exempt'); ?>
						</label>
						<p class="col-sm-4 small pull-right" style="text-align:left; padding-top:5px;">If <strong>Yes</strong>, exemption certificate must be sent</p>
					</div>
					<div class="form-group exempt-cert-div" <?php echo ( $app_form->tax_exempt == 'Y' ) ? '' : 'style="display:none;"'; ?>>
						<?php echo $form->labelEx($app_form,'exempt_certificate_path', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8" style="word-wrap: break-word;">
                                                <?php 
												if($app_form->tax_exempt == "Y")
												{
													if ( !empty($app_form->exempt_certificate_path) )
														$app_form->certificate_path_validator = $app_form->exempt_certificate_path;
												?>
                                                    <strong style="font-size: 12px;"><?php echo $app_form->exempt_certificate_path; ?></strong>
                                                   
                                                <?php } ?>
												
												<?php echo $form->hiddenField($app_form, 'certificate_path_validator'); ?>
												
												<hr style="margin-top: 3px; margin-bottom: 3px;" />
                                                <?php $form->hiddenField($app_form, 'exempt_certificate_path'); ?>
						<?php  echo $form->FileField($app_form, 'exempt_certificate_path', array('value' => $app_form->exempt_certificate_path)); 
						//echo $form->textField($app_form,'exempt_certificate_path', array('class' => 'form-control exempt-cert')); ?>
						<?php echo $form->error($app_form,'exempt_certificate_path'); ?>
                                                     
						</div>
					</div>
					<div class="form-group">
						<?php echo $form->labelEx($app_form,'fed_tax_id', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'fed_tax_id', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'fed_tax_id'); ?>
						</div>
						
					</div>
					<div class="form-group">
						<?php echo $form->labelEx($app_form,'mailing_address', array('class' => 'col-sm-4 control-label',)); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'mailing_address', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'mailing_address'); ?>
						</div>
						
					</div>
					<div class="form-group">
						<?php echo $form->labelEx($app_form,'contact_name_title', array('class' => 'col-sm-4 control-label',)); ?>
						
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'contact_name_title', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'contact_name_title'); ?>
						</div>
					</div>
					
					<div class="form-group">
						<?php echo $form->labelEx($app_form,'business_start', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
							<?php 
							// if ( !empty($app_form->business_start) )
								// $app_form->business_start = date("d/m/Y", strtotime($app_form->business_start));
								
							echo $form->textField($app_form,'business_start',array('class' => 'form-control business-start-date',)); ?>
							<?php echo $form->error($app_form,'business_start'); ?>
						</div>
					</div>
					
					<div class="form-group">
						<?php 
						// if ( !empty($app_form->business_incorporate) )
								// $app_form->business_incorporate = date("d/m/Y", strtotime($app_form->business_incorporate));
								
						echo $form->labelEx($app_form,'business_incorporate', array('class' => 'col-sm-4 control-label',)); ?>
						<div class="col-sm-8">
							<?php echo $form->textField($app_form,'business_incorporate',array('class' => 'form-control business-inc-date',)); ?>
						</div>
						<?php echo $form->error($app_form,'business_incorporate'); ?>
					</div>
					<div class="form-group">
						<?php 
							echo $form->labelEx($app_form,'business_description', array('class' => 'col-sm-4 control-label')); ?>
						<div class="col-sm-8">
						<?php echo $form->textField($app_form,'business_description', array('class' => 'form-control')); ?>
						<?php echo $form->error($app_form,'business_description'); ?>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<?php echo $form->labelEx($app_form,'business_structure', array('class' => 'col-sm-4 control-label')); ?>
				</div>
				<div class="col-md-12">
					<!-- Tried using radio button list  but used radio buttons instead because of different classes used for each div. --> 
					<?php //echo $form->radioButtonList($app_form, 'business_structure', array('SP'=>'Sole Proprietorship', 'P'=>'Partnership', 'C' => 'Corporation', 'LLC' => 'Limited Liabilty Company (LLC)','O' => 'Other'), array('separator' => ' ','template'=> '<div class="col-md-2"><div class="radio"><label>{input} {label}</label></div></div>'));?>
					<div class="col-md-3">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'SP','uncheckValue'=>null)); ?>
								Sole Proprietorship
							</label>
						</div>
					</div>
					<div class="col-md-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'P','uncheckValue'=>null)); ?>
								Partnership
							</label>
						</div>
					</div>
					<div class="col-md-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'C','uncheckValue'=>null)); ?>
								Corporation
							</label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'LLC','uncheckValue'=>null)); ?>
								Limited Liability Company (LLC)
							</label>
						</div>
					</div>
					<div class="col-md-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($app_form,'business_structure',array('value'=>'O','uncheckValue'=>null)); ?>
								Other
							</label>
						</div>
					</div> 
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group">
					<?php echo $form->labelEx($app_form,'business_check_account', array('class' => 'control-label')); ?>
					<?php echo $form->textField($app_form,'business_check_account', array('class' => 'form-control')); ?>
					<?php echo $form->error($app_form,'business_check_account'); ?>
				</div>
			</div>			
			<div class="col-sm-6">				
				<div class="form-group">
					<?php echo $form->labelEx($app_form,'business_loan_types', array('class' => 'control-label')); ?>
					<?php echo $form->textField($app_form,'business_loan_types', array('class' => 'form-control')); ?>
					<?php echo $form->error($app_form,'business_loan_types'); ?>
				</div>
			</div>
			
			
				
			<div class="col-sm-12">
				<div class="form-group">
					<label>
						Other Banking Information:
					</label>
				</div>
			</div>
			<div class="col-sm-3">
			<?php echo $form->textField($app_form,'other_banking_name', array('class' => 'form-control','placeholder' => 'Bank Name')); ?>
			<?php echo $form->error($app_form,'other_banking_name'); ?>
			</div>
			
			<div class="col-sm-3">
			<?php echo $form->textField($app_form,'other_banking_contact', array('class' => 'form-control','placeholder' => 'Contact Name')); ?>
			<?php echo $form->error($app_form,'other_banking_contact'); ?>
			</div>
			
			<div class="col-sm-3">
			<?php echo $form->textField($app_form,'other_banking_phone', array('class' => 'form-control','placeholder' => 'Phone Number')); ?>
			<?php echo $form->error($app_form,'other_banking_phone'); ?>
			</div>
			
			<div class="col-sm-3">
			<?php echo $form->textField($app_form,'other_banking_account_number', array('class' => 'form-control','placeholder' => 'Account Number')); ?>
			<?php echo $form->error($app_form,'other_banking_account_number'); ?>
			</div>
			<br style="clear:both;" />
			<br style="clear:both;" />
			<div class="col-sm-12">
				<?php echo CHtml::button('Next', array('class' => 'btn btn-primary orange-btn pull-right btn-step1', 'data-loading-text' => "Please wait...")); ?>
			</div>
		</div>
</div>


	<!--Step 2-->
<div class="step2 steps">
	<div class="row">
		<div class="col-md-12">
			<div class="row hidden-sm hidden-xs">
				<div class="col-sm-3">
					<h3 class="small-title">List Company Principals</h3>
				</div>
				<div class="col-sm-3 text-center"><br /><span class="badge">1</span></div>
				<div class="col-sm-3 text-center"><br /><span class="badge">2</span></div>
				<div class="col-sm-3 text-center"><br /><span class="badge">3</span></div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-sm-3 control-label">Principal Name(s) and Title(s)</label>
				
				<div class="col-sm-3">
					<?php echo $form->textField($principal1,'[1]name_title', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]name_title'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal2,'[2]name_title', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]name_title'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal3,'[3]name_title', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]name_title'); ?>
				</div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-sm-3 control-label">Home Address</label>
				<div class="col-sm-3">
					<?php echo $form->textField($principal1,'[1]address', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]address'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal2,'[2]address', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]address'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal3,'[3]address', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]address'); ?>
				</div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-sm-3 control-label">City/State/Zip Code</label>
				<div class="col-sm-3">
					<?php echo $form->textField($principal1,'[1]location', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]location'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal2,'[2]location', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]location'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal3,'[3]location', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]location'); ?>
				</div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-sm-3 control-label">% of Ownership</label>
				<div class="col-sm-3">
					<?php echo $form->textField($principal1,'[1]ownership', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]ownership'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal2,'[2]ownership', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]ownership'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal3,'[3]ownership', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]ownership'); ?>
				</div>
			</div>
			<br />
			<div class="form-group">
				<label class="col-sm-3 control-label">Social Security Number</label>
				<div class="col-sm-3">
					<?php echo $form->textField($principal1,'[1]security_number', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal1,'[1]security_number'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal2,'[2]security_number', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal2,'[2]security_number'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal3,'[3]security_number', array('class' => 'form-control')); ?>
					<?php //echo $form->error($principal3,'[3]security_number'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Email Address</label>
				<div class="col-sm-3">
					<?php echo $form->textField($principal1,'[1]email_address', array('class' => 'form-control')); ?>
					<?php echo $form->error($principal1,'[1]email_address'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal2,'[2]email_address', array('class' => 'form-control')); ?>
					<?php echo $form->error($principal2,'[2]email_address'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->textField($principal3,'[3]email_address', array('class' => 'form-control')); ?>
					<?php echo $form->error($principal3,'[3]email_address'); ?>
				</div>
			</div>
			<br />
			<?php /*
			<div class="form-group">
				<label class="col-sm-3 control-label" style="height: 30px; padding-top: 3px; font-weight:bold; font-size:18px;">I agree to the credit release below.</label>
				<div class="col-sm-3">
					<?php echo $form->checkbox($principal1,'[1]check_flag', array('value' => 1,)); ?>
					<?php //echo $form->error($principal1,'[1]security_number'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->checkbox($principal2,'[2]check_flag', array( 'value' => 1)); ?>
					<?php //echo $form->error($principal2,'[2]security_number'); ?>
				</div>
				<div class="col-sm-3">
					<?php echo $form->checkbox($principal3,'[3]check_flag', array( 'value' => 1)); ?>
					<?php //echo $form->error($principal3,'[3]security_number'); ?>
				</div>
			</div>
			
			<br />
			*/ ?>
		</div>
	</div>
	<?php /*
	<div class="row">
		<div class="col-md-12">
			<h3 class="small-title">Credit Release</h3>
			<p>Each individual signing as principal certifies that the information provided in this application is accurate and complete. Each individual signing as principal authorizes Essex Funding, Inc. or any of its lending partners to obtain information from the references listed herein and obtain consumer credit reports that will be ongoing and relate not only to the evaluation and/or extension of the business credit requested, but also for the purpose of reviewing the account, increasing the credit line, taking collection action on the account and for any other legitimate purpose associated with the account as needed. Lessee understands that such investigations may include seeking information as to the background, credit and financial responsibility of Lessee's officers and principals, or any of them. 
			
			Lessee understands and consents that its credit information may be transmitted via the Internet, that such information may be accessible by unintended 3rd parties, that it is being submitted at our own risk, and that Lessee waives any right to any punitive damages arising out of or associated with the transmission, interception, use or misuse of the application. Lessee may request the status of this application to be transmitted by electronic mail and Lessee expressly authorizes Essex Funding, Inc. or its nominee(s) to transmit such message to the electronic mail address, which Lessee may provide.
			
			Each individual signing as principal further waives any right or claim which such individual would otherwise have under the Fair Credit Reporting Act in the absence of this continuing consent.</p>
		</div>
	</div>
	*/ ?>
	<br />
	
	<div class="row">

		<div class="col-md-12">
			<h3 class="small-title">Trade References</h3>
				<div class="col-sm-3">
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
				<div class="col-sm-3">
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
				<div class="col-sm-2">
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
				<div class="col-sm-2">
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
				<div class="col-sm-2">
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
		
		<?php
		/* <div class="col-sm-12">
					<p style="font-style:italic; font-size:14px;">
					<?php echo CHtml::link('Non-refundable credit application fee provision.','https://essexfunding.com/refundPolicy.php', array('target' => '_blank'));?>
				</p>
		</div> */
		?>
		

		<div class="col-md-12">
			<h3 class="small-title">Equipment Vendor / Manufacturer Information</h3>
			<br />
			<div class="col-sm-4">
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'name'); ?>
					<?php echo $form->textField($vendor,'name', array('class' => 'form-control')); ?>
					<?php echo $form->error($vendor,'name'); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'address'); ?>
					<?php echo $form->textField($vendor,'address', array('class' => 'form-control')); ?>
					<?php echo $form->error($vendor,'address'); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'location'); ?>
					<?php echo $form->textField($vendor,'location', array('class' => 'form-control')); ?>
					<?php echo $form->error($vendor,'location'); ?>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-horizontal">
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'contact_person', array('class' => 'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					<?php echo $form->textField($vendor,'contact_person', array('class' => 'form-control')); ?>
					</div>
					<?php echo $form->error($vendor,'contact_person'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'equipment_description', array('class' => 'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
					<?php echo $form->textField($vendor,'equipment_description', array('class' => 'form-control')); ?>
					</div>
					<?php echo $form->error($vendor,'equipment_description'); ?>
					
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($vendor,'monthly_payment', array('class' => 'col-sm-4 control-label')); ?>
					<div class="col-sm-8">
						<div class="input-group">
						<span class="input-group-addon">$</span>
						<?php echo $form->textField($vendor,'monthly_payment', array('class' => 'form-control', 'maxlength' => 25)); ?>
						</div>
						<?php echo $form->error($vendor,'monthly_payment'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Desired Term</label>
					<?php // echo $form->radioButtonList($vendor, 'term', array('12'=>'12mo', '24'=>'24mo', '36' => '36mo', '46' => '46mo','60' => '60mo'), array('separator' => ' ','template'=> '<div class="col-md-2"><div class="radio"><label>{input} {label}</label></div></div>'));?>
					<div class="col-sm-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>12,'uncheckValue'=>null)); ?>
								12mo
							</label>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>24,'uncheckValue'=>null)); ?>
								24mo
							</label>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>36,'uncheckValue'=>null)); ?>
								36mo
							</label>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'term',array('value'=>46,'uncheckValue'=>null)); ?>
								46mo
							</label>
						</div>
					</div>
					<div class="col-sm-2 col-sm-offset-4">
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
		<div class="col-md-6">
			<div class="form-horizontal">
					
				<div class="form-group">
				
					<?php echo $form->labelEx($vendor,'contact_phone',array('class' => 'col-sm-4  control-label', 'style' => 'text-align:right')); ?>
					<div class="col-sm-8">
					<?php echo $form->textField($vendor,'contact_phone', array('class' => 'form-control')); ?>
					<?php echo $form->error($vendor,'contact_phone'); ?>
					</div>
				</div>
				
				<div class="form-group">
											<label class="col-sm-4 control-label required" style="text-align:right" for="VendorInfo_equipment_location">Equipment Location</label>
					<?php //echo $form->labelEx($vendor,'equipment_location',array('class' => 'col-sm-4 control-label', 'style' => 'text-align:right')); ?>
					<div class="col-sm-8">
					<?php echo $form->textField($vendor,'equipment_location', array('class' => 'col-sm-4 form-control')); ?>
					<?php echo $form->error($vendor,'equipment_location'); ?>
					</div>
					
					<div class="col-sm-8 col-sm-offset-4 text-center" style="margin-top:4px;">(If different from company location) </div>
					
				</div>
				
				<div class="form-group" style="margin-bottom:0px;">
					<?php echo $form->labelEx($vendor,'total_invoice', array('class' => 'col-sm-4 control-label','style' => 'text-align:right')); ?>
					<div class="col-sm-8">
						<div class="input-group">
						<span class="input-group-addon">$</span>
						<?php echo $form->textField($vendor,'total_invoice', array('class' => 'form-control', 'maxlength' => 25)); ?>
						</div>
						<?php echo $form->error($vendor,'total_invoice'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label" style="text-align:right;">Equipment Type</label>
					
					<div class="col-sm-2 phone">
						<div class="radio">
							<label>
									<?php echo $form->radioButton($vendor,'new_flag',array('value'=>1,'uncheckValue'=>null)); ?>	New
							</label>
						</div>
					</div>
					<div class="col-sm-2 phone">
						<div class="radio">
							<label>
								<?php echo $form->radioButton($vendor,'new_flag',array('value'=>0,'uncheckValue'=>null)); ?> Used
							</label>
						</div>
					</div>
					
					<?php 
					echo $form->hiddenField($vendor, 'lease_option', array('value' => 1));
					
					/* // <div class="col-sm-2">
						// <div class="radio">
							// <label>
								// <?php echo $form->radioButton($vendor,'lease_option',array('value'=>1,'uncheckValue'=>null)); ?>
								// FMV
							// </label>
						// </div>
					// </div>
					// <div class="col-sm-3">
						// <div class="radio">
							// <label>
								// <?php echo $form->radioButton($vendor,'lease_option',array('value'=>2,'uncheckValue'=>null)); ?>
								// 10% Option
							// </label>
						// </div>
					// </div>
					// <div class="col-sm-2">
						// <div class="radio">
							// <label>
								// <?php echo $form->radioButton($vendor,'lease_option',array('value'=>3,'uncheckValue'=>null)); ?>
								// $1.00
							// </label>
						// </div>
					// </div>
					// <div class="col-sm-3 col-sm-offset-4">
						// <div class="radio">
							// <label>
									// <?php echo $form->radioButton($vendor,'lease_option',array('value'=>4,'uncheckValue'=>null)); ?>
								// 10% PUT
							// </label>
						// </div>
					// </div> */
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label>
					If applying for a line of credit to buy multiple pieces of equipment, indicate size of line requested: 
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="radio">
				<label>
						<?php echo $form->radioButton($vendor,'line_of_credit',array('value'=>'50,000','uncheckValue'=>null, 'class' => "vendorInfo_line_of_credit")); ?>
					$50, 000
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($vendor,'line_of_credit',array('value'=>'100,000','uncheckValue'=>null, 'class' => "vendorInfo_line_of_credit")); ?>
					$100, 000
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="radio">
				<label>
					<?php echo $form->radioButton($vendor,'line_of_credit',array('value'=>'250,000','uncheckValue'=>null, 'class' => "vendorInfo_line_of_credit")); ?>
					$250, 000
				</label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group" style="padding-top:2px;">
				<label class="col-sm-2 control-label radio">Other:</label>
				<div class="col-sm-8">
					<?php //echo $form->textField($vendor,'other', array('class' => 'form-control')); ?>
					<?php echo CHtml::textField('other',$other_line,array('class' => 'form-control other-line-credit other_line_of_credit', 'maxlength' => 25));?>
				</div>
			</div>
		</div>
	</div>
	
	<br/ >
	
	<div class="row">
		<div class="col-sm-12">
			<?php echo CHtml::button('Back', array('class' => 'btn btn-primary orange-btn pull-left btn-back')); ?>
			<?php echo CHtml::button('Next', array('class' => 'btn btn-primary orange-btn pull-right btn-step2', 'data-loading-text' => "Please wait...")); ?>
		</div>
	</div>
</div>

	<!-- page 3 -->
<div class="step3 steps">

	<div class="row">
		<div class="col-md-12">
			<h3 class="small-title">CREDIT CONSENT AND AUTHORIZATION</h3>
			<p>
				Each individual listed as a principal above in this application certifies on behalf of the applicant company (the “Applicant”) and himself or herself as a principal of the Applicant (with the Applicant, each a “Credit Party” and collectively, the “Credit Parties”), that the information provided in this application is accurate and complete.  Each Credit Party expressly authorizes Essex Funding, Inc. (the “Company”) and/or any of its lending partners to obtain, directly or indirectly through its nominees, information from the references listed in this application and a Credit Party’s credit and/or background reports (collectively, "Reports") and understands that such Reports may be used by the lending partners of the Company in the determination of whether or not to enter into a credit agreement with the Credit Parties. Each Credit Party further expressly authorizes the Company and/or any of its lending partners to share any such Reports with the equipment vendor/manufacturer listed in this application. If the Applicant enters into a credit agreement with any of the Company’s lending partners, each of the Credit Parties consents to this authorization remaining on file and serving as on-going authorization for the Company and/or its lending partners to procure additional Reports at any other time during such time such credit agreement is in place for purposes of reviewing the account, increasing the credit line, taking collection action on the account and/or for any other legitimate purpose associated with the account as needed.  Each Credit Party understands that and consents to its credit information and this application being transmitted via the Internet, that such information may be accessible by unintended third parties and that such information is being submitted at such Credit Party’s own risk. Each Credit Party waives any right to any punitive damages arising out of or associated with the transmission, interception, use or misuse of such information.  Each Credit Party further waives any right or claim which such person would otherwise have under the Fair Credit Reporting Act in the absence of this continuing consent.  Each Credit Party, on behalf of the Applicant, may request the status of this application to be transmitted by electronic mail, and each Credit Party expressly authorizes the Company or its nominee(s) to transmit such message to the electronic mail address, which such Credit Party provides. 
			</p>
		</div>

		
		<div class="col-sm-12">
			<div class="checkbox">
				<label>
					 <?php

						// if($app_form->isNewRecord){
							echo CHtml::CheckBox('agree',false, array ('value'=>'1','class' => 'agree'));
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
		<div class="col-md-12">
			<h3 class="small-title">ECOA Notice</h3>
			<p>Thank you for your business credit application. We will review it carefully and get back to you promptly. If your application for business credit is denied, you have the right to a written statement of the specific reasons for the denial. To obtain that statement, please contact us within 60 days from the date you were notified of our decision. We will send you a written statement of the reasons for the denial within 30 days of your request for the statement provided we receive such statement from our applicable leading partner. Contact Essex Funding Inc., 101 East Kennedy Blvd. Suite 1820, Tampa, Florida, 33602, phone number 813.443.4632. NOTICE: The Federal Equal Credit Opportunity Act prohibits creditors from discriminating against credit applications on the basis of race, color, religion, national origin, sex, marital status, age (provided the applicant has the capacity to enter into a binding contract), because all or part of the applicant's income derives from any public assistance program; or because the applicant has in good faith exercised any right under the Consumer Credit Protection Act. The Federal Agency that administers our lending partner's compliance with this law is the Federal Reserve Bank of Chicago, P.O Box 1200, Minneapolis, MN, 55480.</p>
		</div>
		<br />
		<br />
		<div class="col-md-12">
			<p class="col-sm-4 small pull-left">For bank use only</p>
		</div>
		<div class="col-sm-6">
			<div class="form-horizontal">
				<?php echo $form->labelEx($ecoa,'name', array('class' => 'col-sm-4 control-label')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($ecoa,'name', array('class' => 'form-control')); ?>
					<?php echo $form->error($ecoa,'name'); ?>
				</div>
			
				
				<?php echo $form->labelEx($ecoa,'phone', array('class' => 'col-sm-4 control-label')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($ecoa,'phone', array('class' => 'form-control')); ?>
				<?php echo $form->error($ecoa,'phone'); ?>
				</div>
				
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-horizontal">
				<?php echo $form->labelEx($ecoa,'banker_id', array('class' => 'col-sm-4 control-label')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($ecoa,'banker_id', array('class' => 'form-control')); ?>
				<?php echo $form->error($ecoa,'banker_id'); ?>
				</div>
				
				
				<?php echo $form->labelEx($ecoa,'fax', array('class' => 'col-sm-4 control-label')); ?>
				<div class="col-sm-8">
				<?php echo $form->textField($ecoa,'fax', array('class' => 'form-control')); ?>
				<?php echo $form->error($ecoa,'fax'); ?>
				</div>
				
			</div>
		</div>
	</div>
	
	<Br />
	<div class="row">
		<div class="col-sm-12">
			<?php echo CHtml::button('Back', array('class' => 'btn btn-primary orange-btn pull-left btn-back')); 

				if($app_form->isNewRecord || $app_form->type != ApplicationForm::TYPE_PAID)
					echo CHtml::submitButton( ($app_form->isNewRecord)? "Next": "Update" , array('class' => 'btn btn-primary orange-btn pull-right app-submit', 'name' => 'app_submit'));

				echo CHtml::hiddenField('applicationCreditFormProcess', null, array('class' => 'applicationCreditFormProcess'));
			?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
	
<script>	
//---------------------------------BUSINESS CITY -------------------------------------------//
$(document).ready(function(){
$('#ApplicationForm_state').on('change', function(){
	
	$('#ApplicationForm_city').hide(); 
	$('.loading-city').show(); 
	$('.city-text').remove();
	var state = $('#ApplicationForm_state').find(":selected").val();
	var _inputToAppend = '<input type="text" class="form-control city-text" name="ApplicationForm[city]" placeholder=""> ';
	
	var data = {
		state : state		
	};	
	
	$.ajax({
		url: "<?php echo Yii::app()->createAbsoluteUrl('/applicationForm/dynamicCity'); ?>",
		type: "POST",
		dataType: 'JSON',
		data: data,
		success: function(result) {
	
			$('.loading-city').hide(); 		
			$('.other-state-div').hide();	
			if(result != "") {
				var _optToAppend;
				$('#ApplicationForm_city').empty();
				$.each(result, function(index, val){
					console.log(val);
					$('#ApplicationForm_city').append(val);
				}); 
				$('.city-text').remove();		
				$('#ApplicationForm_city').show(); 			
				
			}
			else{
				
				if(state == 'OT')
				{
					$('.other-state-div').show();
				}
				
				$('.city-text').remove();
				$('#ApplicationForm_city').empty();
				$('#ApplicationForm_city').hide(); 
				$('.city-container').append(_inputToAppend);
			}
		}
	});
});
var cityBusiness = "<?php echo Cities::hasCity($app_form->state); ?>";
if(cityBusiness == "")
{
	$('#ApplicationForm_city').hide(); 
	var _inputToAppend = '<input type="text" class="form-control city-text" name="ApplicationForm[city]" value="<?php echo (!empty($app_form->city))? $app_form->city : ''; ?>" placeholder="">';
	$('.city-container').append(_inputToAppend);	
}
else{
		$('.city-text').remove();
		$('#ApplicationForm_city').show();
}


	var stateBusiness = "<?php echo $app_form->state; ?>";
	if(stateBusiness == 'OT')
	{
		$('.other-state-div').show();
	}

});






//COUNTRY

$(document).ready(function(){
	$('#ApplicationForm_country').on('input', function(){
		var  country = $('#ApplicationForm_country').find(":selected").val();
		if(country == "") 
		{
			$("#ApplicationForm_state").val("").trigger('change');			
		}
		else if(country != 191) //United State
		{
			$("#ApplicationForm_state").val("OT").trigger('change');			
		}
		else{
			$("#ApplicationForm_state").val("AK").trigger('change');		
		}
	});
});
$(document).ready(function(){
	$('#ApplicationForm_state').on('input', function(e){
		var  state = $('#ApplicationForm_state').find(":selected").val();
		if(state == 'OT')
		{		
			// $("#ApplicationForm_country").val("").trigger('change');
		}
		else{
			$("#ApplicationForm_country").val(191).trigger('change');
		}
	});	
});



</script>