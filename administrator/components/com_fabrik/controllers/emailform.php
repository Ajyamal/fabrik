<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       1.6
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

/**
 * Fabrik Email From Controller
 *
 * @package  Fabrik
 * @since    3.0
 */

class FabrikAdminControllerEmailform extends JControllerLegacy
{

	/**
	 * Display the view
	 *
	 * @return  null
	 */

	public function display()
	{
		$document = JFactory::getDocument();
		$viewName = JRequest::getVar('view', 'emailform', 'default', 'cmd');
		$modelName = 'form';
		$viewType = $document->getType();

		// Set the default view name from the Request
		$view = $this->getView($viewName, $viewType);

		// Push a model into the view (may have been set in content plugin already
		$model = JModelLegacy::getInstance($modelName, 'FabrikFEModel');

		// Test for failed validation then page refresh
		$model->getErrors();
		if (!JError::isError($model) && is_object($model))
		{
			$view->setModel($model, true);
		}
		// Display the view
		$view->assign('error', $this->getError());
		$view->display();
	}

}
