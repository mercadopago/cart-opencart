<?php
// Heading
$_['heading_title']						= 'Mercado Pago Version 2.0';

// Text
$_['text_ipn']						        = 'Configure your <b>Instant Payment Motification</b> to receive your automatic order status changes at: 
                                                                  <a href="https://www.mercadopago.com/mla/herramientas/notificaciones" target="_blank">Arg</a> or
                                                                  <a href="https://www.mercadopago.com/mlm/herramientas/notificaciones" target="_blank">Mex</a> or
                                                                  <a href="https://www.mercadopago.com/mlv/herramientas/notificaciones" target="_blank">Ven</a> or
                                                                  <a href="https://www.mercadopago.com/mlb/ferramentas/notificacoes" target="_blank">Bra</a><br />
                                                                  Set your url follwing this exemple: http//www.your_store_address_root.com/index.php?route=payment/mercadopago2/retorno/&';
$_['text_payment']						= 'Payment';
$_['text_success']						= 'Sucess, your modifications are done!';
$_['text_mercadopago2']						= '<a onclick="window.open(\'https://www.mercadopago.com\');" target="_blank"><img src="view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_argentina']						= 'Argentina';
$_['text_brasil']						= 'Brasil';
$_['text_colombia']						= 'Colombia';
$_['text_chile']						= 'Chile';

// Entry


$_['entry_client_id']						= 'Cliente ID :  <span class="help">To get this fild, follow:<a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> or <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> or
                                                                     <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> or <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a></span>';
$_['entry_client_secret']					= 'Client Secret : <span class="help">To get this fild, follow:<a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> or <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> or
                                                                    <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> or <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a></span>';

$_['entry_installments']					= 'Maximum accepted payments';
$_['entry_payments_not_accept']					= 'Check the payments methods that you <b>don´t want</b> to accept:<br /><br /><span class="help"><b>Important</b> If you change the Sales Country, save the page and only after that select the methods that you dont´t want to accept.</span>';
$_['entry_geo_zone']						= 'Geo Zona:';
$_['entry_status']						= 'Status:';
$_['entry_country']						= 'Sales Country:';
$_['entry_sort_order']						= 'Sort order:';

$_['entry_url']                                                 = 'Store Url:<br /><span class="help">Insert your store root url installation<br /> (Always write the url with <b>http://</b> or <b>https://</b> )<br/><i>IE. http://www.mystore.com/store/</i><br /></span>';
$_['entry_debug']                                               = 'Debug mode: <br /><span class="help">Turn on to show the erro log on checkout</span>';

$_['entry_order_status']					= 'Order status:<br /><span class="help">Select the default order status of your orders</span>';
$_['entry_order_status_completed']			        = 'Order Completed:<br /><span class="help">Select the status order case your order is <b>Approved</b></span>';
$_['entry_order_status_pending']			        = 'Order Pending:<br /><span class="help">Select the status order when the buyer did not finish the payment yet</span>';
$_['entry_order_status_canceled']			        = 'Order Canceled:<br /><span class="help">Select the status order case the payment was <b>Cancelled</b> </span>';
$_['entry_order_status_in_process']			        = 'Order In Progress:<br /><span class="help">Select the status order case the payment is <b>been analysing</b></span>';
$_['entry_order_status_rejected']			        = 'Order Reject:<br /><span class="help">Select the status order case the payment was <b>reject</b></span>';
$_['entry_order_status_refunded']			        = 'Order Refunded:<br /><span class="help">Select the status order case the payment was <b>Refunded</b></span>';
$_['entry_order_status_in_mediation']			        = 'Order Mediation:<br /><span class="help">Select the status order case the payment is in <b>Mediation</b></span>';

// Error
$_['error_permission']						= 'Sorry, you no permissionto to modify Mercado Pago 2.0';
$_['error_client_id']						= 'Sorry, your <b>Client Id</b> is mandatory.';
$_['error_client_secret']					= 'Sorry <b>Client Secret</b> is mandatory.';

// installments
$_['18']                                                        = '18';
$_['15']                                                        = '15';   
$_['12']                                                        = '12';
$_['9']                                                         = '9';
$_['6']                                                         = '6';
$_['3']                                                         = '3';
$_['1']                                                         = '1';    


?>