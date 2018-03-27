<?php

// Heading
$_['heading_title'] = 'Mercado Pago - Standard';

// Other translations
$_['text_edit'] = 'Edit';
$_['text_enabled'] = 'Enabled';
$_['text_disabled'] = 'Disabled';
$_['text_yes'] = 'Yes';
$_['text_no'] = 'No';
$_['button_save'] = 'Save';
$_['button_cancel'] = 'cancel';

// Credentials
$_['entry_credentials_client_id'] = 'Client ID: ';
$_['entry_credentials_client_secret'] = 'Client Secret: ';
$_['entry_credentials_basic_tooltip'] = 'Get these fields for your country in: ' .
	'<a href="https://www.mercadopago.com/mla/account/credentials?type=basic" target="_blank">Argentina</a>, ' .
	'<a href="https://www.mercadopago.com/mlb/account/credentials?type=basic" target="_blank">Brazil</a>, ' .
	'<a href="https://www.mercadopago.com/mlc/account/credentials?type=basic" target="_blank">Chile</a>, ' .
	'<a href="https://www.mercadopago.com/mco/account/credentials?type=basic" target="_blank">Colombia</a>, ' .
	'<a href="https://www.mercadopago.com/mlm/account/credentials?type=basic" target="_blank">Mexico</a>, ' .
	'<a href="https://www.mercadopago.com/mpe/account/credentials?type=basic" target="_blank">Peru</a>, ' .
	'<a href="https://www.mercadopago.com/mlu/account/credentials?type=basic" target="_blank">Uruguay</a>, or ' .
	'<a href="https://www.mercadopago.com/mlv/account/credentials?type=basic" target="_blank">Venezuela</a>';
// Store entries
$_['entry_country'] = 'Sales Country:';
$_['entry_type_checkout'] = 'Type Checkout:';
$_['entry_category'] = 'Category:';
$_['entry_category_tooltip'] = 'Select the category that best fits your shop';
$_['entry_debug'] = 'Debug mode:';
$_['entry_debug_tooltip'] = 'Turn on to show the erro log on checkout';
$_['entry_autoreturn'] = 'Auto Return: ';
$_['entry_autoreturn_tooltip'] = 'Enables auto return to your store after the checkout is finished.';
$_['entry_sandbox'] = 'Sandbox mode:';
$_['entry_sandbox_tooltip'] = 'Sandbox is used for testing the Checkout and IPN. No need for a valid credit card to approve to purchase test.';
$_['entry_installments'] = 'Installments:';
$_['entry_installments_tooltip'] = 'Maximum accepted payments';
$_['entry_payments_not_accept'] = 'Exclude Payments:';
$_['entry_payments_not_accept_tooltip'] = 'Check the payments methods that you do not want to accept. <b>Important:</b> If you change sales country, wait until the full load of the payment methods.';
// Order statuses
$_['entry_order_status_approved'] = 'Payment Approved, Order is';
$_['entry_order_status_approved_tooltip'] = 'Select the status order case the payment was <b>Approved</b>';
$_['entry_order_status_pending'] = 'Payment Pending, Order is';
$_['entry_order_status_pending_tooltip'] = 'Select the status order when the buyer did not finish the payment yet';
$_['entry_order_status_canceled'] = 'Payment Canceled, Order is';
$_['entry_order_status_canceled_tooltip'] = 'Select the status order case the payment was <b>Cancelled</b>';
$_['entry_order_status_in_process'] = 'Payment In Progress, Order is';
$_['entry_order_status_in_process_tooltip'] = 'Select the status order case the payment was <b>Under Analysing</b>';
$_['entry_order_status_rejected'] = 'Payment Reject, Order is';
$_['entry_order_status_rejected_tooltip'] = 'Select the status order case the payment was <b>Reject</b>';
$_['entry_order_status_refunded'] = 'Payment Refunded, Order is';
$_['entry_order_status_refunded_tooltip'] = 'Select the status order case the payment was <b>Refunded</b>';
$_['entry_order_status_in_mediation'] = 'Payment Mediation, Order is';
$_['entry_order_status_in_mediation_tooltip'] = 'Select the status order case the payment was under <b>Mediation</b>';
$_['entry_order_status_chargeback'] = 'Payment Chargeback, Order is';
$_['entry_order_status_chargeback_tooltip'] = 'Select the status order case the payment was a <b>ChargeBack</b>';
// Errors
$_['error_entry_credentials_basic'] = 'Sorry, your <b>Client Id</b> and <b>Client Secret</b> are mandatory.';
$_['error_entry_no_payments'] = 'Sorry, there is no payment methods available.';













// Other translations
$_['text_success'] = 'Success, your modifications are done!';





// Text
$_['text_payment'] = 'Payment';

$_['text_mp_standard'] = '<a onclick="window.open(\'https://www.mercadopago.com\');" target="_blank"><img src="view/image/payment/mp_standard.png" alt="Mercado Pago" title="Mercado Pago" style="border: 1px solid #EEEEEE;" /></a> <br /><b> Standard Checkout</b>';
$_['text_argentina'] = 'Argentina';
$_['text_brasil'] = 'Brasil';
$_['text_colombia'] = 'Colombia';
$_['text_chile'] = 'Chile';

// Entry
$_['entry_notification_url'] = 'Your notification URL is: ';
$_['entry_notification_url_tooltip'] = '<span class="help"> This URL will be used to notify your store about payments and orders. Copy this URL and click ' .
	'<a href="https://www.mercadopago.com/mlb/ferramentas/notificacoes" target="_blank">here</a> to configure your Mercado Pago account.</span>';






$_['entry_status'] = 'Status:';

$_['entry_sort_order'] = 'Sort order:';

$_['entry_url'] = 'Store Url: ';
$_['entry_url_tooltip'] = '<span class="help">Insert your store root url installation<br /> (Always write the url with <b>http://</b> or <b>https://</b> )<br/><i>IE. http://www.mystore.com/store/</i><br /></span>';

$_['entry_public_key'] = 'Public key:';
$_['entry_public_key_tooltip'] = '<span class="help">Public key to use transparent checkout. To obtain it, click <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials">here</a></span>';
$_['entry_access_token'] = 'Access Token:';
$_['entry_access_token_tooltip'] = '<span class="help">Access Token to use transparent checkout. To obtain it, click <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials">here</a></span>';
// Error
$_['error_permission'] = 'Sorry, you don\'t have permission to modify Mercado Pago';




?>