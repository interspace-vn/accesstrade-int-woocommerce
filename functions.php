<?php 
add_action('woocommerce_checkout_order_processed', 'enroll_student');

    function enroll_student($order_id)
    {
        $order = wc_get_order( $order_id );

        $line_items = $order->get_items();

        $items=array();

        $date = date('Y-m-d H:i:s');

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
        $_SESSION["items"] = $items;
        $arr = array();
        for ($i=0; $i < sizeof($_SESSION["items"]); $i++) { 
            array_push($arr, array(
                        "id" => strval($items[$i]['product_id']),
                        "sku" => " ",
                        "name" => strval($items[$i]['name']),
                        "price" => $items[$i]['subtotal'],
                        "quantity" => $items[$i]['quantity'],
                        "category" => "Category A",
                        "category_id" => "defaul"
                    ));     
        }
        $data1 = array(
            "conversion_id" => strval($order_id),
            "conversion_result_id" => "30",
            "tracking_id" => "xxx",
            "transaction_id" => strval($order_id),
            "transaction_time" => $date,
            "transaction_value" => 100000,
            "transaction_discount " => strval($order->discount_total),
            "items" => $arr
        );

        $data_string = json_encode($data1);

        // echo $data_string;


        $ch = curl_init('https://api.accesstrade.vn/v1/postbacks/conversions');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Token '.get_option( "token", $default = false)
        ));

        $result = curl_exec($ch);

        echo $order_id;
    }

    // function bbloomer_conversion_tracking_thank_you_page() {
    //  // print_r($_SESSION["items"]);
    
    // }

    function wpb_hook_javascript() {
?>
        <script src="//cdn.accesstrade.vn/js/tracking.js" ></script>
        <script type="text/javascript">
                AT.track();
        </script>
<?php
    }
    add_action('wp_head', 'wpb_hook_javascript');

    add_action('woocommerce_order_status_changed','status_changed_processsing');
   function status_changed_processsing( $order_id, $checkout = null ) {
       $order = wc_get_order( $order_id );
       $line_items = $order->get_items();
       echo $order->status;

       $items=array();

        foreach ( $line_items as $item ) {

            array_push($items, $item);

        }

       if($order->status == "completed"){

            $arr = array();
            for ($i=0; $i < sizeof($items); $i++) { 
                array_push($arr, array(
                            "id" => strval($items[$i]['product_id']),
                            "status" => 1
                        ));     
            }
            $data1 = array(
                "transaction_id" => strval($order_id),
                "status" => 1,
                "items" => $arr
            );

            $data_string = json_encode($data1);
            echo $data_string;


            $ch = curl_init('https://api.accesstrade.vn/v1/postbacks/conversions');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Token '.get_option( "token", $default = false)
            ));

            $result = curl_exec($ch);

            echo $result;

           
        }
   }
 ?>
