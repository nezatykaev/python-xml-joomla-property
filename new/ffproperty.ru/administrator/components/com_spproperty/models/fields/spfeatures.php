<?php

/**
 * @package com_spproperty
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

// No Direct Access
defined('_JEXEC') or die('Resticted Aceess');

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('checkboxes');

class JFormFieldSpfeatures extends FormField
{
      protected $type = 'Spfeatures';
    protected function getInput()
    {

          $pfeatures  = SppropertyHelper::getPfeatures();
          $output  = '';

          $output .= '<fieldset id="' . $this->name . '" class="checkboxes">';

        foreach ($pfeatures as $key => $pfeature) {
              $hasChecked = (in_array($pfeature->id, (array)$this->value)) ? 'checked' : '';

              $output .= '<label for="' . $this->name . $key . '" class="checkbox">';
                    $output .= '<input type="checkbox" id="' . $this->name . $key . '" name="' . $this->name . '[]" value="' . $pfeature->id . '" ' . $hasChecked . '>';
                    $output .= $pfeature->title;
              $output .= '</label>';
        }

          $output .= '</fieldset>';

          return $output;
    }
}
