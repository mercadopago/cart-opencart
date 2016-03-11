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
        <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
        <input type="hidden" id="public_key" value="<?php echo $public_key;?>">
        <input type="hidden" id="country" value="<?php echo $action;?>">
        <input type="hidden" id="paymentType"/>
        <div class="form-group" style="margin-left: 10%;">
            <div class="form-group" style="margin-bottom: 4%">
                <div class="col-sm-6"  style="align:left;">
                    <img src="./admin/view/image/payment/mercadopago2.png" />
                    <img src="./image/banners/<?php echo $action;?>/credit_card.png" />
                </div>
            </div>
        <div class="clearfix"></div>
        </div>
        <div id="spinner"> 
        <div id="formulario" style="margin-left: 10%;">
             <div class="panel-body" id="checkoutPayment">
            <div class="form-group" style="margin-bottom: 4%" id="cardData">
               <div class="col-sm-2" style="display: none; " id="divPaymentType">
                    <label class="control-label" id="cardType_label" for="cardType"></label>
                    <select id="cardType" class="form-control">
                        <option value="deb">Debito</option>
                        <option value="cred">Credito</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="control-label" id="ccnum_label" for="ccnum"></label>
                    <input class="form-control" type="text" id="cc_num" data-checkout="cardNumber" />
                </div>
                 <div class="col-sm-2" style="display: none;" id="divIssuer">
                    <label class="control-label" id="issuer_label" for="issuer">Issuer</label>
                    <select id="issuer" class="form-control">
                    </select>
                </div>
                <div class="col-md-2" style="margin-left: -2%">
                    <label class="control-label" id="expiration_month_label" for="expiration_month"></label>
                    <input class="form-control" type="text" id="expiration_month" data-checkout="cardExpirationMonth" />
                </div>
                <div class="col-md-2" style="margin-left: -2%">
                <label class="control-label" id="expiration_year_label" for="expiration_year"></label>
                    <input class="form-control" type="text" id="expiration_year" data-checkout="cardExpirationYear" />
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group" style="margin-bottom: 8%" id="userInfo">
                <div class="col-sm-6">
                 <label class="control-label" id="card_name_label" for="card_name"></label>
                    <input class="form-control" type="text" id="card_name" data-checkout="cardholderName"/>
                </div>
                <div class="col-md-2" style="margin-left: -2%">
                    <label class="control-label" id="cvv_label" for="cvv">CVV</label>
                    <input class="form-control" type="text" id="cvv" data-checkout="securityCode" placeholder="CVV" />
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group" style="margin-bottom: 4%" id="docInfo">
                <div class="col-sm-2" id="divDocType">
                <label class="control-label" id="doc_type_label" for="doc_type"></label>
                    <select class="form-control" id="doc_type" data-checkout="docType">
                    </select>
                </div>
                <div class="col-sm-3" id="divDocNumber">
                <label class="control-label" id="doc_number_label" for="doc_number"></label>
                    <input class="form-control" type="text" id="doc_number" data-checkout="docNumber" placeholder="doc number"/>
                </div>
                <div class="col-sm-2" id="divInstallments">
                <label class="control-label" id="installments_label" for="installments"></label>
                    <select id="installments" class="form-control">
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-top: 10%" id="buttonPay">
            <div class="col-md-8">
                <button class="btn btn-primary pull-right" id="button_pay"></button>
            </div>
            </div>
          </div>
        </div>
            <script defer type="text/javascript" src="//fgnass.github.io/spin.js/spin.min.js"></script>
            <script defer src="./catalog/view/javascript/mercadopago2/mercadopago.js"></script>
            <script defer src="./catalog/view/javascript/mercadopago2/mask.js"></script>
            <script defer src="./catalog/view/javascript/mercadopago2/jquery.bpopup.min.js"></script>
            <script defer type="text/javascript" src="./admin/view/javascript/mercadopago2/spinner.min.js"></script>
            <script defer src="./catalog/view/javascript/mercadopago2/mp_transparente_view.js"></script>
        </div>

        <div id="modal_popup" class="modal fade" role="dialog" style="display: none;">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
              
                <button type="button" class="close" data-dismiss="modal" onclick="$('#modal_popup').bPopup().close();">&times;</button>
                <h4 class="modal-title" id="paymentTitle">Pagamento</h4>
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