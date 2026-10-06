<?php
if(!defined('ABSPATH')) exit;
class DN_Theme_Updater{
 private $option='dealnest_theme_github_';
 public function __construct(){add_filter('pre_set_site_transient_update_themes',array($this,'check'));add_filter('themes_api',array($this,'info'),10,3);add_filter('upgrader_source_selection',array($this,'source'),10,4);}
 private function release(){ $o=get_option($this->option.'owner','');$r=get_option($this->option.'repo','mishikafashion-wordpress');$t=get_option($this->option.'token','');if(!$o||!$r)return false;$args=array('timeout'=>15,'headers'=>array('Accept'=>'application/vnd.github+json','User-Agent'=>'DealNest-Theme-Updater'));if($t)$args['headers']['Authorization']='Bearer '.$t;$res=wp_remote_get('https://api.github.com/repos/'.rawurlencode($o).'/'.rawurlencode($r).'/releases/latest',$args);if(is_wp_error($res)||wp_remote_retrieve_response_code($res)!==200)return false;$d=json_decode(wp_remote_retrieve_body($res),true);return is_array($d)?$d:false;}
 private function asset($r){foreach(($r['assets']??array()) as $a){if(($a['name']??'')==='dealnest-theme.zip')return $a['browser_download_url']??false;}return false;}
 public function check($t){$r=$this->release();if(!$r||empty($r['tag_name']))return $t;$v=ltrim($r['tag_name'],'vV');if(version_compare($v,DEALNEST_THEME_VERSION,'>')){$a=$this->asset($r);if($a){$t->response['dealnest-theme']=array('theme'=>'dealnest-theme','new_version'=>$v,'url'=>$r['html_url']??'','package'=>$a);}}return $t;}
 public function info($false,$action,$args){if($action!=='theme_information'||empty($args->slug)||$args->slug!=='dealnest-theme')return $false;$r=$this->release();if(!$r)return $false;return (object)array('name'=>'DealNest','slug'=>'dealnest-theme','version'=>ltrim($r['tag_name'],'vV'),'author'=>'DealNest','homepage'=>$r['html_url']??'','sections'=>array('description'=>'DealNest affiliate catalog theme.','changelog'=>$r['body']??''));}
 public function source($source,$remote_source,$upgrader,$hook_extra){if(empty($hook_extra['theme'])||$hook_extra['theme']!=='dealnest-theme')return $source;$expected=untrailingslashit($remote_source).'/dealnest-theme';return is_dir($expected)?$expected:$source;}
}
