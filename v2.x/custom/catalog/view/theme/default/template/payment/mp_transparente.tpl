<style>
    /*cartão*/
    .cartao{margin-bottom:10px;margin:20px auto;-moz-border-radius:5px;border-radius:5px;width:600px;background:#fff;-webkit-border-radius:5px;box-shadow:0 0 1px #666;padding:13px 20px 20px 20px;}

    .banner{margin-bottom:10px;margin:20px auto;-moz-border-radius:5px;border-radius:5px;width:600px;background:#fff;-webkit-border-radius:5px;}


</style>


                    <link rel="stylesheet" type="text/css" href="./catalog/view/css/mp_form.css">
                    <link rel="stylesheet" type="text/css" href="./catalog/view/css/custom_checkout_mercadopago.css">
                    <div id="mp_custom"></div>


                    <input type="hidden" id="public_key" value="<?php echo $public_key;?>">
                    <input type="hidden" id="country" value="<?php echo $action;?>">
                    <input type="hidden" id="paymentType"/>
                    <div class="form-group" style="margin-left: 10%;">
                        <div class="form-group">
                            <div class="banner">
                                <img src="./image/banners/<?php echo $action;?>/credit_card.png" />
                            </div>
                        </div>
                    </div>
                    <?php if ($mp_transparente_coupon) : ?>
                        <div class="cartao">
                            <div class="form-inline">
                              <div class="form-group">
                                <input class="form-control" id="mercadopago_coupon" name="mercadopago_coupon"
                                placeholder="Coupon Mercado Pago">
                            </div>
                            <span id="removerDesconto" class="btn btn-danger btn-sm"><?php echo $remover; ?></span>
                            <span id="aplicarDesconto" class="btn btn-primary btn-sm"><?php echo $aplicar; ?></span>
                            <span id="aplicarDescontoDisable" class="btn btn-default btn-disabled btn-sm">
                                <i class="fa fa-spinner fa-spin"></i><?php echo $aguarde; ?>
                            </span>
                        </div>

                        <div class="alert alert-danger" style="margin-top: 10px;"
                        id="error_alert" role="alert">...</div>

                        <br>
                        <ul class="couponApproved nav nav-pills nav-stacked">
                            <li>
                                <p class="couponApproved ch-form-row discount-link"><?php echo $you_save; ?><b>&nbsp;<span id="amount_discount"></span></b> <?php echo $desconto_exclusivo; ?> <strong style="color: #02298D;">Mercado
                                    Pago</strong>
                                </p>
                                <p id="totalCompra"><?php echo $total_compra; ?> <b>&nbsp;<span
                                    id="total-amount"></span></b>.
                                </p>
                                <p class="couponApproved">
                                    <strong><?php echo $total_desconto; ?></strong> <b style="font-size: 20px">&nbsp;<span
                                    class="total_amount_discount" id="total_amount_discount"
                                    alt="decimal"></span><span style="color: red;">*</span>
                                </b>.
                            </p>
                            <p class="couponApproved">
                                <span style="color: red;">*</span><label style="font-size: 12px;"><?php echo $upon_aproval; ?></label>
                            </p>
                            <h6 class="couponApproved">
                                <a href="" id="mercadopago_coupon_termsTicket" class="alert-link"
                                target="_blank"><strong style="text-decoration: underline;"><?php echo $see_conditions; ?></strong></a>
                            </h6>
                        </li>
                        </ul>
                        </div>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <div id="mp-box-form">
                    teste

                    <?php
                        $form_labels = array(
                          "form" => array(
                            "coupon_empty" => "Please, inform your coupon code",
                            'apply' => "Apply",
                            'remove' => "Remove",
                            'discount_info1' => "You will save",
                            'discount_info2' => "with discount from",
                            'discount_info3' => "Total of your purchase:",
                            'discount_info4' => "Total of your purchase with discount:",
                            'discount_info5' => "*Uppon payment approval",
                            'discount_info6' => "Terms and Conditions of Use",
                            'coupon_of_discounts' => "Discount Coupon",
                            'label_other_bank' => "Other Bank",
                            'label_choose' => "Choose",
                            "payment_method" => "Payment Method",
                            "credit_card_number" => "Credit card number",
                            "expiration_month" => "Expiration month",
                            "expiration_year" => "Expiration year",
                            "year" => "Year",
                            "month" => "Month",
                            "card_holder_name" => "Card holder name",
                            "security_code" => "Security code",
                            "document_type" => "Document Type",
                            "document_number" => "Document number",
                            "issuer" => "Issuer",
                            "installments" => "Installments",
                            "your_card" => "Your Card",
                            "other_cards" => "Other Cards",
                            "other_card" => "Other Card",
                            "ended_in" => "ended in"
                          ),
                          "error" => array(

                            //card number
                            "205" => "Parameter cardNumber can not be null/empty",
                            "E301" => "Invalid Card Number",
                            //expiration date
                            "208" => "Invalid Expiration Date",
                            "209" => "Invalid Expiration Date",
                            "325" => "Invalid Expiration Date",
                            "326" => "Invalid Expiration Date",
                            //card holder name
                            "221" => "Parameter cardholderName can not be null/empty",
                            "316" => "Invalid Card Holder Name",

                            //security code
                            "224" => "Parameter securityCode can not be null/empty",
                            "E302" => "Invalid Security Code",
                            "E203" => "Invalid Security Code",

                            //doc type
                            "212" => "Parameter docType can not be null/empty",
                            "322" => "Invalid Document Type",
                            //doc number
                            "214" => "Parameter docNumber can not be null/empty",
                            "324" => "Invalid Document Number",
                            //doc sub type
                            "213" => "The parameter cardholder.document.subtype can not be null or empty",
                            "323" => "Invalid Document Sub Type",
                            //issuer
                            "220" => "Parameter cardIssuerId can not be null/empty",
                          ),
                          "coupon_error" => array(
                            "EMPTY" => "Please, inform your coupon code"
                          )
                        );
                    ?>

                    <div class="mp-box-inputs mp-line" id="mercadopago-form-coupon">
                        <label for="couponCodeLabel"><?php echo $form_labels['form']['coupon_of_discounts']; ?></label>
                          <div class="mp-box-inputs mp-col-65">
                            <input type="text" id="couponCode" name="mercadopago_custom[coupon_code]" autocomplete="off" maxlength="24" />
                            <span class="mp-discount" id="mpCouponApplyed" ></span>
                            <span class="mp-error" id="mpCouponError" ></span>
                          </div>
                          <div class="mp-box-inputs mp-col-10">
                            <div id="mp-separete-date"></div>
                          </div>
                          <div class="mp-box-inputs mp-col-25">
                            <input type="button" class="button" id="applyCoupon" value="<?php echo $form_labels['form']['apply']; ?>" >
                          </div>
                        </div>
                          
                        <!-- <div id="mercadopago-form" > -->
                        <form action="post.php" method="post" id="mercadopago-form">

                          <div id="mercadopago-form-customer-and-card">

                            <div class="mp-box-inputs mp-line">
                              <label for="paymentMethodIdSelector"><?php echo $form_labels['form']['payment_method']; ?> <em>*</em></label>

                              <select id="paymentMethodSelector" name="mercadopago_custom[paymentMethodSelector]" data-checkout='cardId'>
                                <optgroup label="<?php echo $form_labels['form']['your_card']; ?>" id="payment-methods-for-customer-and-cards">
                                  <?php foreach ($customer["cards"] as $card) { ?>

                                    <option value="<?php echo $card["id"]; ?>"
                                      first_six_digits="<?php echo $card["first_six_digits"]; ?>"
                                      last_four_digits="<?php echo $card["last_four_digits"]; ?>"
                                      security_code_length="<?php echo $card["security_code"]["length"]; ?>"
                                      type_checkout="customer_and_card"
                                      payment_method_id="<?php echo $card["payment_method"]["id"]; ?>"
                                      >
                                      <?php echo ucfirst($card["payment_method"]["name"]); ?> <?php echo $form_labels['form']['ended_in']; ?> <?php echo $card["last_four_digits"]; ?>
                                    </option>
                                    <?php } ?>
                                  </optgroup>

                                  <optgroup label="<?php echo $form_labels['form']['other_cards']; ?>" id="payment-methods-list-other-cards">
                                    <option value="-1"><?php echo $form_labels['form']['other_card']; ?></option>
                                  </optgroup>

                                </select>
                              </div>

                              <div class="mp-box-inputs mp-line" id="mp-securityCode-customer-and-card">
                                <div class="mp-box-inputs mp-col-45">
                                  <label for="customer-and-card-securityCode"><?php echo $form_labels['form']['security_code']; ?> <em>*</em></label>
                                  <input type="text" id="customer-and-card-securityCode" data-checkout="securityCode" autocomplete="off" maxlength="4"/>

                                  <span class="mp-error" id="mp-error-224" data-main="#customer-and-card-securityCode"> <?php echo $form_labels['error']['224']; ?> </span>
                                  <span class="mp-error" id="mp-error-E302" data-main="#customer-and-card-securityCode"> <?php echo $form_labels['error']['E302']; ?> </span>
                                  <span class="mp-error" id="mp-error-E203" data-main="#customer-and-card-securityCode"> <?php echo $form_labels['error']['E203']; ?> </span>
                                </div>
                              </div>

                            </div> <!--  end mercadopago-form-osc -->

                            <div id="mercadopago-form">
                              <div class="mp-box-inputs mp-col-100">
                                <label for="cardNumber"><?php echo $form_labels['form']['credit_card_number']; ?> <em>*</em></label>
                                <input type="text" id="cardNumber" data-checkout="cardNumber" autocomplete="off"/>
                                <span class="mp-error" id="mp-error-205" data-main="#cardNumber"> <?php echo $form_labels['error']['205']; ?> </span>
                                <span class="mp-error" id="mp-error-E301" data-main="#cardNumber"> <?php echo $form_labels['error']['E301']; ?> </span>
                              </div>

                              <div class="mp-box-inputs mp-line">
                                <div class="mp-box-inputs mp-col-45">
                                  <label for="cardExpirationMonth"><?php echo $form_labels['form']['expiration_month']; ?> <em>*</em></label>
                                  <select id="cardExpirationMonth" data-checkout="cardExpirationMonth" name="mercadopago_custom[cardExpirationMonth]">
                                    <option value="-1"> <?php echo $form_labels['form']['month']; ?> </option>
                                    <?php for ($x=1; $x<=12; $x++): ?>
                                      <option value="<?php echo $x; ?>"> <?php echo $x; ?></option>
                                    <?php endfor; ?>
                                  </select>
                                </div>

                                <div class="mp-box-inputs mp-col-10">
                                  <div id="mp-separete-date">
                                    /
                                  </div>
                                </div>

                                <div class="mp-box-inputs mp-col-45">
                                  <label for="cardExpirationYear"><?php echo $form_labels['form']['expiration_year']; ?> <em>*</em></label>
                                  <select  id="cardExpirationYear" data-checkout="cardExpirationYear" name="mercadopago_custom[cardExpirationYear]">
                                    <option value="-1"> <?php echo $form_labels['form']['year']; ?> </option>
                                    <?php for ($x=date("Y"); $x<= date("Y") + 10; $x++): ?>
                                      <option value="<?php echo $x; ?>"> <?php echo $x; ?> </option>
                                    <?php endfor; ?>
                                  </select>
                                </div>

                                <span class="mp-error" id="mp-error-208" data-main="#cardExpirationMonth"> <?php echo $form_labels['error']['208']; ?> </span>
                                <span class="mp-error" id="mp-error-209" data-main="#cardExpirationYear"> </span>
                                <span class="mp-error" id="mp-error-325" data-main="#cardExpirationMonth"> <?php echo $form_labels['error']['325']; ?> </span>
                                <span class="mp-error" id="mp-error-326" data-main="#cardExpirationYear"> </span>

                              </div>

                              <div class="mp-box-inputs mp-col-100">
                                <label for="cardholderName"><?php echo $form_labels['form']['card_holder_name']; ?> <em>*</em></label>
                                <input type="text" id="cardholderName" name="mercadopago_custom[cardholderName]" data-checkout="cardholderName" autocomplete="off"/>

                                <span class="mp-error" id="mp-error-221" data-main="#cardholderName"> <?php echo $form_labels['error']['221']; ?> </span>
                                <span class="mp-error" id="mp-error-316" data-main="#cardholderName"> <?php echo $form_labels['error']['316']; ?> </span>
                              </div>

                              <div class="mp-box-inputs mp-line">
                                <div class="mp-box-inputs mp-col-45">
                                  <label for="securityCode"><?php echo $form_labels['form']['security_code']; ?> <em>*</em></label>
                                  <input type="text" id="securityCode" data-checkout="securityCode" autocomplete="off" maxlength="4"/>

                                  <span class="mp-error" id="mp-error-224" data-main="#securityCode"> <?php echo $form_labels['error']['224']; ?> </span>
                                  <span class="mp-error" id="mp-error-E302" data-main="#securityCode"> <?php echo $form_labels['error']['E302']; ?> </span>
                                </div>
                              </div>

                              <div class="mp-box-inputs mp-col-100 mp-doc">
                                <div class="mp-box-inputs mp-col-35 mp-docType">
                                  <label for="docType"><?php echo $form_labels['form']['document_type']; ?> <em>*</em></label>
                                  <select id="docType" data-checkout="docType" name="mercadopago_custom[docType]"></select>

                                  <span class="mp-error" id="mp-error-212" data-main="#docType"> <?php echo $form_labels['error']['212']; ?> </span>
                                  <span class="mp-error" id="mp-error-322" data-main="#docType"> <?php echo $form_labels['error']['322']; ?> </span>
                                </div>

                                <div class="mp-box-inputs mp-col-65 mp-docNumber">
                                  <label for="docNumber"><?php echo $form_labels['form']['document_number']; ?> <em>*</em></label>
                                  <input type="text" id="docNumber" data-checkout="docNumber" name="mercadopago_custom[docNumber]" autocomplete="off"/>

                                  <span class="mp-error" id="mp-error-214" data-main="#docNumber"> <?php echo $form_labels['error']['214']; ?> </span>
                                  <span class="mp-error" id="mp-error-324" data-main="#docNumber"> <?php echo $form_labels['error']['324']; ?> </span>
                                </div>
                              </div>

                              <div class="mp-box-inputs mp-col-100 mp-issuer">
                                <label for="issuer"><?php echo $form_labels['form']['issuer']; ?> <em>*</em></label>
                                <select id="issuer" data-checkout="issuer" name="mercadopago_custom[issuer]"></select>

                                <span class="mp-error" id="mp-error-220" data-main="#issuer"> <?php echo $form_labels['error']['220']; ?> </span>
                              </div>

                            </div>  <!-- end #mercadopago-form -->

                            <div class="mp-box-inputs mp-col-100">
                              <label for="installments"><?php echo $form_labels['form']['installments']; ?> <em>*</em></label>
                              <select id="installments" data-checkout="installments" name="mercadopago_custom[installments]"></select>
                            </div>


                            <div class="mp-box-inputs mp-line">

                              <div class="mp-box-inputs mp-col-50">
                                <input type="submit" id="submit" value="Pay">
                              </div>

                              <!-- NOT DELETE LOADING-->
                              <div class="mp-box-inputs mp-col-25">
                                <div id="mp-box-loading">
                                </div>
                              </div>

                            </div>

                            <div class="mp-box-inputs mp-col-100" id="mercadopago-utilities">
                              <input type="text" id="site_id"  name="mercadopago_custom[site_id]"/>
                              <input type="text" id="amount" value="5249.99" name="mercadopago_custom[amount]"/>
                              <input type="hidden" id="campaign_id" name="mercadopago_custom[campaign_id]"/>
                              <input type="hidden" id="campaign" name="mercadopago_custom[campaign]"/>
                              <input type="hidden" id="discount" name="mercadopago_custom[discount]"/>
                              <input type="text" id="paymentMethodId" name="mercadopago_custom[paymentMethodId]"/>
                              <input type="text" id="token" name="mercadopago_custom[token]"/>
                              <input type="text" id="cardTruncated" name="mercadopago_custom[cardTruncated]"/>
                              <input type="text" id="CustomerAndCard" name="mercadopago_custom[CustomerAndCard]"/>
                            </div>
                          </form>
                          <!-- </div> -->


                            <!-- <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js" defer></script> -->
                            <script type="text/javascript" src="./catalog/view/javascript/mp_transparente/MPv1.js" defer></script>


                              <script>

                              function async(u, c) {
                                  var d = document; 
                                  var t = 'script';
                                    var o = d.createElement(t);
                                    var s = d.getElementsByTagName(t)[0];
                                  
                                  o.src = u;
                                  if (c) { o.addEventListener('load', function (e) { c(null, e); }, false); }
                                  s.parentNode.insertBefore(o, s);
                                }



async('https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js', function() {
    

    var mercadopago_site_id = 'MLB';
    var mercadopago_public_key = '<?php echo $public_key;?>';
    var mercadopago_payer_email = 'teste@teste.com';
    MPv1.create_token_on.event = false;

    MPv1.text.choose = '<?php echo $form_labels["form"]["label_choose"]; ?>';
    MPv1.text.other_bank = '<?php echo $form_labels["form"]["label_other_bank"]; ?>';
    MPv1.text.discount_info1 = '<?php echo $form_labels["form"]["discount_info1"]; ?>';
    MPv1.text.discount_info2 = '<?php echo $form_labels["form"]["discount_info2"]; ?>';
    MPv1.text.discount_info3 = '<?php echo $form_labels["form"]["discount_info3"]; ?>';
    MPv1.text.discount_info4 = '<?php echo $form_labels["form"]["discount_info4"]; ?>';
    MPv1.text.discount_info5 = '<?php echo $form_labels["form"]["discount_info5"]; ?>';
    MPv1.text.discount_info6 = '<?php echo $form_labels["form"]["discount_info6"]; ?>';
    MPv1.text.apply = '<?php echo $form_labels["form"]["apply"]; ?>';
    MPv1.text.remove = '<?php echo $form_labels["form"]["remove"]; ?>';
    MPv1.text.coupon_empty = '<?php echo $form_labels["form"]["coupon_empty"]; ?>';


MPv1.paths.loading = "";
MPv1.sdkResponseHandler = function(status, response) {
      //hide loading
      document.querySelector(MPv1.selectors.box_loading).style.background = "";

      if (status != 200 && status != 201) {
        MPv1.showErrors(response);
      } else {
        var token = document.querySelector(MPv1.selectors.token);
        token.value = response.id;

        if (MPv1.add_truncated_card) {
          var card = MPv1.truncateCard(response);
          document.querySelector(MPv1.selectors.cardTruncated).value=card;
        }

        if (!MPv1.create_token_on.event) {
            console.log("ajax request");
            var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/index.php?route=payment/mp_transparente/payment/';
            
            MPv1.AJAX({
              url: url_backend,
              method : "POST",
              data:payment,
              timeout : 5000,
              success : function (status, response){

                if (status == 200 || status == 201){
                  removeCheckoutId();

                  if(typeof next !== "undefined"){
                    next();
                  }
                }
              }
            });

        }
      }
    }



    MPv1.Initialize(mercadopago_site_id, mercadopago_public_key, true, 'http://google.com/teste.php', mercadopago_payer_email);


});


    </script>
                       </div>



      <!-- Until here -->





<!--                         <div id="formulario" class="cartao"     >
                            <div class="panel-body" id="checkoutPayment">
                             <?php if (isset($cards) && $user_logged): ?>
                            <?php echo($cc_partial); ?>
                            <?php endif; ?>
                                <div class="form-group" style="margin-bottom: 4%;" id="cardData">
                                    <?php if(isset($ccnum_placeholder)): ?>
                                        <div class="row"></div>
                                        <div class="col-xs-10 col-sm-6" style="margin-left: -2%;">
                                            <label class="control-label" id="ccnum_label" for="ccnum"><?php echo($ccnum_placeholder); ?></label>
                                            <input class="form-control" type="text" id="cc_num" data-checkout="cardNumber" />
                                        </div>
                                    <?php endif;?>
                                    <?php if(isset($expiration_month_placeholder)): ?>
                                        <div class="col-xs-10 col-md-3" style="margin-left: -2%; <?php echo $action == "MLB"? '':'margin-top: -4%' ?> ">
                                            <label class="control-label" id="expiration_month_label" for="expiration_month"><?php echo($expiration_month_placeholder); ?></label>
                                            <input class="form-control" type="text" id="expiration_month" data-checkout="cardExpirationMonth" placeholder="MM" maxlength="2" size="2"  />
                                        </div>
                                    <?php endif;?>
                                    <?php if(isset($expiration_year_placeholder)): ?>
                                        <div class="col-xs-10 col-md-3" style="margin-left: -2%;<?php echo $action == "MLB"? '':'margin-top: -4%' ?> ">
                                            <label class="control-label" id="expiration_year_label" for="expiration_year"><?php echo $expiration_year_placeholder;?></label>
                                            <input class="form-control" type="text" id="expiration_year" data-checkout="cardExpirationYear" maxlength="4" placeholder="AAAA" size="4"/>
                                        </div>
                                    <?php endif;?>
                                    <div class="clearfix"></div>
                                    <div class="row" id="userInfo">
                                        <?php if(isset($name_placeholder)): ?>
                                            <div class="col-xs-12 col-md-9" >
                                               <label class="control-label" id="card_name_label" for="card_name"><?php echo $name_placeholder;?></label>
                                               <input style="width: 93%;" class="form-control" type="text" id="card_name" data-checkout="cardholderName"/>
                                           </div>
                                       <?php endif; ?>
                                       <div class="col-xs-10 col-md-3">
                                        <label id="cvv_label" class="control-label" for="cvv" style="margin-left: -30%">CVV</label>
                                        <input class="form-control" style="margin-left: -35%; width: 95%" type="text" id="cvv" data-checkout="securityCode" size="4" maxlength="4" class="form-control"/>
                                    </div>
                                </div>
                                <?php echo $partial; ?>
                                <div class="form-buttons" id="buttonPay" style="margin-right: 8%;margin-top: 4%;'">
                                    <?php if(isset($payment_button)): ?>
                                        <div class="text-center">
                                            <button class="btn btn-primary pull-right" id="button_pay"><?php echo($payment_button); ?></button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript" src="//fgnass.github.io/spin.js/spin.min.js"></script>
                        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
                        <script type="text/javascript" src="./catalog/view/javascript/mp_transparente/jquery.mask.min.js"></script>
                        <script type="text/javascript" src="./admin/view/javascript/mp_transparente/spinner.min.js"></script>
                        <script defer type="text/javascript" src="./catalog/view/javascript/mp_transparente/mp_transparente_view.js">
                        </script>

                    </div> -->


<script type="text/javascript">

<?php if ($mp_transparente_coupon) : ?>
    /*
     *
     * COUPON
     *
     */
    //hide all info
    $("#aplicarDescontoDisable").hide();

    //show loading
    $("#removerDesconto").hide();

    //Esconde todas as mensagens
    $("#error_alert").hide();

    removerDesconto("");
    removerDesconto("Ticket");

    $("#mercadopago_coupon").bind("change", function() {
        if (couponMensagemError(null, "")) {
            carregarDesconto("");
        }

    })

    //action apply
    $("#aplicarDescontoTicket").click(function() {
        if (couponMensagemError(null, "Ticket")) {
            carregarDesconto("Ticket");
        }
    });

    //action apply
    $("#aplicarDesconto").click(function() {
        if (couponMensagemError(null, "")) {
            carregarDesconto("");
        }
    });

    var amount = getValueTotal();

    $('#total-amount').html(amount);

    function carregarDesconto(cupomTicket) {

        var aplicarDescontoDisable = null;
        var error_alert = null;
        var aplicarDesconto = null;
        var mercadopago_coupon = null;

        var totalCompra = null;
        var removerDescontoButton = null;
        var couponApproved = null;
        var amount_discount = null;
        var total_amount = null;
        var total_amount_discount = null;
        var mercadopago_coupon_terms = null;
        var amount = null;

        var coupon = null;

        var mercadopago_coupon_ticket = $(".mercadopago_coupon_ticket");

        aplicarDescontoDisable = $("#aplicarDescontoDisable");
        error_alert = $("#error_alert");
        aplicarDesconto = $("#aplicarDesconto");
        mercadopago_coupon = $("#mercadopago_coupon");

        totalCompra = $("#totalCompra");
        removerDescontoButton = $("#removerDesconto");
        couponApproved = $(".couponApproved");
        amount_discount = $("#amount_discount");
        total_amount = $("#total_amount");
        total_amount_discount = $("#total_amount_discount");
        mercadopago_coupon_terms = $("#mercadopago_coupon_terms");
        amount = $("#amount");
        coupon = $("#mercadopago_coupon");

        aplicarDescontoDisable.show();
        error_alert.hide();
        aplicarDesconto.hide();
        aplicarDescontoDisable.show();

        var parametros = null;

        var url_site = window.location.href.split('index.php')[0];
        var url_message = url_site.slice(-1) == '/' ? url_site : url_site + '/';
        url_message += 'index.php?route=payment/mp_transparente/coupon&coupon_id=' + coupon.val()

        $
        .ajax({
            type : "GET",
            url : url_message,
            success : function(r) {

                if (r.status == 200) {
                    mercadopago_coupon_ticket.val(coupon.val());

                    totalCompra.css('text-decoration', 'line-through');

                    aplicarDesconto.hide();
                    removerDescontoButton.show();
                    couponApproved.show();

                    coupon.attr('readonly', true);

                    var coupon_amount = (r.response.coupon_amount)
                    .toFixed(2)
                    var transaction_amount = (r.response.transaction_amount)
                    .toFixed(2)
                    var id_coupon = r.response.id;

                    var url_term = "https://api.mercadolibre.com/campaigns/"
                    + id_coupon
                    + "/terms_and_conditions?format_type=html"

                    amount_discount.html(coupon_amount);
                    total_amount.html(transaction_amount);

                    var total_amount_discount_v = (transaction_amount - coupon_amount)
                    .toFixed(2);
                    console.info("===total_amount_discount_v===="+total_amount_discount_v);

                    total_amount_discount.html(total_amount_discount_v);

                    mercadopago_coupon_terms.attr("href", url_term);
                    if (validateCard()) {
                        getInstallments();
                    }
                    aplicarDescontoDisable.hide();
                } else {

                    removerDesconto(cupomTicket);

                    couponMensagemError(r, cupomTicket);

                    if ($("#id-installments").val() != null
                        && $("#id-installments").val().length > 0) {
                        getInstallments();
                }
            }
        },
        error : function() {
            aplicarDesconto.show();
            removerDescontoButton.hide();

            if ($("#id-installments").val() != null
                && $("#id-installments").val().length > 0) {
                getInstallments();
        }

    },
    complete : function() {

        aplicarDescontoDisable.hide();

    }
})
    }

    $("#removerDesconto").click(function() {
        removerDesconto("");
        getInstallments();
    });

    $("#removerDescontoTicket").click(function() {
        removerDesconto("Ticket");
    });

    function removerDesconto(cupomTicket) {
        var coupon = null;
        var aplicarDesconto = null;
        var removerDesconto = null;
        var couponApproved = null;
        var totalCompra = null;
        var amount_discount = null;
        var aplicarDescontoDisable = null;
        var error_alert = null;

        mercadopago_coupon_ticket = $(".mercadopago_coupon_ticket");
        coupon = $("#mercadopago_coupon");
        aplicarDesconto = $("#aplicarDesconto");
        removerDesconto = $("#removerDesconto");
        couponApproved = $(".couponApproved");
        totalCompra = $("#totalCompra");
        amount_discount = $("#amount_discount");
        aplicarDescontoDisable = $("#aplicarDescontoDisable");
        error_alert = $("#error_alert");

        coupon.attr('readonly', false);
        coupon.val("");
        mercadopago_coupon_ticket.val("");
        aplicarDesconto.show();
        removerDesconto.hide();
        couponApproved.hide();
        totalCompra.css('text-decoration', '');
        amount_discount.text("");
        aplicarDescontoDisable.hide();
        error_alert.hide();
    }

    function couponMensagemError(r, cupomTicket) {
        console.info(r);
        var error_alert = null;
        var mercadopago_coupon = null;
        var amount_discount = null;
        error_alert = $("#error_alert");
        mercadopago_coupon = $("#mercadopago_coupon");
        amount_discount = $("#amount_discount");

        error_alert.html("");
        var retorno = true;
        if (r == null) {
            if (mercadopago_coupon.val().trim().length == 0) {
                error_alert
                .html('<?php echo $cupom_obrigatorio; ?>');
                retorno = false;
            }
        } else {
            retorno = false;
            console.info(r.response);
            if (r.response.error == "campaign-code-doesnt-match") {
                error_alert
                .html('<?php echo $campanha_nao_encontrado; ?>');
            } else if (r.response.error == "transaction_amount_invalid") {
                error_alert
                .html('<?php echo $cupom_nao_pode_ser_aplicado; ?>');
            } else if (r.response.error == "run-out-of-uses") {
                error_alert
                .html('<?php echo $cupom_invalido; ?>');
            } else if (r.response.error == "amount-doesnt-match") {
                error_alert
                .html('<?php echo $valor_minimo_invalido; ?>');
            } else {
                error_alert
                .html('<?php echo $erro_validacao_cupom; ?>');
            }
        }

        error_alert.show();
        error_alert.fadeTo(10000, 2000).slideUp(2000, function() {
            error_alert.hide();
        });

        return retorno;

    }
<?php endif; ?>
    function validateCard() {
        //var opcaoPagamento = $("#opcaoPagamentoCreditCard").val();
        //if(opcaoPagamento == "Customer") {
         //   return true;
        //}

        if ($("#cc_num").val().length == 0) {
            return false;
        }
        return true;
    }

    function returnAmount() {
        if ($("#amount_discount").text() != "") {
            return $("#total_amount_discount").text();
        } else {
            return getValueTotal();
        }

    }
</script>
