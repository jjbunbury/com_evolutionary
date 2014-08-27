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

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Tooltip
// @todo we can remove this after we rewritten this similar to content edit screens
JHtml::_('behavior.tooltip');
// end
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

$this->hiddenFieldsets = array();
$this->hiddenFieldsets[0] = 'basic-limited';
$this->configFieldsets = array();
$this->configFieldsets[0] = 'editorConfig';

// Create shortcut to parameters.
$params = $this->state->get('params');

$saveHistory = $this->state->get('params')->get('save_history', 0);

$app = JFactory::getApplication();
$input = $app->input;

// This checks if the config options have ever been saved. If they haven't they will fall back to the original settings.
$params = json_decode($params);
$options = isset($params->show_publishing_options);

if (!$options)
{
	$params->show_publishing_options = '1';
	$params->show_texture_options = '1';
}

// Check if the texture uses configuration settings besides global. If so, use them.
if (isset($this->item->attribs['show_publishing_options']) && $this->item->attribs['show_publishing_options'] != '')
{
	$params->show_publishing_options = $this->item->attribs['show_publishing_options'];
}

if (isset($this->item->attribs['show_texture_options']) && $this->item->attribs['show_texture_options'] != '')
{
	$params->show_texture_options = $this->item->attribs['show_texture_options'];
}

// Import CSS
// @todo move this to asset form
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_evolutionary/assets/css/evolutionary.css');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'texture.cancel' || document.formvalidator.isValid(document.id('item-form')))
		{
			<?php //echo $this->form->getField('articletext')->save(); ?>
			Joomla.submitform(task, document.getElementById('item-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_evolutionary&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

	<div class="form-inline form-inline-header">
		<?php $title = $this->form->getField('title') ? 'title' : ($this->form->getField('name') ? 'name' : ''); ?>
		<?php //echo $this->form->getInput('title'); ?>
		<?php echo $title ? $this->form->renderField($title) : ''; ?>
	</div>

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_EVOLUTIONARY_TEXTURE_CONTENT', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<!-- GENERATION -->
				<?php $generation = $this->form->getField('generation') ? 'generation' : ''; ?>
				<?php echo $generation ? $this->form->renderField($generation) : ''; ?>

				<!-- QUALITY -->
				<?php $quality = $this->form->getField('quality') ? 'quality' : ''; ?>
				<?php echo $quality ? $this->form->renderField($quality) : ''; ?>

				<!-- QUANTITY -->
				<?php $quantity = $this->form->getField('quantity') ? 'quantity' : ''; ?>
				<?php echo $quantity ? $this->form->renderField($quantity) : ''; ?>

				<!-- METHOD -->
				<?php $method = $this->form->getField('method') ? 'method' : ''; ?>
				<?php echo $method ? $this->form->renderField($method) : ''; ?>

				<!-- ATTRIBS -->
				<?php echo $this->form->renderField('attribs'); ?>
				<?php foreach ($this->form->getGroup('attribs') as $field) : ?>
					<?php echo $field->renderField(); ?>
				<?php endforeach; ?>
			</div>
			<div class="span3">
				<?php echo $this->form->renderFieldset('sidebar'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php // Do not show the publishing options if the edit form is configured not to. ?>
		<?php if ($params->show_publishing_options == 1) : ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('COM_EVOLUTIONARY_FIELDSET_PUBLISHING', true)); ?>
			<div class="row-fluid form-horizontal-desktop">
				<div class="span6">
					<?php //echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
					<?php echo $this->form->renderFieldset('publishing'); ?>
					<?php //echo $this->loadTemplate('publishing'); ?>
				</div>
			</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php endif; ?>

		<?php $this->show_options = $params->show_texture_options; ?>
		<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

		<?php if ($this->canDo->get('core.admin')) : ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('COM_EVOLUTIONARY_FIELDSET_RULES', true)); ?>
				<?php echo $this->form->getInput('rules'); ?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php endif; ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="return" value="<?php echo $input->getCmd('return'); ?>" />
		<?php echo JHtml::_('form.token'); ?>


		</div>
</form>