<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      jlextdfbnetplayerimport.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage controllers
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Session\Session;
jimport ( 'joomla.filesystem.archive' );

/**
 * sportsmanagementControllerjlextdfbnetplayerimport
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2013
 * @access public
 */
class sportsmanagementControllerjlextdfbnetplayerimport extends BaseController 
{

	/**
	 * sportsmanagementControllerjlextdfbnetplayerimport::save()
	 * 
	 * @return
	 */
	function save() {
	   $option = Factory::getApplication()->input->getCmd('option');
		$app = Factory::getApplication ();
		$document = Factory::getDocument ();
		// Check for request forgeries
		Session::checkToken() or jexit(\Text::_('JINVALID_TOKEN'));
		$msg = '';
		$model = $this->getModel ( 'jlextdfbnetplayerimport' );
		$post = Factory::getApplication()->input->post->getArray(array());
		
		$whichfile = Factory::getApplication()->input->getVar ( 'whichfile', null );
		
		if ( !$post['filter_season'] && $whichfile == 'playerfile' )
		{
		$link = 'index.php?option='.$option.'&view=jlextdfbnetplayerimport';
		$msg = Text::_ ('COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_PLAYERFILE_NO_SEASON');
		$app->Redirect ( $link, $msg, 'ERROR' );
		}
		
		if ($whichfile == 'playerfile') {
			JError::raiseNotice ( 500, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_PLAYERFILE' ) );
		} elseif ($whichfile == 'matchfile') {
			JError::raiseNotice ( 500, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_MATCHFILE' ) );
			
			if (isset ( $post ['dfbimportupdate'] )) {
				JError::raiseNotice ( 500, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_MATCHFILE_UPDATE' ) );
			}
		}
		
/**
 * first step - upload
 */
		if (isset ( $post ['sent'] ) && $post ['sent'] == 1) {
			$upload = $app->input->files->get('import_package');
			$lmoimportuseteams = Factory::getApplication()->input->getVar ( 'lmoimportuseteams', null );
			
			$app->setUserState ( $option . 'lmoimportuseteams', $lmoimportuseteams );
			$app->setUserState ( $option . 'whichfile', $whichfile );
			$app->setUserState ( $option . 'delimiter', $delimiter );
			
			$tempFilePath = $upload ['tmp_name'];
			$app->setUserState ( $option . 'uploadArray', $upload );
			$filename = '';
			$msg = '';
			$dest = JPATH_SITE . DS . 'tmp' . DS . $upload ['name'];
			$extractdir = JPATH_SITE . DS . 'tmp';
			$importFile = JPATH_SITE . DS . 'tmp' . DS . 'joomleague_import.csv';
			if (File::exists ( $importFile )) {
				File::delete ( $importFile );
			}
			if (File::exists ( $tempFilePath )) {
				if (File::exists ( $dest )) {
					File::delete ( $dest );
				}
				if (! File::upload ( $tempFilePath, $dest )) {
					JError::raiseWarning ( 500, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_CTRL_CANT_UPLOAD' ) );
					return;
				} else {
					if (strtolower ( File::getExt ( $dest ) ) == 'zip') {
						$result = JArchive::extract ( $dest, $extractdir );
						if ($result === false) {
							JError::raiseWarning ( 500, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_CTRL_EXTRACT_ERROR' ) );
							return false;
						}
						File::delete ( $dest );
						$src = Folder::files ( $extractdir, 'l98', false, true );
						if (! count ( $src )) {
							JError::raiseWarning ( 500, 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_CTRL_EXTRACT_NOJLG' );
							// todo: delete every extracted file / directory
							return false;
						}
						if (strtolower ( File::getExt ( $src [0] ) ) == 'csv') {
							if (! @ rename ( $src [0], $importFile )) {
								JError::raiseWarning ( 21, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_CTRL_ERROR_RENAME' ) );
								return false;
							}
						} else {
							JError::raiseWarning ( 500, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_CTRL_TMP_DELETED' ) );
							return;
						}
					} else {
						if (strtolower ( File::getExt ( $dest ) ) == 'csv' || strtolower ( File::getExt ( $dest ) ) == 'ics') {
							if (! @ rename ( $dest, $importFile )) {
								JError::raiseWarning ( 21, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_CTRL_RENAME_FAILED' ) );
								return false;
							}
						} else {
							JError::raiseWarning ( 21, Text::_ ( 'COM_SPORTSMANAGEMENT_ADMIN_DFBNET_IMPORT_CTRL_WRONG_EXTENSION' ) );
							return false;
						}
					}
				}
			}
		}
		
		if (isset ( $post ['dfbimportupdate'] )) {
			$link = 'index.php?option='.$option.'&view=jlextdfbnetplayerimport&task=jlextdfbnetplayerimport.update';
		} else {
			
			if ($whichfile == 'matchfile') {
				$xml_file = $model->getData ($post);
				$link = 'index.php?option='.$option.'&view=jlxmlimports&task=jlxmlimport.edit';
			} else {
				$xml_file = $model->getData ($post);
				$link = 'index.php?option='.$option.'&view=jlxmlimports&task=jlxmlimport.edit&filter_season='.$post['filter_season'];
			}
		}
		
		$this->setRedirect ( $link, $msg );
	}
}

?>
