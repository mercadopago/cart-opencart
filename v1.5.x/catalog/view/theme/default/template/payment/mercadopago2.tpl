
<?php  if (isset($error)) { ?>
<div class="warning"><?php
      
      if($debug == 1){
      echo '<strong>MercadoPago fails to connecet, and debug mode is on !!.<br /> Check the erros below and for security reasons turn it off after solve the problem:</strong><br />' ; 
      echo '<pre>'; print_r($error); echo '</pre><br />';
      } else {
      echo '<strong>Sorry...MercadoPago fail to connect.<br /> If you are the store owner, turn on debug mode to get more details about the reason</strong><br />' ; 
      }
      ?>

</div>
<?php  } else {

  // fecha verficação de status da autenticação
?>
         
<div class="right">
<a href="<?php echo $link; ?>" name="MP-payButton" class="blue-l-rn-ar" style="float:right;">Pagar</a>
<script type="text/javascript" src="https://www.mercadopago.com/org-img/jsapi/mptools/buttons/render.js" />
</div>
<?php  ;} ?>