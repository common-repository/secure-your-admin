<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


if (!current_user_can('manage_options')) {
    wp_die(_e('You are not authorized to view this page.', 'suadmplugin'));
}

$option_name = 'wp_suadm_options';
$inputs = get_option($option_name);

if (isset( $_POST['suadmoptions'] ) && wp_verify_nonce( $_POST['suadmoptions'], 'suadmoptionsnonce' )) {

    $inputs = $_POST['inputs'];
    $inputs[0]['hashname'] = md5(sanitize_text_field($inputs[0]['hashname']));
    if ( get_option( $option_name ) !== false ) {
        $update = update_option($option_name, $inputs);
    } else {
        $deprecated = null;
        $autoload = 'no';
        $update = add_option($option_name, $inputs, $deprecated, $autoload);
    }

    if($update) {
        echo '<div class="updated">';
        _e('settings saved.', 'suadmplugin');
        echo '</strong></p></div>';
    } else {
        echo '<div class="error"><p><strong>';
        _e('Error - Url does not seems to be correct.', 'suadmplugin');
        echo '</strong></p></div>';
    }
}
?>
<div class="wrap" xmlns="http://www.w3.org/1999/html">
        <div id="welcome-panel" class="welcome-panel">
                <div class="welcome-panel-content">
                    <h2><?php _e('Secure your Admin', 'suadmplugin'); ?></h2>
                    <p><?php _e('This plugin is intended to add an extra security feature for your wp-admin and wp-login.php with an extra hash that you will pass inside your URL, you can set this word hier and how you will ask for it,
                    For Example, i want to have the word <b>letmein</b> and the pass <b>thesecondnameofmymother</b>, so i will set them bellow and once i want to enter in my admin i have to use <b>http://miwebsite.com/wp-admin?letmein=thesecondnameofmymother</b> otherwise the system will
                    not show you the login page, it will be redirected directly to the home of your website', 'suadmplugin'); ?></p>
                </div> 
                <div class="clear"></div>   
                <div class="welcome-panel-column-container">
                        <form id="form1" name="form1" method="post" action="">
                            <?php wp_nonce_field( 'suadmoptionsnonce', 'suadmoptions' ); ?>
                                <div class="suadmoptions">
                                    <h3><?php esc_attr_e('Check this button to habilitate the security hash', 'suadmplugin'); ?></h3>
                                    <input type="checkbox" name="inputs[0][habilitate]" id="suadmhab" value="1" <?php checked( $inputs[0]['habilitate'], 1 ); ?>> Habilitate
                                    <h3><?php esc_attr_e('Introduce your id and hash to be included as an option on your wp-admin', 'suadmplugin'); ?></h3>
                                    <p></p><label for="variablename"><?php esc_attr_e('Set the Variable Name', 'suadmplugin'); ?></label>
                                    <input type="text" name="inputs[0][varname]" id="variablename" value="<?php echo $varname = isset($inputs[0]['varname']) ? $inputs[0]['varname'] : ""; ?>"></p>
                                    <p></p><label for="hashname"><?php _e('Set the Hash', 'suadmplugin'); ?></label>
                                    <input type="text" name="inputs[0][hashname]" id="variablename" size="80" placeholder="<?php echo $alerthash = isset($inputs[0]['hashname']) ? __('You have set a hash, if you doesn\'t remember you can change it here', 'suadmplugin') : ""; ?>"></p>
                                    <p><?php esc_attr_e('Pls. ensure to use a Variablename and a hash you will easy remember, otherwise you will be not allowed to enter your admin login page', 'suadmplugin'); ?> </p>
                                </div>
                            <p class="submit">
                                <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes')?>" />
                            </p>
                        </form>
                        <p><?php _e('<b>REMEMBER:</b> next time you log-in you have to include in your URL wp-admin<b><i>?yourvariablename=yourhashname</i></b>','suadmplugin'); ?></p>
                </div>
        </div>
</div><!-- end wrap -->                    

