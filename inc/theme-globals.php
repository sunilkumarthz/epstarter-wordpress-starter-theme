<?php

/**
 * Global Function & Variables
 * @since 1.1.0
 * @package epstarter
 */
function epspre($data) {
    echo "<pre>";
    print_r($data);
    echo "<pre>";
}

function epsprx($data) {
    echo "<pre>";
    print_r($data);
    echo "<pre>";
    die();
}

$epsTheme = wp_get_theme();

if (!defined('EPS_THEME_NAME'))
    define('EPS_THEME_NAME', $epsTheme->get('Name'));

if (!defined('EPS_THEME_VERSION'))
    define('EPS_THEME_VERSION', $epsTheme->get('Version'));

if (!defined('EPS_THEME_SLUG'))
    define('EPS_THEME_SLUG', $epsTheme->get('TextDomain'));

if (!defined('EPS_THEME_URI'))
    define('EPS_THEME_URI', get_template_directory_uri() . "/");

if (!defined('EPS_THEME_PATH'))
    define('EPS_THEME_PATH', get_template_directory() . "/");

if (!defined('EPS_ASSETS_URI'))
    define('EPS_ASSETS_URI', get_template_directory_uri() . "/assets/");

if (!defined('EPS_ASSETS_PATH'))
    define('EPS_ASSETS_PATH', get_template_directory() . "/");

if (!defined('EPS_THEME_INC'))
    define('EPS_THEME_INC', get_template_directory() . "/inc/");
