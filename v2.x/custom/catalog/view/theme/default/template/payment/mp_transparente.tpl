<style>
    /*cartão*/
    .cartao{margin-bottom:10px;margin:20px auto;-moz-border-radius:5px;border-radius:5px;width:600px;background:#fff;-webkit-border-radius:5px;box-shadow:0 0 1px #666;padding:13px 20px 20px 20px;}

    .banner{margin-bottom:10px;margin:20px auto;-moz-border-radius:5px;border-radius:5px;width:600px;background:#fff;-webkit-border-radius:5px;}


</style>


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
