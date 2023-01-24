<?php
/* add variables or conditions if need */
class SideNav extends CWidget
{
	/* sample variables */
	public $active = array();
	public $openParent = array();
	public $menu = array();
	
	
	public function init()
	{
		// $menu['id']
		$this->menu = array(
			'manage_user' => array(
				'label' => '<i class="fa fa-users"></i> User Accounts',
				'link' => array('/admin/user')
			),
			'manage_applicationForm' => array(
				'label' => '<i class="glyphicon glyphicon-folder-open"></i> Application Forms',
				'link' => array('/admin/applicationForm')
			),
			'manage_leaseCalculator' => array(
				'label' => '<i class="glyphicon glyphicon-list-alt"></i> Lease Calculator',
				'link' => array('/admin/leaseCalculator')
			),
			/* 'settings' => array(
				'label' => 'Settings',
				'subpages' => array(
					'main_settings' => array(
						'label' => 'Main Settings',
						'link' => array('/admin/setting')
					),
					'api_settings_list' => array(
						'label' => 'API Settings List',
						'link' => array('/admin/setting/manageApi')
					),
					// 'Venue_filters' => array(
						// 'label' => 'Venue List',
						// 'link' => array('/admin/setting/manageVenue')
					// ),
				)
				
			), */
		);
		
	}
	
	public function run()
	{	
		$this->render('sidenav', array(
			'menu' => $this->menu,
		));
	}
	
	public function extractMenu($menu, $level = 1, $id = 'sidebar', $collapse = 'out')
	{
		if ($level == 1)
			$return = '<ul id="'.$id.'" class="nav nav-sidebar">';
		else
			$return = '<ul id="'.$id.'" class="nav panel-collapse collapse '.$collapse.' ">';
		
		foreach($menu as $key => $mm)
		{
			
			if (in_array($key, $this->active)) {
				$class = "active";
				$collapse = "in";
				$linkClass = '';
			} 
			else if ( in_array($key, $this->openParent) )
			{
				$class = "";
				$collapse = "in";
				$linkClass = '';
			} else {
				$class = "";
				$collapse = "out";
				$linkClass = 'collapsed';
			}
			
			if (isset($mm['link']))
			{
				$return .= '<li class='.$class.'>';
					$return .= CHtml::link($mm['label'], $mm['link']);
				$return .= '</li>';
			}
			else
			{
				$return .= '<li class="has-dropdown '.$class.'">';
					$return .= CHtml::link($mm['label'], '', array('class'=>$linkClass, 'data-toggle'=>'collapse', 'data-parent'=>$id, 'href'=>'#'.$key ));
					$return .= $this->extractMenu($mm['subpages'], ($level + 1),$key, $collapse);
				$return .= '</li>';
			}
		}
		$return .= '</ul>';
		return $return;
	}
	
}
?>
