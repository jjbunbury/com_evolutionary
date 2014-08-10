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

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_evolutionary', JPATH_ADMINISTRATOR);
$canEdit = JFactory::getUser()->authorise('core.edit', 'com_evolutionary.' . $this->item->id);
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_evolutionary' . $this->item->id)) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item && $this->item->state == 1) : ?>

    <div class="item_fields">
        <table class="table">
            <tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_ID'); ?></th>
			<td><?php echo $this->item->id; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_TITLE'); ?></th>
			<td><?php echo $this->item->title; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_ALIAS'); ?></th>
			<td><?php echo $this->item->alias; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_TEXTURE'); ?></th>
			<td><?php echo $this->item->texture; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_ANIMATION'); ?></th>
			<td><?php echo $this->item->animation; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_CONFIG'); ?></th>
			<td><?php echo $this->item->config; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_STATE'); ?></th>
			<td>
			<i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_CATEGORY'); ?></th>
			<td><?php echo $this->item->category_title; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_CREATED'); ?></th>
			<td><?php echo $this->item->created; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_CREATED_BY'); ?></th>
			<td><?php echo $this->item->created_by_name; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_MODIFIED'); ?></th>
			<td><?php echo $this->item->modified; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_MODIFIED_BY'); ?></th>
			<td><?php echo $this->item->modified_by; ?></td>
</tr>
<tr>
			<th><?php echo JText::_('COM_EVOLUTIONARY_FORM_LBL_BREEDABLE_VERSION'); ?></th>
			<td><?php echo $this->item->version; ?></td>
</tr>

        </table>
    </div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_evolutionary&task=breedable.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_EVOLUTIONARY_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_evolutionary.breedable.'.$this->item->id)):?>
									<a class="btn" href="<?php echo JRoute::_('index.php?option=com_evolutionary&task=breedable.remove&id=' . $this->item->id, false, 2); ?>"><?php echo JText::_("COM_EVOLUTIONARY_DELETE_ITEM"); ?></a>
								<?php endif; ?>
    <?php
else:
    echo JText::_('COM_EVOLUTIONARY_ITEM_NOT_LOADED');
endif;
?>
