<?php

add_action('admin_menu', 'create_theme_options_page');
add_action('admin_init', 'register_and_build_fields');

function create_theme_options_page() {
   add_options_page('Tognox Theme Options', 'Tognox Options', 'administrator', __FILE__, 'options_page_fn');
}

function register_and_build_fields() {
   register_setting('theme_options', 'theme_options', 'validate_setting');

   add_settings_section('general_section', 'General Settings', 'section_cb', __FILE__);

   add_settings_field('ga_id', 'Google Analytics ID:', 'ga_id_setting', __FILE__, 'general_section');
   add_settings_field('twitter_username', 'Twitter Username:', 'twitter_username_setting', __FILE__, 'general_section');
   add_settings_field('fb_app_id', 'Facebook App ID:', 'fb_app_id_setting', __FILE__, 'general_section');

}

function options_page_fn() {
?>
   <div class="wrap">
      <div class="icon32" id="icon-tools"></div>

      <h2>Tognox Theme Options</h2>

      <form method="post" action="options.php" enctype="multipart/form-data">
         <?php settings_fields('theme_options'); ?>
         <?php do_settings_sections(__FILE__); ?>
         <p class="submit">
            <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
         </p>
   </form>
</div>
<?php
}

function ga_id_setting() {
   $options = get_option('theme_options');
   echo "<input type='text' name='theme_options[ga_id]' value='{$options['ga_id']}'>";
}

function twitter_username_setting() {
   $options = get_option('theme_options');
   echo "<input type='text' name='theme_options[twitter_username]' value='{$options['twitter_username']}'>";
}

function fb_app_id_setting() {
   $options = get_option('theme_options');
   echo "<input type='text' name='theme_options[fb_app_id]' value='{$options['fb_app_id']}'>";
}


function validate_setting($theme_options) {
   return $theme_options;
}

function section_cb() {}
