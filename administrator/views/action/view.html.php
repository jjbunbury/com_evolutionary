<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_evolutionary
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View to edit an action.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_evolutionary
 * @since       1.6
 */
class EvolutionaryViewAction extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{

		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		$this->canDo	= JHelperContent::getActions('com_evolutionary', 'action', $this->item->id);

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		if ($this->getLayout() == 'modal')
		{
			$this->form->setFieldAttribute('catid', 'readonly', 'true');
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);

		// Built the actions for new and existing records.
			JToolbarHelper::title(JText::_('COM_EVOLUTIONARY_PAGE_' . ($checkedOut ? 'VIEW_ACTION' : ($isNew ? 'ADD_ACTION' : 'EDIT_ACTION'))), 'pencil-2 action-add');

		// For new records, check the create permission.
		if ($isNew && (count($user->getAuthorisedCategories('com_evolutionary', 'core.create')) > 0))
		{
			JToolbarHelper::apply('action.apply');
			JToolbarHelper::save('action.save');
			JToolbarHelper::save2new('action.save2new');
			JToolbarHelper::cancel('action.cancel');
		}
		else
		{
			// Can't save the record if it's checked out.
			if (!$checkedOut)
			{
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($this->canDo->get('core.edit') || ($this->canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					JToolbarHelper::apply('action.apply');
					JToolbarHelper::save('action.save');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					if ($this->canDo->get('core.create'))
					{
						JToolbarHelper::save2new('action.save2new');
					}
				}
			}

			// If checked out, we can still save
			if ($this->canDo->get('core.create'))
			{
				JToolbarHelper::save2copy('action.save2copy');
			}

			if ($this->state->params->get('save_history', 0) && $user->authorise('core.edit'))
			{
				JToolbarHelper::versions('com_evolutionary.action', $this->item->id);
			}

			JToolbarHelper::cancel('action.cancel', 'COM_EVOLUTIONARY_TOOLBAR_CLOSE');
		}

		//JToolbarHelper::divider();
		//JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER_EDIT');
	}
}