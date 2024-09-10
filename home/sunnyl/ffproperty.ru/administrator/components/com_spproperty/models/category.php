
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
use Joomla\String\StringHelper;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;

class SppropertyModelCategory extends AdminModel
{
    protected $text_prefix = 'COM_SPPROPERTY';

    public function getTable($name = 'Category', $prefix = 'SppropertyTable', $config = array())
    {
        return Table::getInstance($name, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $app = Factory::getApplication();
        $form = $this->loadForm('com_spproperty.category', 'category', array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form)) {
            return false;
        }

        return $form;
    }


    public function loadFormData()
    {
        $data = Factory::getApplication()
            ->getUserState('com_spproperty.edit.category.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

    protected function canDelete($record)
    {
        if (!empty($record->id)) {
            if ($record->published != -2) {
                return ;
            }

            $user = Factory::getUser();

            return parent::canDelete($record);
        }
    }


    protected function canEditState($record)
    {
        return parent::canEditState($record);
    }


    public function getItem($pk = null)
    {
        return parent::getItem($pk);
    }

    private function generateNewTitleLocally($alias, $title)
    {
        // Alter the title & alias
        $table = $this->getTable();

        while ($table->load(array('alias' => $alias))) {
            $title = StringHelper::increment($title);
            $alias = StringHelper::increment($alias, 'dash');
        }
        return array($title, $alias);
    }

    //Override save method for 'save as copy'
    public function save($data)
    {
        $input  = Factory::getApplication()->input;
        $task   = $input->get('task');

        if ($task == 'save2copy') {
            $originalTable = clone $this->getTable();
            $originalTable->load($input->getInt('id'));

            if ($data['title'] == $originalTable->title) {
                list($title, $alias) = $this->generateNewTitleLocally($data['alias'], $data['title']);
                $data['title'] = $title;
                $data['alias'] = $alias;
            } else {
                if ($data['alias'] == $originalTable->alias) {
                    $data['alias'] = '';
                }
            }

            $data['published'] = 0;
        }
        if (parent::save($data)) {
            return true;
        }
        return false;
    }
}
