<?php
/**
 * Provide a admin area view for the plugin
 * This file is used to markup the admin-facing aspects of the plugin.
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form action='options.php' method='post'>

	<div class="attach_embeds_wrap">

	<div id="attach-embeds-services-block">

		<?php

		settings_fields( 'attach_embeds_reactions' );

		do_settings_sections( 'attach_embeds_reactions' );

		submit_button( __('Apply', 'attach-embeds') , "default");


		?>

		<p>Shortcode: <span id="copy-target">[attach_embeds id="reactions"]</span>
		<span id="copy-btn" class="copy-btn" data-clipboard-action="copy" data-clipboard-target="#copy-target">
		<?php _e('Copy', 'attach-embeds') ?>
		</span>
		</p>
	</div>	
	</div>	


	</form>

