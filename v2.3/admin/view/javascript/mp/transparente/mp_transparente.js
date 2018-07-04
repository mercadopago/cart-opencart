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
                url_backend += 'admin/index.php?route=extension/payment/mp_transparente/getPaymentMethodsByCountry&country_id=' + country + "&token=" + token;
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
        btn_save.onclick = saveConfigs;})();

        function saveConfigs(){

            var selected_payments = $('#div_payments');;
            var div_payment = document.getElementById('div_payments');
            if (selected_payments.find('input:checked').length == 0) 
            {
                if(selected_payments.find('input[type=checkbox]'))
                {
                    selected_payments.find('input[type=checkbox]')[0].focus();
                }
                var div_error = document.createElement('div');
                div_error.className = "text-danger";
                div_error.id = "div_error_methods";
                div_error.innerHTML = '<b>Please, select at least one payment method</b>';
                div_payments.appendChild(div_error);
                return;
            }

            $('#form_mp').submit();
        };