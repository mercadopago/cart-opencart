        (function(){
            var url_site = window.location.href.split('index.php')[0];
            var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
            url_backend += '/index.php?route=extension/payment/mp_ticket/getAcceptedMethods';  
            var spinner = new Spinner().spin(document.getElementById('spinner'));
            var country = $('#contryType').val();

            $.ajax({
                type: "POST",
                url: url_backend,
                success: function success(data){
                    response = JSON.parse(data);
                   var div = document.getElementById('div_payment_methods');
                   var i = response.methods.length;
                   var br = document.createElement('br');

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

                       new_div.setAttribute('style','float:left; margin-left: 10%;');
                       new_div.addEventListener('click', function(){
                        document.getElementById('payment_method_id').value = this.childNodes[2].value;
                        console.log('valor selecionado: ' + this.childNodes[2].value);
                    })

                    div.appendChild(new_div);
                    div.appendChild(br);
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

        function validaCpf(val) {

          if (val.match(/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/) != null) {
              var val1 = val.substring(0, 3);
              var val2 = val.substring(4, 7);
              var val3 = val.substring(8, 11);
              var val4 = val.substring(12, 14);

              var i;
              var number;
              var result = true;

              number = (val1 + val2 + val3 + val4);

              s = number;
              c = s.substr(0, 9);
              var dv = s.substr(9, 2);
              var d1 = 0;

              for (i = 0; i < 9; i++) {
                  d1 += c.charAt(i) * (10 - i);
              }

              if (d1 == 0)
                  result = false;

              d1 = 11 - (d1 % 11);
              if (d1 > 9) d1 = 0;

              if (dv.charAt(0) != d1)
                  result = false;

              d1 *= 2;
              for (i = 0; i < 9; i++) {
                  d1 += c.charAt(i) * (11 - i);
              }

              d1 = 11 - (d1 % 11);
              if (d1 > 9) d1 = 0;

              if (dv.charAt(1) != d1)
                  result = false;

              if (result)
                return number;

              return "";
          }

          return;
      }

      function validaCNPJ (strCNPJ) {
          strCNPJ = strCNPJ.replace('.','');
          strCNPJ = strCNPJ.replace('.','');
          strCNPJ = strCNPJ.replace('.','');
          strCNPJ = strCNPJ.replace('-','');
          strCNPJ = strCNPJ.replace('/','');

          var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
          digitos_iguais = 1;

          if (strCNPJ.length < 14 && strCNPJ.length < 15){
            return false;
          }

          for (i = 0; i < strCNPJ.length - 1; i++){
            if (strCNPJ.charAt(i) != strCNPJ.charAt(i + 1)){
              digitos_iguais = 0;
              break;
            }
          }

          if (!digitos_iguais){
            tamanho = strCNPJ.length - 2
            numeros = strCNPJ.substring(0,tamanho);
            digitos = strCNPJ.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--){
              soma += numeros.charAt(tamanho - i) * pos--;
              if (pos < 2){
                pos = 9;
              }

            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)){
              return false;
            }

            tamanho = tamanho + 1;
            numeros = strCNPJ.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--) {
              soma += numeros.charAt(tamanho - i) * pos--;
              if (pos < 2){
                pos = 9;
              }

            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)){
              return false;
            }

            return true;
          }else{
            return false;
          }
        }

        function validate(firstname, lastname, docNumber, zipcode, address, number, city, state, country, typeDoc, razao, docNumberCNPJ) {

          var retorno = true;

          $('#erro_name').hide();
          $('#erro_cnpj').hide();
          $('#erro_address').hide();
          $('#erro_state').hide();

          if (country == "MLB") {
           
            if(typeDoc == "CPF") {
              if(firstname == "" || lastname == "" || docNumber == "" || validaCpf(docNumber) == ""){
                $('#erro_name').show();
                retorno = false;
              }
            } else {
              if(razao == "" || docNumberCNPJ == "" || validaCNPJ(docNumberCNPJ) == "") {
                $('#erro_cnpj').show();
                retorno = false;
              }
            }

            if(address == "" || number == ""){
              $('#erro_address').show(); 
              retorno = false;
            }

            if(city == "" || state == "" || zipcode == "" ) {
              $('#erro_state').show();
              retorno = false;
            }

            if (Array.prototype.slice.call(document.getElementsByName('rd_payment'))
             .filter(function(item){
               return item.checked;
             }).length <= 0) {
               retorno = false;
            }

          } else {
            return Array.prototype.slice.call(document.getElementsByName('rd_payment'))
             .filter(function(item){
               return item.checked;
             }).length > 0 ;
          }

          return retorno;
        }

        function pay(){

          var firstname = $('#firstname').val();
          var lastname = $('#lastname').val(); 
          var razao = $('#razao').val();  
          var docNumber = $('#docNumber').val();
          var docNumberCNPJ = $('#docNumberCNPJ').val();
          var zipcode = $('#zipcode').val();    
          var address = $('#address').val();
          var number = $('#number').val();
          var city = $('#city').val();
          var state = $('#state').val();
          var country = $('#contryType').val();
          var radioDoc = $("#fisica").is(":checked");
          var typeDoc = "CPF";
          var bolpay = $(".rd_payment").val();

          if (!radioDoc)
            typeDoc = "CNPJ";

          var retorno = validate(firstname, lastname, docNumber, zipcode, address, number, city, state, country, typeDoc, razao, docNumberCNPJ);

           if(retorno){
            this.disabled = true;
            var valid_status = [200, 201];
            var spinner = new Spinner().spin(document.getElementById('spinner'));
            var url_site = window.location.href.split('index.php')[0];
            var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';       
            url_backend += 'index.php?route=extension/payment/mp_ticket/payment/&payment_method_id=' + document.getElementById('payment_method_id').value;

            $.ajax({type: "POST",
                url: url_backend,
                data: { mercadopago_ticket : {
                  firstname : firstname,
                  lastname : lastname,
                  docNumber : docNumber,
                  zipcode : zipcode,
                  address : address,
                  number : number,
                  city : city,
                  state : state,
                  docNumberCNPJ : docNumberCNPJ,
                  razao : razao,
                  typeDoc : typeDoc
                }}, success: function success(data) {
                    response = JSON.parse(data);
                    if((response.error || valid_status.indexOf(status) < 0) && response.url) {
                        ModuleAnalytics.setToken(response.token);
                        ModuleAnalytics.setPaymentId(response.paymentId);
                        ModuleAnalytics.setPaymentType(response.paymentType);
                        ModuleAnalytics.setCheckoutType(response.checkoutType);
                        ModuleAnalytics.put();

                        console.log('abrindo boleto: ' + response.url);
                        var paymentWindow = window.open(response.url);
                        if(!paymentWindow || paymentWindow.closed || typeof paymentWindow.closed=='undefined') { 
                            //TODO: Trocar isso por um getMessage com o idioma nativo
                            alert('Please, disable your pop up blocker');
                            spinner.stop();
                            return;
                        }

                        var location = url_site.slice(-1) == '/' ? url_site : url_site + '/';
                        location += 'index.php?route=checkout/success';

                        window.location.href = location;
                    } else {
                        spinner.stop();
                        getMessage(data);
                    }
                }
            });
        }
    }
