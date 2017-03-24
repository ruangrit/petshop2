<?php

/**
 * @package TT Theme Options Export/Import
 */
/*
Plugin Name: TT Theme Options Export/Import
Plugin URI: 
Description: TT Creation's Extended Themes' Options/Settings Export and Import
Version: 1.0
Author: TT Creation
Author URI: 
License: GPLv2 or later
Text Domain: tteximport

*/

class backup_restore_theme_options {
	
	function backup_restore_theme_options() {
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}
	
	function admin_menu() {
		$page = add_submenu_page('tools.php', 'Export/Import TT Theme Options', 'Export/Import TT Theme Options', 'manage_options', 'TTbackup-options', array(&$this, 'options_page'));

		add_action("load-{$page}", array(&$this, 'import_export'));
	}
	
	function import_export() {
		$TTt_file_name = get_option( 'stylesheet' );
		
		if (isset($_GET['action']) && ($_GET['action'] == 'download')) {
			header("Cache-Control: public, must-revalidate");
			header("Pragma: hack");
			header("Content-Type: text/plain");
			header('Content-Disposition: attachment; filename="'.$TTt_file_name.'-options-'.date("dMy").'.dat"');
			echo serialize($this->_get_options());
			die();
		}
		
		function is_serial($serialdata) { return (@unserialize($serialdata) !== false || $serialdata == 'b:0;'); }
		
		if (isset($_POST['upload']) && check_admin_referer('TTthemes_restoreOptions', 'TTthemes_restoreOptions')) {
			
			if ($_FILES['file']['error'] > 0) {
				// error
			} else { 
				$TTbackupoptions = file_get_contents($_FILES['file']['tmp_name']);
				if (is_serial($TTbackupoptions)): $TToptions = unserialize($TTbackupoptions); else: 				
				echo "<script type='text/javascript'>alert('Not Successful! Not a Valid File! You can try Another'); window.location.href='".admin_url('tools.php?page=TTbackup-options')."';</script>";
				exit(); endif;
				if ($TToptions) { 
					foreach ($TToptions as $TToptions) {
						update_option($TToptions->option_name, unserialize($TToptions->option_value)); 
					}
				}
			}
			wp_redirect(admin_url('tools.php?page=TTbackup-options'));
			exit;
		}
	}
	
	function options_page() { ?>
		<div id="optionsframework-wrap">
		<div class="wrap">
        	<h2><strong><?php _e('TT Theme Options Export/Import','tteximport'); ?></strong></h2>
            <p class="TTbdes">< <a href="<?php echo admin_url('admin.php?page=options-framework'); ?>" ><?php _e('Return Back to Theme Options','tteximport'); ?></a></p>
			<form action="" method="POST" enctype="multipart/form-data">
 				<style>#TTbackup-options td { display: block; margin: 30px auto; max-width: 750px; } .exportTTop { border: 1px solid #dddddd; padding: 10px; background: #ffffff none repeat scroll 0 0; }.exportTTop textarea.readonly { background: #FFFFFF; }.TTbdes { font-size: 15px; margin: 0; } .importTTop { border: 1px solid #dddddd; padding: 10px; background: #fff; }.specialTTop, #optionsframework-wrap .specialTTop { background: #FFF; padding: 10px; border-left: 5px solid #0CF;} #TTbackup-options .button-primary, #TTbackup-options .button-secondary { padding: 5px 10px; font-size: 15px; height: auto; }</style>
				<table id="TTbackup-options">
					<tr>
						<td class="exportTTop">
							<h3><?php _e('Backup/Export','tteximport'); ?></h3>
							<p><?php _e('Here are the stored settings for the current theme:','tteximport'); ?></p>
							<p><textarea readonly="readonly" class="widefat readonly code" rows="20" cols="100" onclick="this.select()"><?php echo serialize($this->_get_options()); ?></textarea></p>
							<p><a href="?page=TTbackup-options&action=download" class="button-secondary"><?php _e('Download as File','tteximport'); ?></a></p>
						</td>
						<td class="importTTop">
							<h3><?php _e('Restore/Import','tteximport'); ?></h3>
							<p><label class="description" for="upload"><?php _e('Restore a previous backup','tteximport'); ?></label></p>
                            
							<p><input type="file" name="file" /> <input type="submit" name="upload" id="upload" class="button-primary" value="Upload and Restore" /></p>				<p style="color:#F00;"><label class="description" for="upload">[ WARNING: This will remove all Existing Theme Options/Settings and Restore Old Options/Settings from Backup ]</label></p>
							<?php if (function_exists('wp_nonce_field')) wp_nonce_field('TTthemes_restoreOptions', 'TTthemes_restoreOptions'); ?>
						</td>
                        
                        <td class="specialTTop">
                            <?php _e('You should check and change the Image Urls, Links and Urls manually from the ','tteximport'); ?><a href="<?php echo admin_url('admin.php?page=options-framework'); ?>" > <?php _e('Theme Options ','tteximport'); ?></a> <?php _e('after Backup/Restore because all settings/options are Imported as it was. ','tteximport'); ?>
                            <p><?php _e('It is Strongly Recommended that you will keep a Full Site Backup and Full Database Backup besides the Theme Options Backup. There are various ways to take the Full Site Backup and Full Database Backup. Many hosting companies provide these services. Full Site Backup and Full Database Backup are not related with Theme Developers. These are Hosting/cPanel Features. ','tteximport'); ?></p> 
                            <p> <?php _e('This ','tteximport'); ?><strong> <?php _e('TT Theme Options Export/Import ','tteximport'); ?></strong><?php _e(' may or may not work with all WordPress Environment. This Product is provided "as is" with no warranty or liabilities of TT Creation ','tteximport'); ?></p> 
                        </td>
					</tr>
				</table>
			</form>
		</div>
		</div>
<?php }
	
	function _display_options() {
		$TToptions = unserialize($this->_get_options());
	}
	
	function _get_options() {
		global $wpdb;
		if ( function_exists( 'optionsframework_option_name' ) ): $TTt_option_name = optionsframework_option_name(); else: $TTt_option_name = 'xxxxxxyyyyyyzzzzzz'; endif;
		// $TTt_option_name = optionsframework_option_name();
		return $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name = '". $TTt_option_name ."'");
	}
}

new backup_restore_theme_options();
	function eximp_options( $options ){
		$options[] = array(
			'name' => 'Export/Import',
			'type' => 'heading'
		);
		$options[] = array(
			'desc' => '
						<div class="specialTTop speciallf">
						<p style="font-size:17px;">Please <a href="'.admin_url('tools.php?page=TTbackup-options').'"><strong>Click Here</strong></a> or Go to <strong>WP-Admin > Tools > TT Theme Options Export/Import</strong>. Cheers!</p></div>
						<a style="display: table; float: none; margin: 30px auto; padding: 5px 11px;" class="button-primary" href="'.admin_url('tools.php?page=TTbackup-options').'" ><strong>Open the TT Theme Options Export/Import Features</strong></a>		
			', 
			'type' => 'info'
	     );
		return $options;
	}
	add_filter( 'of_options', 'eximp_options', 9999 );



add_action( 'optionsframework_custom_scripts', 'TToptions_custom_scripts' );

function TToptions_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('.exportimport-tab').click(function() { jQuery(window).attr('location','<?php echo admin_url('tools.php?page=TTbackup-options'); ?>'); });
});
</script>

<?php
}