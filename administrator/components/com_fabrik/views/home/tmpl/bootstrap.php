<?php
/**
 * Admin Home Bootstrap Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die;

JHTML::stylesheet('media/com_fabrik/css/admin.css');
JToolBarHelper::title(JText::_('COM_FABRIK_WELCOME'), 'fabrik.png');
?>

<div class="row-fluid">
	<div class="span6">
		<a href="http://fabrikar.com">
			<?php echo JHTML::image('media/com_fabrik/images/logo.png', 'Fabrik logo'); ?>
			</a>
		<div style="float:left;width:250px;margin-top:30px;">
			<a href="http://fabrikar.com/subscribe">
				<?php echo JHTML::image('media/com_fabrik/images/box.png', 'Fabrik'); ?>
			</a>
		</div>
		<div style="margin-left:200px;margin-top:30px;">
			<h1><?php echo JText::_('COM_FABRIK_HOME_SUBSCRIBE_TITLE')?></h1>
			<?php echo JText::_('COM_FABRIK_HOME_SUBSCRIBE_FEATURES')?>
			<a href="http://fabrikar.com/subscribe">
			<?php echo JHTML::image('media/com_fabrik/images/subscribe-now.png', 'Fabrik'); ?>
			</a><br />
		</div>
	</div>

	<div class="span6">
		<ul class="nav nav-tabs">
			<li class="active">
		    	<a data-toggle="tab" href="#tab-about">
		    		<?php echo JText::_('COM_FABRIK_HOME_ABOUT'); ?>
		    	</a>
		    </li>
		    <li>
		    	<a data-toggle="tab" href="#tab-news">
		    		<?php echo JText::_('COM_FABRIK_HOME_NEWS'); ?>
		    	</a>
		    </li>
		    <li>
		    	<a data-toggle="tab" href="#tab-stats">
		    		<?php echo JText::_('COM_FABRIK_HOME_STATS')?>
		    	</a>
		    </li>
		    <li>
		    	<a data-toggle="tab" href="#tab-links">
		    		<?php echo JText::_('COM_FABRIK_HOME_USEFUL_LINKS')?>
		    	</a>
		    </li>
		    <li>
		    	<a data-toggle="tab" href="#tab-tools">
		    		<?php echo JText::_('COM_FABRIK_HOME_TOOLS')?>
		    	</a>
		    </li>
		</ul>

		<div class="tab-pane active" id="tab-about">
			<?php echo JText::_('COM_FABRIK_HOME_ABOUT_TEXT'); ?>
		</div>

		<div class="tab-pane" id="tab-news">
			<?php echo $this->feed;?>
		</div>

		<div class="tab-pane" id="tab-stats">
			<table class='adminlist'>
			<thead>
				<tr>
					<th style="width:20%"><?php echo JText::_('COM_FABRIK_HOME_DATE')?></th>
					<th><?php echo JText::_('COM_FABRIK_HOME_ACTION')?></th>
				</tr>
			</thead>
			<tbody>
					<?php foreach ($this->logs as $log) :?>
					<tr>
						<td>
						<?php echo $log->timedate_created;?>
						</td>
						<td>
						<span class="editlinktip hasTip" title="<?php echo $log->message_type . "::" . $log->message; ?>">
							<?php echo $log->message_type;?>
						</span>
						</td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>

		<div class="tab-pane" id="tab-links">
			<ul class="adminlist">
				<li><a href="http://fabrikar.com/"><?php echo JText::_('COM_FABRIK_HOME_FABRIK_WEB_SITE')?></a></li>
				<li><a href="http://fabrikar.com/forums"><?php echo JText::_('COM_FABRIK_HOME_FORUM')?></a>
				<li><a href="http://fabrikar.com/wiki/"><?php echo JText::_('COM_FABRIK_HOME_DOCUMENTATION_WIKI')?></a></li>
			</ul>
		</div>

		<div class="tab-pane" id="tab-tools">
			<ul class="adminlist">
				<li><a href="index.php?option=com_fabrik&task=home.installSampleData">
				<?php echo JText::_('COM_FABRIK_HOME_INSTALL_SAMPLE_DATA')?></a>
				</li>
				<li><a onclick="return confirm('<?php echo JText::_('COM_FABRIK_HOME_CONFIRM_WIPE', true);?>')" href="index.php?option=com_fabrik&task=home.reset">
					<?php echo JText::_('COM_FABRIK_HOME_RESET_FABRIK') ?>
				</a></li>
				<li>
					<a href="index.php?option=com_fabrik&task=upgrade.check">Upgrade from 2.1</a>
				</li>
			</ul>
		</div>

	</div>
</div>