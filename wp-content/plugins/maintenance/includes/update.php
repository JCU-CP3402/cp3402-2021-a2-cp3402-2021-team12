<?php
add_action('admin_init', 'mtnc_version_check');
function mtnc_version_check()
{
  $old_version = get_option('mtnc_db_version');
  $options     = get_option('maintenance_options');
  $meta        = get_option('maintenance_meta', array());

  if (empty($meta) || sizeof($meta) < 2) {
    $meta['first_version'] = MTNC_VERSION;
    $meta['first_install'] = time();
    if (!empty($old_version)) {
      $meta['old_version'] = true;
    } else {
      $meta['old_version'] = false;
    }
    update_option('maintenance_meta', $meta);
  }

  if (empty($old_version) && false === $options) {
    mtnc_install();
  } elseif (empty($old_version) && !empty($options)) {
    mtnc_update();
  } elseif ((int) $old_version < MTNC_DB_VERSION) {
    mtnc_update();
  }
}

function mtnc_install()
{
  $options = mtnc_get_plugin_options();
  add_option('mtnc_db_version', MTNC_DB_VERSION);
  add_option('maintenance_options', $options);
}

function mtnc_update()
{
  $options  = mtnc_get_plugin_options();
  $settings = get_option('maintenance_options');

  update_option('mtnc_db_version', MTNC_DB_VERSION);

  foreach ($options as $key => $value) {
    if (!isset($settings[$key])) {
      $settings[$key] = $value;
    }
  }
  update_option('maintenance_options', $options);
}
