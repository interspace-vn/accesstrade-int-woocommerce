<?php

function at_inject_scripts() {
    $current_hour = new DateTime();
    $current_hour->setTime($current_hour->format("H"), 0, 0);
    ?>
    <script src="//static.accesstrade.vn/js/trackingtag/tracking_kelly.js?v=<?=$current_hour->getTimestamp();?>"></script>
    <script type="text/javascript">
    AT.init({"campaign_id":"xxx", "is_reoccur": 1,"is_lastclick": 1} );
    AT.track();
    </script>
    <?php
}
add_action('wp_head', 'at_inject_scripts');

function at_place_order($order_id) {
    $order = wc_get_order( $order_id );
    $order->get_total();
    $line_items = $order->get_items();
    $items=array();

    foreach ( $line_items as $item ) {
        // This will be a product
        $product = $order->get_product_from_item( $item );

        // This is the products SKU
        $sku = $product->get_sku();

        // This is the qty purchased
        $qty = $item['qty'];

        // Line item total cost including taxes and rounded
        $total = $order->get_line_total( $item, true, true );

        // Line item subtotal (before discounts)
        $subtotal = $order->get_line_subtotal( $item, true, true );
        array_push($items, $item);
    }

    $total_items = count($items);

?>
    <script type="text/javascript">
        document.body.innerHTML += '<textarea>Generate order info</textarea>';
        accesstrade_order_info={
            order_id: <?php echo $order->id; ?>,
            amount: <?php echo $order->discount_total ?>,
            discount: <?php echo $order->discount_total ?>,
            order_items:[<?php
                for ($i=0; $i < $total_items; $i++) {
                    if ($i == ($total_items-1)) {
                        echo "{itemid: ".$items[$i]['product_id'].", quantity: ".$items[$i]['quantity'].",  price: ".$items[$i]['subtotal'] / $items[$i]['quantity'].", catid: 'default'}";
                    }else{
                        echo "{itemid: ".$items[$i]['product_id'].", quantity: ".$items[$i]['quantity'].",  price: ".$items[$i]['subtotal'] / $items[$i]['quantity'].", catid: 'defaul'} , ";
                    }
                }
                ?>
            ]};
        document.body.innerHTML += '<textarea>' + JSON.stringify(accesstrade_order_info) + '</textarea>';
        AT.track_order(accesstrade_order_info);
    </script>
<?php
}
add_action( 'woocommerce_thankyou', 'at_place_order' );
