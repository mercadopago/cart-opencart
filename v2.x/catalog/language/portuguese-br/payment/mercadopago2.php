<?php
// Text
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$admin = strpos($url, 'admin') !== FALSE? '':'./admin/';
$_['text_title'] = '<img src="' . $admin . 'view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;"> ';
$_['currency_no_support'] = 'A moeda selecionada não é aceita pelo Mercadopago';
$_['ccnum_placeholder'] = 'Número do cartão';
$_['expiration_date_placeholder'] = 'Data de expiração';
$_['name_placeholder'] = 'Nome (como escrito no cartão)';
$_['doctype_placeholder'] = 'Tipo de documento';
$_['docnumber_placeholder'] = 'Número do documento';
$_['expiration_month_placeholder'] = 'Mês de expiração';
$_['expiration_year_placeholder'] = 'Ano de expiração';
$_['error_invalid_payment_type'] = 'Este meio de pagamento não é aceito';
?>