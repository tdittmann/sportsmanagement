<?php
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      templaytes.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage controllers
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
 
/**
 * sportsmanagementControllertemplates
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementControllertemplates extends JSMControllerAdmin
{
  
	
    
    
    /**
     * sportsmanagementControllertemplates::changetemplate()
     * 
     * @return void
     */
    public function changetemplate() 
	{
	$post=Factory::getApplication()->input->post->getArray(array());
    $msg = '';
    $this->setRedirect('index.php?option=com_sportsmanagement&view=template&layout=edit&id='.$post['new_id'],$msg);	
	}
    
    
    /**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'template', $prefix = 'sportsmanagementModel', $config = Array() ) 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}