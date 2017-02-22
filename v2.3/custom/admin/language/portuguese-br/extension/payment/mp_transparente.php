<?php
// Heading
$_['heading_title'] = 'Mercado Pago - Custom Checkout';

// Text
$_['text_payment'] = 'Pagamento';
$_['text_success'] = 'Successo, suas modificações foram salvas!';
$_['text_mp_transparente'] = '<a onclick="window.open(\'https://www.mercadopago.com\');" target="_blank"><img src="view/image/payment/mp_transparente.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE; background-color: white;" /></a> <br /><b> Custom Checkout</b>';
$_['text_argentina'] = 'Argentina';
$_['text_brasil'] = 'Brasil';
$_['text_colombia'] = 'Colombia';
$_['text_chile'] = 'Chile';

// Entry
$_['entry_notification_url'] = 'Sua URL de notificação é: ';
$_['entry_notification_url_tooltip'] = '<span class="help"> Esta URL será utilizada para notificar automaticamente as alterações de status dos pagamentos. Copie a URL e clique' .
	'<a href="https://www.mercadopago.com/mlb/ferramentas/notificacoes" target="_blank">aqui</a>para configurar esta opção na sua conta MercadoPago.</span>';
$_['entry_autoreturn'] = 'Auto Retorno';
$_['entry_autoreturn_tooltip'] = '<span class="help"> Habilita o retorno automático para a sua loja depois do pagamento. </span>';
$_['entry_client_id'] = 'Client ID : ';
$_['entry_client_id_tooltip'] = 'Para obter esta informação: <a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> ou <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> ou
                                                                     <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> ou <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a>';

$_['entry_client_secret'] = 'Client Secret : ';
$_['entry_client_secret_tooltip'] = 'Para obter esta informação: <a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> ou <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> ou
                                                                     <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> ou <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a>';

$_['entry_installments'] = 'Quantidade máxima de parcelas';
$_['entry_payments_not_accept'] = 'Marque quais meios de pagamento você deseja aceitar:';
$_['entry_payments_not_accept_tooltip'] = '<b>Importante</b> Caso troque o país de venda, espere até que os novos meio de pagamento estejam carregados.</span>';

$_['entry_status'] = 'Status:';
$_['entry_country'] = 'País das vendas:';
$_['entry_sort_order'] = 'Sort order:';

$_['entry_url'] = 'URL da loja: ';
$_['entry_url_tooltip'] = '<span class="help">Insira aqui a URL da sua loja<br /> (Sempre escreva com <b>http://</b> ou <b>https://</b> )<br/><i>Ex. http://www.minhaloja.com/loja/</i><br /></span>';
$_['entry_debug'] = 'Modo Debug:';
$_['entry_debug_tooltip'] = '<span class="help">Habilite para exibir os erros no checkout</span>';

$_['entry_sandbox'] = 'Modo Sandbox: ';
$_['entry_coupon'] = 'Cúpom de Desconto: ';
$_['entry_coupon_tooltip'] = '<span class="help">* Opção válida apenas para sites participantes de campanhas de cupom.</span>';
$_['entry_sandbox_tooltip'] = '<span class="help">Sandbox é utilizado para testar o Checkout e Notificações de pagamento sem precisar de um cartão válido para aprovar a compra de teste.</span>';
$_['entry_type_checkout'] = 'Tipo de Checkout: ';
$_['entry_category'] = 'Categoria:';
$_['entry_category_tooltip'] = '<span class="help">Selecione a categoria que melhor descreve a sua loja</span>';

$_['entry_order_status'] = 'Status padrão da compra: ';
$_['entry_order_status_general'] = 'Selecione os status a serem exibidos quando a compra estiver: ';
$_['entry_order_status_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas.</span>';
$_['entry_order_status_completed'] = 'Completa:';
$_['entry_order_status_completed_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas cujo pagamento foi <b>aprovado</b>.</span>';
$_['entry_order_status_pending'] = 'Pendente:';
$_['entry_order_status_pending_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas ainda não pagas.</span>';
$_['entry_order_status_canceled'] = 'Cancelada:';
$_['entry_order_status_canceled_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas cujo pagamento foi <b>cancelado</b> </span>';
$_['entry_order_status_in_process'] = 'Em progresso:';
$_['entry_order_status_in_process_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas cujo pagamento está <b>sendo analisado</b></span>';
$_['entry_order_status_rejected'] = 'Rejeitada:';
$_['entry_order_status_rejected_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas cujo pagamento foi <b>rejeitado</b></span>';
$_['entry_order_status_refunded'] = 'Estornada:';
$_['entry_order_status_refunded_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas cujo pagamento foi <b>estornado</b></span>';
$_['entry_order_status_in_mediation'] = 'Mediação:';
$_['entry_order_status_in_mediation_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas cujo pagamento está <b> em mediação</b></span>';
$_['entry_order_status_chargeback'] = 'Chargeback';
$_['entry_order_status_chargeback_tooltip'] = '<span class="help">Selecione o status padrão para suas vendas cujo pagamento está <b>Chargeback</b></span>';
$_['entry_public_key'] = 'Public key:';
$_['entry_public_key_tooltip'] = '<span class="help">Public key para utilizar o checkout transparente. Para obtê-la, clique <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials">aqui</a></span>';
$_['entry_access_token'] = 'Access Token:';
$_['entry_access_token_tooltip'] = '<span class="help">Access Token para utilizar o checkout transparente. Para obtê-lo, clique <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials">aqui</a></span>';

// Error
$_['error_permission'] = 'Desculpe, você não possui permissão para modificar o módulo MercadoPago';
$_['error_client_id'] = 'Desculpe, o <b>Client Id</b> é obrigatório.';
$_['error_client_secret'] = 'Desculpe, o <b>Client Secret</b> é obrigatório.';

// installments
$_['18'] = '18';
$_['15'] = '15';
$_['12'] = '12';
$_['9'] = '9';
$_['6'] = '6';
$_['3'] = '3';
$_['1'] = '1';
?>
