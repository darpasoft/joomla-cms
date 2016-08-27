<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$app       = JFactory::getApplication();
$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.ordering';
$columns   = 10;

?>

<form action="<?php echo JRoute::_('index.php?option=com_content&view=shared'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('filterButton' => false)));
		?>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
			<table class="table table-striped" id="articleList">
				<thead>
					<tr>
						<th width="1%" class="center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th>
							<?php echo JHtml::_('searchtools.sort', 'JGLOBAL_TITLE', 'c.title', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', 'COM_CONTENT_FIELD_SHARETOKEN', 'a.sharetoken', $listDirn, $listOrder); ?>
						</th>
						<th width="10%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', 'JDATE', 'a.created', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="<?php echo $columns; ?>">
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$item->max_ordering = 0;
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create',     'com_content.category.' . $item->catid);
					$canEdit    = $user->authorise('core.edit',       'com_content.article.' . $item->id);
					$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
					$canEditOwn = $user->authorise('core.edit.own',   'com_content.article.' . $item->id) && $item->created_by == $userId;
					$canChange  = $user->authorise('core.edit.state', 'com_content.article.' . $item->id) && $canCheckin;
					?>
					<tr>
						<td class="center">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<td class="has-context">
							<div class="pull-left break-word">
								<?php
									if ($canEdit || $canEditOwn)
									{
										echo JHtml::_(
											'link',
											JRoute::_('index.php?option=com_content&task=article.edit&id=' . $item->id),
											$this->escape($item->title),
											array('class' => 'hasTooltip', 'title' => JText::_('JACTION_EDIT'))
										);
									}
								?>
							</div>
						</td>
						<td class="small">
							<?php
							$url = JUri::root() . 'index.php?option=com_content&view=article&id=' . $item->articleId . '&token=' . $item->sharetoken;

							echo JHtml::_('link', $url, $item->sharetoken);
							?>
						</td>
						<td class="nowrap small hidden-phone">
							<?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC4')); ?>
						</td>
						<td class="hidden-phone">
							<?php echo (int) $item->id; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif;?>

		<?php echo $this->pagination->getListFooter(); ?>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
