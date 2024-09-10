<?php

/**
* @package com_spproperty
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class SppropertyViewAgents extends HtmlView
{
    protected $items;
    protected $state;
    protected $pagination;
    protected $model;
    public $filterForm, $activeFilters;

    public function display($tpl = null)
    {
        $this->items            = $this->get('Items');
        $this->state            = $this->get('State');
        $this->pagination       = $this->get('Pagination');
        $this->model            = $this->getModel('agents');
        $this->filterForm       = $this->get('FilterForm');
        $this->activeFilters    = $this->get('ActiveFilters');

        SppropertyHelper::addSubmenu('agents');
        if (count($errors = $this->get('Errors'))) {
            throw new RuntimeException(implode("\n", $errors), 500);
            return false;
        }

        $this->sidebar = JHtmlSidebar::render();
        $this->addToolbar();
        return parent::display($tpl);
    }

    protected function addToolbar()
    {
        $state = $this->get('State');
        $canDo = SppropertyHelper::getActions('com_spproperty', 'component');
        $user = Factory::getUser();
        $bar = Toolbar::getInstance('toolbar');
        //SppropertyHelper::debug($canDo);

        if ($canDo->get('core.create')) {
            ToolbarHelper::addNew('agent.add');
        }

        if ($canDo->get('core.edit') || $canDo->get('core.edit.own')) {
            ToolbarHelper::editList('agent.edit');
        }

        if ($canDo->get('core.edit.state')) {
            ToolbarHelper::publish('agents.publish', 'JTOOLBAR_PUBLISH', true);
            ToolbarHelper::unpublish('agents.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            ToolbarHelper::archiveList('agents.archive');
            ToolbarHelper::checkin('agents.checkin');
        }

        if ($state->get('filter.published') == -2 && $canDo->get('core.delete')) {
            ToolbarHelper::deleteList('', 'agents.delete', 'JTOOLBAR_EMPTY_TRASH');
        } elseif ($canDo->get('core.edit.state')) {
            ToolbarHelper::trash('agents.trash');
        }

        if ($canDo->get('core.admin')) {
            ToolbarHelper::preferences('com_spproperty');
        }

        JHtmlSidebar::setAction('index.php?option=com_spproperty&view=agents');

        ToolbarHelper::title(Text::_('COM_SPPROPERTY') . ': ' . Text::_('COM_SPPROPERTY_TITLE_AGENTS'), '');
    }
}
