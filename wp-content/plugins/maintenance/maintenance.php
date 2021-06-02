<?php
/*
	Plugin Name: Maintenance
	Plugin URI: https://wpmaintenancemode.com/
	Description: Put your site in maintenance mode, away from the public view. Use maintenance plugin if your website is in development or you need to change a few things, run an upgrade. Make it only accessible to logged in users.
	Version: 4.02
	Author: WebFactory Ltd
	Author URI: https://www.webfactoryltd.com/
	License: GPL2

  Copyright 2013-2021  WebFactory Ltd  (email : support@webfactoryltd.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class MTNC
{
  public function __construct()
  {
    global $mtnc_variable;
    $mtnc_variable = new stdClass();

    add_action('plugins_loaded', array(&$this, 'mtnc_constants'), 1);
    add_action('plugins_loaded', array(&$this, 'mtnc_lang'), 2);
    add_action('plugins_loaded', array(&$this, 'mtnc_includes'), 3);
    add_action('plugins_loaded', array(&$this, 'mtnc_admin'), 4);

    register_activation_hook(__FILE__, array(&$this, 'mtnc_activation'));
    register_deactivation_hook(__FILE__, array(&$this, 'mtnc_deactivation'));

    add_action('template_include', array(&$this, 'mtnc_template_include'), 999999);
    add_action('do_feed_rdf', array(&$this, 'disable_feed'), 0, 1);
    add_action('do_feed_rss', array(&$this, 'disable_feed'), 0, 1);
    add_action('do_feed_rss2', array(&$this, 'disable_feed'), 0, 1);
    add_action('do_feed_atom', array(&$this, 'disable_feed'), 0, 1);
    add_action('wp_logout', array(&$this, 'mtnc_user_logout'));
    add_action('init', array(&$this, 'mtnc_admin_bar'));
    add_action('init', array(&$this, 'mtnc_set_global_options'), 1);

    add_filter(
      'plugin_action_links_' . plugin_basename(__FILE__),
      array(&$this, 'plugin_action_links')
    );
  }

  // add settings link to plugins page
  function plugin_action_links($links)
  {
    $settings_link = '<a href="' . admin_url('admin.php?page=maintenance') . '" title="' . __('Maintenance Settings', 'maintenance') . '">' . __('Settings', 'maintenance') . '</a>';

    array_unshift($links, $settings_link);

    return $links;
  } // plugin_action_links

  public function mtnc_constants()
  {
    define('MTNC_VERSION', '4.0');
    define('MTNC_DB_VERSION', 2);
    define('MTNC_WP_VERSION', get_bloginfo('version'));
    define('MTNC_DIR', trailingslashit(plugin_dir_path(__FILE__)));
    define('MTNC_URI', trailingslashit(plugin_dir_url(__FILE__)));
    define('MTNC_INCLUDES', MTNC_DIR . trailingslashit('includes'));
    define('MTNC_LOAD', MTNC_DIR . trailingslashit('load'));
  }

  public function mtnc_set_global_options()
  {
    global $mt_options;
    $mt_options = mtnc_get_plugin_options(true);
  }

  public function mtnc_lang()
  {
    load_plugin_textdomain('maintenance');
  }

  public function mtnc_includes()
  {
    require_once MTNC_INCLUDES . 'functions.php';
    require_once MTNC_INCLUDES . 'update.php';
    require_once MTNC_DIR . 'load/functions.php';

    require_once dirname(__FILE__) . '/wf-flyout/wf-flyout.php';
    new wf_flyout(__FILE__);
  }

  public function mtnc_admin()
  {
    if (is_admin()) {
      require_once MTNC_INCLUDES . 'admin.php';
    }
  }

  public function mtnc_activation()
  {
    self::mtnc_clear_cache();
  }

  public function mtnc_deactivation()
  {
    self::mtnc_clear_cache();
  }

  public static function mtnc_clear_cache()
  {
    wp_cache_flush();
    if (function_exists('w3tc_pgcache_flush')) {
      w3tc_pgcache_flush();
    }
    if (function_exists('wp_cache_clear_cache')) {
      wp_cache_clear_cache();
    }
    if (method_exists('LiteSpeed_Cache_API', 'purge_all')) {
      LiteSpeed_Cache_API::purge_all();
    }
    do_action('litespeed_purge_all');
    if (class_exists('Endurance_Page_Cache')) {
      $epc = new Endurance_Page_Cache;
      $epc->purge_all();
    }
    if (class_exists('SG_CachePress_Supercacher') && method_exists('SG_CachePress_Supercacher', 'purge_cache')) {
      SG_CachePress_Supercacher::purge_cache(true);
    }
    if (class_exists('SiteGround_Optimizer\Supercacher\Supercacher')) {
      SiteGround_Optimizer\Supercacher\Supercacher::purge_cache();
    }
    if (isset($GLOBALS['wp_fastest_cache']) && method_exists($GLOBALS['wp_fastest_cache'], 'deleteCache')) {
      $GLOBALS['wp_fastest_cache']->deleteCache(true);
    }
    if (is_callable('wpfc_clear_all_cache')) {
      wpfc_clear_all_cache(true);
    }
    if (is_callable(array('Swift_Performance_Cache', 'clear_all_cache'))) {
      Swift_Performance_Cache::clear_all_cache();
    }
    if (is_callable(array('Hummingbird\WP_Hummingbird', 'flush_cache'))) {
      Hummingbird\WP_Hummingbird::flush_cache(true, false);
    }
    if (function_exists('rocket_clean_domain')) {
      rocket_clean_domain();
    }
    do_action('cache_enabler_clear_complete_cache');
  }

  public function mtnc_user_logout()
  {
    wp_safe_redirect(get_bloginfo('url'));
    exit;
  }

  public function disable_feed()
  {
    global $mt_options;

    if (!is_user_logged_in() && !empty($mt_options['state'])) {
      nocache_headers();
      echo '<?xml version="1.0" encoding="UTF-8" ?><status>Service unavailable.</status>';
      exit;
    }
  }

  public function mtnc_template_include($original_template)
  {
    $original_template = mtnc_load_maintenance_page($original_template);
    return $original_template;
  }

  public function mtnc_admin_bar()
  {
    add_action('admin_bar_menu', 'mtnc_add_toolbar_items', 100);
  }

  function is_plugin_installed($slug)
  {
    if (!function_exists('get_plugins')) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $all_plugins = get_plugins();

    if (!empty($all_plugins[$slug])) {
      return true;
    } else {
      return false;
    }
  } // is_plugin_installed

} // class MTNC

$mtnc = new MTNC();
