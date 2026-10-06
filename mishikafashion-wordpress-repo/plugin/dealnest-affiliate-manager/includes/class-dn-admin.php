<?php
if (!defined('ABSPATH')) exit;
class DN_Admin {
    public static function init(){ add_action('admin_menu',array(__CLASS__,'menu')); }
    public static function menu(){ add_submenu_page('edit.php?post_type=affiliate_product','GitHub Updates','GitHub Updates','manage_options','dealnest-github',array(__CLASS__,'github_page')); }
    public static function github_page(){
        if(isset($_POST['dn_save_github'])){
            check_admin_referer('dn_github_save');
            update_option('dealnest_am_github_owner',sanitize_text_field(wp_unslash($_POST['owner']??'')));
            update_option('dealnest_am_github_repo',sanitize_text_field(wp_unslash($_POST['repo']??'')));
            if(!empty($_POST['token'])) update_option('dealnest_am_github_token',sanitize_text_field(wp_unslash($_POST['token'])));
            if(!empty($_POST['clear_token'])) delete_option('dealnest_am_github_token');
            echo '<div class="notice notice-success"><p>GitHub settings saved.</p></div>';
        }
        $owner=get_option('dealnest_am_github_owner',''); $repo=get_option('dealnest_am_github_repo','mishikafashion-wordpress');
        echo '<div class="wrap"><h1>GitHub Updates</h1><p>Publish a higher-version GitHub Release containing <code>dealnest-affiliate-manager.zip</code> to receive plugin updates.</p><form method="post">'; wp_nonce_field('dn_github_save');
        printf('<table class="form-table"><tr><th>GitHub username / organization</th><td><input class="regular-text" name="owner" value="%s"></td></tr><tr><th>Repository</th><td><input class="regular-text" name="repo" value="%s"></td></tr><tr><th>GitHub token</th><td><input type="password" class="regular-text" name="token" value=""><p class="description">Leave blank to keep the saved token. Only needed for private repositories.</p><label><input type="checkbox" name="clear_token" value="1"> Clear saved token</label></td></tr></table><p><button class="button button-primary" name="dn_save_github" value="1">Save GitHub Settings</button></p></form></div>',esc_attr($owner),esc_attr($repo));
    }
}
