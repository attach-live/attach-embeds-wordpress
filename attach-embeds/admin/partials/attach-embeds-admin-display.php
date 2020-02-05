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

				settings_fields( 'attach_embeds_options' );

				do_settings_sections( 'attach_embeds_options' );

				submit_button( __('Apply', 'attach-embeds') , "default");

			?>

		</div>		
	</div>
</form>

