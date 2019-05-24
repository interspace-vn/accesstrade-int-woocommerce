<?php 
add_action('woocommerce_checkout_order_processed', 'request_api_accesstrade');

function request_api_accesstrade($order_id)
{
    $order = wc_get_order( $order_id );

    $line_items = $order->get_items();

    $items=array();

    $date = date('Y-m-d H:i:s');

    foreach ( $line_items as $item ) {
            
        $product = $order->get_product_from_item( $item );

        $sku = $product->get_sku();

        $qty = $item['qty'];

        $total = $order->get_line_total( $item, true, true );

        $subtotal = $order->get_line_subtotal( $item, true, true );

        array_push($items, $item);

    }

    $arr_item = array();

    $count = sizeof($items);

    for ($i=0; $i < $count; $i++) { 
        array_push($arr_item, array(
            "id" => strval($items[$i]['product_id']),
            "sku" => strval($items[$i]['product_id']),
            "name" => strval($items[$i]['name']),
            "price" => $items[$i]['subtotal'],
            "quantity" => $items[$i]['quantity'],
            "category" => "Category A",
            "category_id" => "defaul"
        ));
    }

    $data = array(
        "conversion_id" => strval($order_id),
        "conversion_result_id" => "30",
        "tracking_id" => "xxx",
        "transaction_id" => strval($order_id),
        "transaction_time" => $date,
        "transaction_value" => 100000,
        "transaction_discount " => strval($order->discount_total),
        "items" => $arr_item
    );

    $data_string = json_encode($data);

    $url='https://api.accesstrade.vn/v1/postbacks/conversions';

    $response = wp_remote_post( $url, array(
        'method' => 'POST',
        'body'    => $data_string,
        'headers' => array(
            'Content-Type'=>' application/json',
            'Authorization'=>'Token '.get_option( "at_token", $default = false)
        ),
    ) );

}

function wpb_hook_javascript() {
?>

    <script src="//static.accesstrade.vn/js/trackingtag/tracking.min.js"></script> 
    <script type="text/javascript">
        AT.init({"campaign_id":<?php echo get_option( "at_campaign_id", $default = false) ?>, "is_reoccur": <?php echo get_option( "at_is_reoccur", $default = false) ?>,"is_lastclick": <?php echo get_option( "at_is_lastclick", $default = false) ?>} );
        AT.track();
    </script>

<?php
}
add_action('wp_head', 'wpb_hook_javascript');

add_action('woocommerce_order_status_changed','status_api_accesstrade');

function status_api_accesstrade( $order_id, $checkout = null ) {

 $order = wc_get_order( $order_id );

 $line_items = $order->get_items();

 $items=array();

foreach ( $line_items as $item ) {

    array_push($items, $item);

}

if($order->status == "completed"){

    $arr_item = array();
    $count = sizeof($items);
    for ($i=0; $i < $count; $i++) { 
        array_push($arr_item, array(
            "id" => strval($items[$i]['product_id']),
            "status" => 1
        ));     
    }
    $data = array(
        "transaction_id" => strval($order_id),
        "status" => 1,
        "items" => $arr_item
    );

    $data_string = json_encode($data);

    $url='https://api.accesstrade.vn/v1/postbacks/conversions';

    $response = wp_remote_post( $url, array(
        'method' => 'PUT',
        'body'=> $data_string,
        'headers' => array(
        'Content-Type'=>' application/json',
        'Authorization'=>'Token '.get_option( "at_token", $default = false)
        )
    ) );
    
}
}
?>
