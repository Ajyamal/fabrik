<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       1.6
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

require_once 'fabcontrollerform.php';

/**
 * Group controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	Fabrik
 * @since		3.0
 */

class FabrikAdminControllerGroup extends FabControllerForm
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_FABRIK_GROUP';

}
