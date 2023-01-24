<?php
/*
	developer model for common PHP functions
*/

class Dev
{
	public static function pm($model, $exit = 0)
	{
		if ( $model !== null )
		{
			echo '<pre>';
				print_r($model->attributes);
			echo '</pre>';
		}
		else
		{
			echo 'model is null';
		}
		
		if ( $exit == 1 )
		exit;
		
		return;
	}
	
	public static function pms($models, $exit = 0)
	{
		echo '<pre>';
		foreach($models as $model)
		{
			
			print_r($model->attributes);
			
		}
		echo '</pre>';
		
		if ( $exit == 1 )
			exit;
		
		return;
	}
	
	
	public static function pv($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
		
		return;
	}
	
	public static function pvx($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
		exit;
		return;
	}
	
	public static function pe($model)
	{
		if ( $model !== null )
		{
			foreach($model->getErrors() as $errors)
			{
				foreach($errors as $error)
				{
					echo '<li>'.$error.'</li>';
				}
			}
		}
		else
		{
			echo 'model is null';
		}
			
		return;
	}
	
	public static function femp($models,$property)
	{
		foreach($models as $model)
		{
			echo $model->{$property};
			echo '<br />';
		}
	}
}
