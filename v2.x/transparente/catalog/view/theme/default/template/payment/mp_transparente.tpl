        <div id="mp_custom"></div>

        <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
        <input type="hidden" id="public_key" value="<?php echo $public_key;?>">
        <input type="hidden" id="country" value="<?php echo $action;?>">
        <input type="hidden" id="paymentType"/>
        <div class="form-group" style="margin-left: 10%;">
            <div class="form-group" style="margin-bottom: 4%">
                <div class="col-sm-6"  style="align:left;">
                    <img src="./admin/view/image/payment/mp_transparente.png" />
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
            <script type="text/javascript">
         (function()
                {
                    var doc = document.getElementById('mp_custom');
                    var srcs = ["//fgnass.github.io/spin.js/spin.min.js", 
                                "./catalog/view/javascript/mp_transparente/mask.js",
                                "./admin/view/javascript/mp_transparente/spinner.min.js", 
                                "./catalog/view/javascript/mp_transparente/mp_transparente_view.js"];
                    srcs.forEach(function(src){
                        console.log('carregando ' + src);
                       //var script = document.createElement('script');
                       //script.setAttribute('src',src);
                       //script.setAttribute('defer', 'defer');
                       //doc.appendChild(script);
                       $.getScript(src, function(){});
                    });
                })();

               </script>
        </div>