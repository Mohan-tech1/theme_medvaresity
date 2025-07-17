<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme functions.
 *
 * @package    theme_boost
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_medvaresity_get_main_scss_content($theme) {
    global $CFG;

    $scss = file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    $scss .= file_get_contents($CFG->dirroot . '/theme/medvaresity/scss/theme.scss');

    return $scss;
}

/**
 * Get the sidebar navigation items.
 *
 * @param secondary_navigation $navigation
 * @param int $depth
 * @return array
 */
function theme_medvaresity_get_sidebar_navigation($navigation, $depth = 0) {
    if (!$navigation || !$navigation->has_children() || $depth >= 3) {
        return [];
    }

    $treeitems = [];
    foreach ($navigation->children as $item) {
        if (!$item->display) {
            continue;
        }

        $children = $item->has_children() ? theme_medvaresity_get_sidebar_navigation($item, $depth + 1) : [];
        $treeitems[] = [
            'text' => $item->text,
            'url' => $item->action(),
            'key' => $item->key,
            'haschildren' => !empty($children),
            'children' => $children
        ];
    }

    // Ensure the top-level items are always at the start.
    usort($treeitems, function($a, $b) {
        if ($a['haschildren'] && !$b['haschildren']) {
            return 1; // $a comes before $b.
        } elseif (!$a['haschildren'] && $b['haschildren']) {
            return -1; // $b comes before $a.
        }
        return 0; // Keep the original order.
    }); 
    return $treeitems;
}
