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
use Joomla\CMS\MVC\Controller\FormController;
class SppropertyControllerProperty extends FormController
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    protected function allowAdd($data = array())
    {
        return parent::allowAdd($data);
    }

    protected function allowEdit($data = array(), $key = 'id')
    {
        $id = (int) isset($data[$key]) ? $data[$key] : 0;
        $user = Factory::getUser();

        if (!$id) {
            return parent::allowEdit($data, $key);
        }

        if ($user->authorise('core.edit', 'com_spproperty.property.' . $id)) {
            return true;
        }

        if ($user->authorise('core.edit.own', 'com_spproperty.property.' . $id)) {
            $record = $this->getModel()->getItem($id);
            if (empty($record)) {
                return false;
            }
            $agentItem  = false;
            $userAgentId = SppropertyHelper::userAgentId($user->get('id'));
            if ($userAgentId) {
                $agentItem = $userAgentId == $record->agent_id;
            }
            return $user->id === $record->created_by || $agentItem;
        }

        return false;
    }
}
