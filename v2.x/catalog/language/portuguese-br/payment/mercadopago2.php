<?php
// Text
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$admin = strpos($url, 'admin') !== FALSE? '':'./admin/';
$_['text_title'] = '<img src="' . $admin . 'view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;"> ';
$_['currency_no_support'] = 'A moeda selecionada não é aceita pelo Mercadopago';
?>