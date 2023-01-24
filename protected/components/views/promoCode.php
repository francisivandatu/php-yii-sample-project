<?php
/*@var $promoCode String*/

    $clientScript = Yii::app()->clientScript;
    
    if(empty($promoCode)):
    
        $clientScript->registerScript("promocode_validation_script", "

            function validate(promocode){
                $.ajax({
                    url: '".Yii::app()->createAbsoluteUrl('/promoCode/validate')."',
                    type: 'post',
                    dataType: 'json',
                    data: {PromoCode: promocode},
                    success: function(res){

                        if(parseInt(res.status) == 1) {
                            $('#promo-code-wrapper').empty();
                            $('#promo-code-wrapper').html(res.content);

                            // call promoCodeUpdate()
                            /* pages with promo code should instanciate a function promoCodeUpdate */
                            promoCodeUpdate(res);

                        }   
                        else {
                            alert(res.message);
                        }
                    }
                });
            }

            $(document).ready(function(){
                $('a.promo-code-validate-btn').click(function(){

                    var self = $(this);
                    var promocode = $('#promo-code').val();

                    if(promocode == null || promocode == '') {
                        alert('Promo Code cannot be blank.');
                        return;
                    }

                    validate(promocode);

                });
            }); 
        ");
    
?>
        <div id="promo-code-wrapper" class="promo-code-wrapper">
			<div class="row">	
				<div class="col-md-12">       
					<p>Do you have a promo code?</p>
					<div class="input-group">
						<?php echo CHtml::textField('promo_code',null, array('class' => 'form-control', 'placeholder' => 'Enter your promo code', 'id' => 'promo-code')); ?>
						<a class="btn btn-primary promo-code-validate-btn input-group-addon" >Validate Promo Code</a>
					</div>
				</div>
			</div>
        </div>
<?php else: ?>

		<div class="row">
			<div class="col-md-12">
				Your promo code: <strong><?php echo $promoCode; ?></strong> is valid.
				<?php echo CHtml::hiddenField('validated_promo_code', $promoCode); ?>
			</div>
		</div>

<?php endif; ?>
