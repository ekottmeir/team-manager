<?php
/**
 * Created by PhpStorm.
 * User: emilkottmeir
 * Date: 18.04.17
 * Time: 14:39
 */


/*-------------- register child theme -------------------------*/

function tm_child_styles() {
    wp_deregister_style( 'parallax-one-style');
    wp_register_style('parallax-one-style', get_template_directory_uri(). '/style.css');
    wp_enqueue_style('parallax-one-style', get_template_directory_uri(). '/style.css');
    wp_enqueue_style( 'tm-style', get_stylesheet_directory_uri().'/style.css', array('parallax-one-style') );
}

/*-------------- set upload types -------------------------*/

function kb_svg ( $svg_mime ){
    $svg_mime['svg'] = 'image/svg+xml';
    return $svg_mime;
}

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

/*-------------- save license to db -------------------------*/



function save_license($license, $order_id, $product){

    //live
    $servername = "localhost";
    $username = "teamManagerAdmin";
    $password = "teamManagerAdmin2017#!";
    $dbname = "teamManagerUsers";
    /*
     //local
    $servername = "localhost";
    $username = "tm";
    $password = "tmtest#9";
    $dbname = "teamManagerUsers";
    */

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $order = new WC_Order($order_id);

    $id = '';
    $first_name = $order->get_billing_first_name();
    $_last_name = $order->get_billing_last_name();
    $club = $order->get_billing_company();
    $date = '';
    $units = '';
    $product_type = $product['name'];
    $accountname = $club . ' - ' . $first_name . ' ' . $_last_name;

    if($product_type == 'Einzellizenz' || $product_type == 'Vereinslizenz') {
        $date = '01.01.2000';
    } else {
        $date = date('d.m.Y', strtotime('+1 year'));
    }

    if($product_type == 'Einzellizenz' || $product_type == 'Einzellizenz Miete') {
        $units = '2';
    } else {
        $units = '6';
    }

    $sql = 'SELECT MAX(id) FROM accounts';

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $id = $row['MAX(id)'];
            $new_id = $id + 1;

            $sql2 = "INSERT INTO accounts (id, accountname, accounttype, expirydate, licensenumber, units)
            VALUES ('$new_id','$accountname' , '1', '$date', '$license', '$units')";

            if ($conn->query($sql2) === TRUE) {
                echo "New record created successfully";

            } else {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            }
        }
    } else {
        echo "0 results";
    }

    $conn->close();
}

    /*-------------- get order data -------------------------*/

function process_products ($order_id) {

    if (did_action('woocommerce_thankyou') === 1) {

        $order = new WC_Order($order_id);
        $order_items = $order->get_items();
        $order_licenses = array();
        foreach ($order_items as $product) {
            $license_key = generate_key();
            $license = array('name' => $product['name'], 'key' => $license_key);
            save_license($license_key, $order_id, $product);
            array_push($order_licenses, $license);
        }
        send_license_mail($order_licenses, $order->get_billing_email());
    }
}

function send_license_mail($order_licenses, $email) {

    $rows = '';

    foreach ($order_licenses as $product) {
        $rows .= '<tr><td>' . $product['name'] . '</td><td>' . $product['key'] . '</td></tr>';
    }

    $to = $email;
    $subject = 'Handball Team Manager';
    $headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $content = "
    <html>
        <head>
            <style>
                p {
                    font-size: 15px;
                    margin-bottom: 40px;
                    margin-top: 30px;
                }

                table, th, td {
                    border: 2px solid #eee;
                    border-collapse: collapse;
                }

                th, td {
                    padding: 10px 20px;
                    font-size: 15px;
                }

                th {
                    text-align: left;
                    background-color: #EEEEEE;
                }
            </style>
        </head>
        <body>
            <h2>Lizenzschlüssel</h2>
            <p>Diese Email enthält Lizenzschlüssel für die Aktivierung Ihrer Software.</p>
            <table>
                <tr>
                    <th>Lizenz</th>
                    <th>Key</th>
                </tr>
                {$rows}
            </table>
        </body>
    </html>
    ";


    wp_mail($to, $subject, $content, $headers);
}

add_action( 'wp_enqueue_scripts', 'tm_child_styles' );
add_filter( 'upload_mimes', 'kb_svg' );
add_action('woocommerce_thankyou', 'process_products', 10);
