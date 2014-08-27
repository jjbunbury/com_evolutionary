<?php
/**
 * @version     1.0.0
 * @package     com_evolutionary
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dazzle Software <support@dazzlesoftware.org> - http://dazzlesoftware.org
 */


// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.tabstate');

if (!JFactory::getUser()->authorise('core.manage', 'com_evolutionary'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

JLoader::register('EvolutionaryHelper', __DIR__ . '/helpers/evolutionary.php');

$controller = JControllerLegacy::getInstance('Evolutionary');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();