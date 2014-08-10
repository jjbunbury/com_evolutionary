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

jimport('joomla.application.component.view');

/**
 * View class for a list of Evolutionary.
 */
class EvolutionaryViewBreedables extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        EvolutionaryHelper::addSubmenu('breedables');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/evolutionary.php';

        $state = $this->get('State');
        $canDo = EvolutionaryHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_EVOLUTIONARY_TITLE_BREEDABLES'), 'breedables.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/breedable';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('breedable.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('breedable.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('breedables.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('breedables.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'breedables.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('breedables.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('breedables.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'breedables.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('breedables.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_evolutionary');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_evolutionary&view=breedables');

        $this->extra_sidebar = '';
        
		//Filter for the field texture
		$select_label = JText::sprintf('COM_EVOLUTIONARY_FILTER_SELECT_LABEL', 'Skinsets');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "test";
		$options[0]->text = "test";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_texture',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.texture'), true)
		);

		//Filter for the field animation
		$select_label = JText::sprintf('COM_EVOLUTIONARY_FILTER_SELECT_LABEL', 'Animations');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "test";
		$options[0]->text = "test";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_animation',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.animation'), true)
		);

		//Filter for the field config
		$select_label = JText::sprintf('COM_EVOLUTIONARY_FILTER_SELECT_LABEL', 'Breed Settings');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "test";
		$options[0]->text = "test";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_config',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.config'), true)
		);

		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

		JHtmlSidebar::addFilter(
			JText::_("JOPTION_SELECT_CATEGORY"),
			'filter_category',
			JHtml::_('select.options', JHtml::_('category.options', 'com_evolutionary'), "value", "text", $this->state->get('filter.category'))

		);

			//Filter for the field created
			$this->extra_sidebar .= '<small><label for="filter_from_created">From Created</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.from'), 'filter_from_created', 'filter_from_created', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange' => 'this.form.submit();'));
			$this->extra_sidebar .= '<small><label for="filter_to_created">To Created</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.to'), 'filter_to_created', 'filter_to_created', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange'=> 'this.form.submit();'));
			$this->extra_sidebar .= '<hr class="hr-condensed">';

			//Filter for the field modified
			$this->extra_sidebar .= '<small><label for="filter_from_modified">From Modified</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.modified.from'), 'filter_from_modified', 'filter_from_modified', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange' => 'this.form.submit();'));
			$this->extra_sidebar .= '<small><label for="filter_to_modified">To Modified</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.modified.to'), 'filter_to_modified', 'filter_to_modified', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange'=> 'this.form.submit();'));
			$this->extra_sidebar .= '<hr class="hr-condensed">';

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.title' => JText::_('COM_EVOLUTIONARY_BREEDABLES_TITLE'),
		'a.alias' => JText::_('COM_EVOLUTIONARY_BREEDABLES_ALIAS'),
		'a.texture' => JText::_('COM_EVOLUTIONARY_BREEDABLES_TEXTURE'),
		'a.animation' => JText::_('COM_EVOLUTIONARY_BREEDABLES_ANIMATION'),
		'a.config' => JText::_('COM_EVOLUTIONARY_BREEDABLES_CONFIG'),
		'a.state' => JText::_('JSTATUS'),
		'a.category' => JText::_('COM_EVOLUTIONARY_BREEDABLES_CATEGORY'),
		'a.created' => JText::_('COM_EVOLUTIONARY_BREEDABLES_CREATED'),
		'a.modified' => JText::_('COM_EVOLUTIONARY_BREEDABLES_MODIFIED'),
		'a.modified_by' => JText::_('COM_EVOLUTIONARY_BREEDABLES_MODIFIED_BY'),
		'a.version' => JText::_('COM_EVOLUTIONARY_BREEDABLES_VERSION'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		);
	}

}
