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

jimport('joomla.application.component.controllerform');

/**
 * Configuration controller class.
 */
class EvolutionaryControllerConfiguration extends JControllerForm
{

    function __construct() {
        $this->view_list = 'configurations';
        parent::__construct();
    }

}