<?php
// Heading
$_['heading_title'] = 'MercadoPago - Custom Checkout';

// Text
$_['text_payment'] = 'Payment';
$_['text_success'] = 'Success, your modifications are done!';
$_['text_mp_transparente'] = '<a onclick="window.open(\'https://www.mercadopago.com\');" target="_blank"><img src="view/image/payment/mp_transparente.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE; background-color: white;" /></a> <br /><b> Custom Checkout</b>';
$_['text_argentina'] = 'Argentina';
$_['text_brasil'] = 'Brasil';
$_['text_colombia'] = 'Colombia';
$_['text_chile'] = 'Chile';

// Entry
$_['entry_notification_url'] = 'Your notification URL is: ';
$_['entry_notification_url_tooltip'] = '<span class="help"> This URL will be used to notify your store about payments and orders. Copy this URL and click ' .
	'<a href="https://www.mercadopago.com/mlb/ferramentas/notificacoes" target="_blank">here</a> to configure your MercadoPago account.</span>';
$_['entry_autoreturn'] = 'Auto Return';
$_['entry_autoreturn_tooltip'] = '<span class="help"> Enables auto return to your store after the checkout is finished. </span>';
$_['entry_client_id'] = 'Client ID : ';
$_['entry_client_id_tooltip'] = 'To get this field, follow:<a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> or <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> or
                                                                     <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> or <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a>';

$_['entry_client_secret'] = 'Client Secret : ';
$_['entry_client_secret_tooltip'] = '<span class="help">To get this field, follow:<a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> or <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> or
                                                                    <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> or <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a></span>';

$_['entry_installments'] = 'Maximum accepted payments';
$_['entry_payments_not_accept'] = 'Check the payments methods that you want to accept:';
$_['entry_payments_not_accept_tooltip'] = '<b>Important</b> If you change the Sales Country, wait until the full load of the payment methods.</span>';
$_['entry_status'] = 'Status:';
$_['entry_country'] = 'Sales Country:';
$_['entry_sort_order'] = 'Sort order:';
$_['entry_coupon'] = 'Discount coupon: ';
$_['entry_coupon_tooltip'] = '<span class="help">* This option is valid only for sites participating in coupon campaigns.</span>';


$_['entry_url'] = 'Store Url: ';
$_['entry_url_tooltip'] = '<span class="help">Insert your store root url installation<br /> (Always write the url with <b>http://</b> or <b>https://</b> )<br/><i>IE. http://www.mystore.com/store/</i><br /></span>';
$_['entry_debug'] = 'Debug mode:';
$_['entry_debug_tooltip'] = '<span class="help">Turn on to show the erro log on checkout</span>';

$_['entry_sandbox'] = 'Sandbox mode: ';
$_['entry_sandbox_tooltip'] = '<span class="help">Sandbox is used for testing the Checkout and IPN. Without the need for a valid credit card to approve to purchase test.</span>';
$_['entry_type_checkout'] = 'Type Checkout: ';
$_['entry_category'] = 'Category:';
$_['entry_category_tooltip'] = '<span class="help">Select the category that best fits your shop</span>';

$_['entry_order_status'] = 'Default order status: ';
$_['entry_order_status_general'] = 'Select the statuses to be shown when the order is: ';
$_['entry_order_status_tooltip'] = '<span class="help">Select the default order status of your orders</span>';
$_['entry_order_status_completed'] = 'Completed:';
$_['entry_order_status_completed_tooltip'] = '<span class="help">Select the status order case your order is <b>Approved</b></span>';
$_['entry_order_status_pending'] = 'Pending:';
$_['entry_order_status_pending_tooltip'] = '<span class="help">Select the status order when the buyer did not finish the payment yet</span>';
$_['entry_order_status_canceled'] = 'Canceled:';
$_['entry_order_status_canceled_tooltip'] = '<span class="help">Select the status order case the payment was <b>Cancelled</b> </span>';
$_['entry_order_status_in_process'] = 'In Progress:';
$_['entry_order_status_in_process_tooltip'] = '<span class="help">Select the status order case the payment is <b>been analysing</b></span>';
$_['entry_order_status_rejected'] = 'Reject:';
$_['entry_order_status_rejected_tooltip'] = '<span class="help">Select the status order case the payment was <b>reject</b></span>';
$_['entry_order_status_refunded'] = 'Refunded:';
$_['entry_order_status_refunded_tooltip'] = '<span class="help">Select the status order case the payment was <b>Refunded</b></span>';
$_['entry_order_status_in_mediation'] = 'Mediation:';
$_['entry_order_status_in_mediation_tooltip'] = '<span class="help">Select the status order case the payment is in <b>Mediation</b></span>';
$_['entry_order_status_chargeback'] = 'ChargeBack';
$_['entry_order_status_chargeback_tooltip'] = '<span class="help">Select the status order case the payment is a <b>ChargeBack</b></span>';
$_['entry_public_key'] = 'Public key:';
$_['entry_public_key_tooltip'] = '<span class="help">Public key to use transparent checkout. To obtain it, click <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials">here</a></span>';
$_['entry_access_token'] = 'Access Token:';
$_['entry_access_token_tooltip'] = '<span class="help">Access Token to use transparent checkout. To obtain it, click <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials">here</a></span>';
// Error
$_['error_permission'] = 'Sorry, you don\'t have permission to to modify MercadoPago';
$_['error_client_id'] = 'Sorry, your <b>Client Id</b> is mandatory.';
$_['error_client_secret'] = 'Sorry <b>Client Secret</b> is mandatory.';

// installments
$_['18'] = '18';
$_['15'] = '15';
$_['12'] = '12';
$_['9'] = '9';
$_['6'] = '6';
$_['3'] = '3';
$_['1'] = '1';
?>
