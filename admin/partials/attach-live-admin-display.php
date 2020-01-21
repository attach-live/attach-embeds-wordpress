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

				settings_fields( 'attach_live_options' );

				do_settings_sections( 'attach_live_options' );

				submit_button("Apply", "default");

			?>

		</div>		
	</div>
</form>

