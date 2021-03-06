<?php
/**
 * @package Joomla
 * @subpackage Fabrik
 * @copyright Copyright (C) 2005 Rob Clayburn. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.modelitem');

class FabrikFEModelPackage extends FabModel
{

	/** @var array of table objects */
	protected $tables = array();

	/** @var object importer */
	var $_importer = null;

	/** @var string the last action that was performed server side */
	var $_lastTask = null;

	/** @var string reference to block that called the server e.g. list_1 or form_27 */
	var $_senderBlock = null;

	/** @var string status of lastTask i.e. "success" or "fail" */
	var $_lastTaskStatus = null;

	/** @var string any data created by the lasttask - e.g. data to create a new table row with */
	var $_lastTaskData = null;

	/** @var string format output can be raw or html default = html */
	var $_format = 'html';

	/** @var array blocks to update */
	var $_updateBlocks = null;

	/** @var object table package */
	var $_package = null;

	/** @var int id */
	var $id = null;

	/**
	 * Constructor
	 *
	 * @since       1.5
	 */

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Method to set the  id
	 *
	 * @access	public
* @param   int	ID number
	 */

	function setId($id)
	{
		// Set new package ID
		$this->id = $id;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load the parameters.
		$params = $app->getParams();

		// Load state from the request.
		$pk = JRequest::getInt('id', $params->get('id'));
		$this->setState('package.id', $pk);

		$this->setState('params', $params);

		// TODO: Tune these values based on other permissions.
		$user = JFactory::getUser();
		if ((!$user->authorise('core.edit.state', 'com_fabrik')) && (!$user->authorise('core.edit', 'com_fabrik')))
		{
			$this->setState('filter.published', 1);
			$this->setState('filter.archived', 2);
		}
	}

	/**
	 * Method to get package data.
	 * Packages are all stored in jos_fabrik_packages - so dont use {package} in the query to load them
* @param   integer	The id of the package.
	 *
	 * @return  mixed	Menu item data object on success, false on failure.
	 */
	public function &getItem($pk = null)
	{
		// Initialise variables.
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('package.id');
		if (!isset($this->_item))
		{
			$this->_item = array();
		}
		if (!isset($this->_item[$pk]))
		{

			try
			{
				$db = FabrikWorker::getDbo();
				$query = $db->getQuery(true);

				$query->select('label, params, published, component_name');
				//$query->from('#__{package}_packages');
				$query->from('#__fabrik_packages');

				$query->where('id = ' . (int) $pk);

				// Filter by published state.
				$published = $this->getState('filter.published');
				$archived = $this->getState('filter.archived');

				if (is_numeric($published))
				{
					$query->where('(published = ' . (int) $published . ' OR published =' . (int) $archived . ')');
				}

				$db->setQuery($query);
				$data = $db->loadObject();
				if ($error = $db->getErrorMsg())
				{
					throw new Exception($error);
				}

				if (empty($data))
				{
					throw new JException(JText::_('COM_FABRIK_ERROR_PACKAGE_NOT_FOUND'), 404);
				}

				// Check for published state if filter set.
				if (((is_numeric($published)) || (is_numeric($archived))) && (($data->published != $published) && ($data->published != $archived)))
				{
					throw new JException(JText::_('COM_FABRIK_ERROR_PACKAGE_NOT_FOUND'), 404);
				}

				// Convert parameter fields to objects.
				$registry = new JRegistry;
				$registry->loadJSON($data->params);
				$data->params = clone $this->getState('params');
				$data->params->merge($registry);

				$this->_item[$pk] = $data;
			}
			catch (JException $e)
			{
				$this->setError($e);
				$this->_item[$pk] = false;
			}
		}

		return $this->_item[$pk];
	}

	/**
	 * get a package table object
	 *
	 * @return  object connection tables
	 */

	function &getPackage()
	{
		if (!isset($this->_package))
		{
			$this->_package = FabTable::getInstance('Package', 'FabrikTable');
			$this->_package->load($this->id);
			//forms can currently only be set from form module
			$this->_package->forms = '';
		}
		return $this->_package;
	}

	/**
	 * render the package in the front end
	 */

	function render()
	{
		$db = FabrikWorker::getDbo();
		$config = JFactory::getConfig();
	 	$document = JFactory::getDocument();
		//test stuff needs to be assigned in admin
		$this->_blocks = array();
		return;
		// @TODO: loading of visualizations
	}

	function statusBar()
	{
		return "<div class='fbPackageStatus'><span>loading...</span></div>";
	}

	/**
	 * load the importer class
	 */

	function loadImporter()
	{
		$this->_importer = new fabrikImport($db);
	}

	/**
	 * load in the tables associated with the package
	 */

	function loadTables()
	{
		$db = FabrikWorker::getDbo();
		if ($this->_package->tables != '')
		{
			$aIds = explode(',', $this->_package->tables);
			foreach ($aIds as $id)
			{
				$viewModel = JModelLegacy::getInstance('view', 'FabrikFEModel');
				$viewModel->setId($id);
				$this->tables[] = $viewModel->getTable();
				$formModel = $viewModel->getFormModel();
				$this->forms[] = $formModel->getForm();
			}
		}
		return $this->tables;
	}

	/**
	 * (un)publish the package & all its tables
	 */

	function publish($state)
	{
		foreach ($this->tables as $oTable)
		{
			$oTable->publish($oTable->id, $state);
		}
		parent::publish($this->id, $state);
	}

}

class fabrikPackageMenu extends JModel
{

	/**
	 * Constructor
	 *
	 * @since       1.5
	 */

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Method to set the  id
	 *
	 * @access	public
* @param   int	ID number
	 */

	function setId($id)
	{
		// Set new form ID
		$this->id = $id;
	}

	function render()
	{
		return "menu items to go here";
	}
}

?>