<?php

/**
 * The admin-specific functionality of the plugin.
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class Attach_Live_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $attach_live    The ID of this plugin.
	 */
	private $attach_live;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $attach_live       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $attach_live, $version ) {

		$this->attach_live = $attach_live;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->attach_live, plugin_dir_url( __FILE__ ) . 'css/attach-live-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( 'attach-live-admin-script', plugin_dir_url( __FILE__ ) . 'js/attach-live-admin.js', array( 'jquery' ), $this->version, true );
		
	}

	public function attach_live_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
	     *
	     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
	     *
	     */

		add_menu_page( 'Attach', 'Attach', 'manage_options', 'attach_live_settings', array( $this, 'display_plugin_setup_page' ), plugins_url('images/icon-attach-live.jpg', __FILE__), 54 );
		add_submenu_page( 'attach_live_settings', 'Setup', 'Setup', 'manage_options', 'attach_live_settings' );
		add_submenu_page( 'attach_live_settings', 'Reactions Embed', 'Reactions Embed', 'manage_options', 'attach_live_reactions', array( $this, 'display_plugin_reactions_page' ) );
		add_submenu_page( 'attach_live_settings', 'Preview Embed', 'Preview Embed', 'manage_options', 'attach_live_preview', array( $this, 'display_plugin_preview_page' ) );
	
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
	    include_once( 'partials/attach-live-admin-display.php' );
	}

	
	public function display_plugin_reactions_page() {
	    include_once( 'partials/attach-live-reactions-display.php' );
	}

	public function display_plugin_preview_page() {
	    include_once( 'partials/attach-live-preview-display.php' );
	}
	/**
	 * admin init function.
	 *
	 * @access public
	 * @return void
	 */		
	public function attach_live_admin_init() {
		register_setting( 'attach_live_options', 'attach_live_settings', array($this, 'validate_attach_live_settings') );
		register_setting( 'attach_live_reactions', 'attach_live_reactions_settings', array($this, 'validate_attach_live_reactions_settings') );
		register_setting( 'attach_live_preview', 'attach_live_preview_settings', array($this, 'validate_attach_live_preview_settings') );
	
		add_settings_section(
			'attach_live_settings_section', 
			'', 
			array($this, 'attach_live_settings_section_callback'), 
			'attach_live_options'
		);
		add_settings_section(
			'attach_live_configure_section', 
			'', 
			array($this, 'attach_live_configure_section_callback'), 
			'attach_live_options'
		);

		add_settings_section(
			'attach_live_reactions_section', 
			'', 
			array($this, 'attach_live_reactions_section_callback'), 
			'attach_live_reactions'
		);

		add_settings_section(
			'attach_live_previews_section', 
			'', 
			array($this, 'attach_live_previews_section_callback'), 
			'attach_live_preview'
		);
		
		add_settings_field( 
			'attach_live_text_evaluation_key', 
			__( 'Evaluation Key', 'attach-live' ), 
			array($this, 'attach_live_text_evaluation_key'), 
			'attach_live_options', 
			'attach_live_settings_section',
			array('class'=>'attach-live-settings-section') 
		);

		add_settings_field( 
			'attach_live_text_domain_verification_code', 
			__( 'Domain Verification Code', 'attach-live' ), 
			array($this, 'attach_live_text_domain_verification_code'), 
			'attach_live_options', 
			'attach_live_settings_section',
			array('class'=>'attach-live-settings-section')
		);

		add_settings_field( 
			'attach_live_enable_reaction_posts', 
			__( '', 'attach-live' ), 
			array($this, 'attach_live_enable_reaction_posts'), 
			'attach_live_reactions', 
			'attach_live_reactions_section',
			array('class'=>'attach-live-reactions-section')
		);

		add_settings_field( 
			'attach_live_styles_reaction', 
			__( '', 'attach-live' ), 
			array($this, 'attach_live_styles_reaction'), 
			'attach_live_reactions', 
			'attach_live_reactions_section',
			array('class'=>'attach-live-reactions-section') 
		);

		add_settings_field( 
			'attach_live_enable_preview_posts', 
			__( '', 'attach-live' ), 
			array($this, 'attach_live_enable_preview_posts'), 
			'attach_live_preview', 
			'attach_live_previews_section',
			array('class'=>'attach-live-previews-section')
		);

		add_settings_field( 
			'attach_live_styles_preview', 
			__( '', 'attach-live' ), 
			array($this, 'attach_live_styles_preview'), 
			'attach_live_preview', 
			'attach_live_previews_section',
			array('class'=>'attach-live-previews-section') 
		);
		
	}	

	public function validate_attach_live_settings($input){
		$input['attach_live_text_evaluation_key'] = 	wp_filter_nohtml_kses($input['attach_live_text_evaluation_key']);
		$input['attach_live_text_domain_verification_code'] = 	wp_filter_nohtml_kses($input['attach_live_text_domain_verification_code']);
		return $input;

	}

	public function validate_attach_live_reactions_settings($input){
		$input['attach_live_enable_reaction_posts'] = 	wp_filter_nohtml_kses($input['attach_live_enable_reaction_posts']);
		$input['attach_live_styles_reaction'] = 	wp_filter_nohtml_kses($input['attach_live_styles_reaction']);
		update_option('enable_reactions_first_time', 'disable', true);
		return $input;
		
	}
	public function validate_attach_live_preview_settings($input){
		$input['attach_live_enable_preview_posts'] = 	wp_filter_nohtml_kses($input['attach_live_enable_preview_posts']);
		$input['attach_live_styles_preview'] = 	wp_filter_nohtml_kses($input['attach_live_styles_preview']);
		update_option('enable_preview_first_time', 'disable', true);
		return $input;

	}
	
	/**
	 * attach_live_text_evaluation_key function.
	 *
	 * @access public
	 * @return void
	 */		
	function attach_live_text_evaluation_key(  ) {
		$options = get_option( 'attach_live_settings' );
		if ( !isset ( $options['attach_live_text_evaluation_key'] ) )
			$options['attach_live_text_evaluation_key'] = '';
		?>
		<input type='text' size='27' name='attach_live_settings[attach_live_text_evaluation_key]' 
        	   value = <?php echo sanitize_text_field($options['attach_live_text_evaluation_key']) ?> >
	
			
			<a class="help-link" href="<?php echo esc_url('https://developers.attach.live/organizations/latest/projects/latest/evaluation')?>" target="_new">
			<?php _e( 'Create an account or get a key ', 'attach-live' ) ?>
			</a>
			
		
		<?php
	} 

	function attach_live_text_domain_verification_code(  ) {
		$options = get_option( 'attach_live_settings' );
		if ( !isset ( $options['attach_live_text_domain_verification_code'] ) )
			$options['attach_live_text_domain_verification_code'] = '';
		?>
		<input type='text' size='27' name='attach_live_settings[attach_live_text_domain_verification_code]' 
        	   value = <?php echo sanitize_text_field($options['attach_live_text_domain_verification_code']) ?> >
		
			
			<a class="help-link" href="<?php echo esc_url('https://developers.attach.live/organizations/latest/domains')?>" target="_new">
			<?php _e( 'Validate your domain ', 'attach-live' ) ?>
			</a>
			
		<?php
	}
	/**
	 * attach_live_settings_section_callback function.
	 *
	 * @access public
	 * @return void
	 */		
	function attach_live_settings_section_callback() { 
	
		echo '<h1 class="section-title"> Setup </h1>
		<p style="margin-top: 30px;">For an evaluation key, register with Attach and create an account, 
		then copy the key here. Evaluation projects can be run on localhost, but no feeds will be sent to the Attach social network. 
		Once you are ready for serving to your customers, verify your domain and click “Start serving” 
		on the “Production” tab in the Attach developer platform. Your evaluation key will automatically expire after the time you 
		have set and you will need to get a new key to continue developing once expired.
		</p>
		<!--<a class="help-link" class="attach-live-settings-section" href="https://youtube.com" target="_blank">Watch a video how to get started with Attach</a>-->';

	}

	function attach_live_configure_section_callback(){

		$brandingUrl = "https://developers.attach.live/organizations/latest/projects/latest/branding";
		$augmentedRealityUrl = "https://developers.attach.live/organizations/latest/projects/latest/ar";
		$distribution = "https://developers.attach.live/organizations/latest/projects/latest/distribution";
	
		echo '<table class="form-table attach-live-settings-section" role="presentation"><tbody>
		<tr><th scope="row"></th><td>
		<div class="attach-live-two-third">
		<select id="brand-aug-dist">
		<option value="'.$brandingUrl.'">Branding</option>
		<option value="'.$augmentedRealityUrl.'">Augmented Reality</option>
		<option value="'.$distribution.'">Distribution</option>
		</select>	
		</div>
		<div class="attach-live-one-third">
		<a id="brand-aug-dist-config" class="button button-default" 
		href="https://developers.attach.live/organizations/latest/projects/latest/branding" target="_blank">Configure</a>
		</div>
		</td></tr></tbody></table>';
	}

	function attach_live_reactions_section_callback(){
		echo '<h1 class="section-title"> Reactions Embed </h1>
		<p style="margin-top: 30px;">The Reactions Embed is enabled for all Posts by default. 
		If you wish to control where the embed is placed, disable it here and use the shortcode in your templates, instead.
		</p>';
	}

	function attach_live_enable_reaction_posts() {
		$options = get_option( 'attach_live_reactions_settings' );
		$options_react = get_option( 'enable_reactions_first_time' );
	
		if($options_react == 'enable'){
			$options['attach_live_enable_reaction_posts'] = 'enable';
		}elseif ( !isset ( $options['attach_live_enable_reaction_posts'] ) || $options['attach_live_enable_reaction_posts'] =='' ){
			$options['attach_live_enable_reaction_posts'] = 'disable';
		}else{
			$options['attach_live_enable_reaction_posts'] = 'enable';
		}
			
		?>
		<input type="checkbox" class="ios8-switch" id="attach_live_light" name='attach_live_reactions_settings[attach_live_enable_reaction_posts]' value='enable' 
				<?php echo ($options['attach_live_enable_reaction_posts'] == 'enable') ? 'checked' : '' ?> > 
				<label for="attach_live_light"><b><?php echo __( 'Enable for Posts', 'attach-live' ) ?></b><br/></label>
		<?php
		
	}


	function attach_live_styles_reaction(){
		$options = get_option( 'attach_live_reactions_settings' );
		if ( !isset ( $options['attach_live_styles_reaction'] ) )
			$options['attach_live_styles_reaction'] = '';
			$options['attach_live_styles_reaction'] = trim(preg_replace('/\s+/', ' ', $options['attach_live_styles_reaction']));
		?>
		<span class="code-style">&lt;style&gt;</span>
		<textarea class="code-field" rows="4" cols="50" name='attach_live_reactions_settings[attach_live_styles_reaction]'><?php
		if($options['attach_live_styles_reaction'] == ''){
			$style_reactions="width:100vw; height:400px;";
			echo str_replace(' ',"\n",$style_reactions);
		}else{
			$options['attach_live_styles_reaction'] = sanitize_text_field($options['attach_live_styles_reaction']);
			echo str_replace(' ',"\n",$options['attach_live_styles_reaction']);
		}
			
		?></textarea>
			
		<span class="code-style">&lt;&sol;style&gt;</span>
		
			<a style="margin-top:30px;display:inline-block" href="<?php echo esc_url('https://developers.attach.live/organizations/latest/projects/latest/embeds/reactions')?>" target="_new">
			<?php _e( 'Configure visuals ', 'attach-live' ) ?>
			</a>
			
		<?php
	}
	function attach_live_previews_section_callback(){
		echo '<h1 class="section-title"> Preview Embed </h1>
		<p style="margin-top: 30px;">The Preview Embed is enabled on the Blog Posts Page by default. 
		If you wish to control where the embed is placed, disable it here and use the shortcode in your templates, instead.</p>';
	}

	function attach_live_enable_preview_posts() {
		$options = get_option( 'attach_live_preview_settings' );
		$options_preview = get_option( 'enable_preview_first_time' );

		if($options_preview == 'enable'){
			$options['attach_live_enable_preview_posts'] = 'enable';
		}elseif ( !isset ( $options['attach_live_enable_preview_posts'] ) || $options['attach_live_enable_preview_posts'] =='' ){
			$options['attach_live_enable_preview_posts'] = 'disable';
		}else{
			$options['attach_live_enable_preview_posts'] = 'enable';
		}
			
		?>
		<input type="checkbox" class="ios8-switch" id="attach_live_light" name='attach_live_preview_settings[attach_live_enable_preview_posts]' value='enable' 
				<?php echo ($options['attach_live_enable_preview_posts'] == 'enable') ? 'checked' : '' ?> > 
				<label for="attach_live_light"><b><?php echo __( 'Enable for Blog Post Page', 'attach-live' ) ?></b><br/></label>
		<?php
		
	}


	function attach_live_styles_preview(){
		$options = get_option( 'attach_live_preview_settings' );
		if ( !isset ( $options['attach_live_styles_preview'] ) )
			$options['attach_live_styles_preview'] = '';
			$options['attach_live_styles_preview'] = trim(preg_replace('/\s+/', ' ', $options['attach_live_styles_preview']));
		?>
		<span class="code-style">&lt;style&gt;</span>
		<textarea class="code-field" rows="4" cols="50" name='attach_live_preview_settings[attach_live_styles_preview]'><?php 
		
		if($options['attach_live_styles_preview'] == ''){
			$style_preview="width:100vw; height:72px;";
			echo str_replace(' ',"\n",$style_preview);
		}else{
			$options['attach_live_styles_preview'] = sanitize_text_field($options['attach_live_styles_preview']);
			echo str_replace(' ',"\n",$options['attach_live_styles_preview']);
		}
		
		?></textarea>
		<span class="code-style">&lt;&sol;style&gt;</span>
		
			
			<a style="margin-top:30px;display:inline-block" href="<?php echo esc_url('https://developers.attach.live/organizations/latest/projects/latest/embeds/preview')?>" target="_new">
			<?php _e( 'Configure visuals ', 'attach-live' ) ?>
			</a>
		
		<?php
	}

}
