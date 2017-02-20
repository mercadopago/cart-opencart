<link rel="stylesheet" type="text/css" href="./catalog/view/css/custom_checkout_mercadopago.css">
<div id="mp_custom"></div>
<input type="hidden" id="public_key" value="<?php echo $public_key;?>">
<input type="hidden" id="customer_email" value="<?php echo $customer_email;?>">
<input type="hidden" id="country" value="<?php echo $action;?>">
<input type="hidden" id="paymentType"/>
<div class="form-group" style="margin-left: 10%;">
  <div class="form-group">
    <div class="banner">
      <!-- <img src="./image/banners/<?php echo $action;?>/credit_card.png" /> -->
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div id="mp-box-form">
  <?php
  $form_labels = array(
  "form" => array(
  "coupon_empty" => "Please, inform your coupon code",
  'apply' => "Apply",
  'remove' => "Remove",
  'discount_info1' => "You will save",
  'discount_info2' => "with discount from",
  'discount_info3' => "Total of your purchase:",
  'discount_info4' => "Total of your purchase with discount:",
  'discount_info5' => "*Uppon payment approval",
  'discount_info6' => "Terms and Conditions of Use",
  'coupon_of_discounts' => "Discount Coupon",
  'label_other_bank' => "Other Bank",
  'label_choose' => "Choose",
  "payment_method" => "Payment Method",
  "credit_card_number" => "Credit card number",
  "expiration_month" => "Expiration month",
  "expiration_year" => "Expiration year",
  "year" => "Year",
  "month" => "Month",
  "card_holder_name" => "Card holder name",
  "security_code" => "Security code",
  "document_type" => "Document Type",
  "document_number" => "Document number",
  "issuer" => "Issuer",
  "installments" => "Installments",
  "your_card" => "Your Card",
  "other_cards" => "Other Cards",
  "other_card" => "Other Card",
  "ended_in" => "ended in"
  ),
  "error" => array(

  //card number
  "205" => "Parameter cardNumber can not be null/empty",
  "E301" => "Invalid Card Number",
  //expiration date
  "208" => "Invalid Expiration Date",
  "209" => "Invalid Expiration Date",
  "325" => "Invalid Expiration Date",
  "326" => "Invalid Expiration Date",
  //card holder name
  "221" => "Parameter cardholderName can not be null/empty",
  "316" => "Invalid Card Holder Name",

  //security code
  "224" => "Parameter securityCode can not be null/empty",
  "E302" => "Invalid Security Code",
  "E203" => "Invalid Security Code",

  //doc type
  "212" => "Parameter docType can not be null/empty",
  "322" => "Invalid Document Type",
  //doc number
  "214" => "Parameter docNumber can not be null/empty",
  "324" => "Invalid Document Number",
  //doc sub type
  "213" => "The parameter cardholder.document.subtype can not be null or empty",
  "323" => "Invalid Document Sub Type",
  //issuer
  "220" => "Parameter cardIssuerId can not be null/empty",
  ),
  "coupon_error" => array(
  "EMPTY" => "Please, inform your coupon code"
  )
  );
  ?>

  <!-- <div id="mercadopago-form" > -->
  <form method="post" id="mercadopago-formulario" name="mercadopago-formulario" action="<?php echo $actionForm; ?>">

    <div class="mp-box-inputs mp-line" id="mercadopago-form-coupon">
      <label for="couponCodeLabel"><?php echo $form_labels['form']['coupon_of_discounts']; ?></label>
      <div class="mp-box-inputs mp-col-65">
        <input type="text" id="couponCode" name="mercadopago_custom[coupon_code]" autocomplete="off" maxlength="24" />
      </div>

      <div class="mp-box-inputs mp-col-10">
        <div id="mp-separete-date"></div>
      </div>

      <div class="mp-box-inputs mp-col-25">
        <input type="button" class="button" id="applyCoupon" value="<?php echo $form_labels['form']['apply']; ?>" >
      </div>

      <div class="mp-box-inputs mp-col-100">
        <span class="mp-discount" id="mpCouponApplyed" ></span>
        <span class="mp-error" id="mpCouponError" ></span>
      </div>
    </div>

    <div id="mercadopago-form-customer-and-card">

      <div class="mp-box-inputs mp-line">
        <label for="paymentMethodIdSelector"><?php echo $form_labels['form']['payment_method']; ?> <em>*</em></label>

        <select id="paymentMethodSelector" name="mercadopago_custom[paymentMethodSelector]" data-checkout='cardId'>
          <optgroup label="<?php echo $form_labels['form']['your_card']; ?>" id="payment-methods-for-customer-and-cards">
            <?php foreach ($cards as $card) { ?>
            <option value="<?php echo $card['id']; ?>"
              first_six_digits="<?php echo $card['first_six_digits']; ?>"
              last_four_digits="<?php echo $card['last_four_digits']; ?>"
              security_code_length="<?php echo $card['security_code']['length']; ?>"
              type_checkout="customer_and_card"
              payment_method_id="<?php echo $card['payment_method']['id']; ?>"
              >
              <?php echo ucfirst($card["payment_method"]["name"]); ?> <?php echo $form_labels['form']['ended_in']; ?> <?php echo $card["last_four_digits"]; ?>
            </option>
            <?php } ?>
          </optgroup>

          <optgroup label="<?php echo $form_labels['form']['other_cards']; ?>" id="payment-methods-list-other-cards">
            <option value="-1"><?php echo $form_labels['form']['other_card']; ?></option>
          </optgroup>

        </select>
      </div>

      <div class="mp-box-inputs mp-line" id="mp-securityCode-customer-and-card">
        <div class="mp-box-inputs mp-col-45">
          <label for="customer-and-card-securityCode"><?php echo $form_labels['form']['security_code']; ?> <em>*</em></label>
          <input type="text" id="customer-and-card-securityCode" data-checkout="securityCode" autocomplete="off" maxlength="4"/>

          <span class="mp-error" id="mp-error-224" data-main="#customer-and-card-securityCode"> <?php echo $form_labels['error']['224']; ?> </span>
          <span class="mp-error" id="mp-error-E302" data-main="#customer-and-card-securityCode"> <?php echo $form_labels['error']['E302']; ?> </span>
          <span class="mp-error" id="mp-error-E203" data-main="#customer-and-card-securityCode"> <?php echo $form_labels['error']['E203']; ?> </span>
        </div>
      </div>

    </div> <!--  end mercadopago-form-osc -->

    <div id="mercadopago-form">
      <div class="mp-box-inputs mp-col-100">
        <label for="cardNumber"><?php echo $form_labels['form']['credit_card_number']; ?> <em>*</em></label>
        <input type="text" id="cardNumber" data-checkout="cardNumber" autocomplete="off"/>
        <span class="mp-error" id="mp-error-205" data-main="#cardNumber"> <?php echo $form_labels['error']['205']; ?> </span>
        <span class="mp-error" id="mp-error-E301" data-main="#cardNumber"> <?php echo $form_labels['error']['E301']; ?> </span>
      </div>

      <div class="mp-box-inputs mp-line">
        <div class="mp-box-inputs mp-col-45">
          <label for="cardExpirationMonth"><?php echo $form_labels['form']['expiration_month']; ?> <em>*</em></label>
          <select id="cardExpirationMonth" data-checkout="cardExpirationMonth" name="mercadopago_custom[cardExpirationMonth]">
            <option value="-1"> <?php echo $form_labels['form']['month']; ?> </option>
            <?php for ($x=1; $x<=12; $x++): ?>
              <option value="<?php echo $x; ?>"> <?php echo $x; ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="mp-box-inputs mp-col-10">
          <div id="mp-separete-date">
            /
          </div>
        </div>

        <div class="mp-box-inputs mp-col-45">
          <label for="cardExpirationYear"><?php echo $form_labels['form']['expiration_year']; ?> <em>*</em></label>
          <select  id="cardExpirationYear" data-checkout="cardExpirationYear" name="mercadopago_custom[cardExpirationYear]">
            <option value="-1"> <?php echo $form_labels['form']['year']; ?> </option>
            <?php for ($x=date("Y"); $x<= date("Y") + 10; $x++): ?>
              <option value="<?php echo $x; ?>"> <?php echo $x; ?> </option>
            <?php endfor; ?>
          </select>
        </div>

        <span class="mp-error" id="mp-error-208" data-main="#cardExpirationMonth"> <?php echo $form_labels['error']['208']; ?> </span>
        <span class="mp-error" id="mp-error-209" data-main="#cardExpirationYear"> </span>
        <span class="mp-error" id="mp-error-325" data-main="#cardExpirationMonth"> <?php echo $form_labels['error']['325']; ?> </span>
        <span class="mp-error" id="mp-error-326" data-main="#cardExpirationYear"> </span>

      </div>

      <div class="mp-box-inputs mp-col-100">
        <label for="cardholderName"><?php echo $form_labels['form']['card_holder_name']; ?> <em>*</em></label>
        <input type="text" id="cardholderName" name="mercadopago_custom[cardholderName]" data-checkout="cardholderName" autocomplete="off"/>

        <span class="mp-error" id="mp-error-221" data-main="#cardholderName"> <?php echo $form_labels['error']['221']; ?> </span>
        <span class="mp-error" id="mp-error-316" data-main="#cardholderName"> <?php echo $form_labels['error']['316']; ?> </span>
      </div>

      <div class="mp-box-inputs mp-line">
        <div class="mp-box-inputs mp-col-45">
          <label for="securityCode"><?php echo $form_labels['form']['security_code']; ?> <em>*</em></label>
          <input type="text" id="securityCode" data-checkout="securityCode" autocomplete="off" maxlength="4"/>

          <span class="mp-error" id="mp-error-224" data-main="#securityCode"> <?php echo $form_labels['error']['224']; ?> </span>
          <span class="mp-error" id="mp-error-E302" data-main="#securityCode"> <?php echo $form_labels['error']['E302']; ?> </span>
        </div>
      </div>

      <div class="mp-box-inputs mp-col-100 mp-doc">
        <div class="mp-box-inputs mp-col-35 mp-docType">
          <label for="docType"><?php echo $form_labels['form']['document_type']; ?> <em>*</em></label>
          <select id="docType" data-checkout="docType" name="mercadopago_custom[docType]"></select>

          <span class="mp-error" id="mp-error-212" data-main="#docType"> <?php echo $form_labels['error']['212']; ?> </span>
          <span class="mp-error" id="mp-error-322" data-main="#docType"> <?php echo $form_labels['error']['322']; ?> </span>
        </div>

        <div class="mp-box-inputs mp-col-65 mp-docNumber">
          <label for="docNumber"><?php echo $form_labels['form']['document_number']; ?> <em>*</em></label>
          <input type="text" id="docNumber" data-checkout="docNumber" name="mercadopago_custom[docNumber]" autocomplete="off"/>

          <span class="mp-error" id="mp-error-214" data-main="#docNumber"> <?php echo $form_labels['error']['214']; ?> </span>
          <span class="mp-error" id="mp-error-324" data-main="#docNumber"> <?php echo $form_labels['error']['324']; ?> </span>
        </div>
      </div>

      <div class="mp-box-inputs mp-col-100 mp-issuer">
        <label for="issuer"><?php echo $form_labels['form']['issuer']; ?> <em>*</em></label>
        <select id="issuer" data-checkout="issuer" name="mercadopago_custom[issuer]"></select>

        <span class="mp-error" id="mp-error-220" data-main="#issuer"> <?php echo $form_labels['error']['220']; ?> </span>
      </div>

    </div>  <!-- end #mercadopago-form -->
    <div class="mp-box-inputs mp-col-100">
      <label for="installments"><?php echo $form_labels['form']['installments']; ?> <em>*</em></label>
      <select id="installments" data-checkout="installments" name="mercadopago_custom[installments]"></select>
    </div>
    <div class="mp-box-inputs mp-line">
      <div class="mp-box-inputs mp-col-50">
        <input type="submit" id="btnSubmit" name="btnSubmit" value="Pay">
      </div>
      <!-- NOT DELETE LOADING-->
      <div class="mp-box-inputs mp-col-25">
        <div id="mp-box-loading">
        </div>
      </div>
    </div>
    <div class="mp-box-inputs mp-col-100" id="mercadopago-utilities">
      <input type="text" id="site_id"  name="mercadopago_custom[site_id]"/>
      <input type="text" id="amount" value="<?php echo round($amount,2);?>" name="mercadopago_custom[amount]"/>
      <input type="hidden" id="campaign_id" name="mercadopago_custom[campaign_id]"/>
      <input type="hidden" id="campaign" name="mercadopago_custom[campaign]"/>
      <input type="hidden" id="discount" name="mercadopago_custom[discount]"/>
      <input type="text" id="paymentMethodId" name="mercadopago_custom[paymentMethodId]"/>
      <input type="text" id="token" name="mercadopago_custom[token]"/>
      <input type="text" id="cardTruncated" name="mercadopago_custom[cardTruncated]"/>
      <input type="text" id="CustomerAndCard" name="mercadopago_custom[CustomerAndCard]"/>
    </div>
  </form>
</div>
<script type="text/javascript" src="./catalog/view/javascript/mp_transparente/MPv1.js" defer></script>


<script>

  function async(u, c) {
    var d = document;
    var t = 'script';
    var o = d.createElement(t);
    var s = d.getElementsByTagName(t)[0];

    o.src = u;
    if (c) { o.addEventListener('load', function (e) { c(null, e); }, false); }
    s.parentNode.insertBefore(o, s);
  }

  async('https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js', function() {

    var mercadopago_site_id = 'MLB';
    var mercadopago_public_key = '<?php echo $public_key;?>';
    var mercadopago_payer_email = '<?php echo $customer_email;?>';
    MPv1.create_token_on.event = false;

    MPv1.text.choose = '<?php echo $form_labels["form"]["label_choose"]; ?>';
    MPv1.text.other_bank = '<?php echo $form_labels["form"]["label_other_bank"]; ?>';
    MPv1.text.discount_info1 = '<?php echo $form_labels["form"]["discount_info1"]; ?>';
    MPv1.text.discount_info2 = '<?php echo $form_labels["form"]["discount_info2"]; ?>';
    MPv1.text.discount_info3 = '<?php echo $form_labels["form"]["discount_info3"]; ?>';
    MPv1.text.discount_info4 = '<?php echo $form_labels["form"]["discount_info4"]; ?>';
    MPv1.text.discount_info5 = '<?php echo $form_labels["form"]["discount_info5"]; ?>';
    MPv1.text.discount_info6 = '<?php echo $form_labels["form"]["discount_info6"]; ?>';
    MPv1.text.apply = '<?php echo $form_labels["form"]["apply"]; ?>';
    MPv1.text.remove = '<?php echo $form_labels["form"]["remove"]; ?>';
    MPv1.text.coupon_empty = '<?php echo $form_labels["form"]["coupon_empty"]; ?>';

    MPv1.paths.check = "./image/mercadopago/check.png";
    MPv1.paths.error = "./image/mercadopago/error.png";
    MPv1.paths.loading = "./image/mercadopago/loading.gif";

    var mercadopago_coupon = $("#mercadopago_coupon");
    var url_site = window.location.href.split('index.php')[0];
    var url_message = url_site.slice(-1) == '/' ? url_site : url_site + '/';
    url_message += 'index.php?route=extension/payment/mp_transparente/coupon';

    MPv1.Initialize(mercadopago_site_id, mercadopago_public_key, '<?php echo $mp_transparente_coupon == 0? false:true;?>', url_message, mercadopago_payer_email);

  });

</script>

<script type="text/javascript">

    $.getScript("https://secure.mlstatic.com/modules/javascript/analytics.js", function(){

        ModuleAnalytics.setToken("<?php echo $analytics['token'] ?>");
        ModuleAnalytics.setPlatform("<?php echo $analytics['platform'] ?>");
        ModuleAnalytics.setPlatformVersion("<?php echo $analytics['platformVersion'] ?>");
        ModuleAnalytics.setModuleVersion("<?php echo $analytics['moduleVersion'] ?>");
        ModuleAnalytics.setPayerEmail("<?php echo $analytics['payerEmail'] ?>");
        ModuleAnalytics.setUserLogged(parseInt("<?php echo $analytics['userLogged'] ?>"));
        ModuleAnalytics.setInstalledModules("<?php echo $analytics['installedModules'] ?>");
        ModuleAnalytics.setAdditionalInfo("<?php echo $analytics['additionalInfo'] ?>");
        ModuleAnalytics.post();

     });
</script>
