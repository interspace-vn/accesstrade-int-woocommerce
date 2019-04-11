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
        <form class="w3-container" action="admin.php?page=plugin-options" method="post">
            <h1>------------ Scripts lưu cookies ------------</h1>
            <label>campaign_id: </label>
            <input class="w3-input" type="number" name="campaign_id">
            <label>is_reoccur: </label>
            <input class="w3-input" type="number" name="is_reoccur">
            <br>
            <label>is_lastclick: </label>
            <input class="w3-input" type="number" name="is_lastclick">
            <hr>
            <input type="submit" name="submit" value="submit" />
        </form>
    </div>
    <?php

    $campaign_id = $_POST['campaign_id'];
    $is_reoccur = $_POST['is_reoccur'];
    $is_lastclick = $_POST['is_lastclick'];

    if (isset($campaign_id) && isset($is_reoccur)  && isset($is_lastclick)) {
        update_option( "campaign_id", $campaign_id );
        update_option( "is_reoccur", $is_reoccur );
        update_option( "is_lastclick", $is_lastclick );
    }
}
