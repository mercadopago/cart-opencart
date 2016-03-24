        <div id="mp_ticket"></div>
        <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
        <input type="hidden" id="public_key" value="<?php echo $public_key;?>">
        <input type="hidden" id="paymentType" value="ticket" />
        <div class="form-group" style="margin-left: 10%;">
            <div class="form-group" style="margin-bottom: 4%">
                <div class="col-sm-6"  style="align:left;">
                    <img src="./admin/view/image/payment/mp_ticket.png" />
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="spinner"> 
            <div id="formulario">
               <div class="panel-body" id="checkoutPayment">
                <div class="form-group"id="buttonPay">
                    <div class="col-md-8">
                        <button class="btn btn-primary pull-right" id="button_pay"><?echo $payment_button; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <script defer type="text/javascript" src="//fgnass.github.io/spin.js/spin.min.js"></script>
        <script defer src="./catalog/view/javascript/mp_ticket/mask.js"></script>
        <script defer type="text/javascript" src="./admin/view/javascript/mp_ticket/spinner.min.js"></script>
        <script defer src="./catalog/view/javascript/mp_ticket/mp_ticket_view.js"></script>
    </div>