<?php
/**
 * Plugin element to render fields
 * @package fabrikar
 * @author Rob Clayburn
 * @copyright (C) Rob Clayburn
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class allVideosRender
{

	var $output = '';

	var $inTableView = false;

	/**
	 * Shows the data formatted for the list view
	 * 
	 * @param   string  $data      elements data
	 * @param   object  &$thisRow  all the data in the lists current row
	 * 
	 * @return  string	formatted value
	 */

	function renderListData(&$model, &$params, $file, $thisRow)
	{
		$this->inTableView = true;
		$this->render($model, $params, $file);
	}

	/**
	 * Draws the html form element
	 * 
	 * @param   array  $data           to preopulate element with
	 * @param   int    $repeatCounter  repeat group counter
	 * 
	 * @return  string	elements html
	 */

	public function render(&$model, &$params, $file)
	{
		$src = str_replace("\\", "/", COM_FABRIK_LIVESITE . $file);
		$ext = JString::strtolower(JFile::getExt($file));
		if (!JPluginHelper::isEnabled('content', 'jw_allvideos'))
		{
			$this->output = JText::_(
				'to display this media files types you need to install the all videos plugin - http://www.joomlaworks.gr/content/view/35/41/');
			return;
		}
		$extra = array();
		$extra[] = $src;
		if ($this->inTableView || $params->get('fu_show_image') < 2)
		{
			$extra[] = $params->get('thumb_max_width');
			$extra[] = $params->get('thumb_max_height');
		}
		else
		{
			$extra[] = $params->get('fu_main_max_width');
			$extra[] = $params->get('fu_main_max_height');
		}
		$src = implode('|', $extra);
		switch ($ext)
		{
			case 'flv':
				$this->output = "{flvremote}$src{/flvremote}";
				break;
			case '3gp':
				$this->output = "{3gpremote}$src{/3gpremote}";
				break;
			case 'divx':
				$this->output = "{divxremote}$src{/divxremote}";
				break;
		}
		/*if (!JPluginHelper::isEnabled( 'content', 'fab_jwplayer')) {
		
		
		    } else {
		
		    }
		} else {
		    $this->output = '{fabjwplayer file='.$src.'}';
		}*/
	}
}

?>