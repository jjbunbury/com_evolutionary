<?php

/**
 * @version     1.0.0
 * @package     com_evolutionary
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Dazzle Software <support@dazzlesoftware.org> - http://dazzlesoftware.org
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Evolutionary records.
 */
class EvolutionaryModelBreedables extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'title', 'a.title',
                'alias', 'a.alias',
                'texture', 'a.texture',
                'animation', 'a.animation',
                'config', 'a.config',
                'state', 'a.state',
                'category', 'a.category',
                'created', 'a.created',
                'created_by', 'a.created_by',
                'modified', 'a.modified',
                'modified_by', 'a.modified_by',
                'version', 'a.version',
                'ordering', 'a.ordering',

            );
        }
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState($ordering = null, $direction = null) {

        // Initialise variables.
        $app = JFactory::getApplication();

        // List state information
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
        $this->setState('list.limit', $limit);

        $limitstart = JFactory::getApplication()->input->getInt('limitstart', 0);
        $this->setState('list.start', $limitstart);

        
		if(empty($ordering)) {
			$ordering = 'a.ordering';
		}

        // List state information.
        parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );

        $query->from('`#__evolutionary_breedable` AS a');

        
    // Join over the users for the checked out user.
    $query->select('uc.name AS editor');
    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the category 'category'
		$query->select('category.title AS category_title');
		$query->join('LEFT', '#__categories AS category ON category.id = a.category');
		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
        

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.title LIKE '.$search.'  OR  a.alias LIKE '.$search.' )');
            }
        }

        

		//Filtering texture
		$filter_texture = $this->state->get("filter.texture");
		if ($filter_texture) {
			$query->where("a.texture = '".$filter_texture."'");
		}

		//Filtering animation
		$filter_animation = $this->state->get("filter.animation");
		if ($filter_animation) {
			$query->where("a.animation = '".$filter_animation."'");
		}

		//Filtering config
		$filter_config = $this->state->get("filter.config");
		if ($filter_config) {
			$query->where("a.config = '".$filter_config."'");
		}

		//Filtering category
		$filter_category = $this->state->get("filter.category");
		if ($filter_category) {
			$query->where("a.category = '".$filter_category."'");
		}

		//Filtering created
		$filter_created_from = $this->state->get("filter.created.from");
		if ($filter_created_from) {
			$query->where("a.created >= '".$filter_created_from."'");
		}
		$filter_created_to = $this->state->get("filter.created.to");
		if ($filter_created_to) {
			$query->where("a.created <= '".$filter_created_to."'");
		}

		//Filtering modified
		$filter_modified_from = $this->state->get("filter.modified.from");
		if ($filter_modified_from) {
			$query->where("a.modified >= '".$filter_modified_from."'");
		}
		$filter_modified_to = $this->state->get("filter.modified.to");
		if ($filter_modified_to) {
			$query->where("a.modified <= '".$filter_modified_to."'");
		}

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        foreach($items as $item){
	
					$item->texture = JText::_('COM_EVOLUTIONARY_BREEDABLES_TEXTURE_OPTION_' . strtoupper($item->texture));
					$item->animation = JText::_('COM_EVOLUTIONARY_BREEDABLES_ANIMATION_OPTION_' . strtoupper($item->animation));
					$item->config = JText::_('COM_EVOLUTIONARY_BREEDABLES_CONFIG_OPTION_' . strtoupper($item->config));

			if ( isset($item->category) ) {

				// Get the title of that particular template
					$title = EvolutionaryFrontendHelper::getCategoryNameByCategoryId($item->category);

					// Finally replace the data object with proper information
					$item->category = !empty($title) ? $title : $item->category;
				}
}
        return $items;
    }

}
