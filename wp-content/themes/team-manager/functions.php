<?php
/**
 * Created by PhpStorm.
 * User: emilkottmeir
 * Date: 18.04.17
 * Time: 14:39
 */



function tm_child_styles() {
    wp_deregister_style( 'parallax-one-style');
    wp_register_style('parallax-one-style', get_template_directory_uri(). '/style.css');
    wp_enqueue_style('parallax-one-style', get_template_directory_uri(). '/style.css');
    wp_enqueue_style( 'tm-style', get_stylesheet_directory_uri().'/style.css', array('parallax-one-style') );
}
add_action( 'wp_enqueue_scripts', 'tm_child_styles' );

function kb_svg ( $svg_mime ){
    $svg_mime['svg'] = 'image/svg+xml';
    return $svg_mime;
}

add_filter( 'upload_mimes', 'kb_svg' );




/*-------------- generate keys -------------------------*/

function generate_key() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $key_strings = array();
    $key = array();
    for ($a = 0; $a < 5; $a++) {
        $string = array();
        for ($i = 0; $i < 5; $i++) {
            array_push($string, $characters[rand(0, $charactersLength - 1)]);
        }
        array_push($key_strings, $string);
        unset($string);
    }
    foreach ($key_strings as $string_item){
        array_push($key, implode( '', $string_item ));
    }
    return implode( '-', $key );
}

function save_license($license){
    $servername = "localhost";
    $username = "tm";
    $password = "tmtest#9";
    $dbname = "licence_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $customer = array_column($license, 'customer');
    $first_name = array_column($customer, 'first_name');
    $last_name = array_column($customer, 'last_name');
    $email = array_column($customer, 'email');
    $license_type = array_column($license, 'product');
    $license_key = array_column($license, 'key');


    $sql = "INSERT INTO tm_licences (first_name, last_name, email, license_type, license_key)
        VALUES ('$first_name[0]' , '$last_name[0]', '$email[0]', '$license_type[0]', '$license_key[0]')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";


    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

function process_products ($order_id) {

    if (did_action('woocommerce_thankyou') === 1) {

        $order = new WC_Order($order_id);
        $customer_first_name = $order->get_billing_first_name();
        $customer_last_name = $order->get_billing_last_name();
        $customer_email = $order->get_billing_email();
        $order_items = $order->get_items();
        $customer = array('first_name' => $customer_first_name, 'last_name' => $customer_last_name, 'email' => $customer_email);

        foreach ($order_items as $product) {
            echo $product;
            $license[] = array('product' => $product['name'], 'key' => generate_key(), 'customer' => $customer);
            save_license($license);
            unset($license);
        }
    }
}

add_action('woocommerce_thankyou', 'process_products', 10);
