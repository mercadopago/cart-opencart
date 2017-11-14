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
                url_backend += 'admin/index.php?route=extension/payment/mp_standard/getPaymentMethodsByCountry&country_id=' + country + "&token=" + token;
                $.get(url_backend , function(data) {
                    div_payments.innerHTML = data;
                    spinner.stop();
                });
            }
        };
        var nombre = document.getElementById('countryName').value;
        if(nombre != "")
        {
            document.getElementById('country').value = nombre;
        }
    })();

        (function(){
            var btn_save = document.getElementById('btn_save');
            btn_save.onclick = function(){
                var selected_payments = $('#div_payments').find('input:checked');
                if (selected_payments.length == 0) 
                {
                    var div_error_methods = document.getElementById('div_error_methods');
                    $('#div_payments').find('input[type=checkbox]')[0].focus();
                    div_error_methods.innerHTML = '<b>Please, select at least one payment method</b>';
                    return;
                };

                $('#form_mp').submit();
            };
        })();
   