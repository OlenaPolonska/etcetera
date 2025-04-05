<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*
Plugin Name: bxSlider for WordPress
Plugin URI: https://global-s-h.com/bxsliderwp/en/
Description: This plugin will place bxSlider to your WordPress. You can change slide mode, size, speed, delay, auto start, infinite loop, etc. Optional Javascript can be added manually. Easy using slider for every themes.
Author: Kazuki Yanamoto
Version: 1.2.3
License: GPLv2 or later
Text Domain: global-s-h-bxslider
Domain Path: /languages/
*/

class BxsliderforWP
{
    public $textdomain = 'global-s-h-bxslider';
    public $plugins_url = '';

    public function __construct()
    {
        // プラグインが有効化された時
        if (function_exists('register_activation_hook')) {
            register_activation_hook(__FILE__, array($this, 'activationHook'));
        }
        //無効化
        if (function_exists('register_deactivation_hook')) {
            register_deactivation_hook(__FILE__, array($this, 'deactivationHook'));
        }
        //アンインストール
        if (function_exists('register_uninstall_hook')) {
            register_uninstall_hook(__FILE__, array($this, 'uninstallHook'));
        }

        //footer()のフッック
        add_filter('wp_footer', array($this, 'filter_footer'));

        //header()のフック (style/jQueryのリンク)
        	add_action('wp_head', array($this, 'filter_header'));
			add_action('wp_enqueue_scripts', array($this, 'bx_slider_wp_css_add'));


        //init
        add_action('init', array($this, 'init'));

        //ローカライズ
        add_action('init', array($this, 'load_textdomain'));

        //管理画面について
        add_action('admin_menu', array($this, 'bxSlider_admin_menu'));

		//ショートコード
		add_shortcode('BxSlider_for_WP', array($this, 'bx_slider_shortcode'));
		 
		//メディアアップローダの javascript API
		add_action( 'admin_print_scripts', array($this, 'my_admin_scripts'));
		
    }


    /**
     * init
     */
     public function init()
     {
         $this->plugins_url = untrailingslashit(plugins_url('', __FILE__));
     }


    /***
     * ローカライズ
    ***/
    public function load_textdomain()
    {
        load_plugin_textdomain($this->textdomain, false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }


    /**
     * プラグインが有効化された時
     *
     */
    public function activationHook()
    {
        //オプションを初期値

		//auto_start
        if (! get_option('bxslider_wp_auto_start')) {
            update_option('bxslider_wp_auto_start', 'true');
        }

        //slide_mode
        if (! get_option('bxslider_wp_slide_mode')) {
            update_option('bxslider_wp_slide_mode', 'fade');
        }

        //slide_speed
        if (! get_option('bxslider_wp_slide_speed')) {
            update_option('bxslider_wp_slide_speed', 500);
        }
 
		//slide_delay
        if (! get_option('bxslider_wp_slide_delay')) {
            update_option('bxslider_wp_slide_delay', 600);
        }
       
		//slide_size
        if (! get_option('bxslider_wp_slide_size')) {
            update_option('bxslider_wp_slide_size', 1150);
        }

		//infiniteLoop
        if (! get_option('bxslider_wp_slide_infiniteLoop')) {
            update_option('bxslider_wp_slide_infiniteLoop', 'true');
        }
    }
    
    
   /***
     * style/jQueryのリンク
    ***/
	public function bx_slider_wp_css_add(){
		
		wp_enqueue_style( 'bx-slider-link-css',plugins_url('/bx/jquery.bxslider.css',__FILE__), array());
		
	}


	function my_admin_scripts() {
	 
	    /* メディアアップローダの javascript API */
	    wp_enqueue_media();
	}


    /***
     * 無効化時に実行
    ***/
    public function deactivationHook()
    {
        delete_option('bxslider_wp_home_image_url1');
        delete_option('bxslider_wp_home_image_url2');
        delete_option('bxslider_wp_home_image_url3');
        delete_option('bxslider_wp_home_image_url4');
        delete_option('bxslider_wp_auto_start');
        delete_option('bxslider_wp_slide_mode');
        delete_option('bxslider_wp_slide_speed');
        delete_option('bxslider_wp_slide_delay');
		delete_option('bxslider_wp_slide_size');
		delete_option('bxslider_wp_slide_infiniteLoop');
		delete_option('bxslider_wp_slide_javascript');
    }


    /***
     * アンインストール時
    ***/
    public function uninstallHook()
    {
    	delete_option('bxslider_wp_home_image_url1');
        delete_option('bxslider_wp_home_image_url2');
        delete_option('bxslider_wp_home_image_url3');
        delete_option('bxslider_wp_home_image_url4');
        delete_option('bxslider_wp_auto_start');
        delete_option('bxslider_wp_slide_mode');
        delete_option('bxslider_wp_slide_speed');
        delete_option('bxslider_wp_slide_delay');
		delete_option('bxslider_wp_slide_size');
		delete_option('bxslider_wp_slide_infiniteLoop');
		delete_option('bxslider_wp_slide_javascript');
    }


    /***
     * 管理画面
    ***/
    public function bxSlider_admin_menu()
    {
        add_options_page(
            'bxSlider for WordPress', 
            __('WP bxSlider setting', $this->textdomain), 
            'manage_options',
            'WP_bxSlider_admin_menu',
            array($this, 'bxSlider_edit_setting')
        );
        
       
    }


    /***
     * 管理画面を表示
    ***/
    public function bxSlider_edit_setting()
    {
        // Include the settings page
        include(sprintf("%s/manage/admin.php", dirname(__FILE__)));
    }


	/***
     * ショートコード
    ***/
	public function bx_slider_shortcode() {
		
		$html .= '<div align="center">';
	    $html .= '<div class="bxSlider">';
	    $html .= '<div><img src="'.get_option('bxslider_wp_home_image_url1').'"></div>';

	    if (get_option('bxslider_wp_home_image_url2')) {
	    	$html .= '<div><img src="'.get_option('bxslider_wp_home_image_url2').'"></div>';
	    }

		if (get_option('bxslider_wp_home_image_url3')) {
	    	$html .= '<div><img src="'.get_option('bxslider_wp_home_image_url3').'"></div>';
	    }
	    
	    if (get_option('bxslider_wp_home_image_url4')) {
	    	$html .= '<div><img src="'.get_option('bxslider_wp_home_image_url4').'"></div>';
	    }
	    
	    if (get_option('bx_wp_btn_num')){
		    if(get_option('bx_wp_btn_num') >= 5){
			    for( $i=5; $i<= get_option('bx_wp_btn_num'); $i++ ){
			    	$html .= '<div><img src="'.get_option('bxslider_wp_home_image_url'.$i).'"></div>';
			    }
		    }
		}	 
		
	    $html .= '</div>';
	    $html .= '</div>';

	    return $html;
	}


    
    /***
     * head部分にjquery
    ***/
	public function filter_header()
	{

	?>
		
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.bxSlider').bxSlider({
				  auto: <?php echo get_option('bxslider_wp_auto_start'); ?>,
				  mode: <?php echo "'".get_option('bxslider_wp_slide_mode')."'"; ?>,
				  slideWidth: <?php echo get_option('bxslider_wp_slide_size'); ?>,
				  speed: <?php echo get_option('bxslider_wp_slide_speed'); ?>,
				  autoDelay: <?php echo get_option('bxslider_wp_slide_delay'); ?>,
				  infiniteLoop: <?php echo get_option('bxslider_wp_slide_infiniteLoop'); ?>,
				  <?php echo get_option('bxslider_wp_slide_javascript'); ?>
				});
			});
		</script>
				
	<?php
	}

    /***
    * footerの処理
    ***/
    public function filter_footer()
    {
		//JSファイル登録・指定	
		
		wp_enqueue_script( 'jquery' );
	    wp_enqueue_script( 'bx-slider-link-js',plugins_url( '/bx/jquery.bxslider.js', __FILE__ ), array());
    }

}
$BxsliderforWP = new BxsliderforWP();