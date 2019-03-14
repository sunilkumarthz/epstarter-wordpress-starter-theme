<?php

/**
 * EPStarter functions and definitions
 *
 * @package epstarter
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * EPStarter only works in WordPress 4.7 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.7', '<')) {
    require get_parent_theme_file_path('/inc/back-compat.php');
    return;
}

require_once get_template_directory() . '/inc/theme-globals.php';

require_once get_template_directory() . '/inc/class-theme-setup.php';

require_once get_template_directory() . '/inc/template-functions.php';

require_once get_template_directory() . '/inc/breadcrumbs.php';
