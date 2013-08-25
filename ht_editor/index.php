<?php
/*
Plugin Name: Htaccess Editor
Plugin URI: http://tuffclassified.com
Description: This simple plugin will help you to edit your htaccess file from dashboard
Version: 1.0.1
Author: Navjot Tomer 
Author URI: http://tuffclassified.com/
Short Name: ht_editor
*/

function ht_editor_call_after_install() {
            
            osc_set_preference('htaccess_editor_version', '1.0.1' , 'ht_editor');

            osc_reset_preferences();
        }
function ht_editor_call_after_uninstall() {
            
            osc_delete_preference('htaccess_editor_version', 'ht_editor');
            
            osc_reset_preferences();
        }


 function ht_editor_actions_admin() {

        switch( Params::getParam('action_specific') ) {

            case('ht_editor'):
            	$htaccess_file = osc_base_path() . '.htaccess' ;
                $edit_htaccess  = Params::getParam('edit_htaccess',false,false);
                
            	if( file_exists($htaccess_file) ) {
                if( is_writable($htaccess_file) && file_put_contents($htaccess_file, $edit_htaccess) ) {
                $status = 1 ;}} 
                else { if( is_writable(osc_base_path()) && file_put_contents($htaccess_file, $edit_htaccess) ) {
                $status = 1 ;}}
                
                osc_add_flash_ok_message(__('Files updated successfully', 'ht_editor'), 'admin');
                
                header('Location: ' . osc_admin_render_plugin_url('ht_editor/admin.php')); exit;
            break;
        }
    }
osc_add_hook('init_admin', 'ht_editor_actions_admin');
	 

function ht_admin() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin.php') ;
    }

function ht_admin_menu(){
	osc_admin_menu_plugins('Htaccess Editor', osc_admin_render_plugin_url('ht_editor/admin.php'), 'ht-editor-submenu');
	}
	
	//Adding sub menu to plugins menu in dashboard
 	osc_add_hook('admin_menu_init','ht_admin_menu');
    	// This is needed in order to be able to activate the plugin
    	osc_register_plugin(osc_plugin_path(__FILE__), 'ht_editor_call_after_install');
    	// This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    	osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", 'ht_editor_call_after_uninstall');
    	osc_add_hook(osc_plugin_path(__FILE__)."_configure", 'ht_admin');
?>
