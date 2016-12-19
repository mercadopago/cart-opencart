<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>


<base href="<?php echo $base; ?>" />
</head>
<body>
<div class="div-ajax-carregamento-pagina"></div>
<div>Aguarde...</div>

<script type="text/javascript"  src="https://secure.mlstatic.com/modules/javascript/analytics.js">

</script>

<script type="text/javascript">

    ModuleAnalytics.setToken("<?php echo $token; ?>");
	ModuleAnalytics.setPaymentId("<?php echo $paymentId; ?>");
	ModuleAnalytics.setPaymentType("<?php echo $paymentType; ?>");
	ModuleAnalytics.setCheckoutType("<?php echo $checkoutType; ?>");
	ModuleAnalytics.put(retorno());

	function retorno() {
		setTimeout('location = \'<?php echo $continue; ?>\';', 1);
	}
<!--
//setTimeout('location = \'<?php echo $continue; ?>\';', 10000);
//--></script>



</body>
</html>
