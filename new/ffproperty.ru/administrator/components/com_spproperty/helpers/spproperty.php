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
use Joomla\CMS\Access\Access;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Component\ComponentHelper;
class SppropertyHelper extends ContentHelper
{
    public static function getUserGroupId($groupName = 'Agent')
    {
        $db     = Factory::getDbo();
        $query  = $db->getQuery(true);
        $query->select('a.id')
        ->from($db->quoteName('#__usergroups', 'a'))
        ->where($db->quoteName('a.title') . ' = ' . $db->quote($groupName));

        $db->setQuery($query);
        return $db->loadResult();
    }

    public static function isDesiredGroup($groupName = 'Agent', $userid = null)
    {
        $user       = Factory::getUser();
        if (is_null($userid)) {
            $userid = $user->id;
        }
        $groups     = Access::getGroupsByUser($userid, false);
        $groupID    = self::getUserGroupId($groupName);
        $return     = in_array($groupID, $groups);

        return $return;
    }

    public static function userAgentId($userid)
    {
        if (!self::isDesiredGroup(ComponentHelper::getParams('com_spproperty')->get('agent_group_name', 'Agent'), $userid)) {
            return false;
        }
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('a.id')
        ->from($db->qn('#__spproperty_agents', 'a'))
        ->where($db->qn('a.created_by') . ' = ' . $db->q($userid))
        ->where($db->qn('a.published') . ' = 1');

        $db->setQuery($query);
        return $db->loadResult();
    }

    public static function addSubmenu($vName)
    {
        $cParams    = ComponentHelper::getParams('com_spproperty');
        $user       = Factory::getUser();
        $groupName  = $cParams->get('agent_group_name', 'Agent');
        $superUsers = 'Super Users';
        $access     = self::isDesiredGroup($groupName) || self::isDesiredGroup($superUsers) || $user->authorise('core.admin');
        $isAgent    = self::isDesiredGroup($groupName);

        if ($access) {
            if (!$isAgent) {
                JHtmlSidebar::addEntry(
                    Text::_('COM_SPPROPERTY_TITLE_AGENTS'),
                    'index.php?option=com_spproperty&view=agents',
                    $vName == 'agents'
                );
            }
        }

        if ($access) {
            if (!$isAgent) {
                JHtmlSidebar::addEntry(
                    Text::_('COM_SPPROPERTY_TITLE_CATEGORIES'),
                    'index.php?option=com_spproperty&view=categories',
                    $vName == 'categories'
                );
            }
        }

        if ($access) {
            JHtmlSidebar::addEntry(
                Text::_('COM_SPPROPERTY_TITLE_PROPERTYFEATURES'),
                'index.php?option=com_spproperty&view=propertyfeatures',
                $vName == 'propertyfeatures'
            );
        }
        if ($access) {
            JHtmlSidebar::addEntry(
                Text::_('COM_SPPROPERTY_TITLE_PROPERTIES'),
                'index.php?option=com_spproperty&view=properties',
                $vName == 'properties'
            );
        }
        if ($access) {
            JHtmlSidebar::addEntry(
                Text::_('COM_SPPROPERTY_TITLE_VISITREQUESTS'),
                'index.php?option=com_spproperty&view=visitrequests',
                $vName == 'visitrequests'
            );
        }
    }

    // Get features
    public static function getPfeatures($fetid = '')
    {

        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array('a.*'));
        $query->from($db->quoteName('#__spproperty_propertyfeatures', 'a'));
        if ($fetid) {
            $query->where($db->quoteName('a.id') . '=' . $fetid);
        }
        //Language
        $query->where('a.language IN (' . $db->quote(Factory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
        $query->where($db->quoteName('a.published') . ' = 1');
        $db->setQuery($query);

        if ($fetid) {
            $results = $db->loadObject();
        } else {
            $results = $db->loadObjectList();
        }
        return $results;
    }

    //Generate random property ID from title and creation date
    public static function generateID($title, $date)
    {
        $date   = HTMLHelper::date($date, 'ymd');
        $title  = strtoupper(substr($title, 0, 3));
        $random = rand(100, 999);
        return $title . $date . 'R' . $random;
    }

    //Debugging function. Removed in the production package
    public static function debug($data, $die = true)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($die) {
            die;
        }
    }

    /**
     * Get Joomla Version
     *
     * @param string $type
     * @return void
     */
    public static function getVersion($type = 'major')
    {
        $version = JVERSION;
        list ($major, $minor, $patch) = explode('.', $version);

        if (strpos($patch, '-') !== false) {
            $patch = explode('-', $patch)[0];
        }

        switch ($type) {
            case 'minor':
                return (int) $minor;
            case 'patch':
                return (int) $patch;
            case 'major':
            default:
                return (int) $major;
        }
    }
}
