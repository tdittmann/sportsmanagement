<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      default_irems.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage allprojects
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;

?>
<div class="row-fluid table-responsive">        
<table class="<?php echo $this->tableclass;?>">

<thead>
<tr>
<th class="" id="">
<?php  echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ALL_PROJECTS', 'v.name', $this->sortDirection, $this->sortColumn) ; ?>
</th>
<th class="" id="">
<?php echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_GLOBAL_IMAGE', 'v.picture', $this->sortDirection, $this->sortColumn); ?>
</th>

<th class="" id="">
<?php echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ALL_PROJECTS_LEAGUE_NAME', 'l.name', $this->sortDirection, $this->sortColumn); ?>
</th> 
<th class="" id="">
<?php echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ALL_PROJECTS_SEASON', 's.name', $this->sortDirection, $this->sortColumn); ?>
</th> 
                 
<th class="" id="">
<?php echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_EDIT_CLUBINFO_COUNTRY', 'v.country', $this->sortDirection, $this->sortColumn); ?>
</th>                                 
                
</tr>
</thead>

<?php foreach ($this->items as $i => $item) : ?>
<tr class="row<?php echo $i % 2; ?>">
<td>
<?php 
if ( $item->slug )
{
$routeparameter = array();
$routeparameter['cfg_which_database'] = JFactory::getApplication()->input->getInt('cfg_which_database',0);
$routeparameter['s'] = JFactory::getApplication()->input->getInt('s',0);
$routeparameter['p'] = $item->slug;
$routeparameter['type'] = 0;
$routeparameter['r'] = 0;
$routeparameter['from'] = 0;
$routeparameter['to'] = 0;
$routeparameter['division'] = 0;
$link = sportsmanagementHelperRoute::getSportsmanagementRoute('ranking',$routeparameter);    
echo HTMLHelper::link( $link, $item->name );
}
else
{
echo $item->name;    
}

if ( !JFile::exists(JPATH_SITE.DS.$item->picture) )
{
$item->picture = sportsmanagementHelper::getDefaultPlaceholder("clublogobig");
}

?>
</td>
<td>
<?PHP 
echo sportsmanagementHelperHtml::getBootstrapModalImage('allproject'.$item->id,$item->picture,$item->name,'20')
?>
<td>
<?php echo $item->leaguename; ?>
</td>
<td>
<?php echo $item->seasonname; ?>
</td>
<td>
<?php echo JSMCountries::getCountryFlag($item->country); ?>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>

<div class="pagination">
<p class="counter">
<?php echo $this->pagination->getPagesCounter(); ?>
</p>
<p class="counter">
<?php echo $this->pagination->getResultsCounter(); ?>
</p>
<?php echo $this->pagination->getPagesLinks(); ?>
</div>