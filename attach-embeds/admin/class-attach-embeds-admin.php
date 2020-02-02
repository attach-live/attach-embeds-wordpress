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
class Attach_Embeds_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $attach_embeds    The ID of this plugin.
	 */
	private $attach_embeds;

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
	 * @param      string    $attach_embeds       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $attach_embeds, $version ) {

		$this->attach_embeds = $attach_embeds;
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

		wp_enqueue_style( $this->attach_embeds, plugin_dir_url( __FILE__ ) . 'css/attach-embeds-admin.css', array(), $this->version, 'all' );

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
		
		wp_enqueue_script( 'attach-embeds-admin-script', plugin_dir_url( __FILE__ ) . 'js/attach-embeds-admin.js', array( 'jquery' ), $this->version, true );
		
	}

	public function attach_embeds_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
	     *
	     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
	     *
	     */

		add_menu_page( 'Attach', 'Attach', 'manage_options', 'attach_embeds_settings', array( $this, 'display_plugin_setup_page' ), plugins_url('images/icon-attach-embeds.jpg', __FILE__), 99 );
		add_submenu_page( 'attach_embeds_settings', 'Setup', 'Setup', 'manage_options', 'attach_embeds_settings' );
		add_submenu_page( 'attach_embeds_settings', 'Reactions Embed', 'Reactions Embed', 'manage_options', 'attach_embeds_reactions', array( $this, 'display_plugin_reactions_page' ) );
		add_submenu_page( 'attach_embeds_settings', 'Preview Embed', 'Preview Embed', 'manage_options', 'attach_embeds_preview', array( $this, 'display_plugin_preview_page' ) );
	
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
	    include_once( 'partials/attach-embeds-admin-display.php' );
	}

	
	public function display_plugin_reactions_page() {
	    include_once( 'partials/attach-embeds-reactions-display.php' );
	}

	public function display_plugin_preview_page() {
	    include_once( 'partials/attach-embeds-preview-display.php' );
	}
	/**
	 * admin init function.
	 *
	 * @access public
	 * @return void
	 */		
	public function attach_embeds_admin_init() {
		register_setting( 'attach_embeds_options', 'attach_embeds_settings', array($this, 'validate_attach_embeds_settings') );
		register_setting( 'attach_embeds_reactions', 'attach_embeds_reactions_settings', array($this, 'validate_attach_embeds_reactions_settings') );
		register_setting( 'attach_embeds_preview', 'attach_embeds_preview_settings', array($this, 'validate_attach_embeds_preview_settings') );
	
		add_settings_section(
			'attach_embeds_settings_section', 
			'', 
			array($this, 'attach_embeds_settings_section_callback'), 
			'attach_embeds_options'
		);
		add_settings_section(
			'attach_embeds_configure_section', 
			'', 
			array($this, 'attach_embeds_configure_section_callback'), 
			'attach_embeds_options'
		);

		add_settings_section(
			'attach_embeds_reactions_section', 
			'', 
			array($this, 'attach_embeds_reactions_section_callback'), 
			'attach_embeds_reactions'
		);

		add_settings_section(
			'attach_embeds_previews_section', 
			'', 
			array($this, 'attach_embeds_previews_section_callback'), 
			'attach_embeds_preview'
		);
		
		add_settings_field( 
			'attach_embeds_text_evaluation_key', 
			__( 'Evaluation Key', 'attach-embeds' ), 
			array($this, 'attach_embeds_text_evaluation_key'), 
			'attach_embeds_options', 
			'attach_embeds_settings_section',
			array('class'=>'attach-embeds-settings-section') 
		);

		add_settings_field( 
			'attach_embeds_text_domain_verification_code', 
			__( 'Domain Verification Code', 'attach-embeds' ), 
			array($this, 'attach_embeds_text_domain_verification_code'), 
			'attach_embeds_options', 
			'attach_embeds_settings_section',
			array('class'=>'attach-embeds-settings-section')
		);

		add_settings_field( 
			'attach_embeds_enable_reaction_posts', 
			__( '', 'attach-embeds' ), 
			array($this, 'attach_embeds_enable_reaction_posts'), 
			'attach_embeds_reactions', 
			'attach_embeds_reactions_section',
			array('class'=>'attach-embeds-reactions-section')
		);

		add_settings_field( 
			'attach_embeds_styles_reaction', 
			__( '', 'attach-embeds' ), 
			array($this, 'attach_embeds_styles_reaction'), 
			'attach_embeds_reactions', 
			'attach_embeds_reactions_section',
			array('class'=>'attach-embeds-reactions-section') 
		);

		add_settings_field( 
			'attach_embeds_enable_preview_posts', 
			__( '', 'attach-embeds' ), 
			array($this, 'attach_embeds_enable_preview_posts'), 
			'attach_embeds_preview', 
			'attach_embeds_previews_section',
			array('class'=>'attach-embeds-previews-section')
		);

		add_settings_field( 
			'attach_embeds_styles_preview', 
			__( '', 'attach-embeds' ), 
			array($this, 'attach_embeds_styles_preview'), 
			'attach_embeds_preview', 
			'attach_embeds_previews_section',
			array('class'=>'attach-embeds-previews-section') 
		);
		
	}	

	public function validate_attach_embeds_settings($input){
		$input['attach_embeds_text_evaluation_key'] = 	wp_filter_nohtml_kses($input['attach_embeds_text_evaluation_key']);
		$input['attach_embeds_text_domain_verification_code'] = 	wp_filter_nohtml_kses($input['attach_embeds_text_domain_verification_code']);
		return $input;

	}

	public function validate_attach_embeds_reactions_settings($input){
		$input['attach_embeds_enable_reaction_posts'] = 	wp_filter_nohtml_kses($input['attach_embeds_enable_reaction_posts']);
		$input['attach_embeds_styles_reaction'] = 	wp_filter_nohtml_kses($input['attach_embeds_styles_reaction']);
		update_option('enable_reactions_first_time', 'disable', true);
		return $input;
		
	}
	public function validate_attach_embeds_preview_settings($input){
		$input['attach_embeds_enable_preview_posts'] = 	wp_filter_nohtml_kses($input['attach_embeds_enable_preview_posts']);
		$input['attach_embeds_styles_preview'] = 	wp_filter_nohtml_kses($input['attach_embeds_styles_preview']);
		update_option('enable_preview_first_time', 'disable', true);
		return $input;

	}
	
	/**
	 * attach_embeds_text_evaluation_key function.
	 *
	 * @access public
	 * @return void
	 */		
	function attach_embeds_text_evaluation_key(  ) {
		$options = get_option( 'attach_embeds_settings' );
		if ( !isset ( $options['attach_embeds_text_evaluation_key'] ) )
			$options['attach_embeds_text_evaluation_key'] = '';
		?>
		<input type='text' size='27' name='attach_embeds_settings[attach_embeds_text_evaluation_key]' 
        	   value = <?php echo sanitize_text_field($options['attach_embeds_text_evaluation_key']) ?> >
	
			
			<a class="help-link" href="<?php echo esc_url('https://developers.attach.live/organizations/latest/projects/latest/evaluation')?>" target="_new">
			<?php _e( 'Create an account or get a key ', 'attach-embeds' ) ?>
			</a>
			
		
		<?php
	} 

	function attach_embeds_text_domain_verification_code(  ) {
		$options = get_option( 'attach_embeds_settings' );
		if ( !isset ( $options['attach_embeds_text_domain_verification_code'] ) )
			$options['attach_embeds_text_domain_verification_code'] = '';
		?>
		<input type='text' size='27' name='attach_embeds_settings[attach_embeds_text_domain_verification_code]' 
        	   value = <?php echo sanitize_text_field($options['attach_embeds_text_domain_verification_code']) ?> >
		
			
			<a class="help-link" href="<?php echo esc_url('https://developers.attach.live/organizations/latest/domains')?>" target="_new">
			<?php _e( 'Validate your domain ', 'attach-embeds' ) ?>
			</a>
			
		<?php
	}
	/**
	 * attach_embeds_settings_section_callback function.
	 *
	 * @access public
	 * @return void
	 */		
	function attach_embeds_settings_section_callback() { 
	
		echo '<h1 class="section-title">' . esc_html__('Setup', 'attach-embeds') . '</h1>
		<p style="margin-top: 30px;">' . esc_html__('For an evaluation key, register with Attach and create an account, 
		then copy the key here. Evaluation projects can be run on localhost, but no feeds will be sent to the Attach social network. 
		Once you are ready for serving to your customers, verify your domain and click “Start serving” 
		on the “Production” tab in the Attach developer platform. Your evaluation key will automatically expire after the time you 
		have set and you will need to get a new key to continue developing once expired.', 'attach-embeds') . 
		'</p>
		<!--<a class="help-link" class="attach-embeds-settings-section" href="https://youtube.com" target="_blank">'.esc_html__('Watch a video how to get started with Attach.','attach-embeds') .'</a>-->';

	}

	function attach_embeds_configure_section_callback(){

		$brandingUrl = "https://developers.attach.live/organizations/latest/projects/latest/branding";
		$augmentedRealityUrl = "https://developers.attach.live/organizations/latest/projects/latest/ar";
		$distribution = "https://developers.attach.live/organizations/latest/projects/latest/distribution";
	
		echo '<table class="form-table attach-embeds-settings-section" role="presentation"><tbody>
		<tr><th scope="row"></th><td>
		<div class="attach-embeds-two-third">
		<select id="brand-aug-dist">
		<option value="'.$brandingUrl.'">' . esc_html__('Branding','attach-embeds') . '</option>
		<option value="'.$augmentedRealityUrl.'">' . esc_html__('Augmented Reality','attach-embeds') . '</option>
		<option value="'.$distribution.'">' . esc_html__('Distribution','attach-embeds') . '</option>
		</select>	
		</div>
		<div class="attach-embeds-one-third">
		<a id="brand-aug-dist-config" class="button button-default" 
		href="https://developers.attach.live/organizations/latest/projects/latest/branding" target="_blank">' . esc_html__('Configure','attach-embeds') . '</a>
		</div>
		</td></tr></tbody></table>';
	}

	function attach_embeds_reactions_section_callback(){
		echo '<h1 class="section-title"> Reactions Embed </h1>
		<p style="margin-top: 30px;">' . esc_html__('The Reactions Embed is enabled for all Posts by default. If you wish to control where the embed is placed, disable it here and use the shortcode in your templates, instead.','attach-embeds') . '</p>';
	}

	function attach_embeds_enable_reaction_posts() {
		$options = get_option( 'attach_embeds_reactions_settings' );
		$options_react = get_option( 'enable_reactions_first_time' );
	
		if($options_react == 'enable'){
			$options['attach_embeds_enable_reaction_posts'] = 'enable';
		}elseif ( !isset ( $options['attach_embeds_enable_reaction_posts'] ) || $options['attach_embeds_enable_reaction_posts'] =='' ){
			$options['attach_embeds_enable_reaction_posts'] = 'disable';
		}else{
			$options['attach_embeds_enable_reaction_posts'] = 'enable';
		}
			
		?>
		<input type="checkbox" class="ios8-switch" id="attach_embeds_light" name='attach_embeds_reactions_settings[attach_embeds_enable_reaction_posts]' value='enable' 
				<?php echo ($options['attach_embeds_enable_reaction_posts'] == 'enable') ? 'checked' : '' ?> > 
				<label for="attach_embeds_light"><b><?php echo __( 'Enable for Posts', 'attach-embeds' ) ?></b><br/></label>
		<?php
		
	}


	function attach_embeds_styles_reaction(){
		$options = get_option( 'attach_embeds_reactions_settings' );
		if ( !isset ( $options['attach_embeds_styles_reaction'] ) )
			$options['attach_embeds_styles_reaction'] = '';
			$options['attach_embeds_styles_reaction'] = trim(preg_replace('/\s+/', ' ', $options['attach_embeds_styles_reaction']));
		?>
		<span class="code-style">&lt;style&gt;</span>
		<span class="code-style">.attach-reactions{</span>
		<textarea class="code-field" rows="4" cols="50" name='attach_embeds_reactions_settings[attach_embeds_styles_reaction]'><?php
		if($options['attach_embeds_styles_reaction'] == ''){
			$style_reactions="width:100%; height:800px;";
			echo str_replace(' ',"\n",$style_reactions);
		}else{
			$options['attach_embeds_styles_reaction'] = sanitize_text_field($options['attach_embeds_styles_reaction']);
			$g = str_replace(';',";\n",$options['attach_embeds_styles_reaction']);
			echo str_replace(':',": ",$g);
		}
			
		?></textarea>
		<span class="code-style">}</span>	
		<span class="code-style">&lt;&sol;style&gt;</span>
		
			<a style="margin-top:30px;display:inline-block" href="<?php echo esc_url('https://developers.attach.live/organizations/latest/projects/latest/embeds/reactions')?>" target="_new">
			<?php _e( 'Configure visuals ', 'attach-embeds' ) ?>
			</a>
			
		<?php
	}
	function attach_embeds_previews_section_callback(){
		echo '<h1 class="section-title"> Preview Embed </h1>
		<p style="margin-top: 30px;">' . esc_html__('The Preview Embed is enabled on the Blog Posts Page by default. 
		If you wish to control where the embed is placed, disable it here and use the shortcode in your templates, instead.','attach-embeds') . '</p>';
	}

	function attach_embeds_enable_preview_posts() {
		$options = get_option( 'attach_embeds_preview_settings' );
		$options_preview = get_option( 'enable_preview_first_time' );

		if($options_preview == 'enable'){
			$options['attach_embeds_enable_preview_posts'] = 'enable';
		}elseif ( !isset ( $options['attach_embeds_enable_preview_posts'] ) || $options['attach_embeds_enable_preview_posts'] =='' ){
			$options['attach_embeds_enable_preview_posts'] = 'disable';
		}else{
			$options['attach_embeds_enable_preview_posts'] = 'enable';
		}
			
		?>
		<input type="checkbox" class="" id="attach_embeds_light" name='attach_embeds_preview_settings[attach_embeds_enable_preview_posts]' value='enable' 
				<?php echo ($options['attach_embeds_enable_preview_posts'] == 'enable') ? 'checked' : '' ?> > 
				<label for="attach_embeds_light"><b><?php echo __( 'Enable for Blog Post Page', 'attach-embeds' ) ?></b><br/></label>
		<?php
		
	}


	function attach_embeds_styles_preview(){
		$options = get_option( 'attach_embeds_preview_settings' );
		if ( !isset ( $options['attach_embeds_styles_preview'] ) )
			$options['attach_embeds_styles_preview'] = '';
			$options['attach_embeds_styles_preview'] = trim(preg_replace('/\s+/', ' ', $options['attach_embeds_styles_preview']));
		?>
		<span class="code-style">&lt;style&gt;</span>
		<span class="code-style">.attach-preview{</span>
		<textarea class="code-field" rows="4" cols="50" name='attach_embeds_preview_settings[attach_embeds_styles_preview]'><?php 
		
		if($options['attach_embeds_styles_preview'] == ''){
			$style_preview="width:100%; height:75px;";
			echo str_replace(' ',"\n",$style_preview);
		}else{
			$options['attach_embeds_styles_preview'] = sanitize_text_field($options['attach_embeds_styles_preview']);
			$g = str_replace(';',";\n",$options['attach_embeds_styles_preview']);
			echo str_replace(':',": ",$g);
		}
		
		?></textarea>
		<span class="code-style">}</span>
		<span class="code-style">&lt;&sol;style&gt;</span>
		
			
			<a style="margin-top:30px;display:inline-block" href="<?php echo esc_url('https://developers.attach.live/organizations/latest/projects/latest/embeds/preview')?>" target="_new">
			<?php _e( 'Configure visuals ', 'attach-embeds' ) ?>
			</a>
		
		<?php
	}

}
