<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      seasons.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage controllers
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text; 
/**
 * sportsmanagementControllerseasons
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementControllerseasons extends JSMControllerAdmin
{
	
 function cancel($key = NULL)
{
    $msg = Text::_('JLIB_HTML_BEHAVIOR_CLOSE');
    $link = 'index.php?option=com_sportsmanagement&view=close&tmpl=component';
$this->setRedirect($link,$msg);
    }
	
	/**
	 * sportsmanagementControllerseasons::applypersons()
	 * 
	 * @return void
	 */
	function applypersons()
    {
        $option = Factory::getApplication()->input->getCmd('option');
		$app = Factory::getApplication();
        $post = Factory::getApplication()->input->post->getArray(array());
        $model = $this->getModel();
       $model->saveshortpersons();
       
       $msg = '';
        $this->setRedirect('index.php?option=com_sportsmanagement&tmpl=component&view=persons&layout=assignpersons&season_id='.$post['season_id'].'&team_id='.$post['team_id'].'&persontype='.$post['persontype'],$msg);
        
    }
    
//    /**
//     * sportsmanagementControllerseasons::savepersons()
//     * 
//     * @return void
//     */
//    function savepersons()
//    {
//        $option = Factory::getApplication()->input->getCmd('option');
//		$app = Factory::getApplication();
//        $post = Factory::getApplication()->input->post->getArray(array());
//        $model = $this->getModel();
//       $model->saveshortpersons();
//        
//        $msg = '';
//        $this->setRedirect('index.php?option=com_sportsmanagement&view=close&tmpl=component',$msg);
//        
//    }
    
    /**
     * sportsmanagementControllerseasons::applyteams()
     * 
     * @return void
     */
    function applyteams()
    {
        $option = Factory::getApplication()->input->getCmd('option');
		$app = Factory::getApplication();
        $post = Factory::getApplication()->input->post->getArray(array());
        $model = $this->getModel();
       $model->saveshortteams();
       
       $msg = '';
       $this->setRedirect('index.php?option=com_sportsmanagement&tmpl=component&view=teams&layout=assignteams&season_id='.$post['season_id'],$msg);
        
    }
    
//    /**
//     * sportsmanagementControllerseasons::saveteams()
//     * 
//     * @return void
//     */
//    function saveteams()
//    {
//        $option = Factory::getApplication()->input->getCmd('option');
//		$app = Factory::getApplication();
//        $post = Factory::getApplication()->input->post->getArray(array());
//        $model = $this->getModel();
//       $model->saveshortteams();
//        
//        $msg = '';
//        $this->setRedirect('index.php?option=com_sportsmanagement&view=close&tmpl=component',$msg);
//        
//    }
  
  /**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Season', $prefix = 'sportsmanagementModel', $config = Array() ) 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	


	
}
