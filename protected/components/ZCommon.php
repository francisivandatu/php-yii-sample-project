<?php
/* 
 * Class for common and general reusable functions that are not dependant on other models/modules
 */
class ZCommon
{
	/* 
	 * Commonly used for $model->getErrors(). 
	 * It will parse 2 level dimensional error array and return string output
	 * Feel free to adjust the params, like adding a format parameter for the string output
	*/
	public static function parseError($errorItems = array())
	{
		$errorText = '';
		foreach($errorItems as $key => $errors)
		{
			foreach ( $errors as $value )
			{
				$errorText .= '<li>'.$value.'</li>';
			}
		}
		
		return $errorText = '<ul>'.$errorText.'</ul>';
	}
	
	/* 
	 * General date formater
	*/
	public static function formatDate( $date = null, $format = 'M d, Y g:i a' )
	{
		if ( $date == null )
			$date = date('Y-m-d H:i:s');
			
		return date($format, strtotime($date));
	}
	
	/* 
	 * Shortening string function
	*/
	public static function stringTruncate($string, $length, $end = '...')
	{
		$count = strlen($string);
		if ($length <> 0)
		{
			if($count > $length)
				$sting = substr($sting,0,$length) . $end;
		}
		return $string;
	}
}
?>
