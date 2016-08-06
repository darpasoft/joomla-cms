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
 * Share Table class.
 *
 * @since  3.7
 */
class ContentTableShare extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  Database connector object
	 *
	 * @since   1.6
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__share_draft', 'id', $db);
	}

	/**
	 * Perform some sanity checks.
	 *
	 * @return  bool  True if all is OK | False otherwise.
	 *
	 * @since   3.7
	 */
	public function check()
	{
		if ((int) $this->get('id') === 0)
		{
			$date = new JDate;

			$this->set('created', $date->toSql());
		}

		return true;
	}
}
