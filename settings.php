<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $enable = !empty($_POST['enable_reroute']) ? 1 : 0;
        $append_recipient = !empty($_POST['append_recipient']) ? 1 : 0;
        $email = !empty($_POST['email_address']) ? $_POST['email_address'] : '';
        $append_msg = !empty($_POST['append_msg']) ? $_POST['append_msg'] : '';

        $error = false;

        if($enable && !$email){
            print '<div id="message" class="error fade"><p>'. __('Enter at least one email address.', 'wp_reroute_email') . '</p></div>';
            $error = true;
        }

        if(!$error){
            update_option('wp_reroute_email_enable', $enable);
            update_option('wp_reroute_append_recipient', $append_recipient);
            update_option('wp_reroute_email_address', $email);
            update_option('wp_reroute_email_message_to_append', $append_msg);
            print '<div id="message" class="updated fade"><p>'. __('Settings saved.', 'wp_reroute_email') . '</p></div>';
        }
    }
    else{
        $enable = get_option('wp_reroute_email_enable', 0);
        $append_recipient = get_option('wp_reroute_append_recipient', 0);
        $email = get_option('wp_reroute_email_address', '');
        $append_msg = get_option('wp_reroute_email_message_to_append', '');
    }
?>
<div class="wrap">
    <div class="icon32" id="icon-options-general"><br></div>
    <h2><?php echo __("WP Reroute Email Settings"); ?></h2>
    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">Enable rerouting</th>
                    <td>
                        <input type="checkbox" <?php print $enable ? 'checked="checked"' : ''; ?> value="1" name="enable_reroute">
                        <br><span class="description">Check this box if you want to enable email rerouting. Uncheck to disable rerouting.</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Email address</th>
                    <td>
                        <input type="text" name="email_address" size="60" value="<?php print $email; ?>">
                        <br><span class="description">Provide a comma-delimited list of email addresses to pass through.</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Append text</th>
                    <td>
                        <input type="text" name="append_msg" size="60" value="<?php print $append_msg; ?>">
                        <br><span class="description">This text will be appended with the mail body. Leave it blank if you do not want to append anything.</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Append recipient email addresses</th>
                    <td>
                        <input type="checkbox" <?php print $append_recipient ? 'checked="checked"' : ''; ?> value="1" name="append_recipient">
                        <br><span class="description">Check this box if you want to append recipient email addresses at the bottom of the mail.</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" value="Save Changes"></p>
    </form>
</div>