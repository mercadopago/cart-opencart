# OpenCart - MercadoPago Module (v1.4.9, 1.5.x, 2.x)
---
*Available for Argentina, Brazil, Chile, Colombia, Mexico and Venezuela*


## Installation:

1. Download MercadoPago module:
    * OpenCart 1.4.9
    * OpenCart 1.5.x
    * OpenCart 2.x

2. Copy the folders **admin**, **catalog** and **image** to your OpenCart ROOT installation. Make sure to keep the OpenCart folders structure intact.

## Setup MercadoPago

1. On your store administration, go to **extensions > payments > MercadoPago 2.0** and click **Install**.

2. Again in **extensions > payments > MercadoPago 2.0**, click **Edit** to Setup your MercadoPago account:

	![MercadoPago Account](https://raw.github.com/mercadopago/cart-opencart/master/README.img/MPAccount.png)

3. Set your Country where your MercadoPago account was created and save config.
	
	***Note:*** *If you change the Country where your account was created you need save config to refresh the excluded payment methods.*

4. Set your **CLIENT_ID** and **CLIENT_SECRET**. 

	Get your **CLIENT_ID** and **CLIENT_SECRET** in the following address:
	* Argentina: [https://www.mercadopago.com/mla/herramientas/aplicaciones](https://www.mercadopago.com/mla/herramientas/aplicaciones)
	* Brazil: [https://www.mercadopago.com/mlb/ferramentas/aplicacoes](https://www.mercadopago.com/mlb/ferramentas/aplicacoes)
	* Chile: [https://www.mercadopago.com/mlc/herramientas/aplicaciones](https://www.mercadopago.com/mlc/herramientas/aplicaciones)
	* Colombia: [https://www.mercadopago.com/mco/herramientas/aplicaciones](https://www.mercadopago.com/mco/herramientas/aplicaciones)
	* Mexico: [https://www.mercadopago.com/mlm/herramientas/aplicaciones](https://www.mercadopago.com/mlm/herramientas/aplicaciones)
	* Venezuela: [https://www.mercadopago.com/mlv/herramientas/aplicaciones](https://www.mercadopago.com/mlv/herramientas/aplicaciones)

***IMPORTANT:*** *This module will only work with the following currencies:*

* Argentina:
	* ARS (Peso Argentino)
* Brazil:
	* BRL (Real)
* Chile:
	* CLP (Peso Chileno)
* Colombia:
	* COP (Peso Colombiano)
* Mexico:
	* MXN (Peso Mexicano)
* Venezuela:
	* VEF (Bolivar fuerte)

---
## Sync your backoffice with MercadoPago (IPN) 

1. Go to **MercadoPago IPN configuration**:
	* Argentina: [https://www.mercadopago.com/mla/herramientas/notificaciones](https://www.mercadopago.com/mla/herramientas/notificaciones)
	* Brazil: [https://www.mercadopago.com/mlb/ferramentas/notificacoes](https://www.mercadopago.com/mlb/ferramentas/notificacoes)
	* Chile: [https://www.mercadopago.com/mlc/herramientas/notificaciones](https://www.mercadopago.com/mlc/herramientas/notificaciones)
	* Colombia: [https://www.mercadopago.com/mco/herramientas/notificaciones](https://www.mercadopago.com/mco/herramientas/notificaciones)
	* Mexico: [https://www.mercadopago.com/mlm/herramientas/notificaciones](https://www.mercadopago.com/mlm/herramientas/notificaciones)
	* Venezuela: [https://www.mercadopago.com/mlv/herramientas/notificaciones](https://www.mercadopago.com/mlv/herramientas/notificaciones)

2. Enter the URL as follow: ***[yourstoreaddress.com]***/index.php?route=payment/mercadopago2/retorno/
