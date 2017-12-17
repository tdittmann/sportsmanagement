<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie k�nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp�teren
* ver�ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n�tzlich sein wird, aber
* OHNE JEDE GEW�HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew�hrleistung der MARKTF�HIGKEIT oder EIGNUNG F�R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f�r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * sportsmanagementModelClubs
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementModelClubs extends JSMModelList
{
	var $_identifier = "clubs";
	
	/**
	 * sportsmanagementModelClubs::__construct()
	 * 
	 * @param mixed $config
	 * @return void
	 */
	public function __construct($config = array())
        {   
                $config['filter_fields'] = array(
                        'a.name',
                        'a.website',
                        'a.logo_big',
                        'a.logo_middle',
                        'a.logo_small',
                        'a.country',
                        'a.alias',
                        'a.zipcode',
                        'a.location',
                        'a.address',
                        'a.latitude',
                        'a.longitude',
                        'a.id',
                        'a.published',
                        'a.unique_id',
                        'a.new_club_id',
                        'a.ordering',
                        'a.checked_out',
                        'a.checked_out_time'
                        );
                parent::__construct($config);
                parent::setDbo($this->jsmdb);
        
        }
        
    /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		
        
        if ( JComponentHelper::getParams($this->jsmoption)->get('show_debug_info_backend') )
        {
		$this->jsmapp->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' context -> '.$this->context.''),'');
        $this->jsmapp->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' identifier -> '.$this->_identifier.''),'');
        }

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $published);
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.search_nation', 'filter_search_nation', '');
		$this->setState('filter.search_nation', $temp_user_request);
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.season', 'filter_season', '');
		$this->setState('filter.season', $temp_user_request);
        $temp_user_request = $this->getUserStateFromRequest($this->context.'.filter.geo_daten', 'filter_geo_daten', '');
		$this->setState('filter.geo_daten', $temp_user_request);
        $value = $this->getUserStateFromRequest($this->context . '.list.limit', 'limit', $this->jsmapp->get('list_limit'), 'int');
		$this->setState('list.limit', $value);	
		// List state information.
        $value = $this->getUserStateFromRequest($this->context . '.list.start', 'limitstart', 0, 'int');
		$this->setState('list.start', $value);
        // Filter.order
		$orderCol = $this->getUserStateFromRequest($this->context. '.filter_order', 'filter_order', '', 'string');
		if (!in_array($orderCol, $this->filter_fields))
		{
			$orderCol = 'a.name';
		}
		$this->setState('list.ordering', $orderCol);
		$listOrder = $this->getUserStateFromRequest($this->context. '.filter_order_Dir', 'filter_order_Dir', '', 'cmd');
		if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', '')))
		{
			$listOrder = 'ASC';
		}
		$this->setState('list.direction', $listOrder);
	}
    
    /**
     * sportsmanagementModelClubs::getListQuery()
     * 
     * @return
     */
    protected function getListQuery()
	{
	
		// Select some fields
        $this->jsmquery->clear();
		$this->jsmquery->select(implode(",",$this->filter_fields));
		// From the club table
		$this->jsmquery->from('#__sportsmanagement_club as a');
        
        // Join over the users for the checked out user.
		$this->jsmquery->select('uc.name AS editor');
		$this->jsmquery->join('LEFT', '#__users AS uc ON uc.id = a.checked_out');

/**
 * keine geodaten gesetzt
 */
        if ( $this->getState('filter.geo_daten') == 1 )
		{
        $this->jsmquery->where(' ( a.latitude IS NULL OR a.latitude = 0.00000000 )' );  
        }
/**
 * geo daten gesetzt
 */
        if ( $this->getState('filter.geo_daten') == 2 )
		{
		$this->jsmquery->where(' a.latitude > 0.00000000 ' );  
        }
        
        if ( $this->getState('filter.search') )
		{
        $this->jsmquery->where(' ( LOWER(a.name) LIKE '.$this->jsmdb->Quote('%'.$this->getState('filter.search').'%') .' OR LOWER(a.unique_id) LIKE '.$this->jsmdb->Quote('%'.$this->getState('filter.search').'%') .')' );
        }
        if ( $this->getState('filter.search_nation') )
		{
        $this->jsmquery->where('a.country LIKE '.$this->jsmdb->Quote(''.$this->getState('filter.search_nation').'') );
        }
        
        if ( $this->getState('filter.season') )
		{
        $this->jsmquery->join('LEFT','#__sportsmanagement_team AS t ON a.id = t.club_id');
        $this->jsmquery->join('LEFT','#__sportsmanagement_season_team_id as st ON t.id = st.team_id ');
        $this->jsmquery->where('st.season_id = '.$this->getState('filter.season'));
        }
        
        if ( is_numeric($this->getState('filter.state')) )
		{
		$this->jsmquery->where('a.published = '.$this->getState('filter.state'));	
		}
        
        $this->jsmquery->order($this->jsmdb->escape($this->getState('list.ordering', 'a.name')).' '.
                $this->jsmdb->escape($this->getState('list.direction', 'ASC')));
        
        if ( COM_SPORTSMANAGEMENT_SHOW_DEBUG_INFO )
        {
        $my_text = 'query <pre>'.print_r($this->jsmquery->dump(),true).'</pre>';    
        sportsmanagementHelper::setDebugInfoText(__METHOD__,__FUNCTION__,__CLASS__,__LINE__,$my_text); 
        }
        

		return $this->jsmquery;
	}

   
    /**
     * sportsmanagementModelClubs::getClubListSelect()
     * 
     * @return
     */
    public function getClubListSelect()
	{
	   
        $starttime = microtime(); 
        $results = array();
        // Select some fields
        $this->jsmquery->clear();
		$this->jsmquery->select('id,name,id AS value,name AS text,country,standard_playground');
        // From table
		$this->jsmquery->from('#__sportsmanagement_club');
        $this->jsmquery->order('name');

		try{
        $this->jsmdb->setQuery($this->jsmquery);
        $results = $this->jsmdb->loadObjectList();
        return $results;
        }
        catch (Exception $e)
        {
        $this->jsmapp->enqueueMessage(JText::_($e->getMessage()), 'error');
        return false;
        }
	}

	
}
?>
