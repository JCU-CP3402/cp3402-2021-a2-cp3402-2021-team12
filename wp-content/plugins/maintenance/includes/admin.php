<?php
add_action('admin_menu', 'mtnc_admin_setup');

function mtnc_admin_setup()
{
  global  $mtnc_variable;
  $mtnc_variable->options_page = add_menu_page(__('Maintenance', 'maintenance'), __('Maintenance', 'maintenance'), 'manage_options', 'maintenance', 'mtnc_manage_options', MTNC_URI . 'images/icon-small.png');

  add_action('admin_init', 'mtnc_register_settings');
  add_action("admin_head-{$mtnc_variable->options_page}", 'mtnc_metaboxes_scripts');
  add_action("admin_print_styles-{$mtnc_variable->options_page}", 'mtnc_admin_print_custom_styles');
  add_action("load-{$mtnc_variable->options_page}", 'mtnc_page_add_meta_boxes');
  add_action('admin_enqueue_scripts', 'mtnc_load_later_scripts', 1);
  add_action('admin_enqueue_scripts', 'mtnc_codemirror_enqueue_scripts');
  add_action('admin_footer', 'mtnc_plugin_information', 1, 0);
}

function mtnc_plugin_dismiss_dialog() {
	if ( !wp_verify_nonce( $_REQUEST['nonce'], "mtnc_dismiss_nonce")) {
		exit("Woof Woof Woof");
	}

	$meta = get_option('maintenance_meta', array());

	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'mtnc_dismiss_dialog') {
		$meta['mtnc_dismiss_dialog'] = true;

		update_option('maintenance_meta', $meta);
    }

	die();
}
add_action("wp_ajax_mtnc_dismiss_dialog", "mtnc_plugin_dismiss_dialog");

function mtnc_plugin_information() {
  if (empty($_GET['fix-install-button']) || empty($_GET['tab']) || $_GET['tab'] != 'plugin-information') {
    return;
  }

  echo '<script>';
  echo "jQuery('#plugin_install_from_iframe').on('click', function() { window.location.href = jQuery(this).attr('href'); return false;});";
  echo '</script>';
}

function mtnc_page_add_meta_boxes()
{
  global  $mtnc_variable;
  do_action('add_mt_meta_boxes', $mtnc_variable->options_page);
}

function mtnc_register_settings()
{

  if (!empty($_POST['lib_options']) && check_admin_referer('mtnc_edit_post', 'mtnc_nonce')) {
    if (!isset($_POST['lib_options']['state'])) {
      $_POST['lib_options']['state'] = 0;
    } else {
      $_POST['lib_options']['state'] = 1;
    }

    if (isset($_POST['lib_options']['htmlcss'])) {
      $_POST['lib_options']['htmlcss'] = wp_kses_stripslashes($_POST['lib_options']['htmlcss']);  // Allowed all tags as for WYSIWYG post content
    }

    if (isset($_POST['lib_options'])) {
      $lib_options = sanitize_post(wp_unslash($_POST['lib_options']), 'db');
      $lib_options['default_settings'] = false;
      update_option('maintenance_options', $lib_options);
      MTNC::mtnc_clear_cache();
    }
  }
}

function mtnc_admin_print_custom_styles()
{
  if (function_exists('wp_enqueue_media')) {
    wp_enqueue_media();
  } else {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
  }

  wp_enqueue_script('common');
  wp_enqueue_script('wp-lists');
  wp_enqueue_script('postbox');

  wp_enqueue_style('plugin-install');
  wp_enqueue_script('plugin-install');

  wp_enqueue_style('arvo', '//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Arvo:400,400italic,700,700italic');
  wp_enqueue_style('wp-color-picker');

  wp_enqueue_script('uploads_', MTNC_URI . 'js/uploads_.min.js', 'jquery', filemtime(MTNC_DIR . 'js/uploads_.min.js'), '');
  wp_register_script('mtnc', MTNC_URI . 'js/init.js', array('wp-color-picker'), filemtime(MTNC_DIR . 'js/init.js'), true);

  $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
  $meta                                 = get_option('maintenance_meta', array());
  $firstInstallDateTime             = date('Y-m-d H:i:s', $meta['first_install']);
  $firstInstallDateTimeTimeStamp     = (new DateTime($firstInstallDateTime))->add(new DateInterval('PT15M'))->getTimestamp();

  $nonce = wp_create_nonce("mtnc_dismiss_nonce");
  $dismissDialogLink = admin_url('admin-ajax.php?action=mtnc_dismiss_dialog&nonce='.$nonce);

  $meta = get_option('maintenance_meta', array());
  $isDialogDismiss = isset($meta['mtnc_dismiss_dialog']) ? $meta['mtnc_dismiss_dialog'] : 0;
  $isDialogDismiss = 1;

  wp_localize_script(
        'mtnc',
    'mtnc',
                array(
                        'path' => MTNC_URI,
                        'cm_settings' =>  $cm_settings,
                        'site_url' => home_url(),
                        'first_install_date' => $firstInstallDateTimeTimeStamp,
                        'dismiss_dialog_link' => $dismissDialogLink,
                        'isDialogDismiss' => $isDialogDismiss
                )
  );

  wp_enqueue_script('mtnc');
  wp_enqueue_style('mtnc', MTNC_URI . 'css/admin.css', '', filemtime(MTNC_DIR . 'css/admin.css'));

  wp_enqueue_style('wp-jquery-ui-dialog');
  wp_enqueue_script('jquery-ui-dialog');

  add_thickbox();

  // fix for aggressive plugins that include their CSS on all pages
  wp_dequeue_style('uiStyleSheet');
  wp_dequeue_style('wpcufpnAdmin');
  wp_dequeue_style('unifStyleSheet');
  wp_dequeue_style('wpcufpn_codemirror');
  wp_dequeue_style('wpcufpn_codemirrorTheme');
  wp_dequeue_style('collapse-admin-css');
  wp_dequeue_style('jquery-ui-css');
  wp_dequeue_style('tribe-common-admin');
  wp_dequeue_style('file-manager__jquery-ui-css');
  wp_dequeue_style('file-manager__jquery-ui-css-theme');
  wp_dequeue_style('wpmegmaps-jqueryui');
  wp_dequeue_style('wp-botwatch-css');
}

function mtnc_codemirror_enqueue_scripts($hook)
{
  if ('toplevel_page_maintenance' !== $hook) {
    return;
  }

  $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));
  wp_localize_script('jquery', 'cm_settings', $cm_settings);

  wp_enqueue_script('wp-theme-plugin-editor');
  wp_enqueue_style('wp-codemirror');
}

function mtnc_load_later_scripts($hook)
{
  if ($hook !== 'toplevel_page_maintenance') {
    return;
  }

  // fix a bug with WooCommerce 3.2.2 .
  wp_deregister_script('select2');
  wp_deregister_style('select2');
  wp_dequeue_script('select2');
  wp_dequeue_style('select2');
  wp_enqueue_script('select2', MTNC_URI . 'js/select2/select2.min.js', 'jquery', filemtime(MTNC_DIR . 'js/select2/select2.min.js'), '');
  wp_enqueue_style('select2', MTNC_URI . 'js/select2/select2.css', '', filemtime(MTNC_DIR . 'js/select2/select2.css'));

  // fix for aggressive plugins
  wp_dequeue_style('uiStyleSheet');
  wp_dequeue_style('wpcufpnAdmin');
  wp_dequeue_style('unifStyleSheet');
  wp_dequeue_style('wpcufpn_codemirror');
  wp_dequeue_style('wpcufpn_codemirrorTheme');
  wp_dequeue_style('collapse-admin-css');
  wp_dequeue_style('jquery-ui-css');
  wp_dequeue_style('tribe-common-admin');
  wp_dequeue_style('file-manager__jquery-ui-css');
  wp_dequeue_style('file-manager__jquery-ui-css-theme');
  wp_dequeue_style('wpmegmaps-jqueryui');
  wp_dequeue_style('wp-botwatch-css');
}

function mtnc_manage_options()
{
  mtnc_generate_plugin_page();
}

function mtnc_generate_plugin_page()
{
  global  $mtnc_variable;
  $mt_option = mtnc_get_plugin_options(true);
  $date      = new DateTime();
  ?>

<div id="dialog-form-new-info" title="🚀 We're Rebuilding the Maintenance plugin! 🚀" style="display: none;">
        <p>Dear user!<br>We're super excited to tell you that we started working on the new version of the Maintenance plugin. <b>We want you to be a part of the journey!</b> We need your ideas, your input, your feedback! That's why we want to send you the new version before it's available to the public. Here's what we have planned;</p>
        <ul>
            <li>simpler &amp; faster admin interface</li>
            <li>pre-built themes so you can work even faster</li>
            <li>easier access control via IPs, users, and secret links</li>
            <li>better cache handling so you never get stuck in maintenance mode</li>
        </ul>
        <hr>
        <p class="validateTips"></p>
        <form id="dialog-form-new-info-form">
            <fieldset>
                <label for="name">Name (*)</label>
                <input type="text" name="name" id="name" value="" placeholder="How shall we call you?" class="text ui-widget-content ui-corner-all" required>

                <label for="email">Email (*)</label>
                <input type="text" name="email" id="email" value="" placeholder="Your best email address" class="text ui-widget-content ui-corner-all" required>

                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">

                <span>
                    <i>We hate SPAM and never send it! And we won't share your email with anybody else.</i>
                </span>

                <div class="buttons">
                    <a href="#" class="submit-new-dialog button button-primary">I want to be the first to know about the new plugin version</a>
                    <br>
                    <a href="#" class="dismiss-new-dialog"><small>I'm not interested</small></a>
                </div>
            </fieldset>
        </form>
    </div>

  <div id="maintenance-options" class="wrap">
    <form method="post" action="" enctype="multipart/form-data" name="options-form">
      <?php wp_nonce_field('mtnc_edit_post', 'mtnc_nonce'); ?>
      <?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
      <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
      <div class="postbox-container header-container column-1 normal">
        <h1><?php esc_html_e('Maintenance', 'maintenance'); ?><input type="checkbox" id="state" name="lib_options[state]" <?php checked($mt_option['state'], 1); ?> /> <p class="submit"><a href="<?php echo home_url( '?maintenance-preview'); ?>" target="_blank" class="button">Preview</a> &nbsp;&nbsp; <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p></h1>

      </div>
      <div class="clear"></div>
      <div id="poststuff">
        <div class="metabox-holder">
          <div id="all-fileds" class="postbox-container column-1 normal">

            <?php do_meta_boxes($mtnc_variable->options_page, 'normal', null); ?>
            <?php do_meta_boxes($mtnc_variable->options_page, 'advanced', null); ?>

          </div>

          <div id="promo" class="postbox-container column-2 normal">
            <?php do_meta_boxes($mtnc_variable->options_page, 'side', null); ?>
          </div>

        </div>
      </div>
    </form>
  </div>
<?php
}
