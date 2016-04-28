# OpenCart - MercadoPago Module (v1.4.9, 1.5.x, 2.x)
---

* [Features](#features)
* [Available versions](#available_versions)
* [Installation](#installation)
* [Setup](#setup)
* [Notifications](#notifications)

<a name="features"></a>
##Features##

**Standard checkout**

This feature allows merchants to have a standard checkout. It includes all
payment methods (i.e. all credit cards, bar code payment, account money) and all window types (i.e. redirect, iframe, modal, blank and popup). Customization is not allowed.

**Credit Card Customized Checkout**

This feature will allow merchants to have a customized checkout for credit card
payment. Thus, it will be possible to customize its look and feel, customers won’t be redirected away to complete the payment, and it will also reduce the checkout steps, improving conversion rates.

**Ticket Checkout**

This feature allows merchants to have a customized ticket checkout, according to each country's ticket method (i.e Boleto in Brazil, RapiPago in Argentina, etc).  Thus, it will be possible to customize its look and feel, customers won’t be redirected away to complete the payment, and it will also reduce the checkout steps, improving conversion rates. The ticket link will be shown and when the customer click on it, another tab with the ticket will be opened.


***Important information***

**SSL certificate**

If you're using Ticket Checkout or Custom Checkout, it is a requirement that you have a SSL certificate, and the payment form to be provided under an HTTPS page.
During the sandbox mode tests, you can operate over HTTP, but for homologation you'll need to acquire the certificate in case you don't have it.

<a name="available_versions"></a>
##Available versions##
<table>
  <thead>
    <tr>
      <th>Plugin Version</th>
      <th>Status</th>
      <th>Compatible Versions</th>
    </tr>
  <thead>
  <tbody>
    <tr>
      <td><a href="https://github.com/mercadopago/cart-opencart/tree/master/v1.4.9">v1.4.9</a></td>
      <td>Deprecated (Old Version)</td>
      <td>OpenCart v1.4.9</td>
    </tr>
    <tr>
      <td><a href="https://github.com/mercadopago/cart-opencart/tree/master/v1.5.x">v1.5.x</a></td>
      <td>Deprecated (Old Version)</td>
      <td>OpenCart v1.5.x</td>
    </tr>
    <tr>
      <td><a href="https://github.com/mercadopago/cart-opencart/tree/master/v2.x">v2.x</a></td>
      <td>Stable (Current Version)</td>
      <td>OpenCart v2.x</td>
     </tr>
  </tbody>
</table>

<a name="installation"></a>
##Installation##

1. Download MercadoPago module:
    * OpenCart 1.4.9
    * OpenCart 1.5.x
    * OpenCart 2.x

2. Copy the folders **admin**, **catalog** and **image** to your OpenCart ROOT installation. Make sure to keep the OpenCart folders structure intact.

**Important**: If you're using OpenCart 2.0, you'll find 3 different types of checkout inside the OpenCart 2.x folder: Standard, Custom and Ticket. You can use them all together or individually, without any problems or dependencies between them. Each one of these folders have its own Admin, Catalog and Image folders and the installation process is the same described above.

<a name="setup"></a>
## Setup MercadoPago

1. On your store administration, go to **extensions > payments > MercadoPago** and click **Install**.

2. Again in **extensions > payments > MercadoPago**, click **Edit** to Setup your MercadoPago account:

	![MercadoPago Account](https://raw.github.com/mercadopago/cart-opencart/master/README.img/MPAccount.png)

3. Set your Country where your MercadoPago account was created and save config.
	
	***Note:*** *If you change the Country where your account was created you need save config to refresh the excluded payment methods.*

4. Set your **CLIENT_ID** and **CLIENT_SECRET**, or **PUBLIC_KEY** and **ACCESS_TOKEN** (depending on which module you're using). 

	Get your CLIENT_ID and CLIENT_SECRET in the following address:
	* Argentina: [https://www.mercadopago.com/mla/herramientas/aplicaciones](https://www.mercadopago.com/mla/herramientas/aplicaciones)
	* Brazil: [https://www.mercadopago.com/mlb/ferramentas/aplicacoes](https://www.mercadopago.com/mlb/ferramentas/aplicacoes)
	* Chile: [https://www.mercadopago.com/mlc/herramientas/aplicaciones](https://www.mercadopago.com/mlc/herramientas/aplicaciones)
	* Colombia: [https://www.mercadopago.com/mco/herramientas/aplicaciones](https://www.mercadopago.com/mco/herramientas/aplicaciones)
	* Mexico: [https://www.mercadopago.com/mlm/herramientas/aplicaciones](https://www.mercadopago.com/mlm/herramientas/aplicaciones)
	* Venezuela: [https://www.mercadopago.com/mlv/herramientas/aplicaciones](https://www.mercadopago.com/mlv/herramientas/aplicaciones)

***IMPORTANT:*** *This module will only work with the following currencies:*

* Argentina:
	* **ARS** (Peso Argentino)
* Brazil:
	* **BRL** (Real)
* Chile:
	* **CLP** (Peso Chileno)
* Colombia:
	* **COP** (Peso Colombiano)
* Mexico:
	* **MXN** (Peso Mexicano)
* Venezuela:
	* **VEF** (Bolivar fuerte)

<a name="notifications"></a>
## Sync your backoffice with MercadoPago (IPN) 
Your notification URL will be automatically send with your payment to our API.