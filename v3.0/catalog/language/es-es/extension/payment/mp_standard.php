<?php

// Text
$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$admin = strpos($url, 'admin') !== FALSE ? '' : './admin/';

$_['text_title'] = '<img src="' . $admin . 'view/image/payment/mp_standard.png" alt="Mercadopago" title="Mercadopago" style="border: 1px solid #EEEEEE;"> - Checkout Básico';
$_['currency_no_support'] = 'La moneda seleccionada no es aceptada por Mercado Pago';
$_['ccnum_placeholder'] = 'Número de la tarjeta de crédito';
$_['expiration_date_placeholder'] = 'Fecha de vencimiento';
$_['name_placeholder'] = 'Nombre (como esta escrito en la tarjeta)';
$_['doctype_placeholder'] = 'Tipo de documento';
$_['docnumber_placeholder'] = 'Número de documento';
$_['expiration_month_placeholder'] = 'Mes de expiración';
$_['expiration_year_placeholder'] = 'Año de expiración';
$_['error_invalid_payment_type'] = 'Medio de pago no aceptado.';
$_['installments_placeholder'] = 'Parcelas';
$_['issuer_placeholder'] = 'Banco';
$_['cardType_placeholder'] = 'Tipo de Pago';
$_['payment_processing'] = 'Procesando el pago';
$_['payment_title'] = 'Pago';
$_['payment_button'] = 'Pagar';

// Payment messages
$_['S200'] = 'Pago aprobado!';
$_['S201'] = $_['S200'];
$_['S2000'] = 'Pago no encontrado';
$_['S4'] = 'Caller no tiene autorización para acceder a esta función.';
$_['S2041'] = 'Sólo los administradores pueden ejecutar la acción solicitada.';
$_['S3002'] = 'Caller no tiene autorización para ejecutar esta acción.';
$_['S1'] = 'Errores en los parámetros';
$_['S3'] = 'Token debe ser de testeo';
$_['S5'] = 'Es necesario informar su access_token para continuar.';
$_['S1000'] = 'Número de líneas excede el limite.';
$_['S1001'] = 'Formato de fecha debe ser yyyy-MM-dd\'T\'HH:mm:ss.SSSZ.';
$_['S2001'] = 'Solicitud enviada en el minuto anterior.';
$_['S2004'] = 'POST para la API de Gateway Transactions ha fallado.';
$_['S2002'] = 'Customer no encontrado.';
$_['S2006'] = 'Card Token no encontrado.';
$_['S2007'] = 'Conexión con la API de Card Token ha fallado.';
$_['S2009'] = 'Card token issuer no puede ser nulo.';
$_['S2010'] = 'Tarjeta no encontrada.';
$_['S2013'] = 'profileId inválido';
$_['S2014'] = 'reference_id inválido';
$_['S2015'] = 'Scope inválido';
$_['S2016'] = 'Status inválido para la actualización';
$_['S2017'] = 'transaction_amount inválido para la actualización';
$_['S2018'] = 'La acción solicitada no es válida para el estado atual de pago.';
$_['S2020'] = 'Customer no tiene permiso de operar.';
$_['S2021'] = 'Collector no tiene permiso de operar.';
$_['S2022'] = 'Limite de reembolsos excedido para este pago.';
$_['S2024'] = 'pago fuera del período de devolución.';
$_['S2025'] = 'Operation type no permitido para devolución.';
$_['S2027'] = 'La acción solicitada es inválida para este tipo de pago.';
$_['S2029'] = 'pago sin cambios.';
$_['S2030'] = 'Collector no tiene saldo disponible.';
$_['S2031'] = 'Collector no tiene saldo suficiente disponible.';
$_['S2034'] = 'Usuários inválidos involucrados.';
$_['S2035'] = 'Parámetros inválidos para la API de preferencias.';
$_['S2036'] = 'Contexto inválido.';
$_['S2038'] = 'campaign_id es inválido.';
$_['S2039'] = 'coupon_code es inválido.';
$_['S2040'] = 'Email del usuário no existe.';
$_['S2060'] = 'Vendedor y comprador no pueden ser el mismo usuário.';
$_['S3000'] = 'Rellena el campo \'Nombre\' igual a lo que está en su Tarjeta.';
$_['S3001'] = 'Debes enviar el cardissuer_id con los datos de la Tarjeta';
$_['S3003'] = 'card_token_id es inválido';
$_['S3004'] = 'site_id es inválido';
$_['S3005'] = 'Acción inválida, el recurso está en un estado que no permite esta operación. Para obtener más información, vea el estado del recurso.';
$_['S3006'] = 'cardtoken_id inválido.';
$_['S3007'] = 'El parámetro client_id no puede ser nulo o vacio.';
$_['S3008'] = 'Cardtoken no encontrado.';
$_['S3009'] = 'client_id no autorizado.';
$_['S3010'] = 'Tarjeta no encontrada en la white list.';
$_['S3011'] = 'payment_method no encontrado.';
$_['S3012'] = 'security_code_length inválido.';
$_['S3013'] = 'El parámetro security_code es un campo obligatorio y no puede ser nulo o vacio.';
$_['S3014'] = 'payment_method es inválido';
$_['S3015'] = 'Cantidad de dígitos de la Tarjeta es inválido.';
$_['S3016'] = 'Número de Tarjeta es inválido.';
$_['S3017'] = 'El parámetro card_number_id no puede ser nulo o vacio.';
$_['S3018'] = 'El parámetro expiration_month no puede ser nulo o vacio.';
$_['S3019'] = 'El parámetro expiration_year no puede ser nulo o vacio.';
$_['S3020'] = 'El parámetro cardholder.name no puede ser nulo o vacio.';
$_['S3021'] = 'El parámetro cardholder.document.number no puede ser nulo o vacio.';
$_['S3022'] = 'El parámetro cardholder.document.type no puede ser nulo o vacio.';
$_['S3023'] = 'El parámetro cardholder.document.subtype no puede ser nulo o vacio.';
$_['S3024'] = 'Acción inválida - devolución parcial no soportada para la transacción';
$_['S3025'] = 'Auth Code es inválido.';
$_['S3026'] = 'card_id inválido para este payment_method_id';
$_['S3027'] = 'payment_type_id es inválido.';
$_['S3028'] = 'payment_method_id es inválido.';
$_['S3029'] = 'Mes de expiración de la Tarjeta es inválido.';
$_['S3030'] = 'Año de expiración de la Tarjeta es inválido.';
$_['S4000'] = 'Atributo del Tarjeta no puede ser nulo.';
$_['S4001'] = 'payment_method_id no puede ser nulo.';
$_['S4002'] = 'transaction_amount no puede ser nulo.';
$_['S4003'] = 'transaction_amount debe ser numérico.';
$_['S4004'] = 'installments no puede ser nulo.';
$_['S4005'] = 'installments debe ser numérico.';
$_['S4006'] = 'payer en formato incorrecto';
$_['S4007'] = 'site_id no puede ser nulo.';
$_['S4012'] = 'payer.id no puede ser nulo.';
$_['S4013'] = 'payer.type no puede ser nulo.';
$_['S4015'] = 'payment_method_reference_id no puede ser nulo.';
$_['S4016'] = 'payment_method_reference_id debe ser numérico.';
$_['S4017'] = 'status no puede ser nulo.';
$_['S4018'] = 'payment_id no puede ser nulo.';
$_['S4019'] = 'payment_id debe ser numérico.';
$_['S4020'] = 'notificaction_url debe ser una URL válida.';
$_['S4021'] = 'notificaction_url debe tener menos que 500 caracteres.';
$_['S4022'] = 'metadata debe ser un JSON válido.';
$_['S4023'] = 'transaction_amount no puede ser nulo.';
$_['S4024'] = 'transaction_amount debe ser numérico.';
$_['S4025'] = 'refund_id no puede ser nulo.';
$_['S4026'] = 'coupon_amount inválido.';
$_['S4027'] = 'campaign_id debe ser numérico.';
$_['S4028'] = 'coupon_amount debe ser numérico.';
$_['S4029'] = 'payer type inválido.';
$_['S4037'] = 'transaction_amount inválido.';
$_['S4038'] = 'application_fee no puede ser más grande que transaction_amount.';
$_['S4039'] = 'application_fee no puede ser un valor negativo.';
$_['S4050'] = 'payer.email debe ser un email válido.';
$_['S4051'] = 'payer.email debe tener menos de 254 caracteres.';

// Token messages
$_['T310'] = 'Parámetro inválido: \'internal_client_id\'';
$_['T200'] = 'El parámetro \'public_key\' debe tener un valor válido';
$_['T302'] = 'Parámetro inválido: \'public_key\'';
$_['T219'] = 'El parámetro \'client_id\' debe tener un valor válido';
$_['T315'] = 'Parámetro inválido: \'site_id\'';
$_['T222'] = 'El parámetro \'site_id\' es un campo obligatorio';
$_['T318'] = 'Parámetro inválido: \'card_number_id\'';
$_['T304'] = 'Parámetro inválido: \'card_number_length\'';
$_['T703'] = 'Tamaño inválido del campo \'card_number_length\'';
$_['T319'] = 'Parámetro inválido: \'trunc_card_number\'';
$_['T701'] = 'Tamaño inválido del campo \'trunc_card_number\'';
$_['T321'] = 'Parámetro inválido: \'security_code_id\'';
$_['T700'] = 'Tamaño inválido del campo \'security_code_id\'';
$_['T307'] = 'Parámetro inválido: \'security_code_length\'';
$_['T704'] = 'Tamaño inválido del campo \'security_code_length\'';
$_['T305'] = 'Datos del dueño de la tarjeta inválidos.';
$_['T210'] = 'El valor \'cardholder\' no puede ser nulo';
$_['T316'] = 'Parámetro inválido: \'cardholder.name\'';
$_['T211'] = 'El valor \'cardholder.identification\' no puede ser nulo';
$_['T322'] = 'Parámetro inválido: \'cardholder.identification.type\'';
$_['T323'] = 'Parámetro inválido: \'cardholder.identification.subtype\'';
$_['T213'] = 'El parámetro \'cardholder.identification.subtype\' debe tener un valor válido';
$_['T324'] = 'Parámetro inválido: \'cardholder.identification.number\'';
$_['T325'] = 'Parámetro inválido: \'expiration_month\'';
$_['T326'] = 'Parámetro inválido: \'cardExpirationYear\'';
$_['T702'] = 'Parámetro inválido: \'expiration_year\'';
$_['T301'] = 'Fecha de expiración de la tarjeta inválida';
$_['T317'] = 'Parámetro inválido: \'card_id\'';
$_['T320'] = 'Parámetro inválido: \'luhn_validation\'';
$_['TE111'] = 'JSON inválido';
$_['TE114'] = 'El parámetro cardholderName no puede ser nulo o vacio';
$_['TE115'] = 'El parámetro public_key no puede ser nulo o vacio';
$_['TE202'] = 'Parámetro inválido: cardNumber';
$_['TE203'] = 'Parámetro inválido: securityCode';
$_['TE213'] = 'Parámetro inválido: card_present';
$_['TE301'] = 'Largo del parámetro cardNumber inválido';
$_['TE302'] = 'Largo del parámetro securityCode inválido';
$_['TE305'] = 'Largo del parámetro docType inválido';
$_['TE501'] = 'public_key no encontrada';

$_['T205'] = 'Digite el número de su tarjeta.';
$_['T208'] = 'Seleccione el mes.';
$_['T209'] = 'Seleccione el año.';
$_['T212'] = 'Seleccione el tipo de documento.';
$_['T213'] = 'Seleccione el subtipo de documento';
$_['T214'] = 'Digite el número del su documento';
$_['T220'] = 'Seleccione el banco emisor';
$_['T221'] = 'Digite su nombre completo';
$_['T224'] = 'Digite el código de seguridad de la tarjeta';
$_['TE301'] = 'Hay un error en el número de su tarjeta. Por favor, escriba nuevamente.';
$_['TE302'] = 'Verifique el código de seguridad';
$_['T316'] = 'Digite un nombre válido';
$_['T322'] = 'Verifique el tipo de documento.';
$_['T323'] = 'Verifique el tipo de documento.';
$_['T324'] = 'Verifique el número del documento.';
$_['T325'] = 'Mes de expiración inválido.';
$_['T326'] = 'Año de expiración inválido.';

$_['S106'] = 'No se pueden realizar compras en otros países.';
$_['S109'] = 'Escoja otra tarjeta.';
$_['S126'] = 'No es posible procesar su pago.';
$_['S129'] = 'Escoja otra tarjeta.';
$_['S145'] = 'No es posible procesar su pago.';
$_['S150'] = 'Usted no puede efectuar pagos.';
$_['S151'] = 'Usted no puede efectuarpagos.';
$_['S160'] = 'No es posible procesar su pago.';
$_['S204'] = 'Medio de pago no disponible. Escoja otra tarjeta.';
$_['S801'] = 'Intente nuevamente en algunos minutos.';

$_['text_total'] = 'Envío, descuentos, impuestos y tasas';