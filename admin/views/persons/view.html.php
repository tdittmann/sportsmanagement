<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage persons
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;

/**
 * sportsmanagementViewPersons
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewPersons extends sportsmanagementView
{

	/**
	 * sportsmanagementViewPersons::init()
	 * 
	 * @return
	 */
	public function init ()
	{
	   $tpl = '';
       $this->assign = false;
       $this->season_id = 0;
       $this->team_id = 0;
       $this->persontype = 0;
       
       switch ( $this->getLayout() )
       {
       case 'assignpersons':
       case 'assignpersons_3':
       case 'assignpersons_4':
       $this->season_id = $this->jinput->get('season_id');
       $this->team_id = $this->jinput->get('team_id');
       $this->persontype = $this->jinput->get('persontype');
	   $this->assign = true;
       break; 
       }

		$this->table = Table::getInstance('person', 'sportsmanagementTable');
		$this->app->setUserState($this->option.'task','');

/**
 * build the html select list for positions
 */
		$positionsList[] = HTMLHelper::_('select.option', '0', Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_POSITION'));
		$positions = BaseDatabaseModel::getInstance('positions', 'sportsmanagementmodel')->getAllPositions();
		if ($positions)
        { 
            $positions = array_merge($positionsList, $positions);
            }
		$lists['positions'] = $positions;
		unset($positionsList);

/**
 * build the html options for nation
 */
		$nation[] = HTMLHelper::_('select.option', '0', Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_COUNTRY'));
		if ($res = JSMCountries::getCountryOptions())
        {
            $nation = array_merge($nation,$res);
            $this->search_nation = $res;
            }
		
        $lists['nation'] = $nation;
        $lists['nation2'] = JHtmlSelect::genericlist($nation, 
						'filter_search_nation', 
						'class="inputbox" style="width:140px; " onchange="this.form.submit();"', 
						'value', 
						'text', 
						$this->state->get('filter.search_nation'));
        
        unset($nation);
        
        $myoptions = array();
        $myoptions[] = HTMLHelper::_('select.option','0',Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_AGEGROUP'));
        $mdlagegroup = BaseDatabaseModel::getInstance('agegroups', 'sportsmanagementModel');
        if ( $res = $mdlagegroup->getAgeGroups() )
        {
            $myoptions = array_merge($myoptions,$res);
            $this->search_agegroup	= $res;
        }
        $lists['agegroup'] = $myoptions;
        $lists['agegroup2'] = JHtmlSelect::genericlist($myoptions, 
						'filter_search_agegroup', 
						'class="inputbox" style="width:140px; " onchange="this.form.submit();"', 
						'value', 
						'text', 
						$this->state->get('filter.search_agegroup'));
        unset($myoptions);
		
		$this->lists = $lists;

	}

	/**
	 * sportsmanagementViewPersons::_displayAssignPlayers()
	 * 
	 * @param mixed $tpl
	 * @return void
	 */
	function _displayAssignPlayers($tpl=null)
	{
        
        $this->project_id	= $this->app->getUserState( "$this->option.pid", '0' );
        $this->persontype	= $this->app->getUserState( "$this->option.persontype", '0' );
		$mdlProject = BaseDatabaseModel::getInstance('project', 'sportsmanagementModel');
        $project = $mdlProject->getProject($this->project_id);
		$project_name = $project->name;
		$project_team_id = $this->app->getUserState($this->option.'project_team_id');
		$team_name = $this->model->getProjectTeamName($project_team_id);
        
        
        
        //$items = $this->get('Items');
		//$total = $this->get('Total');
		//$pagination = $this->get('Pagination');
        
        $this->table = Table::getInstance('person', 'sportsmanagementTable');
//		$this->table	= $table;

		//save icon should be replaced by the apply
		JToolbarHelper::apply('person.saveassigned',Text::_('COM_SPORTSMANAGEMENT_ADMIN_PERSONS_SAVE_SELECTED'));		
		
		// Set toolbar items for the page
		$type = $jinput->getInt('type');
		if ($type == 0)
		{
                    //back icon should be replaced by the abort/close icon
                    JToolbarHelper::back(Text::_('COM_SPORTSMANAGEMENT_ADMIN_PERSONS_BACK'),'index.php?option=com_sportsmanagement&view=teamplayers');
                    JToolbarHelper::title(Text::_('COM_SPORTSMANAGEMENT_ADMIN_PERSONS_ASSIGN_PLAYERS'),'generic.png');
		}
		elseif ($type == 1)
		{
                    //back icon should be replaced by the abort/close icon
                    JToolbarHelper::back(Text::_('COM_SPORTSMANAGEMENT_ADMIN_PERSONS_BACK'),'index.php?option=com_sportsmanagement&view=teamstaffs');
                    JToolbarHelper::title(Text::_('COM_SPORTSMANAGEMENT_ADMIN_PERSONS_ASSIGN_STAFF'),'generic.png');
		}
		elseif ($type == 2)
		{
                    //back icon should be replaced by the abort/close icon
                    JToolbarHelper::back(Text::_('COM_SPORTSMANAGEMENT_ADMIN_PERSONS_BACK'),'index.php?option=com_sportsmanagement&view=projectreferees');
                    JToolbarHelper::title(Text::_('COM_SPORTSMANAGEMENT_ADMIN_PERSONS_ASSIGN_REFEREES'),'generic.png');
		}
        
        //build the html options for nation
		$nation[] = HTMLHelper::_('select.option', '0', Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_COUNTRY'));
		if ($res = JSMCountries::getCountryOptions()){$nation = array_merge($nation, $res);}
        $lists['nation'] = $nation;
        
        //build the html select list for positions
		$positionsList[] = HTMLHelper::_('select.option','0',Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_POSITION'));
		$positions = BaseDatabaseModel::getInstance('positions', 'sportsmanagementmodel')->getAllPositions();
		if ($positions)
		{
			$positions = array_merge($positionsList, $positions);
		}
		$lists['positions'] = $positions;
		unset($positionsList);
        
        $myoptions = array();
        $myoptions[] = HTMLHelper::_('select.option', '0', Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_AGEGROUP'));
        $mdlagegroup = BaseDatabaseModel::getInstance("agegroups", "sportsmanagementModel");
        if ( $res = $mdlagegroup->getAgeGroups() )
        {
            $myoptions = array_merge($myoptions,$res);
            $this->search_agegroup	= $res;
        }
        $lists['agegroup'] = $myoptions;
        $lists['agegroup2']= JHtmlSelect::genericlist(	$myoptions, 
																'filter_search_agegroup', 
																'class="inputbox" style="width:140px; " onchange="this.form.submit();"',
																'value', 
																'text', 
																$this->state->get('filter.search_agegroup'));
        unset($myoptions);
		
		$this->prjid	= $this->project_id;
		$this->prj_name	= $project_name;
		//$this->team_id	= $team_id;
		$this->team_name	= $team_name;
		$this->project_team_id	= $project_team_id;
		$this->lists	= $lists;
	//	$this->items	= $items;
//        $this->user	= $user;
//		$this->pagination	= $pagination;
//		$this->request_url	= Factory::getURI()->toString();
		$this->type	= $type;
        
        $this->setLayout('assignplayers');


	}

	/**
	 * Displays a calendar control field with optional onupdate js handler
	 *
	 * @param	string	The date value
	 * @param	string	The name of the text field
	 * @param	string	The id of the text field
	 * @param	string	The date format
	 * @param	string	js function to call on date update
	 * @param	array	Additional html attributes
	 */
	function calendar($value,$name,$id,$format='%Y-%m-%d',$attribs=null,$onUpdate=null,$i=null)
	{
		HTMLHelper::_('behavior.calendar'); //load the calendar behavior

		if (is_array($attribs)){$attribs=ArrayHelper::toString($attribs);}
		$document = Factory::getDocument();
		$document->addScriptDeclaration('window.addEvent(\'domready\',function() {Calendar.setup({
	        inputField     :    "'.$id.'",    // id of the input field
	        ifFormat       :    "'.$format.'",     // format of the input field
	        button         :    "'.$id.'_img", // trigger for the calendar (button ID)
	        align          :    "Tl",          // alignment (defaults to "Bl")
	        onUpdate       :    '.($onUpdate ? $onUpdate : 'null').',
	        singleClick    :    true
    	});});');
		$html = '';
		$html .= '<input onchange="document.getElementById(\'cb'.$i.'\').checked=true" type="text" name="'.$name.'" id="'.$id.'" value="'.htmlspecialchars($value,ENT_COMPAT,'UTF-8').'" '.$attribs.' />'.
				 '<img class="calendar" src="'.JURI::root(true).'/templates/system/images/calendar.png" alt="calendar" id="'.$id.'_img" />';
		return $html;
	}
	
	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{
		$this->title = Text::_('COM_SPORTSMANAGEMENT_ADMIN_PERSONS_TITLE');

		JToolbarHelper::publish('persons.publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('persons.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolbarHelper::divider();
		
		JToolbarHelper::apply('persons.saveshort');
		JToolbarHelper::editList('person.edit');
		JToolbarHelper::addNew('person.add');
		JToolbarHelper::custom('person.import', 'upload', 'upload', Text::_('JTOOLBAR_UPLOAD'), false);
		JToolbarHelper::archiveList('person.export', Text::_('JTOOLBAR_EXPORT'));
		
        parent::addToolbar();
	}
}
?>
