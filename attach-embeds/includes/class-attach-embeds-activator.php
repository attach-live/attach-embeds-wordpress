<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Attach Embeds
 * @subpackage attach-embeds/includes
 */
class Attach_Embeds_Activator {

	/**
	 *
	 * Adds two option values into  database to enable Reactions and Preview show frontend first time.  
	 * Checked two checkboxes (Enable for Posts and Enable for Blog Post Page)
	 * 
	 * @since    1.0.0
	 */
	public static function activate() {

		update_option('enable_reactions_first_time', 'enable', true);
		update_option('enable_preview_first_time', 'disable', true);
		update_option('preview_default_css', 'width:100%; padding-top:0px; padding-left:0px; padding-right:0px; padding-bottom:0px;', true);
		update_option('reaction_default_css', 'width:100%; padding-top:0px; padding-left:0px; padding-right:0px; padding-bottom:0px;', true);

	}

}
