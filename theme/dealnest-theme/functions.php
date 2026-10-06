<?php
if(!defined('ABSPATH')) exit;
define('DEALNEST_THEME_VERSION','1.2.2');
require_once get_template_directory().'/inc/class-dn-theme-updater.php';
function dealnest_setup(){add_theme_support('title-tag');add_theme_support('post-thumbnails');add_theme_support('custom-logo',array('height'=>80,'width'=>240,'flex-height'=>true,'flex-width'=>true));register_nav_menus(array('primary'=>'Primary Menu'));}
add_action('after_setup_theme','dealnest_setup');
function dealnest_assets(){wp_enqueue_style('dealnest-style',get_stylesheet_uri(),array(),DEALNEST_THEME_VERSION);wp_enqueue_script('dealnest-js',get_template_directory_uri().'/assets/js/theme.js',array(),DEALNEST_THEME_VERSION,true);}
add_action('wp_enqueue_scripts','dealnest_assets');
function dealnest_customize($c){$c->add_section('dealnest_options',array('title'=>'DealNest Settings','priority'=>30));$fields=array('marquee_text'=>'Announcement / Marquee Text','hero_title'=>'Hero Title','hero_text'=>'Hero Description','accent_color'=>'Accent Color');foreach($fields as $id=>$label){$type=$id==='accent_color'?'color':'text';$c->add_setting('dealnest_'.$id,array('default'=>$id==='accent_color'?'#635bff':''));$c->add_control(new WP_Customize_Control($c,'dealnest_'.$id,array('label'=>$label,'section'=>'dealnest_options','type'=>$type)));} $c->add_setting('dealnest_dark_default',array('default'=>false));$c->add_control('dealnest_dark_default',array('label'=>'Default Dark Mode','section'=>'dealnest_options','type'=>'checkbox'));}
add_action('customize_register','dealnest_customize');
function dealnest_custom_css(){echo '<style>:root{--dn-accent:'.esc_attr(get_theme_mod('dealnest_accent_color','#635bff')).';}</style>';}
add_action('wp_head','dealnest_custom_css');
new DN_Theme_Updater();

require_once get_template_directory().'/inc/admin-settings.php';
