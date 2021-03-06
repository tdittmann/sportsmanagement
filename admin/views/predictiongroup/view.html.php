<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage predictiongroup
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

/**
 * sportsmanagementViewpredictiongroup
 * 
 * @package 
 * @author diddi
 * @copyright 2014
 * @version $Id$
 * @access public
 */
class sportsmanagementViewpredictiongroup extends sportsmanagementView
{

	
	/**
	 * sportsmanagementViewpredictiongroup::init()
	 * 
	 * @return
	 */
	public function init ()
	{

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

	}



	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{	
	   
	$jinput = Factory::getApplication()->input;
	$jinput->set('hidemainmenu', true);
        
	$isNew = $this->item->id ? $this->title = Text::_('COM_SPORTSMANAGEMENT_PREDICTION_GROUP_EDIT') : $this->title = Text::_('COM_SPORTSMANAGEMENT_PREDICTION_GROUP_NEW');
	$this->icon = 'pgame';

	parent::addToolbar();  	      
	}
    
   
    		
}
?>
