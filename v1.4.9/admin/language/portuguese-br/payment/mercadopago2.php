<?php
// Heading
$_['heading_title']						= 'Mercado Pago versão 2.0';

// Text
$_['text_ipn']						        = 'Configure a <b>Notificao instantania de pagamento</b> para receber atualizacoes automaticas de seus pedidos
                                                                  <a href="https://www.mercadopago.com/mlb/ferramentas/notificacoes" target="_blank">Clique aqui para configurar</a><br />
                                                                  Configure a URL como no exemplo: http//www.your_store_address_root.com/index.php?route=payment/mercadopago2/retorno/&';
$_['text_payment']						= 'Pagamento';
$_['text_success']						= 'Sucesso: Você alterou o módulo Mercadopago!';
$_['text_mercadopago2']						= '<a onclick="window.open(\'http://www.mercadopago.com/mp-brasil/\');" target="_blank"><img src="view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_argentina']						= 'Argentina';
$_['text_brasil']						= 'Brasil';
$_['text_colombia']						= 'Colômbia';
$_['text_chile']						= 'Chile';

// Entry
$_['entry_payments_not_accept']                                 = 'Formas de Pagamento que você não deseja aceitar<br /><br /><span class="help"> <b>Atenção</b> Caso altere o campo <b>País</b>, salve essa página antes de selecionar os meios de pagamento não aceitos</span>';
$_['entry_client_id']						= 'Cliente ID :  <span class="help">Essa informacao esta disponivel <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Aqui</a></span>';
$_['entry_client_secret']					= 'Client Secret : <span class="help">Essa informacao esta disponivel <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Aqui</a></span>';
$_['entry_installments']                                        = 'Número máximo de parcela aceitas';
$_['entry_status']						= 'Status:';
$_['entry_country']						= 'País:<br /><span class="help">Onde a loja está realizando as vendas:</span>';
$_['entry_sort_order']						= 'Ordem:';

$_['entry_url']                                                 = 'Url de pagamento aprovado:<br /><span class="help">Insira o domininio completo de instalacao da sua loja (utilize sempre o endereco com http:// <i>Ex. http://www.minhaloja.com/loja/</i><br /></span>';
$_['entry_debug']                                               = 'Debug mode: <br /><span class="help">Habilite essa opcao para que seja exibido erros gerados no checkout</span>';

$_['entry_order_status']					= 'Situação padrão da venda:<br /><span class="help">Selecione a situação padrão da venda.</span>';
$_['entry_order_status_completed']                              = 'Situação quando pagamento aprovado:<br /><span class="help">Selecione a situação quando a venda foi <b>Completada</b> e o pagamento foi <b>Confirmado</b></span>';
$_['entry_order_status_pending']                                = 'Situação quando o pagamento ainda está pendente:<br /><span class="help">Selecione a situação quando o pagamento ainda <b>não foi identificado</b> pelo MercadoPago</span>';
$_['entry_order_status_canceled']                               = 'Situação quando a transação está cancelada:';
$_['entry_order_status_in_process']			        = 'Em análise:<br /><span class="help">Selecione quando o pagamento está sendo <b>analisado</b> pelo MercadoPago</span>';
$_['entry_order_status_rejected']			        = 'Rejeitado:<br /><span class="help">Selecione a opção quando o pagamento não foi aprovado pelo MercadoPago</b></span>';
$_['entry_order_status_refunded']			        = 'Devolvido:<br /><span class="help">Selecione a opção quando o pagamento foi devolvido ao comprador</span>';
$_['entry_order_status_in_mediation']			        = 'Em Mediação:<br /><span class="help">Selecione a opção quando o comprador abriu uma <b>Mediação</b> no MercadoPago</span>';

// Error
$_['error_permission']						= 'Atenção: Você não tem permissão para modificar o módulo Mercadopago!';
$_['error_client_id']						= 'O Client Id é de preenchimento obrigatório';
$_['error_client_secret']					= 'O Client Secret é de preenchimento obrigatório';

// installments
$_['18']                                                        = '18';
$_['15']                                                        = '15';   
$_['12']                                                        = '12';
$_['9']                                                         = '9';
$_['6']                                                         = '6';
$_['3']                                                         = '3';
$_['1']                                                         = '1';
?>