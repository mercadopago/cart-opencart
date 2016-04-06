(function(){
    var url_site = window.location.href.split('index.php')[0];
    var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
    url_backend += '/index.php?route=payment/mp_ticket/getAcceptedMethods';  
    var spinner = new Spinner().spin(document.getElementById('spinner'));
     $.ajax({
            type: "POST",
            url: url_backend,
            success: function success(data){
                 response = JSON.parse(data);
                 var div = document.getElementById('div_payment_methods');
                 var i = response.methods.length;
                 while(i--)
                 {
                 var div_error = document.createElement('div');
                        //adiciona os checkboxes e imagens e um event listener neles
                        //para no onclick trocar o valor de um input hidden e
                        // pegar sempre o meio de pagamento
                        div_error.setAttribute('id',"div_error");
                 }
            }.
            error: function(){} 
})();

document.getElementById('button_pay').addEventListener('click', function () {
    var spinner = new Spinner().spin(document.getElementById('spinner'));
    var url_site = window.location.href.split('index.php')[0];
    var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
    url_backend += 'index.php?route=payment/mp_ticket/payment/';         
    var valid_status = [200, 201];
    $.ajax({type: "POST",
            url: url_backend,
            success: function success(data) 
            {
                response = JSON.parse(data);
                if(response.error || valid_status.indexOf(status) < 0)
                {
                    window.open(response.url);
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
});


function getMessage(data)
{      
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
    url_message += 'index.php?route=payment/mp_ticket/getPaymentStatus&status=' 
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
