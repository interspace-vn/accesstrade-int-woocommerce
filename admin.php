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
				<h1>------------ Token ------------</h1>				
				<label>Token: </label>
				<input class="w3-input" type="text" name="token">
				<hr>
			    <input type="submit" name="submit" value="submit" />			 
			</form>
	</div>
    <?php
    
    $token = $_POST['token'];

	if (isset($token)) {
		update_option( "token", $token );
	}
   
}
