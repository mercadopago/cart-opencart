<?php

include_once dirname(__FILE__) . '/../../../../../catalog/controller/extension/payment/lib/mp_util.php';

$mp_util = new MPOpencartUtil();
$moduleVersion = $mp_util->getModuleVersion();

// Heading
$_['heading_title'] = 'Mercado Pago - Básico' . ' (v' .$moduleVersion . ')';
$_['text_mp_standard'] = '<a onclick="window.open(\'https://www.mercadopago.com\');" target="_blank"><img src="view/image/payment/mp_standard.png" alt="Mercado Pago" title="Mercado Pago" style="border: 1px solid #EEEEEE;" /></a> <br /><b> Checkout Básico</b>';

// Other translations
$_['text_edit'] = 'Editar';
$_['text_enabled'] = 'Ativado';
$_['text_disabled'] = 'Desativado';
$_['text_yes'] = 'Sim';
$_['text_no'] = 'Não';
$_['button_save'] = 'Salvar';
$_['button_cancel'] = 'Cancelar';

// Credentials
$_['entry_credentials_client_id'] = 'Client ID: ';
$_['entry_credentials_client_secret'] = 'Client Secret: ';
$_['entry_credentials_basic_tooltip'] = 'Obtenha esses valores para seu país em: ' .
	'<a href="https://www.mercadopago.com/mla/account/credentials?type=basic" target="_blank">Argentina</a>, ' .
	'<a href="https://www.mercadopago.com/mlb/account/credentials?type=basic" target="_blank">Brasil</a>, ' .
	'<a href="https://www.mercadopago.com/mlc/account/credentials?type=basic" target="_blank">Chile</a>, ' .
	'<a href="https://www.mercadopago.com/mco/account/credentials?type=basic" target="_blank">Colômbia</a>, ' .
	'<a href="https://www.mercadopago.com/mlm/account/credentials?type=basic" target="_blank">México</a>, ' .
	'<a href="https://www.mercadopago.com/mpe/account/credentials?type=basic" target="_blank">Peru</a>, ' .
	'<a href="https://www.mercadopago.com/mlu/account/credentials?type=basic" target="_blank">Uruguai</a>, ou ' .
	'<a href="https://www.mercadopago.com/mlv/account/credentials?type=basic" target="_blank">Venezuela</a>';

// Store entries
$_['entry_country'] = 'País das vendas:';
$_['entry_type_checkout'] = 'Tipo de Checkout:';
$_['entry_category'] = 'Categoria:';
$_['entry_category_tooltip'] = 'Selecione a categoria que melhor descreve a sua loja';
$_['entry_debug'] = 'Modo Debug:';
$_['entry_debug_tooltip'] = 'Habilite para exibir os erros no checkout';
$_['entry_autoreturn'] = 'Auto Retorno:';
$_['entry_autoreturn_tooltip'] = 'Habilita o retorno automático para a sua loja depois do pagamento.';
$_['entry_sandbox'] = 'Modo Sandbox:';
$_['entry_sandbox_tooltip'] = 'Sandbox é utilizado para testar o Checkout e Notificações de pagamento sem precisar de um cartão válido para aprovar a compra de teste.';
$_['entry_installments'] = 'Parcelas:';
$_['entry_installments_tooltip'] = 'Quantidade máxima de parcelas';
$_['entry_payments_not_accept'] = 'Excluir Pagamentos:';
$_['entry_payments_not_accept_tooltip'] = 'Marque quais meios de pagamento você não deseja aceitar. <b>Importante:</b> Caso troque o país de venda, espere até que os novos meio de pagamento estejam carregados.';
$_['entry_sponsor'] = 'Patrocinador ID: ';
// Order statuses
$_['entry_order_status_approved'] = 'Pgto Aprovado, Pedido fica';
$_['entry_order_status_approved_tooltip'] = 'Escolha o status do pedido caso o pagamento seja <b>Aprovado</b>';
$_['entry_order_status_pending'] = 'Pgto Pendente, Pedido fica';
$_['entry_order_status_pending_tooltip'] = 'Escolha o status do pedido caso o pagamento ainda não tenha sido feito';
$_['entry_order_status_canceled'] = 'Pgto Cancelado, Pedido fica';
$_['entry_order_status_canceled_tooltip'] = 'Escolha o status do pedido caso o pagamento seja <b>Cancelado</b>';
$_['entry_order_status_in_process'] = 'Pgto Em Progresso, Pedido fica';
$_['entry_order_status_in_process_tooltip'] = 'Escolha o status do pedido caso o pagamento seja <b>Em Análise</b>';
$_['entry_order_status_rejected'] = 'Pgto Rejeitado, Pedido fica';
$_['entry_order_status_rejected_tooltip'] = 'Escolha o status do pedido caso o pagamento seja <b>Rejeitado</b>';
$_['entry_order_status_refunded'] = 'Pgto Devolvido, Pedido fica';
$_['entry_order_status_refunded_tooltip'] = 'Escolha o status do pedido caso o pagamento seja <b>Devolvido</b>';
$_['entry_order_status_in_mediation'] = 'Pgto Em Mediação, Pedido fica';
$_['entry_order_status_in_mediation_tooltip'] = 'Escolha o status do pedido caso o pagamento esteja sob <b>Mediação</b>';
$_['entry_order_status_chargeback'] = 'Pgto Extornado, Pedido fica';
$_['entry_order_status_chargeback_tooltip'] = 'Escolha o status do pedido caso o pagamento seja <b>Extornado</b>';

// Messages
$_['error_entry_credentials_basic'] = 'Desculpe, sua <b>Client Id</b> e <b>Client Secret</b> são obrigatórias.';
$_['error_entry_no_payments'] = 'Desculpe, não há meios de pagamento disponíveis.';
$_['text_success'] = 'Successo, suas modificações foram salvas!';
$_['error_sponsor_span'] = 'ID do Patrocinador inválido. Este campo não é obrigatório, se você não conhece seu Patrocinador, limpe este campo!';
// installments
$_['18'] = '18';
$_['15'] = '15';
$_['12'] = '12';
$_['9'] = '9';
$_['6'] = '6';
$_['3'] = '3';
$_['1'] = '1';

?>
