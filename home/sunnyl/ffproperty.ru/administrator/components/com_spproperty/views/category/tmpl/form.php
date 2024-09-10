<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_JEXEC') or die('resticted aceess');

use Joomla\CMS\HTML\HTMLHelper;

if (SppropertyHelper::getVersion() < 4) {
    HTMLHelper::_('formbehavior.chosen', 'select');
}

echo $this->getRenderedForm();
