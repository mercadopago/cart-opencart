        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.min.css">  
        <div id="mp_custom"></div>
        <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
        <input type="hidden" id="public_key" value="<?php echo $public_key;?>">
        <input type="hidden" id="country" value="<?php echo $action;?>">
        <input type="hidden" id="paymentType"/>
        <div class="form-group" style="margin-left: 10%;">
            <div class="form-group" style="margin-bottom: 4%">
                <div class="col-sm-6"  style="align:left;">
                    <img src="./image/banners/<?php echo $action;?>/credit_card.png" />
                </div>
            </div>
        <div class="clearfix"></div>
        </div>
        <div id="spinner"> 
        <div id="formulario" style="margin-left: 10%;">
             <div class="panel-body" id="checkoutPayment">
            <div class="form-group" style="margin-bottom: 4%" id="cardData">
            <?php if(isset($cardType_placeholder)): ?>
               <div class="col-sm-2" style="display: none; " id="divPaymentType">
                    <label class="control-label" id="cardType_label" for="cardType"><?php echo($cardType_placeholder); ?></label>
                    <select id="cardType" class="form-control">
                        <option value="deb">Debito</option>
                        <option value="cred">Credito</option>
                    </select>
                </div>
            <?php endif; ?>
                <?php if(isset($ccnum_placeholder)): ?>
                <div class="col-md-4">
                    <label class="control-label" id="ccnum_label" for="ccnum"><?php echo($ccnum_placeholder); ?></label>
                    <input class="form-control" type="text" id="cc_num" data-checkout="cardNumber" />
                </div>
                <?php endif;?>
                 <div class="col-sm-2" style="display: none;" id="divIssuer">
                    <label class="control-label" id="issuer_label" for="issuer">Issuer</label>
                    <select id="issuer" class="form-control">
                    </select>
                </div>
                <?php if(isset($expiration_month_placeholder)): ?>
                <div class="col-md-2" style="margin-left: -2%">
                    <label class="control-label" id="expiration_month_label" for="expiration_month"><?php echo($expiration_month_placeholder); ?></label>
                    <input class="form-control" type="text" id="expiration_month" data-checkout="cardExpirationMonth" />
                </div>
            <?php endif;?>
            <?php if(isset($expiration_year_placeholder)): ?>
                <div class="col-md-2" style="margin-left: -2%">
                <label class="control-label" id="expiration_year_label" for="expiration_year"><?php echo $expiration_year_placeholder;?></label>
                    <input class="form-control" type="text" id="expiration_year" data-checkout="cardExpirationYear" />
                </div>
            <?php endif;?>
            </div>
            <div class="clearfix"></div>
            <div class="form-group" style="margin-bottom: 8%" id="userInfo">
            <?php if(isset($name_placeholder)): ?>
                <div class="col-sm-6">
                 <label class="control-label" id="card_name_label" for="card_name"><?php echo $name_placeholder;?></label>
                    <input class="form-control" type="text" id="card_name" data-checkout="cardholderName"/>
                </div>
            <?php endif; ?>
                <div class="col-md-2" style="margin-left: -2%">
                    <label class="control-label" id="cvv_label" for="cvv">CVV</label>
                    <input class="form-control" type="text" id="cvv" data-checkout="securityCode" placeholder="CVV" />
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group" style="margin-bottom: 4%" id="docInfo">
            <?php if(isset($doctype_placeholder)): ?>
                <div class="col-sm-2" id="divDocType">
                <label class="control-label" id="doc_type_label" for="doc_type"><?php echo $doctype_placeholder;?></label>
                    <select class="form-control" id="doc_type" data-checkout="docType">
                    </select>
                </div>
            <?php endif; ?>
               <?php if(isset($docnumber_placeholder)): ?>
                <div class="col-sm-3" id="divDocNumber">
                <label class="control-label" id="doc_number_label" for="doc_number"><?php echo $docnumber_placeholder;?></label>
                    <input class="form-control" type="text" id="doc_number" data-checkout="docNumber" placeholder="doc number"/>
                </div>
            <?php endif; ?>
              <?php if(isset($installments_placeholder)): ?>
                <div class="col-sm-2" id="divInstallments">
                <label class="control-label" id="installments_label" for="installments"><?php echo $installments_placeholder;?></label>
                    <select id="installments" class="form-control">
                    </select>
                </div>
                  <?php endif; ?>
            </div>

            <div class="form-group" style="margin-top: 10%" id="buttonPay">
            <?php if(isset($payment_button)): ?>
            <div class="col-md-8">
                <button class="btn btn-primary pull-right" id="button_pay"><?php echo($payment_button); ?></button>
            </div>
            <?php endif; ?>
            </div>
          </div>
        </div>
        <script type="text/javascript" src="//fgnass.github.io/spin.js/spin.min.js"></script>
        <script type="text/javascript" src="./catalog/view/javascript/mp_transparente/mask.js"></script>
        <script type="text/javascript" src="./admin/view/javascript/mp_transparente/spinner.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="./catalog/view/javascript/mp_transparente/mp_transparente_view.js"></script>
        </div>