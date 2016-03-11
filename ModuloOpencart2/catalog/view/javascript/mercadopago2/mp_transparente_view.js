 (function(){
     var spinner = new Spinner().spin(document.getElementById('spinner'));
     getLabelNames();
        var firstname =  document.getElementById('input-payment-firstname');
     if(firstname)
     {
        var firstname =  document.getElementById('input-payment-firstname');
        var lastname =  document.getElementById('input-payment-lastname');
        document.getElementById('card_name').value = firstname.value + ' ' + lastname.value  ; 
     }
        if (document.getElementById('country').value == "MLM")
        {
            var docInfo = document.getElementById('docInfo');
            var docType = document.getElementById('divDocType');
            var docNumber = document.getElementById('divDocNumber');
            docInfo.removeChild(docType);
            docInfo.removeChild(docNumber);
            document.getElementById('divPaymentType').style = 'display: block;';    
        }
        else
        {
            setTimeout(function(){
            var public_key = document.getElementById("public_key").value;
            Mercadopago.setPublishableKey(public_key);
            Mercadopago.getIdentificationTypes(function (httpStatus, dt) {
                var select = document.getElementById('doc_type');
                    var i = dt.length;
                    while(i--)
                    {
                        var option = new Option(dt[i].name, dt[i].id);
                        select.appendChild(option);
                    }
                });
        }, 3000);
    }
        
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
        console.log('public key: ' + public_key);
        Mercadopago.setPublishableKey(public_key);

        Mercadopago.getPaymentMethod({
            "bin": cc_num
        }, function (status, response) {
            document.querySelector('input[data-checkout="cardNumber"]').style.background = "url(" + response[0].secure_thumbnail + ") 98% 50% no-repeat"
            var paymentType = document.getElementById('paymentType')
            paymentType.value = response[0].id;//.replace('deb', '').replace('cred', '');
            console.log('response');
            console.log(response);
            if (response[0].additional_info_needed.indexOf('issuer_id') > -1)
            {
                console.log('rolou 1');
                getCardIssuers();
                document.getElementById('divIssuer').style = 'display: block;';
                if(document.getElementById('country').value == "MLM")
                {
                    console.log('rolou 2');
                    if(paymentType.value.indexOf('visa') > -1 || paymentType.value.indexOf('master') > -1)
                    {
                        console.log('rolou 3');
                        document.getElementById('divPaymentType').style = 'display: block;';    
                    }
                    
                }
            }
            else
            {
                console.log('num rolou');
                 document.getElementById('divIssuer').style = 'display: none;';
                 document.getElementById('divPaymentType').style = 'display: none;';
            }
            
            getInstallments();
            
        });    
      }
});

document.getElementById('button_pay').addEventListener('click', function () {
        document.getElementById('formulario').style = 'pointer-events: none; opacity: 0.4;';

        var spinner = new Spinner().spin(document.getElementById('spinner'));
        var form = {cardNumber: document.getElementById('cc_num').value,
                    securityCode: document.getElementById('cvv').value,
                    cardExpirationMonth:document.getElementById('expiration_month').value,
                    cardExpirationYear:document.getElementById('expiration_year').value,
                    cardholderName:document.getElementById('card_name').value};

        if(document.getElementById('country').value != "MLM")
        {
            form.docType = document.getElementById('doc_type').value;
            form.docNumber = document.getElementById('doc_number').value;
        }
                    console.log('form');
                    console.log(form);
        var url_site = window.location.href.split('index.php')[0];
        var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
        url_backend += 'index.php?route=payment/mercadopago2/payment/';         
        
        var p_return = document.getElementById('return_message');
        p_return.innerHTML = "";
       Mercadopago.createToken(form, function (status, response) {
           console.log('response');
           console.log(response);
           var valid_status = [200, 201];
            console.log('entrou no createToken');
            if(response.error || valid_status.indexOf(status) < 0)
            {
                spinner.stop();
                document.getElementById('formulario').style = '';
                var data = {status: response.cause[0].code, message: response.cause[0].description, request_type:"token"};
                getMessage(data);
            } 
            else 
            {
                var payment = {token: response.id, 
                               //email: document.getElementById('email').value,
                               user: document.getElementById('card_name').value,
                               payment_method_id: document.getElementById('paymentType').value,
                               installments: document.getElementById('installments').value
                               };
              if(document.getElementById('country').value != "MLM")
                    {
                        payment.docType = document.getElementById('doc_type').value;
                        payment.docNumber = document.getElementById('doc_number').value;
                    }
                var issuer = document.getElementById('issuer').value;
                if(issuer)
                {
                    payment.issuer_id = issuer;
                }
                console.log('payment');
                console.log(payment);
                setTimeout(function(){
                    spinner.stop();
                    document.getElementById('formulario').style = '';
                }, 3000); 
                $.ajax({
                        type: "POST",
                        url: url_backend,
                        data: payment,
                        success: function success(data) {
                        getMessage(data);
                        response_payment = JSON.parse(data);
                        if (response_payment.status == 200 || response_payment.status == 201)
                           {
                                setTimeout(function () {
                                    var location = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
                                    location += 'index.php?route=checkout/success';
                                    window.location.href = location;
                                    }, 5000);
                           }
                        }     
                      });
            }
        }
        );
});

 function getLabelNames()
 {
    var url_site =  window.location.href.split('index.php')[0];
        console.log('url_site ' + url_site);
            if (url_site.value != "")
            {
                var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';
                url_backend += 'index.php?route=payment/mercadopago2/getPaymentDataByLanguage/';
                console.log('url_backend ' + url_backend);
                $.get(url_backend , function(data) {
                    var dt = JSON.parse(data);
                    document.getElementById('ccnum_label').innerHTML = dt.ccnum_placeholder;
                    document.getElementById('expiration_month_label').innerHTML = dt.expiration_month_placeholder;
                    document.getElementById('expiration_year_label').innerHTML = dt.expiration_year_placeholder;
                    document.getElementById('card_name_label').innerHTML =  dt.name_placeholder;
                    document.getElementById('installments_label').innerHTML = dt.installments_placeholder;
                    document.getElementById('cardType_label').innerHTML = dt.cardType_placeholder;
                    document.getElementById('button_pay').innerHTML = dt.payment_button;
                    document.getElementById('paymentTitle').innerHTML = dt.payment_title;
                    document.getElementById('return_message').innerHTML = dt.payment_processing;  
                    document.getElementById('doc_type_label').innerHTML = dt.doctype_placeholder;
                    document.getElementById('doc_number_label').innerHTML = dt.docnumber_placeholder;
                });
            }
 }

 function getMessage(data)
 {      
        var response_payment = typeof(data) == "string"? JSON.parse(data): data;
        var p_return = document.getElementById('return_message');
        var url_site = window.location.href.split('index.php')[0];
        var url_message = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
        url_message += 'index.php?route=payment/mercadopago2/getPaymentStatus&status=' 
        + response_payment.status + '&request_type=' + response_payment.request_type;    
        $.get(url_message, function success(rtn) 
        {
            p_return.innerHTML = "";
            var payment_return = JSON.parse(rtn);
            p_return.innerHTML = payment_return["message"];
            $('#modal_popup').bPopup();
            console.log('response_payment');
        });
                      
 }

function getInstallments()
{
    var public_key = document.getElementById("public_key").value;
    var issuer = document.getElementById('issuer').value;
    var bin = document.getElementById('cc_num').value.replace(/[ .-]/g, '').slice(0, 6);
    var lbls = document.getElementsByClassName('text-right');
    var amount = parseFloat(lbls[lbls.length -1].textContent.split('$')[1].replace(',', ''));
    var config = {"bin": bin,"amount": amount};
    if (issuer)
    {
        config.issuer_id = issuer;
    }

    console.log('config');
    console.log(config);
    
    console.log('issuer 1');
    console.log(issuer);
    

    Mercadopago.setPublishableKey(public_key);
    
    
    Mercadopago.getInstallments(config, function(httpStatus, data){
        console.log('retorno do installments: ');
        console.log(data);
        if (httpStatus == 200)
        {
            var installments = data[0].payer_costs;
            //document.getElementById('paymentType').value = data[0].payment_method_id;
            var i = installments.length;
            if( i > 0)
            {
                var select = document.getElementById('installments');
                select.options.length = 0;
                while(i--)
                {
                    var opt = document.createElement('option');    
                    opt.appendChild(document.createTextNode(installments[i].recommended_message));
                    opt.value = installments[i].installments;
                    select.appendChild(opt);
                }
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
    console.log('entrou no listener do cardType');
    
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

