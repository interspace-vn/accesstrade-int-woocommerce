<?php

function add_admin_menu()
{
    add_menu_page (
        'ACCESSTRADE Int',
        'ACCESSTRADE Int',
        'manage_options',
        'plugin-options',
        'at_int_woocommerce_options',
        '',
        '2'
    );
}
add_action('admin_menu', 'add_admin_menu');

function at_int_woocommerce_options(){
    ?>
    <div>
        <div>
            <form class="w3-container" action="admin.php?page=plugin-options" method="post">
                <h1>------------ Token ------------</h1>                
                <label>Token: </label>
                <input class="w3-input" type="text" name="token">                
                <label>Campaign_id: </label>
                <input class="w3-input" type="text" name="campaign_id">                
                <label>Is_reoccur: </label>
                <input class="w3-input" type="text" name="is_reoccur">                
                <label>Is_lastclick: </label>
                <input class="w3-input" type="text" name="is_lastclick">
                <hr>
                <input type="submit" name="submit" value="submit" />             
            </form>
        </div>
    </div>
    <?php

    $token = $_POST['token'];
    $campaign_id = $_POST['campaign_id'];
    $is_reoccur = $_POST['is_reoccur'];
    $is_lastclick = $_POST['is_lastclick'];

    if (isset($token) && $token != '' && isset($campaign_id) && $campaign_id != '' && isset($is_reoccur) && $is_reoccur != '' && isset($is_lastclick) && $is_lastclick != '') {
        update_option( "token", $token );
        update_option( "campaign_id", $campaign_id );
        update_option( "is_reoccur", $is_reoccur );
        update_option( "is_lastclick", $is_lastclick );
    }
}
