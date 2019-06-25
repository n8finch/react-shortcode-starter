<?php
/*
Plugin Name: React Shortcode Starter
Plugin URI: https://n8finch.com
Description: Basic boilerplate for a react app via shortcode
Version: 0.1.0
Author: Nate Finch
Author URI: https://n8finch.com
Text Domain: react-shortcode
*/


define('N8F_REACT_SHORTCODE', plugins_url() . '/react-shortcode-starter');

require __DIR__ . '/shortcodes/posts-query-results.php';

add_action('wp_enqueue_scripts', 'n8f_react_enqueue_react_scripts');
function n8f_react_enqueue_react_scripts()
{
	wp_enqueue_script(
		'n8f-react-react-sorter',
		plugin_dir_url(__FILE__) . 'react-app/dist/main.js',
		['wp-element'],
		time(), // Change this to null for production
		true
	);
}
