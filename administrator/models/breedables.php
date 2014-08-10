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
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering texture
		$this->setState('filter.texture', $app->getUserStateFromRequest($this->context.'.filter.texture', 'filter_texture', '', 'string'));

		//Filtering animation
		$this->setState('filter.animation', $app->getUserStateFromRequest($this->context.'.filter.animation', 'filter_animation', '', 'string'));

		//Filtering config
		$this->setState('filter.config', $app->getUserStateFromRequest($this->context.'.filter.config', 'filter_config', '', 'string'));

		//Filtering category
		$this->setState('filter.category', $app->getUserStateFromRequest($this->context.'.filter.category', 'filter_category', '', 'string'));

		//Filtering created
		$this->setState('filter.created.from', $app->getUserStateFromRequest($this->context.'.filter.created.from', 'filter_from_created', '', 'string'));
		$this->setState('filter.created.to', $app->getUserStateFromRequest($this->context.'.filter.created.to', 'filter_to_created', '', 'string'));

		//Filtering modified
		$this->setState('filter.modified.from', $app->getUserStateFromRequest($this->context.'.filter.modified.from', 'filter_from_modified', '', 'string'));
		$this->setState('filter.modified.to', $app->getUserStateFromRequest($this->context.'.filter.modified.to', 'filter_to_modified', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_evolutionary');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.title', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
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

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the category 'category'
		$query->select('category.title AS category');
		$query->join('LEFT', '#__categories AS category ON category.id = a.category');
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.title LIKE '.$search.'  OR  a.alias LIKE '.$search.'  OR  a.texture LIKE '.$search.'  OR  a.animation LIKE '.$search.'  OR  a.config LIKE '.$search.'  OR  a.category LIKE '.$search.'  OR  a.created LIKE '.$search.'  OR  a.modified LIKE '.$search.'  OR  a.modified_by LIKE '.$search.'  OR  a.version LIKE '.$search.' )');
            }
        }

        

		//Filtering texture
		$filter_texture = $this->state->get("filter.texture");
		if ($filter_texture) {
			$query->where("a.texture = '".$db->escape($filter_texture)."'");
		}

		//Filtering animation
		$filter_animation = $this->state->get("filter.animation");
		if ($filter_animation) {
			$query->where("a.animation = '".$db->escape($filter_animation)."'");
		}

		//Filtering config
		$filter_config = $this->state->get("filter.config");
		if ($filter_config) {
			$query->where("a.config = '".$db->escape($filter_config)."'");
		}

		//Filtering category
		$filter_category = $this->state->get("filter.category");
		if ($filter_category) {
			$query->where("a.category = '".$db->escape($filter_category)."'");
		}

		//Filtering created
		$filter_created_from = $this->state->get("filter.created.from");
		if ($filter_created_from) {
			$query->where("a.created >= '".$db->escape($filter_created_from)."'");
		}
		$filter_created_to = $this->state->get("filter.created.to");
		if ($filter_created_to) {
			$query->where("a.created <= '".$db->escape($filter_created_to)."'");
		}

		//Filtering modified
		$filter_modified_from = $this->state->get("filter.modified.from");
		if ($filter_modified_from) {
			$query->where("a.modified >= '".$db->escape($filter_modified_from)."'");
		}
		$filter_modified_to = $this->state->get("filter.modified.to");
		if ($filter_modified_to) {
			$query->where("a.modified <= '".$db->escape($filter_modified_to)."'");
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
        
        return $items;
    }

}
