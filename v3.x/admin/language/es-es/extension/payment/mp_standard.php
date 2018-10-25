<?php

include_once dirname(__FILE__) . '/../../../../../catalog/controller/extension/payment/lib/mp_util.php';

$mp_util = new MPOpencartUtil();
$moduleVersion = $mp_util->getModuleVersion();

// Heading
$_['heading_title'] = 'Mercado Pago - Básico' . ' (v' .$moduleVersion . ')';
$_['text_mp_standard'] = '<a onclick="window.open(\'https://www.mercadopago.com\');" target="_blank"><img src="view/image/payment/mp_standard.png" alt="Mercado Pago" title="Mercado Pago" style="border: 1px solid #EEEEEE;" /></a> <br /><b> Checkout Básico</b>';

// Other translations
$_['text_edit'] = 'Edit';
$_['text_enabled'] = 'Activado';
$_['text_disabled'] = 'Desactivado';
$_['text_yes'] = 'Sí';
$_['text_no'] = 'No';
$_['button_save'] = 'Guardar';
$_['button_cancel'] = 'Cancelar';

// Credentials
$_['entry_credentials_client_id'] = 'Client ID: ';
$_['entry_credentials_client_secret'] = 'Client Secret: ';
$_['entry_credentials_basic_tooltip'] = 'Encontra eses campos para su país en: ' .
	'<a href="https://www.mercadopago.com/mla/account/credentials?type=basic" target="_blank">Argentina</a>, ' .
	'<a href="https://www.mercadopago.com/mlb/account/credentials?type=basic" target="_blank">Brazil</a>, ' .
	'<a href="https://www.mercadopago.com/mlc/account/credentials?type=basic" target="_blank">Chile</a>, ' .
	'<a href="https://www.mercadopago.com/mco/account/credentials?type=basic" target="_blank">Colombia</a>, ' .
	'<a href="https://www.mercadopago.com/mlm/account/credentials?type=basic" target="_blank">Mexico</a>, ' .
	'<a href="https://www.mercadopago.com/mpe/account/credentials?type=basic" target="_blank">Peru</a>, ' .
	'<a href="https://www.mercadopago.com/mlu/account/credentials?type=basic" target="_blank">Uruguay</a>, o ' .
	'<a href="https://www.mercadopago.com/mlv/account/credentials?type=basic" target="_blank">Venezuela</a>';

// Store entries
$_['entry_country'] = 'País de Ventas:';
$_['entry_type_checkout'] = 'Tipo de Checkout:';
$_['entry_category'] = 'Categoría:';
$_['entry_category_tooltip'] = 'Elije la categoría que mejor se adapta a su tienda';
$_['entry_debug'] = 'Modo Debug:';
$_['entry_debug_tooltip'] = 'Activa para mostrar el registro de error al finalizar la compra';
$_['entry_autoreturn'] = 'Retorno automático:';
$_['entry_autoreturn_tooltip'] = 'Permite el retorno automático a su tienda después de que finalice el pago.';
$_['entry_sandbox'] = 'Modo Sandbox:';
$_['entry_sandbox_tooltip'] = 'Sandbox se usa para probar Checkout e IPN. No es necesario que una tarjeta de crédito válida par aprobar la compra.';
$_['entry_installments'] = 'Cuotas:';
$_['entry_installments_tooltip'] = 'Pagos máximos aceptados';
$_['entry_payments_not_accept'] = 'Excluir pagos:';
$_['entry_payments_not_accept_tooltip'] = 'Verifique los métodos de pago que no quiere aceptar. <b>Importante:</b> Si cambia el país de ventas, espere hasta la carga completa de los métodos de pago.';
$_['entry_sponsor'] = 'Patrocinador ID: ';
// Order statuses
$_['entry_order_status_approved'] = 'Pago Aprobado, Pedido es';
$_['entry_order_status_approved_tooltip'] = 'Elije el estado de pedido cuando el pago es <b>Aprobado</b>';
$_['entry_order_status_pending'] = 'Pago Pendiente, Pedido es';
$_['entry_order_status_pending_tooltip'] = 'Elije el estado de pedido cuando el pago no fue hecho aun';
$_['entry_order_status_canceled'] = 'Pago Cancelado, Pedido es';
$_['entry_order_status_canceled_tooltip'] = 'Elije el estado de pedido cuando el pago es <b>Cancelado</b>';
$_['entry_order_status_in_process'] = 'Pago En Progreso, Pedido es';
$_['entry_order_status_in_process_tooltip'] = 'Elije el estado de pedido cuando el pago es <b>En Análisis</b>';
$_['entry_order_status_rejected'] = 'Pago Rechazado, Pedido es';
$_['entry_order_status_rejected_tooltip'] = 'Elije el estado de pedido cuando el pago es <b>Rechazado</b>';
$_['entry_order_status_refunded'] = 'Pago Reembolsado, Pedido es';
$_['entry_order_status_refunded_tooltip'] = 'Elije el estado de pedido cuando el pago es <b>Reembolsado</b>';
$_['entry_order_status_in_mediation'] = 'Pago Mediación, Pedido es';
$_['entry_order_status_in_mediation_tooltip'] = 'Elije el estado de pedido cuando el pago está en <b>Mediación</b>';
$_['entry_order_status_chargeback'] = 'Pago Chargeback, Pedido es';
$_['entry_order_status_chargeback_tooltip'] = 'Elije el estado de pedido cuando el pago es <b>Chargeback</b>';

// Messages
$_['error_entry_credentials_basic'] = 'Lo siento, su <b>Client Id</b> y <b>Client Secret</b> son obligatorios.';
$_['error_entry_no_payments'] = 'Lo siento, no hay medios de pago disponibles.';
$_['text_success'] = 'Éxito! Las modificaciones están listas!';
$_['error_sponsor_span'] = 'ID del Patrocinador inválido. Este campo no es obligatorio. Si no conoce a su Patrocinador, ¡limpie este campo!';
// installments
$_['18'] = '18';
$_['15'] = '15';
$_['12'] = '12';
$_['9'] = '9';
$_['6'] = '6';
$_['3'] = '3';
$_['1'] = '1';

?>
