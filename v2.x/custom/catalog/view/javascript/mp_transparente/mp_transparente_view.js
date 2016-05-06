                 (function(){
                    $('#formulario').hide();
                    var spinner = new Spinner().spin(document.getElementById('spinner'));
                    var country = document.getElementById('country').value;
                    var firstname =  document.getElementById('input-payment-firstname');

                    if(firstname)
                    {
                        var firstname =  document.getElementById('input-payment-firstname');
                        var lastname =  document.getElementById('input-payment-lastname');
                        document.getElementById('card_name').value = firstname.value + ' ' + lastname.value  ; 
                    }
                        setTimeout(function(){
                            $('#expiration_month').datetimepicker({minViewMode: 1, maxViewMode: 1, format: 'M'});
                            $('#expiration_year').datetimepicker({minViewMode: 2, maxViewMode: 2, format: 'YYYY'});

                            var public_key = document.getElementById("public_key").value;
                            Mercadopago.setPublishableKey(public_key);
                            if(country != "MLM")
                            {
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
                                });  
                            }
                            console.log('parando spinner');
                            spinner.stop();
                            console.log('spinner parado');
                            $('#formulario').show("slow"); 
                        }, 5000);
                    
                })();

                document.getElementById('cc_num').addEventListener('change', function () {
                    var card_number = document.getElementById('cc_num');
                    card_number.value = card_number.value.trim();
                    var cc_num = card_number.value.replace(/[ .-]/g, '').slice(0, 6);

                    if(cc_num.length == 0)
                    { 
                        document.getElementById('paymentType').value = "";
                        document.getElementById('cc_num').style.background = "";
                        return;
                    }

                    if(cc_num.length > 5)
                    {
                        var public_key = document.getElementById("public_key").value;
                        Mercadopago.setPublishableKey(public_key);

                        Mercadopago.getPaymentMethod({
                            "bin": cc_num
                        }, function (status, response) {
                         var paymentType = document.getElementById('paymentType')
                         paymentType.value = response[0].id;
                         var bg = 'url("' + response[0].secure_thumbnail + '") 98% 50% no-repeat';
                         card_number.style.background = bg;
                         if (paymentType.value == 'amex' )
                         {
                            $("#credit").mask("9999-999999-99999", {clearIfNotMatch: true});
                        }
                        else 
                        { 
                            $("#credit").mask("9999-9999-9999-9999", {clearIfNotMatch: true}); 
                        }
                        if (response[0].additional_info_needed.indexOf('issuer_id') > -1)
                        {
                            getCardIssuers();
                        }
                        getInstallments();
                    });    
                    }
                });

                document.getElementById('button_pay').addEventListener('click', function doPayment () {
                    var tries = localStorage.getItem('payment')? parseInt(localStorage.getItem('payment')):0;
                    if(tries)
                    {
                        Mercadopago.clearSession();
                    }
                    tries+=1;
                    localStorage.setItem('payment',tries);
                    var style = 'margin-left: 22%;'; 
                    document.getElementById('formulario').setAttribute('style', 'pointer-events: none; opacity: 0.4;' + style);
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

                           var issuer = document.getElementById('issuer');
                           if(issuer)
                           {
                            payment.issuer_id = issuer.value;
                        }
                        pay(payment);

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
                    var issuer = document.getElementById('issuer');
                    var bin = document.getElementById('cc_num').value.replace(/[ .-]/g, '').slice(0, 6);
                    var lbls = document.getElementsByClassName('text-right');
                    var amount = parseFloat(lbls[lbls.length -1].textContent.split('$')[1].replace('.','').replace(',','.'));
                    var config = {"bin": bin,"amount": amount};
                    if (issuer)
                    {
                        config.issuer_id = issuer.value;
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
                                option.style.background = 'url("' + dt[i].secure_thumbnail + '") 98% 50% no-repeat';
                            } 
                            else 
                            {
                                var option = new Option("Otro", dt[i].id);
                            }
                            select.appendChild(option);
                        }

                        select.addEventListener('change', getInstallments);
                    });

                }
                var cardType = document.getElementById('cardType');

                if(cardType)
                {
                    cardType.addEventListener('change', function(){
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
                }


                function customersAndCards()
                {
        //TODO: JS para pegar as informações sobre o cartão escolhido
        //e chamar a função pay
    }

    function pay(payment)
    {
        $.ajax({
            type: "POST",
            url: url_backend,
            data: payment,
            success: function success(data) {
                response_payment = JSON.parse(data);
                document.getElementById('formulario').style = 'margin-left: 22%';
                var acceptable_status = ["approved", "in_process"];
                if (acceptable_status.indexOf(response_payment.status) > -1)
                {    
                    var location = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
                    location += 'index.php?route=checkout/success';
                    localStorage.removeItem('payment');
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