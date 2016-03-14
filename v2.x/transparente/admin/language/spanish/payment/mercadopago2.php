<?php 
// Heading
$_['heading_title']                     = 'MercadoPago';

// Text
$_['text_payment']                      = 'Pago';
$_['text_success']                      = 'Éxito! Las modificaciones están listas!';
$_['text_mercadopago2']                     = '<a onclick="window.open(\'https://www.mercadopago.com\');" target="_blank"><img src="view/image/payment/mercadopago2.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_argentina']                        = 'Argentina';
$_['text_brasil']                       = 'Brasil';
$_['text_colombia']                     = 'Colombia';
$_['text_chile']                        = 'Chile';

// Entry
$_['entry_notification_url'] = 'Tu url de notificación es: ';
$_['entry_notification_url_tooltip'] = '<span class="help"> Esta dirección URL se utilizará para notificar automáticamente a los cambios de estado de los pagos. Copia la URL y haga clic en'.
                                       '<a href="https://www.mercadopago.com/mlb/ferramentas/notificacoes" target="_blank">aqui</a>para configurar esta opción en su cuenta MercadoPago.</span>';
$_['entry_autoreturn']                = 'Auto de regreso';
$_['entry_autoreturn_tooltip']        = '<span class="help"> Habilitar auto de regreso a su tienda después del checkout.</span>';
$_['entry_client_id']                       = 'Client ID : ' ;
$_['entry_client_id_tooltip']               = 'Para obtener estos datos :<a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> o <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> or
                                                                     <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> o <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a>';

$_['entry_client_secret']                   = 'Client Secret : ';
$_['entry_client_secret_tooltip']           = '<span class="help">Para obtener estos datos :<a href="https://www.mercadopago.com/mla/herramientas/aplicaciones" target="_blank">Arg</a> o <a href="https://www.mercadopago.com/mlm/herramientas/aplicaciones" target="_blank">Mex</a> or
                                                                    <a href="https://www.mercadopago.com/mlv/herramientas/aplicaciones" target="_blank">Ven</a> o <a href="https://www.mercadopago.com/mlb/ferramentas/aplicacoes" target="_blank">Bra</a></span>';

$_['entry_installments']                    = 'Cantidad máxima de cuotas';  
$_['entry_payments_not_accept']             = 'Selecciona los medios de pagos que vas a aceptar:';
$_['entry_payments_not_accept_tooltip']     = '<b>Importante</b> Cuando cambiar el país de las ventas, espera hasta la carga de los nuevos medios de pago y solo después selecciona los medios que vas a aceptar.</span>';
$_['entry_status']                      = 'Status:';
$_['entry_country']                     = 'País de las ventas:';
$_['entry_sort_order']                      = 'Orden:';

$_['entry_url']                                                 = 'Url de la tienda: ';
$_['entry_url_tooltip']                                         = '<span class="help"> Inserte la URL de instalación de tu tienda<br /> (Siempre escribe la URL con <b>http://</b> o <b>https://</b> )<br/><i>Ejemplo: http://www.mitienda.com/tienda/</i><br /></span>';
$_['entry_debug']                                               = 'Debug mode:';
$_['entry_debug_tooltip']                                       = '<span class="help">Habilita para exibir los errores de checkout en el log de OpenCart</span>';

$_['entry_sandbox']                                             = 'Sandbox mode: ';
$_['entry_sandbox_tooltip']                                     = '<span class="help">Sandbox es utilizado para hacer pruebas con Checkout y IPN sin necesitar de una tarjeta de credito valida para hacer los pagos.</span>';
$_['entry_type_checkout']                                       = 'Tipo de Checkout: ';
$_['entry_category']                                            = 'Categoria:';
$_['entry_category_tooltip']                                    = '<span class="help">La categoria de tu tienda</span>';

$_['entry_order_status']                    = 'Status estándar de ventas: ';
$_['entry_order_status_general']            = 'Elige los status exhibidos cuando las ventas estuvieren: ';
$_['entry_order_status_tooltip']            = '<span class="help">Elije los status estándar de tus ventas.</span>';
$_['entry_order_status_completed']          = 'Completa:';
$_['entry_order_status_completed_tooltip']  = '<span class="help"> Elije el status cuando el pago es <b>aprobado</b></span>';
$_['entry_order_status_pending']            = 'Pendiente:';
$_['entry_order_status_pending_tooltip']    = '<span class="help">Elije el status cuando el pago es <b>pendente</b></span>';
$_['entry_order_status_canceled']           = 'Canceleda:';
$_['entry_order_status_canceled_tooltip']   = '<span class="help">Elije el status cuando el pago es <b>cancelado</b> </span>';
$_['entry_order_status_in_process']         = 'En Progreso:';
$_['entry_order_status_in_process_tooltip'] = '<span class="help">Elije el status cuando el pago es <b>en el análisis</b></span>';
$_['entry_order_status_rejected']           = 'Rechazada:';
$_['entry_order_status_rejected_tooltip']   = '<span class="help">Elije el status cuando el pago es <b>rechazado</b></span>';
$_['entry_order_status_refunded']           = 'Reembolsado:';
$_['entry_order_status_refunded_tooltip']   = '<span class="help">Elije el status cuando el pago es<b>reembolsado</b></span>';
$_['entry_order_status_in_mediation']       = 'Mediación:';
$_['entry_order_status_in_mediation_tooltip'] = '<span class="help">Elije el status cuando el pago es en <b>mediación</b></span>';
$_['entry_order_status_chargeback'] 		= 'Chargeback'; 
$_['entry_order_status_chargeback_tooltip'] = '<span class="help">Elije el status cuando el pago es en <b>Chargeback</b></span>';
$_['entry_public_key']      = 'Public key:';
$_['entry_public_key_tooltip'] = '<span class="help">Public key para utilizar el checkout transparente. Para obtenerla, clique <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials">aquí</a></span>';
$_['entry_access_token']      = 'Access Token:';
$_['entry_access_token_tooltip'] = '<span class="help">Access Token para utilizar el checkout transparente. Para obtenerlo, clique <a target="_blank" href="https://www.mercadopago.com/mlb/account/credentials">aquí</a></span>';

// Error
$_['error_permission']                      = 'Lo siento, no tienes permiso para modificar MercadoPago';
$_['error_client_id']                       = 'Lo sient, el <b>Client Id</b> es obligatorio.';
$_['error_client_secret']                   = 'Lo siento, el <b>Client Secret</b> es obligatorio.';

// installments
$_['18']                                                        = '18';
$_['15']                                                        = '15';   
$_['12']                                                        = '12';
$_['9']                                                         = '9';
$_['6']                                                         = '6';
$_['3']                                                         = '3';
$_['1']                                                         = '1';    
?>