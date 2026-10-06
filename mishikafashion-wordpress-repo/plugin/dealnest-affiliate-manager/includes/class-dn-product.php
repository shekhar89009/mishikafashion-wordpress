<?php
if (!defined('ABSPATH')) exit;
class DN_Product {
    public static function init(){ add_action('init', array(__CLASS__,'register')); add_action('add_meta_boxes', array(__CLASS__,'metabox')); add_action('save_post_affiliate_product', array(__CLASS__,'save'),10,2); }
    public static function register(){
        register_post_type('affiliate_product', array(
            'labels'=>array('name'=>'Affiliate Products','singular_name'=>'Affiliate Product','add_new_item'=>'Add Affiliate Product','edit_item'=>'Edit Affiliate Product'),
            'public'=>true,'show_in_rest'=>true,'menu_icon'=>'dashicons-cart','supports'=>array('title','editor','thumbnail','excerpt'),
            'has_archive'=>true,'rewrite'=>array('slug'=>'products'),'taxonomies'=>array('product_category','product_brand','product_tag')
        ));
        register_taxonomy('product_category','affiliate_product',array('labels'=>array('name'=>'Product Categories','singular_name'=>'Product Category'),'public'=>true,'show_in_rest'=>true,'hierarchical'=>true,'rewrite'=>array('slug'=>'product-category')));
        register_taxonomy('product_brand','affiliate_product',array('labels'=>array('name'=>'Brands','singular_name'=>'Brand'),'public'=>true,'show_in_rest'=>true,'hierarchical'=>false,'rewrite'=>array('slug'=>'brand')));
        register_taxonomy('product_tag','affiliate_product',array('labels'=>array('name'=>'Product Tags','singular_name'=>'Product Tag'),'public'=>true,'show_in_rest'=>true,'hierarchical'=>false,'rewrite'=>array('slug'=>'product-tag')));
    }
    public static function metabox(){ add_meta_box('dn_product_details','Affiliate Product Details',array(__CLASS__,'box'),'affiliate_product','normal','high'); }
    public static function box($post){
        wp_nonce_field('dn_product_save','dn_product_nonce');
        $fields=array('affiliate_url'=>'Affiliate URL','sale_price'=>'Sale Price','regular_price'=>'Regular Price','retailer'=>'Retailer / Platform','video_url'=>'Product Video URL');
        echo '<div style="display:grid;gap:14px">';
        foreach($fields as $key=>$label){ printf('<label><strong>%s</strong><input type="text" name="%s" value="%s" style="width:100%%;margin-top:5px"></label>',$label,esc_attr($key),esc_attr(get_post_meta($post->ID,'_'.$key,true))); }
        printf('<label><strong>Short Description</strong><textarea name="short_description" style="width:100%%;min-height:90px;margin-top:5px">%s</textarea></label>',esc_textarea(get_post_meta($post->ID,'_short_description',true)));
        printf('<label><input type="checkbox" name="featured" value="1" %s> Featured product</label>',checked(get_post_meta($post->ID,'_featured',true),'1',false));
        echo '</div><p style="color:#666">Use the Featured Image for the main product image. Use the WordPress editor for the full description.</p>';
    }
    public static function save($post_id){
        if(!isset($_POST['dn_product_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['dn_product_nonce'])),'dn_product_save')) return;
        if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE) return; if(!current_user_can('edit_post',$post_id)) return;
        $keys=array('affiliate_url','sale_price','regular_price','retailer','video_url','short_description');
        foreach($keys as $key){ if(isset($_POST[$key])) update_post_meta($post_id,'_'.$key,sanitize_text_field(wp_unslash($_POST[$key]))); }
        update_post_meta($post_id,'_featured',isset($_POST['featured'])?'1':'0');
    }
}
