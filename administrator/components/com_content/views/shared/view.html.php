<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of shared articles.
 *
 * @since  _DEPLOY_VERSION_
 */
class ContentViewShared extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	public $filterForm;

	public $activeFilters;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 *
	 * @since   _DEPLOY_VERSION_
	 */
	public function display($tpl = null)
	{
		ContentHelper::addSubmenu('shared');

		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   _DEPLOY_VERSION_
	 */
	protected function addToolbar()
	{
		$canDo = JHelperContent::getActions('com_content', 'category', $this->state->get('filter.category_id'));

		JToolbarHelper::title(JText::_('COM_CONTENT_SHARED_TITLE'), 'stack article');

		if ($canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'shared.delete');
		}
	}
}
