<?php

/**
 * Plugin Name:       Attach Embeds
 * Plugin URI:        https://github.com/attach-live/attach-embeds-wordpress
 * Description:       The Attach plugin adds Attach social embeds to WordPress Posts and Pages. Attach Reactions lets your visitors comment your blog posts in text and video. Then others can upvote and downvote your comments.
 * Version:           1.0.0
 * Author:            Closeup, Inc.
 * Author URI:        https://www.attach.live/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       attach-embeds
 * Domain Path:       /languages
 * Namespace of plugin: attach_embeds
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'ATTACH_EMBEDS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-attach-embeds-activator.php
 */

function activate_attach_embeds() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-attach-embeds-activator.php';
	Attach_Embeds_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-attach-embeds-deactivator.php
 */
function deactivate_attach_embeds() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-attach-embeds-deactivator.php';
	Attach_Embeds_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_attach_embeds' );
register_deactivation_hook( __FILE__, 'deactivate_attach_embeds' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-attach-embeds.php';



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_attach_embeds() {

	$plugin = new Attach_Embeds();
	$plugin->run();

}
run_attach_embeds();

