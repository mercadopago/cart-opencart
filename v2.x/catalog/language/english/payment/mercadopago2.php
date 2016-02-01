<?php
// Text
//$_['text_title'] = '<img src="./view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;">'
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$admin = strpos($url, 'admin') !== FALSE? '':'./admin/';
$_['text_title'] = '<img src="' . $admin . 'view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;"> ';
$_['currency_no_support'] = 'The currency selected is not supported by MercadoPago';
$_['ccnum_placeholder'] = 'Credit Card Number';
$_['expiration_date_placeholder'] = 'Expiration Date';
$_['name_placeholder'] = 'Name';
$_['doctype_placeholder'] = 'Document Type';
$_['docnumber_placeholder'] = 'Document Number';
$_['expiration_month_placeholder'] = 'Expiration Month';
$_['expiration_year_placeholder'] = 'Expiration Year';
$_['error_invalid_payment_type'] = 'Payment type not accepted';

?>
