<?php
/*
Plugin Name: WP Reroute Email
Plugin URI: http://wordpress.org/extend/plugins/wp-reroute-email/
Description: This plugin intercepts all outgoing emails from a WordPress site and reroutes them to a predefined configurable email address.
Version: 1.1.0
Author: msh134
Author URI: http://www.sajjadhossain.com
*/

class WPRerouteEmail{
	static $plugin_name;
    /**
     * Constructor
     */
    public function __construct() {
        $this->add_actions();
		$this->add_filters();
    }

    /**
     * Adds actions
     */
    private function add_actions(){
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('phpmailer_init', array($this, 'modify_phpmailer_object'), 1000, 1);
    }

	/**
     * Adds filters
     */
	private function add_filters(){
		add_filter( 'plugin_action_links', array($this, 'add_settings_link'), 10, 2);
		add_filter( 'wp_mail', array($this, 'modify_mail_message'), 1000, 1);
	}

    /**
     * Add a submenu for settings page under Settings menu
     */
    public function add_admin_menu(){
        add_submenu_page('options-general.php', __('WP Reroute Email', 'wp_reroute_email'),__('WP Reroute Email', 'wp_reroute_email'), 'manage_options', 'wp-reroute-email/settings.php');
    }

    /**
     * Unsets all recipient addresses from PHPMailer object and adds emails address to which all mails will be rerouted.
     *
     * @param object $phpmailer
     */
    public function modify_phpmailer_object($phpmailer){
        $enable = get_option('wp_reroute_email_enable', 0);
        $email = get_option('wp_reroute_email_address', '');

        if($enable && $email){
            $phpmailer->ClearAllRecipients();

            $email_array = explode(',', $email);

            foreach($email_array as $email){
                $phpmailer->AddAddress(trim($email));
            }
        }
    }

    /**
     * Append given text with the mail message.
     *
     * @param array $mail_parts
     */
    public function modify_mail_message($mail_parts){
        $append_msg = get_option('wp_reroute_email_message_to_append', '');

        if($append_msg){
            if(!empty($mail_parts['message']) && strstr($mail_parts['message'], '</body>') !== FALSE){
                $mail_parts['message'] = str_replace('</body>', $append_msg . '</body>', $mail_parts['message']);
            }
            else{
                $mail_parts['message'] .= "\r\n\r\n$append_msg";
            }
        }

        return $mail_parts;
    }


    /**
	 * Add a settings link to the Plugins page
	 *
	 * @param array $links
	 * @param string $file
	 *
	 * @return array
	 */
	public function add_settings_link( $links, $file ){

		if(is_null($this->plugin_name)){
			$this->plugin_name = plugin_basename(__FILE__);
		}

		if ( $file == $this->plugin_name ){
			$settings_link = '<a href="options-general.php?page=wp-reroute-email/settings.php">Settings</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}
}

new WPRerouteEmail();