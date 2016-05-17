                    <link rel="stylesheet" type="text/css" href="./catalog/view/css/mp_form.css">  
                    <div id="mp_custom"></div>
                    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
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
                    <div class="clearfix"></div>
                    <div id="spinner"> 
                        <div id="formulario" class="cartao">
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
                        <script defer type="text/javascript" src="./catalog/view/javascript/mp_transparente/mp_transparente_view.js"></script>
                        
                    </div>