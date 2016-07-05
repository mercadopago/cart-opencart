# OpenCart - MercadoPago Module (v1.4.9, 1.5.x, 2.x)

* [Features](#features)
* [Available Versions](#versions)
* [Requirements](#requirements)
* [Installation](#installation)
* [Configuration](#configuration)
* [Upgrade](#upgrade)
* [Feedback](#feedback)

<a name="features"></a>
## Features:

Checkout options right for your business: 
We offer two checkout methods that make it easy to securely accept payments from anyone, anywhere.

**Custom Checkout**

Offer a checkout fully customized to your brand experience with our simple-to-use payments API.

* Seamless integration— no coding required, unless you want to.
* Full control of buying experience.
* Store buyer’s card for fast checkout.
* Accept tickets in addition to cards.
* Improve conversion rate.

**Standard Checkout**

Great for merchants who want to get going quickly and easily.

* Easy website integration— no coding required.
* Limited control of buying experience— display Checkout window as redirect, modal or iframe.
* Store buyer’s card for fast checkout.
* Accept tickets, bank transfer and account money in addition to cards.
* Accept Mercado Pago's discount coupons.

**Ticket Checkout**

This feature allows merchants to have a customized ticket checkout, according to each country's ticket method (i.e Boleto in Brazil, RapiPago in Argentina, etc).  Thus, it will be possible to customize its look and feel, customers won’t be redirected away to complete the payment, and it will also reduce the checkout steps, improving conversion rates. The ticket link will be shown and when the customer click on it, another tab with the ticket will be opened.

* All checkouts are available for Argentina, Brazil, Chile, Colombia, Mexico, Peru and Venezuela*

<a name="requirements"></a>
## Requirements:

**Operating System**

* Linux x86-64

**Web Server**

* Apache 2.x
* Nginx 1.7.x

**Database**

* MySQL 5.6 (Oracle or Percona)

**PHP**

* PHP 5.4.x / 5.5.x
* Required extensions: PDO_MySQL, simplexml, mcrypt, hash, GD, DOM, iconv, curl

**SSL certificate**

It is a requirement that you have a SSL certificate, and the payment form to be provided under an HTTPS page.
During the sandbox mode tests, you can operate over HTTP, but for homologation you'll need to acquire the certificate in case you don't have it.


<a name="versions"></a>
## Available Versions:
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
## Installation:

1. Download MercadoPago module:
    * OpenCart 1.4.9
    * OpenCart 1.5.x
    * OpenCart 2.x

2. Copy the folders **admin**, **catalog** and **image** to your OpenCart ROOT installation. Make sure to keep the OpenCart folders structure intact.

3.  On your store administration, go to **Extensions > Payments > MercadoPago** and click **Install**.

**Important**: If you're using OpenCart 2.0, you'll find 3 different types of checkout inside the OpenCart 2.x folder: Standard, Custom and Ticket. You can use them all together or individually, without any problems or dependencies between them. Each one of these folders have its own Admin, Catalog and Image folders and the installation process is the same described above.

<a name="configuration"></a>
## Configuration

1. Again in **Extensions > Payments > MercadoPago**, click **Edit** to Setup your MercadoPago account:

 ![MercadoPago Account](https://raw.github.com/brunocodeman/cart-opencart/master/README.img/MPAccount.png)

2.  Set your **CLIENT_ID** and **CLIENT_SECRET**, or **PUBLIC_KEY** and **ACCESS_TOKEN** (depending on which module you're using).  
  In order to get them check the following links according to the country you are opperating in:
  
  * Argentina: [https://www.mercadopago.com/mla/account/credentials](https://www.mercadopago.com/mla/account/credentials)
  * Brazil: [https://www.mercadopago.com/mlb/account/credentials](https://www.mercadopago.com/mlb/account/credentials)
  * Chile: [https://www.mercadopago.com/mlc/account/credentials](https://www.mercadopago.com/mlc/account/credentials)
  * Colombia: [https://www.mercadopago.com/mco/account/credentials](https://www.mercadopago.com/mco/account/credentials)
  * Mexico: [https://www.mercadopago.com/mlm/account/credentials](https://www.mercadopago.com/mlm/account/credentials)
  * Venezuela: [https://www.mercadopago.com/mlv/account/credentials](https://www.mercadopago.com/mlv/account/credentials)
4. If you're using **Custom Checkout** or **Standard Checkout**, select the country related to your **Mercado Pago** account. If you're using **Ticket Checkout**, there is no need to configure the country.

5. Other general configurations:

  * **Category of your store**: Sets up the category of the store.
  * **Choose the status of approved orders**: Sets up the order status when payments are approved.
  * **Choose the status of refunded orders**: Sets up the order status when payments are refunded.
  * **Choose the status when payment is pending**: Sets up the order status when payments are pending.
  * **Choose the status when client open a mediation**: Sets up the order status when client opens a mediation.
  * **Choose the status when payment was reject**: Sets up the order status when payments are rejected.
  * **Choose the status when payment was canceled**: Sets up the order status when payments are canceled.
  * **Choose the status when payment was chargeback**: Sets up the order status when payments are chargeback.
  * **Logs**: Enables/disables system logs.
  * **Debug Mode**: If enabled, displays the raw response from the API instead of a friendly message.
  *  **Enabled**: Enables/disables this payment solution.
  * **Type Checkout (you're using Standard Checkout)**: Sets the type of checkout, the options are:
    *  *Iframe*: Opens an OpenCart URL with a iframe as the content.
    *  *Redirect*: Redirects to Mercado Pago URL.
    *  *Lightbox*: Similar to Iframe option but opens a lightbox instead of an iframe. 

<a name="upgrade"></a>
## Upgrade MercadoPago Plugin ##

Follow the same steps that you did to install the module. 

<a name="Feedback"></a>
## Feedback ##

We want to know your opinion, please answer the following form.

* [Portuguese](http://goo.gl/forms/2n5jWHaQbfEtdy0E2)
* [Spanish](http://goo.gl/forms/A9bm8WuqTIZ89MI22)