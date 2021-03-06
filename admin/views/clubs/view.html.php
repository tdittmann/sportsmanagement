<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage clubs
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

jimport('joomla.filesystem.file');

/**
 * sportsmanagementViewClubs
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewClubs extends sportsmanagementView
{
	
	/**
	 * sportsmanagementViewClubs::init()
	 * 
	 * @return void
	 */
	public function init ()
	{
    
        $inputappend = '';
        
	$this->table = Table::getInstance('club', 'sportsmanagementTable');
        
        //build the html select list for seasons
	$seasons[] = HTMLHelper::_('select.option', '0', Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_SEASON_FILTER'), 'id', 'name');
        $mdlSeasons = BaseDatabaseModel::getInstance('Seasons', 'sportsmanagementModel');
	$allSeasons = $mdlSeasons->getSeasons();
	$seasons = array_merge($seasons, $allSeasons);
        $this->season = $allSeasons;
	$lists['seasons'] = HTMLHelper::_( 'select.genericList',
		$seasons,
		'filter_season',
		'class="inputbox" onChange="this.form.submit();" style="width:120px"',
		'id',
		'name',
		$this->state->get('filter.season'));

		unset($seasons);
       
        //build the html options for nation
	$nation[] = HTMLHelper::_('select.option','0',Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_COUNTRY'));
	if ($res = JSMCountries::getCountryOptions())
        {
        $nation = array_merge($nation, $res);
        $this->search_nation = $res;
        }
		
	$lists['nation'] = $nation;
	$lists['nation2'] = JHtmlSelect::genericlist($nation,
		'filter_search_nation',
		$inputappend.'class="inputbox" style="width:140px; " onchange="this.form.submit();"',
		'value',
		'text',
		$this->state->get('filter.search_nation'));

		if ( $this->state->get('filter.search_nation') )
		{
		$mdlassociations = BaseDatabaseModel::getInstance('jlextassociations', 'sportsmanagementModel');
		$allassociations = $mdlassociations->getAssociations();
		$this->association = $allassociations;
		}
		$this->lists = $lists;

        
	}
	
	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{
        // Set toolbar items for the page
		$this->title = Text::_('COM_SPORTSMANAGEMENT_ADMIN_CLUBS_TITLE');
        JToolbarHelper::apply('clubs.saveshort');
        
        JToolbarHelper::divider();
		JToolbarHelper::addNew('club.add');
		JToolbarHelper::editList('club.edit');
		JToolbarHelper::custom('club.import', 'upload', 'upload', Text::_('JTOOLBAR_UPLOAD'), false);
		JToolbarHelper::archiveList('club.export',Text::_('JTOOLBAR_EXPORT'));
        parent::addToolbar();
		
	}
}
?>
