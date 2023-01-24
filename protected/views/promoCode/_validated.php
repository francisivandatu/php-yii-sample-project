<?php
/*@var $promoCode String*/
?>

<div class="row">
    <div class="col-md-12">
        Your promo code: <strong><?php echo $promoCode; ?></strong> is valid.
        <?php echo CHtml::hiddenField("validated_promo_code", $promoCode); ?>
    </div>
</div>
