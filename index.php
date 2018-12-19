<?php
/**
 *	@package WP&Co Hide DLM downloads in WP Media Library
 *	@author Celyan
 *	@version 0.0.1
 */
/*
 Plugin Name: WP&Co Hide DLM downloads in WP Media Library
 Plugin URI: https://github.com/Celyan-SAS/hide-dlm-downloads-in-wp-media-library
 Description: This WordPress plugin hides files managed by the Download Monitor plugin in the WP Media library admin
 Version: 0.0.1
 Author: Yann Dubois
 Author URI: https://wordpressandco.fr/
 License: GPL2
 */

include_once( dirname(__FILE__) . '/inc/main.php' );

new wpcHideDlm();