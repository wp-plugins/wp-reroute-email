<?php
/*
Plugin Name: WP Reroute Email
Plugin URI: http://www.sajjadhossain.com
Description: This plugin intercepts all outgoing emails from a WordPress site and reroutes them to a predefined configurable email address.
Version: 1.0.0
Author: msh134
Author URI: http://www.sajjadhossain.com
*/

class WPRerouteEmail{
    /**
     * Constructor
     */
    public function __construct() {
        $this->add_actions();
    }

    /**
     * Adds actions
     */
    private function add_actions(){
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('phpmailer_init', array($this, 'modify_phpmailer_object'), 1000, 1);
    }

    /**
     * Add a submenu for settings page under Settings menu
     */
    public function add_admin_menu(){
        add_submenu_page('options-general.php', __('WP Reroute Email', 'wp_reroute_email'),__('WP Reroute Email', 'wp_reroute_email'), 2, 'wp-reroute-email/settings.php');
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
}

new WPRerouteEmail();