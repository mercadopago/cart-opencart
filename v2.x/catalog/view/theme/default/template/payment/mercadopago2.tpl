    <?php  if (isset($error)) { ?>
        <div class="warning">
        <?php
            if($debug == 1){
                echo '<strong>MercadoPago failed to connect, and debug mode is on !!.<br /> Check the errors below and for security reasons turn it off after solve the problem:</strong><br />' ; 
                echo '<pre>'; print_r($error); echo '</pre><br />';    
            } else {
                echo '<strong>Sorry...MercadoPago failed to connect.<br /> If you are the store owner, turn on debug mode to get more details about the reason</strong><br />' ; 
            }
        ?>
        
        </div>
    <?php  } else { ?>

    <?php
        switch($type_checkout):
            case "Redirect": ?>
                <script type="text/javascript">
                console.log('redirect checkout');
                    var redirect = '<?php echo $redirect_link;?>';
                    console.log('redirecting to ' + redirect);
                    window.location = redirect;
                </script>
                <button>confirmar pagamento</button>
                <div class="right">Redirigiendo a MercadoPago, por favor, espere...</div>
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
        <input type="hidden" id="public_key" value="<?php echo $public_key?>">
        <script type="text/javascript" src="//fgnass.github.io/spin.js/spin.min.js"></script>
        <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
        <div id="spinner"> 
        <div id="formulario"></div>
            <script src="./catalog/view/javascript/mercadopago2/react.js"></script>
            <script src="./catalog/view/javascript/mercadopago2/react-dom.js"></script>
            <script defer src="./catalog/view/javascript/mercadopago2/mercadopago2_checkout_transparente.js"></script>
            <script defer src="./catalog/view/javascript/mercadopago2/mask.js"></script>
            <script defer src="./catalog/view/javascript/mercadopago2/jquery.bpopup.min.js"></script>
            <script type="text/javascript" defer>
            (function(){
                $('#expiration_date').mask('99/9999');
            })();
            </script>
        </div>

        <div id="modal_popup" class="modal fade" role="dialog" style="display: none;">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pagamento</h4>
              </div>
              <div class="modal-body">
                <p id="return_message"></p>
              </div>
              
            </div>

          </div>
        </div>
        <?php break; endswitch;
        ?>
        
    <?php  ;} ?>