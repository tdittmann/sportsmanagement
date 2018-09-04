<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      extrafields.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage controllers
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * SportsManagements Controller
 */
class sportsmanagementControllerextrafields extends JSMControllerAdmin
{
  
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'extrafield', $prefix = 'sportsmanagementModel', $config = Array() ) 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}