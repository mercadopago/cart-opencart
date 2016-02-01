<?php
// Text
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$admin = strpos($url, 'admin') !== FALSE? '':'./admin/';
$_['text_title'] = '<img src="' . $admin . 'view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;"> ';
$_['currency_no_support'] = 'La moneda seleccionado no es aceptado por MercadoPago';

$_['ccnum_placeholder'] = 'Numero de la tarjeta de credito';
$_['name_placeholder'] = 'Nombre (como escrito en la tarjeta)';
$_['doctype_placeholder'] = 'Tipo de documento';
$_['docnumber_placeholder'] = 'Numero de documento';
$_['expiration_month_placeholder'] = 'Mes de la expiración';
$_['expiration_year_placeholder'] = 'Año de la expiración';
$_['error_invalid_payment_type'] = 'Medio de pago no aceptado.';
?>