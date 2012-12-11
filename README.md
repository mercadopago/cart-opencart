# OpenCart - Mercadopago Module (v1.4.9 - 1.5.x)
---
*Available for Argentina, Brazil and Mexico*


## Installation:

1. Download Mercadopago module:
    * OpenCart 1.4.9
    * OpenCart 1.5.x

2. Copy the folders **admin**, **catalog** and **image** to your OpenCart ROOT installation. Make sure to keep the OpenCart folders structure intact.

## Setup Mercadopago

1. On your store administration, go to **extensions > payments > Mercado Pago 2.0** and click **Install**.

2. Again in **extensions > payments > Mercado Pago 2.0**, click **Edit** to Setup your Mercadopago account:

	![Mercadopago Accounr](https://raw.github.com/mercadopago/cart-opencart/master/README.img/MPAccount.png)

3. Set your Country where your Mercadopago account was created and save config.
	
	***Note:*** *If you change the Country where your account was created you need save config to refresh the excluded payment methods.*

4. Set your **CLIENT_ID** and **CLIENT_SECRET**. 

	Get your **CLIENT_ID** and **CLIENT_SECRET** in the following address:
	* Argentina: [https://www.mercadopago.com/mla/herramientas/aplicaciones](https://www.mercadopago.com/mla/herramientas/aplicaciones)
	* Brasil: [https://www.mercadopago.com/mlb/ferramentas/aplicacoes](https://www.mercadopago.com/mlb/ferramentas/aplicacoes)
	* Mexico: [https://www.mercadopago.com/mlm/herramientas/aplicaciones](https://www.mercadopago.com/mlm/herramientas/aplicaciones)
***IMPORTANT:*** *This module will only work with the following currencies:*

* Brasil:
	* BRL (Real)
* Argentina:
	* ARS (Peso)
* Mexico:
	* MXN (Peso)

---
## Sync your backoffice with Mercadopago (IPN) 

1. Go to **Mercadopago IPN configuration**:
	* Argentina: [https://www.mercadopago.com/mla/herramientas/notificaciones](https://www.mercadopago.com/mla/herramientas/notificaciones)
	* Brasil: [https://www.mercadopago.com/mlb/ferramentas/notificacoes](https://www.mercadopago.com/mlb/ferramentas/notificacoes)
	* Mexico: [https://www.mercadopago.com/mlm/herramientas/notificaciones](https://www.mercadopago.com/mlm/herramientas/notificaciones)
2. Enter the URL as follow: ***[yourstoreaddress.com]***/index.php?route=payment/mercadopago2/retorno/
