<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

//$app = JFactory::getApplication();
//$form = $displayData->getForm();

$fieldSets = $this->form->getFieldsets('publishing');

//echo print_r($fieldSets, true);
?>

<?php foreach ($fieldSets as $name => $fieldSet) : ?>
	<?php foreach ($this->form->getFieldset($name) as $field) : ?>
		<?php echo print_r($field, true); ?>
		<?php //echo $this->form->renderField(); ?>
		<?php //echo $this->form->getInput($field); ?>
		<?php echo $this->form->renderFieldset($field); ?>
	<?php endforeach; ?>
<?php endforeach; ?>