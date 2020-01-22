<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Attach Embeds
 * @subpackage attach-embeds/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * @since      1.0.0
 * @package    Attach Embeds
 * @subpackage attach-embeds/public

 */

class Attach_Embeds_Public {
	/**

	 * The ID of this plugin.

	 *

	 * @since    1.0.0

	 * @access   private

	 * @var      string    $plugin_name    The ID of this plugin.

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

	 * @param      string    $plugin_name       The name of the plugin.

	 * @param      string    $version    The version of this plugin.

	 */

	public function __construct( $plugin_name, $version ) {



		$this->attach_embeds = $attach_embeds;

		$this->version = $version;



	}



	/**

	 * Register the stylesheets for the public-facing side of the site.

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



		wp_enqueue_style( $this->attach_embeds, plugin_dir_url( __FILE__ ) . 'css/attach-embeds-public.css', array(), $this->version, 'all' );



	}



	/**

	 * Register the JavaScript for the public-facing side of the site.

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



		wp_enqueue_script( $this->attach_embeds, plugin_dir_url( __FILE__ ) . 'js/attach-embeds-public.js', array( 'jquery' ), $this->version, false );



	}



	/**

	 * add meta property function.

	 *

	 * @access public

	 * @return void

	 */

	public function attach_embeds_add_meta_property() {

		$options = get_option( 'attach_embeds_settings' );
		$options['attach_embeds_text_evaluation_key'] = sanitize_text_field($options['attach_embeds_text_evaluation_key']);
		$options['attach_embeds_text_domain_verification_code'] = sanitize_text_field($options['attach_embeds_text_domain_verification_code']);

		$eval_key = '';

		if ( isset ( $options['attach_embeds_text_evaluation_key'] ) ){

			$eval_key = $options['attach_embeds_text_evaluation_key'];

		}

		if ( isset ( $options['attach_embeds_text_domain_verification_code'] ) ){

			$verification_code = $options['attach_embeds_text_domain_verification_code'];

		}



			$metatag = '<meta property="attach:site-verification" content="" />';

			$metatag .= '<script src="https://embeds.attach.live/v1" defer></script>';

			$metatag .= '<meta property="attach:evaluation-key" content="'.$eval_key.'">';

			$metatag .= '<meta property="attach:site-verification" content="'.$verification_code.'" />';

			echo $metatag;

		}

		

	public function attach_embeds_show_reactions( $content ) {

		$options = get_option( 'attach_embeds_reactions_settings' );
		$options_react = get_option( 'enable_reactions_first_time' );
        $options['attach_embeds_styles_reaction'] = sanitize_text_field($options['attach_embeds_styles_reaction']);
				

		if ( is_single() && in_the_loop() && is_main_query() && ( $options_react == 'enable' ||	$options['attach_embeds_enable_reaction_posts'] == 'enable' ) ) {

            global $post; $id = $post->ID; $permalink = get_permalink($id);
	        
			$reactions_content = $content;

			$reactions_content .= '<div class="attach-reactions" data-property-item="'.$permalink.'"></div>';

	        $reactions_content .= '<style>.attach-reactions{';

    	        if ( isset ( $options['attach_embeds_styles_reaction'] ) && $options['attach_embeds_styles_reaction'] != ''){

    	            $reactions_content .= $options['attach_embeds_styles_reaction']; 

    	            }else{

    	            $reactions_content .= 'width: 100%;height: 800px;';

    	           }  

	        $reactions_content .= '}</style>';

    

			return $reactions_content;

	    }else{
	        return $content;
	        }



	

		}



public function attach_embeds_show_previews( $content ) {
    
    $options = get_option( 'attach_embeds_preview_settings' );
	$options_preview = get_option( 'enable_preview_first_time' );
	$options['attach_embeds_styles_preview'] = sanitize_text_field($options['attach_embeds_styles_preview']);

    if ( (!is_single()) && (get_post_type() == 'post') && in_the_loop() && is_main_query() && ( $options_preview == 'enable' || $options['attach_embeds_enable_preview_posts'] == 'enable')) {

        global $post; $id= $post->ID; $permalink = get_permalink($id); $has_run = true;
        if($has_run){
        $preview_content = $content;
		$preview_content .= '<div class="attach-preview" data-property-item="'.$permalink.'"></div>';
	    $preview_content .= '<style>.attach-preview{';
    	        if ( isset ( $options['attach_embeds_styles_preview'] ) and $options['attach_embeds_styles_preview'] != ''){

    	            $preview_content .= $options['attach_embeds_styles_preview']; 

    	            }else{

    	            $preview_content .= 'width:100%;height:75px;';

    	           }  
	    $preview_content .= '}</style>';
        
        
		return $preview_content;
        }
	    $has_run = false;

		}else{
		    return $content;
		    }

    }

    

    

    // Shortcode initialize



public function attach_embeds_shortcodes(){

    

    add_shortcode('attach_embeds', array($this, 'attach_embeds_shortcode_function'));

    

    }

    

public function attach_embeds_shortcode_function($atts){

    ob_start();

	$shortcode_atts = shortcode_atts( array(

		'id' => 'reactions'

	), $atts );

	$options = get_option( 'attach_embeds_settings' );
	$options['attach_embeds_styles_reaction'] = sanitize_text_field($options['attach_embeds_styles_reaction']);
	$options['attach_embeds_styles_preview'] = sanitize_text_field($options['attach_embeds_styles_preview']);
	global $post;

	$id= $post->ID;

	$permalink = get_permalink($id);

	?>

	<?php if($shortcode_atts['id']=='reactions') { ?>

	<div class="attach-reactions" data-property-item="<?php echo $permalink; ?>"></div>

	<style>.attach-reactions{

	<?php

	$reactions_content='';

	if ( isset ( $options['attach_embeds_styles_reaction'] ) and $options['attach_embeds_styles_reaction'] != ''){

    	            $reactions_content .= $options['attach_embeds_styles_reaction']; 

    	            }else{

    	            $reactions_content .= 'width: 100%;height: 800px;';

    }

    echo $reactions_content;

	?>

	}</style>

	<?php } ?>

	

	<?php if($shortcode_atts['id']=='preview') { ?>

	<div class="attach-preview" data-property-item="<?php echo $permalink; ?>"></div>

	<style>.attach-preview{

	<?php

	$preview_content='';

	if ( isset ( $options['attach_embeds_styles_preview'] ) and $options['attach_embeds_styles_preview'] != ''){	    

    	            $preview_content .= $options['attach_embeds_styles_preview']; 

    	            }else{

    	            $preview_content .= 'width:100%;height:75px;';

    	           }  

    echo $preview_content;

	?>

	}</style>

	<?php } 

	return ob_get_clean();

    }

}

