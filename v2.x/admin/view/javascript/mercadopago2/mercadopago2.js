    (function(){
        var url_site =  document.getElementsByName('mercadopago2_url')[0];
        url_site.onblur = function(){
            var url_notifications =  document.getElementById('notification_url');
            if (url_site.value != "")
            {
                url_site.value = url_site.value.slice(-1) == '/' ? url_site.value : url_site.value + '/';
                url_notifications.value = url_site.value + 'index.php?route=payment/mercadopago2/notifications';
                document.getElementById("div_notifications").style.visibility = "visible";
            }
            
        };
    })();

    (function(){
        var country_select = document.getElementById('country');
        country.onchange = function(){
            var div_payments = document.getElementById('div_payments');
            div_payments.innerHTML = '';
            var spinner = new Spinner().spin(div_payments);
            var url_site =  window.location.href.split('admin')[0];
            var token = window.location.href.split('token=')[1];
            if (url_site.value != "")
            {
                var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';
                var country = country_select.options[country_select.selectedIndex].value;
                url_backend += 'admin/index.php?route=payment/mercadopago2/getPaymentMethodsByCountry&country_id=' + country + "&token=" + token;
                $.get(url_backend , function(data) {
                    div_payments.innerHTML = data;
                    spinner.stop();
                });
            }
            
        };
        (function(){
            var btn_save = document.getElementById('btn_save');
            btn_save.onclick = function(){
                var selected_payments = $('#div_payments').find('input:checked');
                var store_url = document.getElementsByName('mercadopago2_url')[0];
                if (store_url.value == "") 
                {
                    store_url.focus();
                    if(document.getElementById('div_error_url') == null)
                    {
                        $('#div_store_url').append('<div class="text-danger" id="div_error_url"><b>Mandatory field</b></div>');
                    }
                    return;
                }

                if (selected_payments.length == 0) 
                {
                    
                    var div_error_methods = document.getElementById('div_error_methods');
                    $('#div_payments').find('input[type=checkbox]')[0].focus();
                    div_error_methods.innerHTML = '<b>Please, select at least one payment method</b>';
                    return;
                };

                $('#form').submit();
            };
        })();

    })();