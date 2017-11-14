    (function(){
        var access_token = document.getElementById('mp_ticket_access_token');
        var btn_save = document.getElementById('btn_save');
        
        access_token.onchange = loadPaymentMethods;
        btn_save.onclick = saveConfigs;

        if (access_token.value != "")
        {
            loadPaymentMethods();
        }
    })();


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
            };

            $('#form_mp').submit();
        };

    function loadPaymentMethods()
    {
        var access_token = document.getElementById('mp_ticket_access_token');
        var token_value = access_token? access_token.value: "";
        var div_payments = document.getElementById('div_payments');
        if (token_value == "")
        {
            var div_error = document.createElement('div');
            div_error.className = "text-danger";
            div_error.id = "div_error_methods";
            div_error.innerHTML = '<b>Please, select at least one payment method</b>';
            div_payments.appendChild(div_error);
            //TEST-5249833162698191-020413-831f3b52f3922cb013847f9e02829d69__LC_LD__-204620652
            return;
        }

        var spinner = new Spinner().spin(div_payments);
        var url_site =  window.location.href.split('admin')[0];
        var token = window.location.href.split('token=')[1];

        if (url_site.value != "")
        {
            div_payments.innerHTML = '';
            var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';
            url_backend += 'admin/index.php?route=extension/payment/mp_ticket/getPaymentMethods&token=' + token;
            url_backend = access_token.value  == ""? url_backend: url_backend + '&access_token=' + access_token.value;
            $.get(url_backend , function(data) {
                div_payments.innerHTML = data.indexOf('{"status":400') > -1? JSON.parse(data).message : data;
                spinner.stop();
            });
        }
    }