<?php
/**
 * Admin Import Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>
<script type="text/javascript">
window.addEvent('domready', function () {
	(function($){

	    (['jform_inPutFormat1', 'jform_inPutFormat2']).each(function (l) {
	    	var options = {title: 'CSV', 'trigger': 'hover'};
		    var opt = document.getElement('label[for=' + l + ']');
		    var s = opt.getElement('small');
		    options.content = s.get('text');
		    s.destroy();
			$('label[for=' + l + ']').popover(options);
	    });

    })(jQuery);
});

</script>
<form enctype="multipart/form-data" action="<?php JRoute::_('index.php?option=com_fabrik'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

<div class="width-100 fltlft">
	<?php
	$id	= JRequest::getInt('listid', 0); // from list data view in admin
	$cid = JRequest::getVar('cid', array(0));// from list of lists checkbox selection
	JArrayHelper::toInteger($cid);
	if ($id === 0)
	{
		$id = $cid[0];
	}
	if (($id !== 0))
	{
		$db = FabrikWorker::getDbo(true);
		$query = $db->getQuery(true);
		$query->select('label')->from('#__{package}_lists')->where('id = ' . $id);
		$db->setQuery($query);
		$list = $db->loadResult();
	}
	$fieldsets = array('details');
	$fieldsets[] = $id === 0 ? 'creation' : 'append';
	$fieldsets[] = 'format';
	?>
		<input type="hidden" name="listid" value="<?php echo $id ;?>" />

<?php foreach ($fieldsets as $n => $fieldset) {?>
	<fieldset class="form-horizontal">
		<?php if ($n == 0) :
		echo '<legend>' . JText::_('COM_FABRIK_IMPORT_CSV') . '</legend>';
		endif;
		?>
		<?php foreach ($this->form->getFieldset($fieldset) as $this->field) :
			echo $this->loadTemplate('control_group');
		endforeach;
		?>


	</fieldset>
	<?php }?>

	<input type="hidden" name="task" value="" />
  	<?php echo JHTML::_('form.token');
	echo JHTML::_('behavior.keepalive'); ?>
	</div>
</form>