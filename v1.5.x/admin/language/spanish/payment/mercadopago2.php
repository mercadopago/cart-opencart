<?php
// Heading
$_['heading_title']						= 'MercadoPago Version 2.0';

// Text
$_['text_ipn']						        = 'Configure your <b>Instant Payment Motification</b> to receive your automatic order status changes at: 
                                                                  <a href="https://www.mercadopago.com/mla/herramientas/notificaciones" target="_blank">Arg</a> or
                                                                  <a href="https://www.mercadopago.com/mlm/herramientas/notificaciones" target="_blank">Mex</a> or
                                                                  <a href="https://www.mercadopago.com/mlv/herramientas/notificaciones" target="_blank">Ven</a> or
                                                                  <a href="https://www.mercadopago.com/mlb/ferramentas/notificacoes" target="_blank">Bra</a><br />
                                                                  Set your url follwing this exemple: http//www.your_store_address_root.com/index.php?route=payment/mercadopago2/retorno/&';
$_['text_payment']						= 'Pago';
$_['text_success']						= 'Éxito: Se ha cambiado el módulo de MercadoPago!';
$_['text_mercadopago2']						= '<a onclick="window.open(\'http://www.mercadopago.com/\');" target="_blank"><img src="view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_argentina']						= 'Argentina';
$_['text_brasil']						= 'Brasil';
$_['text_colombia']						= 'Colômbia';
$_['text_chile']						= 'Chile';

// Entry
// Entry
$_['entry_payments_not_accept']                                 = 'El pago que usted no desea aceptar<br /><br /><span class="help"> <b>atención</b> Caso altere o campo <b>País</b>, guardar esta página antes de seleccionar los medios de pago que no es aceptado</span>';
$_['entry_client_id']						= 'Cliente ID :  <span class="help">To get this fild, follow:<a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> or <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> or
                                                                     <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> or <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a></span>';
$_['entry_client_secret']					= 'Client Secret : <span class="help">To get this fild, follow:<a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> or <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> or
                                                                   <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> or <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a></span>';

$_['entry_installments']                                        = 'El número máximo de acciones aceptadas';
$_['entry_status']						= 'Estado:';
$_['entry_country']						= 'País:<br /><span class="help">Dónde está la tienda de la realización de ventas:</span>';
$_['entry_sort_order']						= 'Ordem:';



$_['entry_url']                                                 = 'Store Url:<br /><span class="help">Insert your store root url installation<br /> (Always write the url with <b>http://</b> or <b>https://</b> )<br/><i>IE. http://www.mystore.com/store/</i><br /></span>';

$_['entry_debug']                                               = 'Debug mode: <br /><span class="help">Turn on to show the erro log on checkout</span>';




$_['entry_order_status']					= 'Situación estándar de la venta:<br />';
$_['entry_order_status_completed']                              = 'Situación en que el pago autorizado:<br /><span class="help">Seleccione la situación cuando la venta se haya completado y el pago es confirmado';
$_['entry_order_status_pending']                                = 'Situación en la que el pago está pendiente::<br /><span class="help">Seleccione la situación cuando el pago no ha sido identificado por MercadoPago</span>';
$_['entry_order_status_canceled']                               = 'Situação quando a transação está cancelada:';
$_['entry_order_status_in_process']			        = 'En el análisis:<br /><span class="help">Seleccione cuando el pago está siendo examinado por MercadoPago</span>';
$_['entry_order_status_rejected']			        = 'Rechazado:<br /><span class="help">Seleccione esta opción cuando el pago no fue aprobado por MercadoPago</b></span>';
$_['entry_order_status_refunded']			        = 'Devuelto:<br /><span class="help">Selecione a opção quando o pagamento foi devolvido ao comprador</span>';
$_['entry_order_status_in_mediation']			        = 'En la mediación:<br /><span class="help">Seleccione esta opción cuando el pago fue devuelto al comprador</span>';

// Error
$_['error_permission']						= 'No está permitido modificar el módulo de MercadoPago!';
$_['error_client_id']						= 'ID de Cliente es obligatoria';
$_['error_client_secret']					= 'El Cliente Secreto se Requiere';

// installments
$_['maximum']                                                   = 'Máxima';
$_['18']                                                        = '18';
$_['15']                                                        = '15';   
$_['12']                                                        = '12';
$_['9']                                                         = '9';
$_['6']                                                         = '6';
$_['3']                                                         = '3';
$_['1']                                                         = '1';
?>