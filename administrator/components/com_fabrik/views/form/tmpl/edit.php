<?php
/**
 * Admin Form Edit Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHTML::stylesheet('administrator/components/com_fabrik/views/fabrikadmin.css');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

JHtml::script('media/com_fabrik/js/mootools-ext.js');
$fbConfig = JComponentHelper::getParams('com_fabrik');

$document = JFactory::getDocument();

$srcs = FabrikHelperHTML::framework();
$srcs[] = 'administrator/components/com_fabrik/views/namespace.js';
$srcs[] = 'administrator/components/com_fabrik/views/pluginmanager.js';

FabrikHelperHTML::script($srcs, $this->js);
?>

<script type="text/javascript">

	Joomla.submitbutton = function(task) {
		if (task !== 'form.cancel'  && !controller.canSaveForm()) {
			alert('Please wait - still loading');
			return false;
		}
		if (task == 'form.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {

			Joomla.submitform(task, document.getElementById('adminForm'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php JRoute::_('index.php?option=com_fabrik'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_FABRIK_DETAILS');?></legend>
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('details') as $field) :?>
				<li>
					<?php echo $field->label; ?><?php echo $field->input; ?>
				</li>
				<?php endforeach; ?>
				<?php foreach ($this->form->getFieldset('details2') as $field) :?>
				<li>
					<?php echo $field->label; ?><?php echo $field->input; ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<div class="clr"> </div>
		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_FABRIK_BUTTONS');?></legend>
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('buttons') as $field) :?>
				<li>
					<?php echo $field->label; ?><?php echo $field->input; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_FABRIK_FORM_PROCESSING');?></legend>
			<ul class="adminformlist">
				<li>
					<?php echo $this->form->getLabel('record_in_database') . $this->form->getInput('record_in_database');
					echo $this->form->getLabel('db_table_name') ?>
					<?php if ($this->item->record_in_database != '1') {?>
						<?php  echo $this->form->getInput('db_table_name'); ?>
					<?php } else { ?>
						<input class="readonly" readonly="readonly" id="database_name" name="_database_name" value="<?php echo $this->item->db_table_name;?>"  />
						<input type="hidden" id="_connection_id" name="_connection_id" value="<?php echo $this->item->connection_id;?>"  />
					<?php }?>
				</li>
				<?php foreach ($this->form->getFieldset('processing') as $field) :?>
				<li>
					<?php echo $field->label; ?><?php echo $field->input; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_FABRIK_NOTES');?></legend>
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('notes') as $field) :?>
				<li>
					<?php echo $field->label; ?><?php echo $field->input; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</fieldset>
	</div>

	<div class="width-50 fltrt">
		<?php echo JHtml::_('tabs.start','table-tabs-'.$this->item->id, array('useCookie' => 1));

		echo JHtml::_('tabs.panel', JText::_('COM_FABRIK_GROUP_LABEL_PUBLISHING_DETAILS'), 'form_publishing');
		echo $this->loadTemplate('publishing');

		echo JHtml::_('tabs.panel',JText::_('COM_FABRIK_GROUPS'), 'form_groups');
		echo $this->loadTemplate('groups');

		echo JHtml::_('tabs.panel',JText::_('COM_FABRIK_LAYOUT'), 'form_templates');
		echo $this->loadTemplate('templates');

		echo JHtml::_('tabs.panel',JText::_('COM_FABRIK_OPTIONS'), 'form_options');
		echo $this->loadTemplate('options');

		echo JHtml::_('tabs.panel',JText::_('COM_FABRIK_PLUGINS'), 'form_plugins');
		echo $this->loadTemplate('plugins');
		echo JHtml::_('tabs.end'); ?>
	</div>

	<div class="clr"></div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
