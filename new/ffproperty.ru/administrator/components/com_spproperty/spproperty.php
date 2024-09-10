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
use Joomla\CMS\MVC\Controller\BaseController;

if (file_exists(JPATH_COMPONENT . '/vendor/autoload.php')) {
    include JPATH_COMPONENT . '/vendor/autoload.php';
}

if (!Factory::getUser()->authorise('core.manage', 'com_spproperty')) {
    return Factory::getApplication()->enqueueMessage('JERROR_ALERTNOAUTHOR', 'warning');
}
if (file_exists(JPATH_COMPONENT . '/helpers/spproperty.php')) {
    JLoader::register('SppropertyHelper', JPATH_COMPONENT . '/helpers/spproperty.php');
}

// Execute the task.
$controller = BaseController::getInstance('Spproperty');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
