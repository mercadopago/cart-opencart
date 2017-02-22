        (function(){
            var url_site = window.location.href.split('index.php')[0];
            var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
            url_backend += '/index.php?route=extension/payment/mp_ticket/getAcceptedMethods';  
            var spinner = new Spinner().spin(document.getElementById('spinner'));
            
            $.ajax({
                type: "POST",
                url: url_backend,
                success: function success(data){
                   response = JSON.parse(data);
                   var div = document.getElementById('div_payment_methods');
                   var i = response.methods.length;
           
                   var br = document.createElement('br');
                   var label = document.createElement('label');

                   label.innerHTML = "Selecione um meio de pagamento";
                   label.setAttribute('style','float:none; margin-left: auto; margin-right: auto; ');

                   div.appendChild(label);
                   div.appendChild(br);
                   while(i--)
                   {                    
                       var new_div = document.createElement('div');
                       var chk = document.createElement('input');
                       var img = document.createElement('img');

                       chk.setAttribute('type', 'radio');
                       chk.setAttribute('name', 'rd_payment');
                       chk.setAttribute('value', response.methods[i].method);

                       img.setAttribute('src', response.methods[i].secure_thumbnail);
                       new_div.appendChild(img);
                       new_div.appendChild(document.createElement('br'));
                       new_div.appendChild(chk);


                       new_div.setAttribute('style','margin-left: 5%; display: inline-block;');
                       new_div.addEventListener('click', function(){
                        document.getElementById('payment_method_id').value = this.childNodes[2].value;
                        console.log('valor selecionado: ' + this.childNodes[2].value);
                    })
                       div.appendChild(new_div);
                       spinner.stop();
                   }
               

           },
           error: function(data){spinner.stop(); alert('error'); console.log(data);this.disabled = false;}
       })
        })();

        document.getElementById('button_pay').addEventListener('click', pay);


        function getMessage(data)
        {
            document.getElementById('mp_ticket').innerHTML = "";
            var div_error = document.createElement('div');
            div_error.setAttribute('class', "alert alert-danger");
            div_error.setAttribute('id',"div_error");
            var btn_dismiss = document.createElement('button');
            btn_dismiss.setAttribute('class',"close");
            btn_dismiss.setAttribute('id',"btn_dismiss");
            btn_dismiss.innerHTML = "x";

            btn_dismiss.onclick = function()
            {
                document.getElementById('mp_ticket').removeChild(document.getElementById('div_error'));
            };

            var response_payment = typeof(data) == "string"? JSON.parse(data): data;
            var url_site = window.location.href.split('index.php')[0];
            var url_message = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
            url_message += 'index.php?route=extension/payment/mp_ticket/getPaymentStatus&status=' 
            + response_payment.status + '&request_type=' + response_payment.request_type;    
            $.get(url_message, function success(rtn) 
            {
                var payment_return = JSON.parse(rtn);
                var text = document.createTextNode(payment_return["message"]); 
                div_error.appendChild(text);
                div_error.appendChild(btn_dismiss);
                document.getElementById('mp_ticket').appendChild(div_error);
            });

        }

        function validate(){
            return Array.prototype.slice.call(document.getElementsByName('rd_payment'))
            .filter(function(item){
                return item.checked;
            }).length > 0 ;
        }

        function pay(){
           if(validate()){
            this.disabled = true;
            var spinner = new Spinner().spin(document.getElementById('spinner'));
            var url_site = window.location.href.split('index.php')[0];
            var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
            url_backend += 'index.php?route=extension/payment/mp_ticket/payment/&payment_method_id=' + document.getElementById('payment_method_id').value;         
            var valid_status = [200, 201];
            $.ajax({type: "POST",
                url: url_backend,
                success: function success(data) 
                {
                    response = JSON.parse(data);
                    if((response.error || valid_status.indexOf(status) < 0) && response.url)
                    {
                        ModuleAnalytics.setToken(response.token);
                        ModuleAnalytics.setPaymentId(response.paymentId);
                        ModuleAnalytics.setPaymentType(response.paymentType);
                        ModuleAnalytics.setCheckoutType(response.checkoutType);
                        ModuleAnalytics.put();

                        console.log('abrindo boleto: ' + response.url);
                        var paymentWindow = window.open(response.url);
                        if(!paymentWindow || paymentWindow.closed || typeof paymentWindow.closed=='undefined') 
                        { 
                            //TODO: Trocar isso por um getMessage com o idioma nativo
                            alert('Please, disable your pop up blocker');
                            spinner.stop();
                            return;
                        }

                        var location = url_site.slice(-1) == '/' ? url_site : url_site + '/';
                        location += 'index.php?route=checkout/success';

                        window.location.href = location;
                    }
                    else
                    {
                        spinner.stop();
                        getMessage(data);
                    }
                }
            });
        }
    }
