         (function(){
           var spinner = new Spinner().spin(document.getElementById('spinner'));
           console.log('running script');
           
           var country = document.getElementById('country').value;
           var firstname =  document.getElementById('input-payment-firstname');
           if(firstname)
           {
                var firstname =  document.getElementById('input-payment-firstname');
                var lastname =  document.getElementById('input-payment-lastname');
                document.getElementById('card_name').value = firstname.value + ' ' + lastname.value  ; 
           }
           setTimeout(function(){
                    var public_key = document.getElementById("public_key").value;
                    Mercadopago.setPublishableKey(public_key);
                    Mercadopago.getIdentificationTypes(function (httpStatus, dt) {
                        var select = document.getElementById('doc_type');
                        var i = dt.length;
                        if (i > 1)
                        {
                            while(i--)
                            {
                                var option = new Option(dt[i].name, dt[i].id);
                                select.appendChild(option);
                            }    
                        }
                        else
                        {
                            //TODO: esconder DDL de doctype e arrumar CSS de docnumber e installments 
                        }
                        
                    });
                }, 3000);
            
        /* Máscaras dos inputs do cartão */
            $("#card_number").mask("0000000000000000999999", {clearIfNotMatch: true});

            $("#card_cvv").mask("0009", {clearIfNotMatch: true});

            //$("#expiration_month").mask("00", {clearIfNotMatch: true});

            //$("#expiration_year").mask("0000", {clearIfNotMatch: true});
        spinner.stop(); 


    })();

    document.getElementById('cc_num').addEventListener('change', function () {
       document.getElementById('cc_num').value = document.getElementById('cc_num').value.trim();
       var cc_num = document.getElementById('cc_num').value.replace(/[ .-]/g, '').slice(0, 6);

       if(cc_num.length == 0)
       { 
        document.getElementById('paymentType').value = "";
        return;
    }

    if(cc_num.length >5)
    {
        var public_key = document.getElementById("public_key").value;
        Mercadopago.setPublishableKey(public_key);

        Mercadopago.getPaymentMethod({
            "bin": cc_num
        }, function (status, response) {
               var paymentType = document.getElementById('paymentType')
                    paymentType.value = response[0].id;
                    if (response[0].additional_info_needed.indexOf('issuer_id') > -1)
                    {
                        getCardIssuers();
                        document.getElementById('divIssuer').style = 'display: block;';
                        if(document.getElementById('country').value == "MLM")
                        {
                            if(paymentType.value.indexOf('visa') > -1 || paymentType.value.indexOf('master') > -1)
                            {
                                document.getElementById('divPaymentType').style = 'display: block;';    
                            }
                            
                        }
                    }
                    getInstallments();

               });    
    }
    });

    document.getElementById('button_pay').addEventListener('click', function doPayment () {
        var style = 'margin-left: 22%;'; 
        document.getElementById('formulario').setAttribute('style', 'pointer-events: none; opacity: 0.4;' + style);
        console.log('style do form 1: ' + JSON.stringify(document.getElementById('formulario').style));
        var spinner = new Spinner().spin(document.getElementById('spinner'));
        var form = {cardNumber: document.getElementById('cc_num').value,
        securityCode: document.getElementById('cvv').value,
        cardExpirationMonth:document.getElementById('expiration_month').value,
        cardExpirationYear:document.getElementById('expiration_year').value,
        cardholderName:document.getElementById('card_name').value};
        var docType = document.getElementById('doc_type');
        var docNumber = document.getElementById('doc_number');

        if (docType)
        {
         form.docType = docType.value;   
        }
        
        if (docNumber) 
        {
         form.docNumber = docNumber.value;      
        }
        
        var url_site = window.location.href.split('index.php')[0];
        var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
        url_backend += 'index.php?route=payment/mp_transparente/payment/';         

        Mercadopago.createToken(form, function (status, response) {
         var valid_status = [200, 201];
         if(response.error || valid_status.indexOf(status) < 0)
         {
            spinner.stop();
            document.getElementById('formulario').style = style;
            console.log('style do form 2: ' + JSON.stringify(document.getElementById('formulario').style));
            var data = {status: response.cause[0].code, message: response.cause[0].description, request_type:"token"};
            getMessage(data);
        } 
        else 
        {
            var payment = {token: response.id, 
             user: document.getElementById('card_name').value,
             payment_method_id: document.getElementById('paymentType').value,
             installments: document.getElementById('installments').value};

        if (docType)
        {
         payment.docType = docType.value; 
        }
        
        if (docNumber) 
        {
         payment.docNumber = docNumber.value;
        }
        
        var issuer = document.getElementById('issuer').value;
        if(issuer)
        {
            payment.issuer_id = issuer;
        }
            
        $.ajax({
            type: "POST",
            url: url_backend,
            data: payment,
            success: function success(data) {
                response_payment = JSON.parse(data);
                console.log('json payment: ' + data);
                document.getElementById('formulario').style = 'margin-left: 22%';
                var acceptable_status = ["approved", "in_process"];
                if (acceptable_status.indexOf(response_payment.status) > -1)
                {    
                    var location = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
                    location += 'index.php?route=checkout/success';
                    window.location.href = location;
                }
                else
                {
                    delete response_payment.request_type;
                    getMessage(response_payment);
                }
                spinner.stop();     
            }
        });
    }
    }
    );
    });

    function getMessage(data)
    {   
        var div_main = document.getElementById('mp_custom');
        div_main.innerHTML = '';
        var div_error = document.createElement('div');
        div_error.setAttribute('class', "alert alert-danger");
        div_error.setAttribute('id',"div_error");
        var btn_dismiss = document.createElement('button');
        btn_dismiss.setAttribute('class',"close");
        btn_dismiss.setAttribute('id',"btn_dismiss");
        btn_dismiss.innerHTML = "x";

        btn_dismiss.onclick = function()
        {
            div_main.removeChild(document.getElementById('div_error'));
        };


        var response_payment = typeof(data) == "string"? JSON.parse(data): data;
        var url_site = window.location.href.split('index.php')[0];
        var url_message = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
        url_message += 'index.php?route=payment/mp_transparente/getPaymentStatus&status=' 
        + response_payment.status;
        if(response_payment.request_type)
        {
            url_message += '&request_type=' + response_payment.request_type;        
        }

        $.get(url_message, function success(rtn) 
        {
            var payment_return = JSON.parse(rtn);
            var text = document.createTextNode(payment_return["message"]); 
            div_error.innerHTML = "";
            div_error.appendChild(text);
            div_error.appendChild(btn_dismiss);
            document.getElementById('mp_custom').appendChild(div_error);
        });

    }

    function getInstallments()
    {
        var public_key = document.getElementById("public_key").value;
        var issuer = document.getElementById('issuer').value;
        var bin = document.getElementById('cc_num').value.replace(/[ .-]/g, '').slice(0, 6);
        var lbls = document.getElementsByClassName('text-right');
        var amount = parseFloat(lbls[lbls.length -1].textContent.split('$')[1].replace('.','').replace(',','.'));
        console.log('total amount: ' + amount);
        var config = {"bin": bin,"amount": amount};
        if (issuer)
        {
            config.issuer_id = issuer;
        }

        Mercadopago.setPublishableKey(public_key);


        Mercadopago.getInstallments(config, function(httpStatus, data){
            if (httpStatus == 200)
            {
                var installments = data[0].payer_costs;
                    //document.getElementById('paymentType').value = data[0].payment_method_id;
                    var i = installments.length;
                    var select = document.getElementById('installments');
                    select.options.length = 0;
                    select.appendChild(new Option('Selecione'));
                    for (i = 0; i < installments.length; i++) 
                    {
                        var opt = document.createElement('option');    
                        opt.appendChild(document.createTextNode(installments[i].recommended_message));
                        opt.value = installments[i].installments;
                        select.appendChild(opt);
                    }
                    
            }
        });
    }

    function getCardIssuers()
    {
        var public_key = document.getElementById("public_key").value;
        var payment_method_id =  document.getElementById('paymentType').value;

        Mercadopago.setPublishableKey(public_key);
        Mercadopago.getIssuers(payment_method_id, function(httpStatus, dt)
        {
            var select = document.getElementById('issuer');
            var i = dt.length;

            while(i--)
            {
                if (dt[i].name != "default") 
                {
                    var option = new Option(dt[i].name, dt[i].id);
                } 
                else 
                {
                    var option = new Option("Otro", dt[i].id);
                }
                select.appendChild(option);
            }

            document.getElementById('divIssuer').style = 'display: block';
            select.addEventListener('change', getInstallments);
        });

    }

    document.getElementById('cardType').addEventListener('change', function(){
        var paymentType = document.getElementById('paymentType');
        var bg = document.querySelector('input[data-checkout="cardNumber"]');

        if (paymentType.value.indexOf('visa') > -1 || paymentType.value.indexOf('master') > -1)
        {
            var cardType = document.getElementById('cardType').value;
            if (cardType == "deb")
            {
                paymentType.value = cardType + paymentType.value;
                bg.style.background =   bg.style.background.replace('visa.gif','debvisa.gif').replace('master.gif','debmaster.gif');
                document.getElementById('divInstallments')    
            }
            else
            {
                paymentType.value = paymentType.value.replace('deb','')
                bg.style.background =   bg.style.background.replace('debvisa.gif', 'visa.gif').replace('debmaster.gif', 'master.gif');    
            }
        }   

    });

