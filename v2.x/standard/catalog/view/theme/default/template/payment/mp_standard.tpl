
<style type="text/css">

.mp-standard-banner {
  width: 320px;
  display: inline;
  margin-top: 10px;
  margin-left: 50px;
  margin-bottom: 10px;
}

.mp-form {
    border: 1px solid #d6d4d4;
    border-radius: 4px;
    padding: 10px;
    width: 570px;
    background: white;
    margin-bottom: 20px;
  }

.hover:hover {
  background: 60% no-repeat whitesmoke;
}

.payment-label {
    font: bolder 20px/24px "Open Sans", sans-serif;
    color: #333333;
    margin-left: 28px;
}

.standard {
    font: 600 13px/15px "Open Sans", sans-serif;
    margin-left: 174px;
    display: block;
}

</style>

    <?php  if (isset($error)) { ?>
        <div class="warning">
        <?php
            if($debug == 1){
                echo '<strong>Mercado Pago failed to connect, and debug mode is on !!.<br /> Check the errors below and for security reasons turn it off after solve the problem:</strong><br />' ;
                echo '<pre>'; print_r($error); echo '</pre><br />';
            } else {
                echo '<strong>Sorry...Mercado Pago failed to connect.<br /> If you are the store owner, turn on debug mode to get more details about the reason</strong><br />' ;
            }
        ?>

        </div>
    <?php  } else { ?>

    <?php
        switch($type_checkout):
            case "Redirect": ?>
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                            <a
                            href='<?php echo $redirect_link;?>' id="id-standard"
                            mp-mode="redirect" name="MP-Checkout">
                            <div class="mp-form hover">
                                <div class="row">
                                    <div class="col">
                                        <img style="margin-left: 20px;" src="catalog/view/image/payment/payment_method_logo_120_31.png"
                                            id="id-standard-logo">
                                            <img src="catalog/view/image/payment/<?php echo $action ?>/banner_all_methods.png" class="mp-standard-banner" />
                                            <span class="payment-label standard">
                                                'Pay via Mercado Pago and split into up to 24 times'
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
                break;
            case "Iframe":
                    ?>
    		    <iframe src="<?php echo $redirect_link ?>" name="MP-Checkout" width="740" height="600" frameborder="0"></iframe>
    		    <script type="text/javascript">

    			(function(){function $MPBR_load(){console.log('iframe checkout');window.$MPBR_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;
    			s.src = ("https:"==document.location.protocol?"https://www.mercadopago.com/org-img/jsapi/mptools/buttons/":"http://mp-tools.mlstatic.com/buttons/")+"render.js";
    			var x = document.getElementsByTagName("script")[0];x.parentNode.insertBefore(s, x);window.$MPBR_loaded = true;})();}
    			window.$MPBR_loaded !== true ? (window.attachEvent ? window.attachEvent("onload", $MPBR_load) : window.addEventListener("load", $MPBR_load, false)) : null;})();
    		    </script>
    		<?php
                break;
            case "Lightbox":
            default:
                ?>
                    <div class="pull-right">
                    <script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script>
                    <a href="<?php echo $redirect_link ?>" name="MP-Checkout" class="btn btn-primary" mp-mode="modal" onreturn="execute_my_onreturn">Pagar</a>
    <!-- Pega este código antes de cerrar la etiqueta </body> -->
    </div>

                <?php
                break;
        case "Transparente": ?>

        <?php break; endswitch;
        ?>

    <?php  ;} ?>

<script type="text/javascript">

    $.getScript("https://secure.mlstatic.com/modules/javascript/analytics.js", function(){

        ModuleAnalytics.setToken("<?php echo $analytics['token'] ?>");
        ModuleAnalytics.setPlatform("<?php echo $analytics['platform'] ?>");
        ModuleAnalytics.setPlatformVersion("<?php echo $analytics['platformVersion'] ?>");
        ModuleAnalytics.setModuleVersion("<?php echo $analytics['moduleVersion'] ?>");
        ModuleAnalytics.setPayerEmail("<?php echo $analytics['payerEmail'] ?>");
        ModuleAnalytics.setUserLogged(parseInt("<?php echo $analytics['userLogged'] ?>"));
        ModuleAnalytics.setInstalledModules("<?php echo $analytics['installedModules'] ?>");
        ModuleAnalytics.setAdditionalInfo("<?php echo $analytics['additionalInfo'] ?>");
        ModuleAnalytics.post();

     });
</script>
