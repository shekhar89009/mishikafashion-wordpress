<?php
if(!defined('ABSPATH')) exit;
function dealnest_theme_github_menu(){add_theme_page('GitHub Updates','GitHub Updates','manage_options','dealnest-theme-github','dealnest_theme_github_page');}
add_action('admin_menu','dealnest_theme_github_menu');
function dealnest_theme_github_page(){
    if(isset($_POST['dn_theme_save'])){
        check_admin_referer('dn_theme_github');
        update_option('dealnest_theme_github_owner',sanitize_text_field(wp_unslash($_POST['owner']??'')));
        update_option('dealnest_theme_github_repo',sanitize_text_field(wp_unslash($_POST['repo']??'mishikafashion-wordpress')));
        if(!empty($_POST['token'])) update_option('dealnest_theme_github_token',sanitize_text_field(wp_unslash($_POST['token'])));
        if(!empty($_POST['clear_token'])) delete_option('dealnest_theme_github_token');
        echo '<div class="notice notice-success"><p>Theme GitHub settings saved.</p></div>';
    }
    $o=get_option('dealnest_theme_github_owner','');
    $r=get_option('dealnest_theme_github_repo','mishikafashion-wordpress');
    echo '<div class="wrap"><h1>DealNest Theme — GitHub Updates</h1><p>Publish a higher-version GitHub Release containing <code>dealnest-theme.zip</code> to receive theme updates.</p><form method="post">';
    wp_nonce_field('dn_theme_github');
    printf('<table class="form-table"><tr><th>GitHub username / organization</th><td><input class="regular-text" name="owner" value="%s"></td></tr><tr><th>Repository</th><td><input class="regular-text" name="repo" value="%s"></td></tr><tr><th>GitHub token</th><td><input type="password" class="regular-text" name="token"><p class="description">Leave blank to keep the saved token. Only needed for a private repository.</p><label><input type="checkbox" name="clear_token" value="1"> Clear saved token</label></td></tr></table><p><button class="button button-primary" name="dn_theme_save" value="1">Save GitHub Settings</button></p></form></div>',esc_attr($o),esc_attr($r));
}
