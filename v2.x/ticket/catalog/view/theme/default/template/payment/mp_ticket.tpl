        <div id="mp_ticket"></div>
        <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
        <input type="hidden" id="paymentType" value="ticket" />
        <div id="spinner"> 
            <div id="formulario">
             <div class="panel-body" id="checkoutPayment">
             <div style="margin: 0 auto; float:none; text-align: center;">
                    <div class="col-md-12" id="div_payment_methods" style="margin-left: auto; margin-right: auto; float:none;">
                        
                    </div>
                </div>
                <div class="form-group" id="buttonPay">
                    <div class="col-md-12">
                        <input type="hidden" id="payment_method_id" />
                        <button class="btn btn-primary pull-right" id="button_pay"><?echo $payment_button; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo('<script defer type="text/javascript" src="//fgnass.github.io/spin.js/spin.min.js"></script>'); ?>
        <?php echo('<script defer src="./catalog/view/javascript/mp_ticket/mask.js"></script>'); ?>
        <?php echo('<script defer type="text/javascript" src="./admin/view/javascript/mp_ticket/spinner.min.js"></script>'); ?>
        <?php echo('<script defer src="./catalog/view/javascript/mp_ticket/mp_ticket_view.js"></script>'); ?>
          <script type="text/javascript">
               /* $(document).ajaxComplete(function(e, xhr, settings){
                        var doc = document.getElementById('mp_ticket');
                        if(doc && doc.innerHTML == "")
                        {
                           var srcs = ["//fgnass.github.io/spin.js/spin.min.js", 
                                    "./catalog/view/javascript/mp_ticket/mask.js",
                                    "./admin/view/javascript/mp_ticket/spinner.min.js", 
                                    "./catalog/view/javascript/mp_ticket/mp_ticket_view.js"];
                        
                            srcs.forEach(function(src){
                                var script = document.createElement('script');
                                script.setAttribute('type', 'text/javascript');
                                script.setAttribute('src', src);
                                //script.setAttribute('defer', 'defer');
                                doc.appendChild(script);
                                //$.getScript(src, function(){});
                                });
                    }});*/
            </script>
    </div>
