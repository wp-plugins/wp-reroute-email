<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $enable = !empty($_POST['enable_reroute']) ? 1 : 0;
        $email = !empty($_POST['email_address']) ? $_POST['email_address'] : '';

        $error = false;

        if($enable && !$email){
            print '<div id="message" class="error fade"><p>'. __('Enter at least one email address.', 'wp_reroute_email') . '</p></div>';
            $error = true;
        }

        if(!$error){
            update_option('wp_reroute_email_enable', $enable);
            update_option('wp_reroute_email_address', $email);
            print '<div id="message" class="updated fade"><p>'. __('Setting saved.', 'wp_reroute_email') . '</p></div>';
        }
    }
    else{
        $enable = get_option('wp_reroute_email_enable', 0);
        $email = get_option('wp_reroute_email_address', '');
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
            </tbody>
        </table>
        <p class="submit"><input type="submit" value="Save Changes"></p>
    </form>
</div>