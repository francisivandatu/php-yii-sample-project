<?php
/* add variables or conditions if need */
class PromoCode extends CWidget
{
    
        public $promoCode = null;
    
	/* sample variables */
	public function init()
	{
		
	}
	
	public function run()
	{	
            
                $this->render('promoCode', array(
                    'promoCode' => $this->promoCode
                ));
                
	}
}
?>
