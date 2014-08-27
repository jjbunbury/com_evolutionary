<?php

/**
 * @version     1.0.0
 * @package     com_evolutionary
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dazzle Software <support@dazzlesoftware.org> - http://dazzlesoftware.org
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Evolutionary helper.
 */
class EvolutionaryHelper extends JHelperContent
{
	public static $extension = 'com_evolutionary';

	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_EVOLUTIONARY_TITLE_ACTIONS'),
			'index.php?option=com_evolutionary&view=actions',
			$vName == 'actions'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_EVOLUTIONARY_TITLE_ANIMATIONS'),
			'index.php?option=com_evolutionary&view=animations',
			$vName == 'animations'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_EVOLUTIONARY_TITLE_CONFIGURATIONS'),
			'index.php?option=com_evolutionary&view=configurations',
			$vName == 'configurations'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_EVOLUTIONARY_TITLE_TEXTURES'),
			'index.php?option=com_evolutionary&view=textures',
			$vName == 'textures'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_EVOLUTIONARY_TITLE_BREEDABLES'),
			'index.php?option=com_evolutionary&view=breedables',
			$vName == 'breedables'
		);
		JHtmlSidebar::addEntry(
			JText::_('JCATEGORIES') . ' (' . JText::_('COM_EVOLUTIONARY_TITLE_BREEDABLES') . ')',
			"index.php?option=com_categories&extension=com_evolutionary",
			$vName == 'categories'
		);
		if ($vName=='categories') {
			JToolBarHelper::title('Evolutionary: JCATEGORIES (COM_EVOLUTIONARY_TITLE_BREEDABLES)');
		}
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
/*
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_evolutionary';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
*/

}
