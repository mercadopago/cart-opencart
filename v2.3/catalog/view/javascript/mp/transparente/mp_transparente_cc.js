(function(){
	$("#cardData").hide('slow');
	document.getElementById('cc_num_cc').addEventListener('change', customersAndCardsSelectHandler);
	document.getElementById('button_pay_cc').addEventListener('click',doPay);
	setTimeout(function(){
		customersAndCardsGetInstallments();
	}, 4000);
	
})();

function doPay(event){
	event.preventDefault();
	var $form = document.querySelector('#divCustomersAndCards');
	console.log('form');
	console.log($form);
	Mercadopago.createToken($form, customersAndCardsPay);
	return false;
};

function buildAmount(amount)
{
	var string_amount = amount.toString();
	var splitted_amount = string_amount.split("");
	var comma = amount.indexOf(',');
	var dot =  amount.indexOf('.');
    //virgula vem antes do ponto
    if(comma < dot)
    {
    	splitted_amount[comma] = "";
    }//virgula vem depois do ponto
    else
    {
    	splitted_amount[comma] = ".";
        splitted_amount[dot] = "";
    }
   var final_amount = splitted_amount.join("");
    console.log("comma:" + comma);
    console.log("dot:" + dot);
    console.log("final value:" + final_amount);
    return Number(final_amount);
}
                function cardsHandler(){
                	var card = document.querySelector('select[data-checkout="cardId"]');
                	if (card[card.options.selectedIndex].getAttribute('security_code_length')==0){
                		document.querySelector("#cvv_cc").style.display = "none";
                	}else if(document.querySelector("#cvv_cc").style.display!="block") {
                		document.querySelector("#cvv_cc").style.display = "block";
                	}
                }


                function customersAndCardsPay(status, response)
                {
                	var tries = localStorage.getItem('payment')? parseInt(localStorage.getItem('payment')):0;
                	if(tries)
                	{
                		Mercadopago.clearSession();
                	}
                	tries+=1;
                	localStorage.setItem('payment',tries);
                	var spinner = new Spinner().spin(document.getElementById('spinner'));
                	var lbls = document.getElementsByClassName('text-right');
                	var url_site = window.location.href.split('index.php')[0];
                	var url_backend = url_site.slice(-1) == '/' ? url_site : url_site + '/';        
                	url_backend += 'index.php?route=extension/payment/mp_transparente/paymentCustomersAndCards/';    
                	var page_amount = lbls[lbls.length -1].textContent.split('$')[1];
                	var payment = {token: response.id, 
                		transaction_amount: buildAmount(page_amount),
                		installments: document.getElementById('installments_cc').value};


                		$.ajax({
                			type: "POST",
                			url: url_backend,
                			data: payment,
                			success: function success(data) {
                				response_payment = JSON.parse(data);
			//document.getElementById('formulario').style = 'margin-left: 22%';
			var acceptable_status = ["approved", "in_process"];
			if (acceptable_status.indexOf(response_payment.status) > -1)
			{

                console.info("====ModuleAnalytics enviar=====");
                ModuleAnalytics.setToken(response_payment.token);
                ModuleAnalytics.setPaymentId(response_payment.paymentId);
                ModuleAnalytics.setPaymentType(response_payment.paymentType);
                ModuleAnalytics.setCheckoutType(response_payment.checkoutType);
                console.info("====ModuleAnalytics=====");
                ModuleAnalytics.put();

				var url_site = window.location.href.split('index.php')[0];
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


                	function getInstallments()
                	{
                		var public_key = document.getElementById("public_key").value;
                		var issuer = document.getElementById('issuer');
                		var bin = document.getElementById('cc_num').value.replace(/[ .-]/g, '').slice(0, 6);
                		var lbls = document.getElementsByClassName('text-right');
                		var string_amount = lbls[lbls.length -1].textContent.split('$')[1];
                		var amount = buildAmount(string_amount);
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

                	function customersAndCardsGetInstallments()
                	{
                		var public_key = document.getElementById("public_key").value;
                		var cc_num = document.getElementById('cc_num_cc')
                		var bin = cc_num.options[cc_num.selectedIndex].getAttribute('first_six_digits');
                		console.log('bin: ')
                		console.log(bin);
                		var lbls = document.getElementsByClassName('text-right');
                		var string_amount = lbls[lbls.length -1].textContent.split('$')[1];
                		var amount = buildAmount(string_amount);
                		var config = {"bin": bin,"amount": amount};

                		Mercadopago.setPublishableKey(public_key);


                		Mercadopago.getInstallments(config, function(httpStatus, data){
                			if (httpStatus == 200)
                			{
                				var installments = data[0].payer_costs;
                				var i = installments.length;
                				var select = document.getElementById('installments_cc');
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


                	function customersAndCardsSelectHandler()
                	{
                		console.log('this.value = ' + this.value);
                		if (this.value == "-1")
                		{
                			$("#cc_inputs").hide('slow');
                			$("#cardData").show('slow');
                		}
                		else
                		{
                			$("#cardData").hide('slow');
                			$("#cc_inputs").show('slow');
                			customersAndCardsGetInstallments();

                        //esconde form de pagamento e exibe form cc
                    }
                    //TODO: JS para pegar as informações sobre o cartão escolhido
                    //e chamar a função pay
                    //Colocar bandeiras nos selects
                    // Salvar os cartões (como array PHP ou json) em sessão para manter os tokens e usar o id do cartão para 
                    // obter o token direto da sessão (usar filter + function que faça o match)
                    //TODO: alterar o script de listener para fazer minor commits
                }