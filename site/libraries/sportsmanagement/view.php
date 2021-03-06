<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      view.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage libraries
 * 
 * fehlerbehandlung
 * https://docs.joomla.org/Using_JLog
 * https://hotexamples.com/examples/-/JLog/addLogger/php-jlog-addlogger-method-examples.html
 * http://eddify.me/posts/logging-in-joomla-with-jlog.html
 * https://github.com/joomla-framework/log/blob/master/src/Logger/Database.php
 * 
 */
 
defined('_JEXEC') or die();
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;

$document = Factory::getDocument();

$params_com = ComponentHelper::getParams( 'com_sportsmanagement' );
$jsmgrid	= $params_com->get( 'use_jsmgrid' );
$jsmflex	= $params_com->get( 'use_jsmflex' );
$cssflags	= $params_com->get( 'cfg_flags_css' );
$usefontawesome	= $params_com->get( 'use_fontawesome' );
$addfontawesome	= $params_com->get( 'add_fontawesome' );

// welche joomla version ?
if (version_compare(JVERSION, '3.0.0', 'ge')) {
    if($cssflags){
    $stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'components/com_sportsmanagement/libraries/flag-icon/css/flag-icon.css' . '" type="text/css" />' . "\n";
    $document->addCustomTag($stylelink);
    }
    if($jsmflex){
    $stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'components/com_sportsmanagement/assets/css/flex.css' . '" type="text/css" />' . "\n";
    $document->addCustomTag($stylelink);
    }
    if($jsmgrid){
    $stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'components/com_sportsmanagement/assets/css/grid.css' . '" type="text/css" />' . "\n";
    $document->addCustomTag($stylelink);
    }
    if($usefontawesome){
    $stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'components/com_sportsmanagement/assets/css/fontawesome_extend.css' . '" type="text/css" />' . "\n";
    $document->addCustomTag($stylelink);
    }
    if($addfontawesome){
    $stylelink = '<link rel="stylesheet" href="' . Uri::root() . 'components/com_sportsmanagement/libraries/fontawesome/css/font-awesome.min.css' . '" type="text/css" />' . "\n";
    $document->addCustomTag($stylelink);
    }
} elseif (version_compare(JVERSION, '2.5.0', 'ge')) {
// Joomla! 2.5 code here
} elseif (version_compare(JVERSION, '1.7.0', 'ge')) {
// Joomla! 1.7 code here
} elseif (version_compare(JVERSION, '1.6.0', 'ge')) {
// Joomla! 1.6 code here
} else {
// Joomla! 1.5 code here
}

/**
 * sportsmanagementView
 * 
 * @package 
 * @author diddi
 * @copyright 2014
 * @version $Id$
 * @access public
 */
class sportsmanagementView extends HtmlView {

    protected $icon = '';
    protected $title = '';
    protected $layout = '';
    protected $tmpl = '';
    protected $table_data_class = '';
    protected $table_data_div = '';

    /**
     * sportsmanagementView::display()
     * 
     * @param mixed $tpl
     * @return
     */
    public function display($tpl = null) {
        
/**
 * alle fehlermeldungen online ausgeben
 * mit der kategorie: jsmerror       
 */ 
Log::addLogger(array('logger' => 'messagequeue'), Log::ALL, array('jsmerror'));
/**
 * fehlermeldungen datenbankabfragen
 */
Log::addLogger(array('logger' => 'database','db_table' => '#__sportsmanagement_log_entries'), Log::ALL, array('dblog'));
/**
 * laufzeit datenbankabfragen
 */
Log::addLogger(array('logger' => 'database','db_table' => '#__sportsmanagement_log_entries'), Log::ALL, array('dbperformance'));
        
        // Reference global application object
        $this->app = Factory::getApplication();
        // JInput object
        $this->jinput = $this->app->input;

        $this->modalheight = ComponentHelper::getParams($this->jinput->getCmd('option'))->get('modal_popup_height', 600);
        $this->modalwidth = ComponentHelper::getParams($this->jinput->getCmd('option'))->get('modal_popup_width', 900);

        if (version_compare(JSM_JVERSION, '4', 'eq')) {
            $this->uri = Uri::getInstance();
        } else {
            $this->uri = Factory::getURI();
        }

        $this->action = $this->uri->toString();
        $this->params = $this->app->getParams();
        // Get a refrence of the page instance in joomla
        $this->document = Factory::getDocument();
        $this->option = $this->jinput->getCmd('option');
        $this->user = Factory::getUser();
        $this->view = $this->jinput->getVar("view");
        $this->cfg_which_database = $this->jinput->getVar('cfg_which_database','0');
	    
        if(isset($_SERVER['HTTP_REFERER'])) {
        $this->backbuttonreferer = $_SERVER['HTTP_REFERER'];
	    }
	    else
	    {
		$this->backbuttonreferer = getenv('HTTP_REFERER');    
	    }
        
        $this->model = $this->getModel();
        $headData = $this->document->getHeadData();
        $scripts = $headData['scripts'];
        $this->document->addStyleSheet(Uri::base().'components/'.$this->option.'/assets/css/modalwithoutjs.css');
        
        $this->document->addStyleSheet(Uri::base().'components/'.$this->option.'/assets/css/jcemediabox.css');
		$this->document->addScript(Uri::root(true) . '/components/'.$this->option.'/assets/js/jcemediabox.js');

        $headData['scripts'] = $scripts;
        $this->document->setHeadData($headData);

        switch ($this->view) {
	case 'ical':
                $this->project = sportsmanagementModelProject::getProject(sportsmanagementModelProject::$cfg_which_database);
		break;
            case 'resultsranking':
                $this->project = sportsmanagementModelProject::getProject(sportsmanagementModelProject::$cfg_which_database);
                $this->overallconfig = sportsmanagementModelProject::getOverallConfig(sportsmanagementModelProject::$cfg_which_database);

                break;
            default:
                $this->project = sportsmanagementModelProject::getProject(sportsmanagementModelProject::$cfg_which_database);
                $this->overallconfig = sportsmanagementModelProject::getOverallConfig(sportsmanagementModelProject::$cfg_which_database);
                $this->config = sportsmanagementModelProject::getTemplateConfig($this->getName(), sportsmanagementModelProject::$cfg_which_database);
                $this->config = array_merge($this->overallconfig, $this->config);
                break;
        }

 /**
  * flexible einstellung der div klassen im frontend
  * da man nicht alle templates mit unterschiedlich bootstrap versionen
  * abfangen kann. hier muss der anwender bei den templates hand anlegen
  */	    
	$this->divclasscontainer = isset($this->config['divclasscontainer']) ? $this->config['divclasscontainer'] : 'container-fluid';   
	$this->divclassrow = isset($this->config['divclassrow']) ? $this->config['divclassrow'] : 'row-fluid';
		
        $this->init();

        $this->addToolbar();

        parent::display($tpl);
    }

    
    protected function addToolbar() {
        
    }

    /**
     * sportsmanagementView::init()
     * 
     * @return void
     */
    protected function init() {
        
    }

}
