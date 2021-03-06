<?php 
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      default.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage jlextassociastions
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;

//Ordering allowed ?
//$ordering=($this->sortColumn == 'objassoc.ordering');

HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.modal');
$templatesToLoad = array('footer','listheader');
sportsmanagementHelper::addTemplatePaths($templatesToLoad, $this);
?>
<script language="javascript" type="text/javascript">

function searchPerson(val)
	{
        var s= document.getElementById("filter_search");
        s.value = val;
        Joomla.submitform('', this.form)
	}
</script>
<form action="<?php echo $this->request_url; ?>" method="post" name="adminForm" id="adminForm">
<?PHP
echo $this->loadTemplate('joomla_version');
?>
	
<input type="hidden" name="task" value="" />  
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
<?php echo HTMLHelper::_('form.token')."\n"; ?>
</form>
<?PHP
echo $this->loadTemplate('footer');
?>   
