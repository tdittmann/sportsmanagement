<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      confidential.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage tables
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );
// import Joomla table library
jimport('joomla.database.table');
// Include library dependencies
jimport('joomla.filter.input');

/**
 * sportsmanagementTableconfidential
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementTableconfidential extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db)
	{
	   $db = sportsmanagementHelper::getDBConnection();
		parent::__construct( '#__'.COM_SPORTSMANAGEMENT_TABLE.'_confidential', 'id', $db );
	}

}
?>
