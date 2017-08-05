<?php
/*
Plugin Name: LJXDM Wordpress phpinfo()
Plugin URI: https://github.com/ljxdm/wp-php-info
Description:  Displays phpinfo() in Wordpress Settings menu.
Author: LJXDM
Version: 19
Author URI: https://lojinx.digital
*/

defined( 'ABSPATH' ) or die( 'No.' );

$ljxdm_wp_phpinfo = new ljxdm_wp_phpinfo;

/**
 * WordPress phpinfo() core
 *
 * @link		https://github.com/ljxdm/wp-php-info
 * @package 	LJXDM phpinfo()
 *
 */

class ljxdm_wp_phpinfo {
	
	 /**
	  * Constructor
	  *
      * @access public
      * @static
	  * @uses http://codex.wordpress.org/Function_Reference/add_action
	  */

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'ljxdm_wp_admin_enqueue_scripts' ) );
     	add_action( 'admin_menu', array( $this, 'ljxdm_wp_admin_menu' ) );
    }
 

	/**
	  * ljxdm_admin_enqueue_scripts 
	  *
      * @access public
      * @static
	  * @uses http://codex.wordpress.org/Function_Reference/wp_enqueue_style
      *
	  */
	function ljxdm_wp_admin_enqueue_scripts() {
		if(isset($_GET['page'])) {
			if('ljxdm_wp_phpinfo' != $_GET['page']) return;
			wp_register_style('ljxdm_wp_phpinfo', plugin_dir_url( __FILE__ ) . 'css/ljxdm-wp-php-info.css', false);
		    wp_enqueue_style('ljxdm_wp_phpinfo');
		}
	}

	/**
	  * ljxdm_admin_menu 
	  *
      * @access public
      * @static
	  * @uses http://codex.wordpress.org/Function_Reference/add_options_page
      *
	  */
	function ljxdm_wp_admin_menu() {
		add_options_page( __( 'phpinfo()', 'ljxdm_wp_phpinfo' ), __( 'phpinfo()', 'ljxdm_wp_phpinfo' ), 'manage_options', 'ljxdm_wp_phpinfo', array( $this, 'ljxdm_wp_phpinfo_page' ) );
	}
	

	function ljxdm_wp_phpinfo_page() {
		?>
		<div class="ljxdm_wp_phpinfo_wrap"><?php $this->ljxdm_wp_phpinfo_output(); ?></div>
		<?php
	}

	function ljxdm_wp_phpinfo_output() {
		ob_start();
		phpinfo(-1);
		$phpinfo_content = ob_get_contents();
		ob_end_clean();

		$html = new DOMDocument();
		$html->loadHTML($phpinfo_content);
		$body = $html->getElementsByTagName('body');
		$body = $body->item(0);

		echo($html->saveHtml($body));
	}
}





