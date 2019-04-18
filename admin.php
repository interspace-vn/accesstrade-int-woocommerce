<?php

function add_admin_menu()
{
    add_menu_page (
        'ACCESSTRADE',
        'ACCESSTRADE',
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
                <h1>Cấu hình tích hợp API ACCESSTRADE</h1>  

                <table border="0,5">     

                    <tr>
                        <td><label><b>Token</b>: </label></td>
                        <td><input class="w3-input" type="text" name="token"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Accesstrade sẽ cung cấp token ứng với từng chiến dịch khi tích hợp.</td>
                    </tr>
                    <tr>
                        <td><label><b>Campaign id</b>: </label></td>
                        <td><input class="w3-input" type="number" name="campaign_id"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Accesstrade sẽ cung cấp id ứng với từng chiến dịch khi tích hợp.</td>
                    </tr>
                    <tr>
                        <td><label><b>Is reoccur</b>: </label></td>
                        <td>
                            <input type="radio" name="is_reoccur" value="0"> Không<br>
                            <input type="radio" name="is_reoccur" value="1"> Có<br>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Không =>  Cookies sẽ bị xóa sau khi đặt đơn hàng đầu tiên thành công.
 <br> Có => Áp dụng luật re-occur không giới hạn số lượt chuyển đổi trên 1 click.</td>
                    </tr>
                    <tr>
                        <td><label><b>Is lastclick</b>: </label></td>
                        <td>
                            <input type="radio" name="is_lastclick" value="0"> Không<br>
                            <input type="radio" name="is_lastclick" value="1"> Có<br>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Không => Cookies của ACCESSTRADE sẽ không bị ghi đè bởi các kênh quảng cáo khác của nhà cung cấp trong thời gian cookies còn hiệu lực.
 <br> Có => Áp dụng luật last click, cookies của ACCESSTRADE sẽ bị xóa khi người dùng click vào link quảng cáo đến từ nguồn khác ACCESSTRADE ( thường phân biệt theo utm_source ).</td>
                    </tr>

                </table>
                <br>
                <input type="submit" name="submit" value="Cấu hình" class="button button-primary" />             
            </form>
        </div>
    </div>
    <?php

    $at_token = trim($_POST['token']);
    $at_campaign_id = trim($_POST['campaign_id']);
    $at_is_reoccur = trim($_POST['is_reoccur']);
    $at_is_lastclick = trim($_POST['is_lastclick']);

    if (isset($at_token, $at_campaign_id, $at_is_reoccur, $at_is_lastclick) && $at_token != '' && $at_campaign_id != '' && $at_is_reoccur != '' && $at_is_lastclick != '') {
        update_option( "at_token", $at_token );
        update_option( "at_campaign_id", $at_campaign_id );
        update_option( "at_is_reoccur", $at_is_reoccur );
        update_option( "at_is_lastclick", $at_is_lastclick );
    }
}
