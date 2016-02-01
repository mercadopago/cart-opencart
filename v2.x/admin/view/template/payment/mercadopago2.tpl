<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <div class="pull-right">
      <a id="btn_save" class="btn btn-primary"><?php echo $button_save; ?><i class="fa fa-save"></i></a>
      <a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-default"><?php echo $button_cancel; ?><i class="fa fa-reply"></i></a>
    </div>
    <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) : ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<div class="container-fluid">
  <?php if ($error_warning) : ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-pencil"></i>Edit MercadoPago</h3>
    </div>
    <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form_mp" class="form-horizontal">
       <div class="form-group">
        <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
        <div class="col-sm-10">
          <select name="mercadopago2_status" id="input-status" class="form-control">
            <?php if ($mercadopago2_status) : ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php  else : ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="entry_type_checkout"><?php echo $entry_type_checkout; ?></label>
        <div class="col-sm-10">
         <select class="form-control" name="mercadopago2_type_checkout" id="mercadopago2_type_checkout">
          <?php foreach ($type_checkout as $type) : ?>
          <?php if ($type == $mercadopago2_type_checkout) : ?>
          <option value="<?php echo $type; ?>" selected="selected" id="<?php echo $type; ?>"><?php echo $type; ?></option>
          <?php  else : ?>
          <option value="<?php echo $type; ?>" id="<?php echo $type; ?>"><?php echo $type; ?></option>
          <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
      <div class="form-group required" id="div_client_id">
       <label class="col-sm-2 control-label" for="mercadopago2_client_id">
        <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_client_id_tooltip; ?> '><?php echo $entry_client_id; ?></span></label>
       <div class="col-sm-10">
         <input type="text" class="form-control" id="mercadopago2_client_id" name="mercadopago2_client_id" value="<?php echo $mercadopago2_client_id; ?>" />
         <?php if (isset($error_client_id)) : ?>
         <div class="text-danger"><?php echo $error_client_id; ?></div>
         <?php endif; ?>
       </div>

     </div>
     <div class="form-group required" id="div_client_secret">
      <label class="col-sm-2 control-label" for="mercadopago2_client_secret">
      <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_client_secret_tooltip; ?> '><?php echo $entry_client_secret; ?></span></label>
      <div class="col-sm-10">
        <input class="form-control" type="text" id="mercadopago2_client_secret" name="mercadopago2_client_secret" value="<?php echo $mercadopago2_client_secret; ?>" />
        <?php if (isset($error_client_secret)) : ?>
        <div class="text-danger"><?php echo $error_client_secret; ?></div>
        <?php endif; ?>
      </div>
    </div>
     <div class="form-group required" id="div_public_key">
       <label class="col-sm-2 control-label" for="mercadopago2_public_key">
        <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_public_key_tooltip; ?> '><?php echo $entry_public_key; ?></span></label>
       <div class="col-sm-10">
         <input type="text" class="form-control" id="mercadopago2_public_key" name="mercadopago2_public_key" value="<?php echo $mercadopago2_public_key; ?>" />
         <?php if (isset($error_public_key)) : ?>
         <div class="text-danger"><?php echo $error_public_key; ?></div>
         <?php endif; ?>
       </div>
      </div>     
      <div class="form-group required" id="div_access_token">
       <label class="col-sm-2 control-label" for="mercadopago2_access_token">
        <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_access_token_tooltip; ?> '><?php echo $entry_access_token; ?></span></label>
       <div class="col-sm-10">
         <input type="text" class="form-control" id="mercadopago2_access_token" name="mercadopago2_access_token" value="<?php echo $mercadopago2_access_token; ?>" />
         <?php if (isset($error_access_token)) : ?>
         <div class="text-danger"><?php echo $error_access_token; ?></div>
         <?php endif; ?>
       </div>
      </div>

    <div class="form-group required">
      <label class="col-sm-2 control-label" for="mercadopago2_category_id"> <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_category_tooltip; ?>'>
            <?php echo $entry_category; ?></label>
      <div class="col-sm-10">
        <select class="form-control" name="mercadopago2_category_id" id="mercadopago2_category_id">
          <?php foreach ($category_list as $category) : ?>
          <?php if ($category['id'] == $mercadopago2_category_id) : ?>
          <option value="<?php echo $category['id']; ?>" selected="selected" id="<?php echo $category['description']; ?>"><?php echo $category['description']; ?></option>
          <?php  else : ?>
          <option value="<?php echo $category['id']; ?>" id="<?php echo $category['description']; ?>"><?php echo $category['description']; ?></option>
          <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-group required">
     <label class="col-sm-2 control-label" for="mercadopago2_url">
      <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_url_tooltip; ?> '>
      <?php echo $entry_url; ?></span></label>
      <div class="col-sm-10" id="div_store_url">
        <input class="form-control" type="text" name="mercadopago2_url" value="<?php echo $mercadopago2_url; ?>" />
        <?php if (isset($error_mercadopago2_url)) : ?>
        <div class="text-danger" id="div_error_url">
            <?php echo $error_mercadopago2_url; ?></div>
          <?php endif; ?>
      </div>
    </div>
    <div class="form-group" id="div_notifications" style="visibility:hidden;">
      <label class="col-sm-2 control-label" for="notification_url">
      <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_notification_url_tooltip; ?>'><?php echo $entry_notification_url; ?></span></label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="notification_url" name="notification_url" disabled="disabled" />
      </div>
    </div>

    <div class="form-group required">
      <label class="col-sm-2 control-label" for="mercadopago2_debug"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_debug_tooltip; ?> '> <?php echo $entry_debug; ?></span></label>
      <div class="col-sm-10">
        <select class="form-control" name="mercadopago2_debug" id="mercadopago2_debug">
          <?php if ($mercadopago2_debug) : ?>
          <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
          <option value="0"><?php echo $text_disabled; ?></option>
          <?php else : ?>
          <option value="1"><?php echo $text_enabled; ?></option>
          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
          <?php endif; ?>
        </select>
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="mercadopago2_enable_return"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_autoreturn_tooltip; ?> '> <?php echo $entry_autoreturn; ?></span></label>
      <div class="col-sm-10">
        <select class="form-control" name="mercadopago2_enable_return" id="mercadopago2_enable_return">
          <?php if ($mercadopago2_enable_return) : ?>
          <option value="all" selected="selected"><?php echo $text_enabled; ?></option>
          <option value="approved"><?php echo $text_disabled; ?></option>
          <?php  else : ?>
          <option value="all"><?php echo $text_enabled; ?></option>
          <option value="approved" selected="selected"><?php echo $text_disabled; ?></option>
          <?php endif; ?>
        </select>
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="mercadopago2_sandbox"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_sandbox_tooltip; ?>'>
      <?php echo $entry_sandbox; ?></span></label>
      <div class="col-sm-10">
       <select class="form-control" name="mercadopago2_sandbox" id="mercadopago2_sandbox">
        <?php if ($mercadopago2_sandbox) : ?>
        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
        <option value="0"><?php echo $text_disabled; ?></option>
        <?php else : ?>
        <option value="1"><?php echo $text_enabled; ?></option>
        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
        <?php endif; ?>
      </select>
    </div>
  </div>  




<div class="form-group required">
  <label class="col-sm-2 control-label" for="mercadopago2_order_status_id"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_tooltip; ?> '><?php echo $entry_order_status; ?> </span></label>
  <div class="col-sm-10">
   <select class="form-control" name="mercadopago2_order_status_id" id="mercadopago2_order_status_id">
    <?php foreach ($order_statuses as $order_status) : ?>
    <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id) : ?>
    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
    <?php else : ?>
    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
    <?php endif; ?>
    <?php endforeach; ?>
  </select>
</div>
</div>

<div class="form-group required">
<label class="col-sm-2 control-label" for="mercadopago2_order_status_id"><?php echo $entry_country; ?></label>
<div class="col-sm-10">
 <select class="form-control" name="mercadopago2_country" id="country">
 <?php foreach ($countries as $country) : ?>
 <?php if ($country['id'] == $mercadopago2_country) : ?>
 <option value="<?php echo $country['id']; ?>" selected="selected" id="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
 <?php else : ?>
 <option value="<?php echo $country['id']; ?>" id="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
 <?php endif; ?>
 <?php endforeach; ?>
</select>
</div>
</div>

<div class="form-group required">
<label class="col-sm-2 control-label" for="mercadopago2_installments"><?php echo $entry_installments; ?></label>
<div class="col-sm-10">
 <select class="form-control" name="mercadopago2_installments" id="mercadopago2_installments">
<?php foreach ($installments as $installment) : ?>
            <?php if ($installment['id'] == $mercadopago2_installments) : ?>
            <option value="<?php echo $installment['id']; ?>" selected="selected" id="<?php echo $installment['id']; ?>"><?php echo $installment['value']; ?></option>
            <?php else : ?>
            <option value="<?php echo $installment['id']; ?>" id="<?php echo $installment['id']; ?>"><?php echo $installment['value']; ?></option>
            <?php endif; ?>
            <?php endforeach; ?>
</select>
</div>
</div>
<?php if(isset($methods) && count($methods) > 0) : ?>
<div class="form-group">
<label class="col-sm-2 control-label" for="mercadopago2_methods">
  <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_payments_not_accept_tooltip; ?> '>
    <?php echo $entry_payments_not_accept; ?>
  </span>
</label>
<div class="col-sm-10" id="div_payments">
  <div class="form-group">
    <?php foreach ($methods as $method) : ?>
          <div style="<?php echo $payment_style; ?>" id="<?php echo $method['name'];?>">
            <?php if($method['id'] != 'account_money') : ?>
                <?php if($methods != null && in_array($method['id'], $mercadopago2_methods)) : ?>
              <img src="<?php echo $method['secure_thumbnail'];?>"><br /><input name="mercadopago2_methods[]" type="checkbox" checked="yes" value="<?php echo $method['id'];?>" style="margin-left:25%;">
            </div>
            <?php   else : ?>
                <img src="<?php echo $method['secure_thumbnail'];?>"><br/><input name="mercadopago2_methods[]" type="checkbox" value="<?php echo $method['id'];?>" style="margin-left:25%;">
              </div> 
        <?php endif; ?>
      <?php endif; ?>
      <?php endforeach; ?>
        <div class="text-danger" id="div_error_methods"></div>
  </div>
</div>
</div>
<?php endif; ?>
<div class="form-group"></div>
<div class="form-group">
<label class="col-sm-3 control-label" for="mercadopago2_order_status_id_completed"><?php echo $entry_order_status_general; ?></label></div>
<div class="form-group">
<label class="col-sm-2 control-label" for="mercadopago2_order_status_id_completed"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_completed_tooltip; ?> '><?php echo $entry_order_status_completed; ?></span></label>
<div class="col-sm-10">
  <select class="form-control" name="mercadopago2_order_status_id_completed" id="mercadopago2_order_status_id_completed">
     <?php foreach ($order_statuses as $order_status) : ?>
                    <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_completed) : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php else : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
  </select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="mercadopago2_order_status_id_pending"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_pending_tooltip; ?> '><?php echo $entry_order_status_pending; ?></span></label>
<div class="col-sm-10">
  <select class="form-control" name="mercadopago2_order_status_id_pending" id="mercadopago2_order_status_id_pending">
     <?php foreach ($order_statuses as $order_status) : ?>
                    <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_pending) : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php else : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
  </select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="mercadopago2_order_status_id_canceled">
<span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_canceled_tooltip; ?> '><?php echo $entry_order_status_canceled; ?></span></label>
<div class="col-sm-10">
  <select class="form-control" name="mercadopago2_order_status_id_canceled" id="mercadopago2_order_status_id_canceled">
   <?php foreach ($order_statuses as $order_status) : ?>
                    <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_canceled) : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php else : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
  </select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label" for="mercadopago2_order_status_id_in_process">
<span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_in_process_tooltip; ?> '><?php echo $entry_order_status_in_process; ?></span></label>
<div class="col-sm-10">
  <select class="form-control" name="mercadopago2_order_status_id_in_process" id="mercadopago2_order_status_id_in_process">
   <?php foreach ($order_statuses as $order_status) : ?>
                    <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_in_process) : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php else : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
  </select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="mercadopago2_order_status_id_rejected"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_rejected_tooltip; ?> '><?php echo $entry_order_status_rejected; ?></span></label>
<div class="col-sm-10">
  <select class="form-control" name="mercadopago2_order_status_id_rejected" id="mercadopago2_order_status_id_rejected">
   <?php foreach ($order_statuses as $order_status) : ?>
                    <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_rejected) : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php else : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
  </select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="mercadopago2_order_status_id_refunded">
<span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_refunded_tooltip; ?> '><?php echo $entry_order_status_refunded; ?></span></label>
<div class="col-sm-10">
  <select class="form-control" name="mercadopago2_order_status_id_refunded" id="mercadopago2_order_status_id_refunded">
    <?php foreach ($order_statuses as $order_status) : ?>
                    <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_refunded) : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php  else : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
  </select>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="mercadopago2_order_status_id_in_mediation">
<span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_in_mediation_tooltip; ?> '><?php echo $entry_order_status_in_mediation; ?></span></label>
<div class="col-sm-10">
  <select class="form-control" name="mercadopago2_order_status_id_in_mediation" id="mercadopago2_order_status_id_in_mediation">
   <?php foreach ($order_statuses as $order_status) : ?>
                    <?php if ($order_status['order_status_id'] == $mercadopago2_order_status_id_in_mediation) : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php else : ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
  </select>
</div>
</div>
</form>
</div>
</div>
</div>
<script type="text/javascript" src="./view/javascript/mercadopago2/mercadopago2.js"></script>
<script type="text/javascript" src="./view/javascript/mercadopago2/spinner.min.js"></script>