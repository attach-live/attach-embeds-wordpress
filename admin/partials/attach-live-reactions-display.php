<?php
/**
 * Provide a admin area view for the plugin
 * This file is used to markup the admin-facing aspects of the plugin.
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form action='options.php' method='post'>

	<div class="attach_live_wrap">

	<div id="attach-live-services-block">

	<?php if(!is_ssl()){ ?>
		<div class="notice notice-error">
                <p><?php _e('This plugin requires a secure https connection.', 'attach-live') ?></p>
            </div>
	<?php } ?> 
		
		<?php

		settings_fields( 'attach_live_reactions' );

		do_settings_sections( 'attach_live_reactions' );

		submit_button("Apply", "default");


		?>

		<p>Shortcode: <span id="copy-target">[attach_live id="reactions"]</span>
		<span id="copy-btn" class="copy-btn" data-clipboard-action="copy" data-clipboard-target="#copy-target">Copy</span></p>
	</div>	
	</div>	


	</form>

