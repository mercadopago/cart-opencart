<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
       <tr><td></td><td><?php echo $entry_ipn;?></td></tr>  
          <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="mercadopago2_status">
              <?php if ($mercadopago2_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_client_id; ?></td>
          <td><input type="text" name="mercadopago2_client_id" value="<?php echo $mercadopago2_client_id; ?>" />
            <?php if (isset($error_client_id)) { ?>
            <span class="error"><?php echo $error_client_id; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_client_secret; ?></td>
          <td><input type="text" name="mercadopago2_client_secret" value="<?php echo $mercadopago2_client_secret; ?>" />
            <?php if (isset($error_client_secret)) { ?>
            <span class="error"><?php echo $error_client_secret; ?></span>
            <?php } ?></td>
        </tr>
        
          <tr>
          <td><span class="required">*</span> <?php echo $entry_url; ?></td>
          <td><input type="text" name="mercadopago2_url" value="<?php echo $mercadopago2_url; ?>" />
            <?php if (isset($error_mercadopago2_url)) { ?>
            <span class="error"><?php echo $error_mercadopago2_url; ?></span>
            <?php } ?></td>
        </tr>
        
        
          <tr>
          <td><span class="required">*</span> <?php echo $entry_debug; ?></td>
          <td><select name="mercadopago2_debug">
              <?php if ($mercadopago2_debug) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        
        
        
        <tr>
          <td><?php echo $entry_order_status; ?></td>
          <td><select name="mercadopago2_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        
       
        
        <tr>
          <td><?php echo $entry_country; ?></td>
          <td><select name="mercadopago2_country" id="country">
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['id'] == $mercadopago2_country) { ?>
              <option value="<?php echo $country['id']; ?>" selected="selected" id="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['id']; ?>" id="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_installments; ?></td>
          <td><select name="mercadopago2_installments" id="country">
              <?php foreach ($installments as $installment) { ?>
              <?php if ($installment['id'] == $mercadopago2_installments) { ?>
              <option value="<?php echo $installment['id']; ?>" selected="selected" id="<?php echo $installment['id']; ?>"><?php echo $installment['value']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $installment['id']; ?>" id="<?php echo $installment['id']; ?>"><?php echo $installment['value']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <?php if(isset($methods)){?>
          <tr>
          <td><?php echo $entry_payments_not_accept; ?></td>
          <td>
          
          <table>         
          <?php foreach ($methods as $method) : ?>
          <?php if($method['id'] != 'account_money'){ ?>
          <?php if($mercadopago2_methods != null && in_array($method['id'], $mercadopago2_methods)){ ?>
          <tr><td><label><?php echo $method['name'];?></td><td><input name="mercadopago2_methods[]" type="checkbox" checked="yes" value="<?php echo $method['id'];?>"></label></td></tr>    
          <?php } else { ?>
          <tr><td><label><?php echo $method['name'];?></td><td><input name="mercadopago2_methods[]" type="checkbox" value="<?php echo $method['id'];?>"></label></td></tr>       
          <?php }} endforeach; ?>
          </table>
          
          </td>
          </tr>
        <?php ;} ?>
       <tr> 
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="mercadopago2_sort_order" value="<?php echo $mercadopago2_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
        <td><?php echo $entry_order_status_completed; ?></td>
                  <td><select name="mercadopago2_order_status_id_completed">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_completed) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                </tr>
                
                <tr>
                  <td><?php echo $entry_order_status_pending; ?></td>
                  <td><select name="mercadopago2_order_status_id_pending">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_pending) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                </tr>
                 <tr>
                  <td><?php echo $entry_order_status_canceled; ?></td>
                  <td><select name="mercadopago2_order_status_id_canceled">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_canceled) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                </tr>
                 <tr>
                  <td><?php echo $entry_order_status_in_process; ?></td>
                  <td><select name="mercadopago2_order_status_id_in_process">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_in_process) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                </tr>
                 <tr>
                  <td><?php echo $entry_order_status_rejected; ?></td>
                  <td><select name="mercadopago2_order_status_id_rejected">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_rejected) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                </tr>
                 <tr>
                  <td><?php echo $entry_order_status_refunded; ?></td>
                  <td><select name="mercadopago2_order_status_id_refunded">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_refunded) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                </tr>
                 <tr>
                  <td><?php echo $entry_order_status_in_mediation; ?></td>
                  <td><select name="mercadopago2_order_status_id_in_mediation">
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_in_mediation) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select></td>
                </tr>
                
                 
               
               
           
      </table>
    </form>
  </div>
</div>
<br /><br /><br /><br /><br /><br /><br />

<?php echo $footer; ?>