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
            <select name="mp_transparente_status" id="input-status" class="form-control">
              <?php if ($mp_transparente_status) : ?>
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
          <label class="col-sm-2 control-label" for="mp_transparente_order_status_id"><?php echo $entry_country; ?></label>
          <div class="col-sm-10">
            <input type="hidden" value="<?php if(isset($mp_transparente_country)){echo $mp_transparente_country;} ;?>" id="countryName" />
            <select class="form-control" name="mp_transparente_country" id="country">
             <option id="MLA" value="MLA">Argentina</option>
             <option id="MLB" value="MLB">Brasil</option>
             <option id="MLC" value="MLC">Chile</option>
             <option id="MCO" value="MCO">Colombia</option>
             <option id="MLM" value="MLM">Mexico</option>
             <option id="MPE" value="MPE">Peru</option>
             <option id="MLV" value="MLV">Venezuela</option>
           </select>
         </div>
       </div>
       <div class="form-group required" id="div_public_key">
         <label class="col-sm-2 control-label" for="mp_transparente_public_key">
          <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_public_key_tooltip; ?> '><?php echo $entry_public_key; ?></span></label>
          <div class="col-sm-10">
           <input type="text" class="form-control" id="mp_transparente_public_key" name="mp_transparente_public_key" value="<?php echo $mp_transparente_public_key; ?>" />
           <?php if (isset($error_public_key)) : ?>
             <div class="text-danger"><?php echo $error_public_key; ?></div>
           <?php endif; ?>
         </div>
       </div>
       <div class="form-group required" id="div_access_token">
         <label class="col-sm-2 control-label" for="mp_transparente_access_token">
          <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_access_token_tooltip; ?> '><?php echo $entry_access_token; ?></span></label>
          <div class="col-sm-10">
           <input type="text" class="form-control" id="mp_transparente_access_token" name="mp_transparente_access_token" value="<?php echo $mp_transparente_access_token; ?>" />
           <?php if (isset($error_access_token)) : ?>
             <div class="text-danger"><?php echo $error_access_token; ?></div>
           <?php endif; ?>
         </div>
       </div>

       <div class="form-group required">
        <label class="col-sm-2 control-label" for="mp_transparente_category_id"> <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_category_tooltip; ?>'>
          <?php echo $entry_category; ?></label>
          <div class="col-sm-10">
            <select class="form-control" name="mp_transparente_category_id" id="mp_transparente_category_id">
              <?php foreach ($category_list as $category) : ?>
                <?php if ($category['id'] == $mp_transparente_category_id) : ?>
                  <option value="<?php echo $category['id']; ?>" selected="selected" id="<?php echo $category['description']; ?>"><?php echo $category['description']; ?></option>
                <?php  else : ?>
                  <option value="<?php echo $category['id']; ?>" id="<?php echo $category['description']; ?>"><?php echo $category['description']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="mp_transparente_debug"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_debug_tooltip; ?> '> <?php echo $entry_debug; ?></span></label>
          <div class="col-sm-10">
            <select class="form-control" name="mp_transparente_debug" id="mp_transparente_debug">
              <?php if ($mp_transparente_debug) : ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
              <?php else : ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php endif; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label" for="mp_transparente_coupon"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_coupon_tooltip; ?>'>
            <?php echo $entry_coupon; ?></span></label>
            <div class="col-sm-10">
              <select class="form-control" name="mp_transparente_coupon" id="mp_transparente_coupon">
                <?php if ($mp_transparente_coupon) : ?>
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
            <label class="col-sm-2 control-label" for="mp_transparente_installments"><?php echo $entry_installments; ?></label>
            <div class="col-sm-10">
             <select class="form-control" name="mp_transparente_installments" id="mp_transparente_installments">
              <?php foreach ($installments as $installment) : ?>
                <?php if ($installment['id'] == $mp_transparente_installments) : ?>
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
            <label class="col-sm-2 control-label" for="mp_transparente_methods">
              <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_payments_not_accept_tooltip; ?> '>
                <?php echo $entry_payments_not_accept; ?>
              </span>
            </label>
            <div class="col-sm-10" id="div_payments">
              <div class="form-group">
                <?php foreach ($methods as $method) : ?>
                  <div style="<?php echo $payment_style; ?>" id="<?php echo $method['name'];?>">
                    <?php if($method['id'] != 'account_money') : ?>
                      <?php if($methods != null && in_array($method['id'], $mp_transparente_methods)) : ?>
                        <img src="<?php echo $method['secure_thumbnail'];?>"><br /><input name="mp_transparente_methods[]" type="checkbox" checked="yes" value="<?php echo $method['id'];?>" style="margin-left:25%;">
                      </div>
                    <?php   else : ?>
                      <img src="<?php echo $method['secure_thumbnail'];?>"><br/><input name="mp_transparente_methods[]" type="checkbox" value="<?php echo $method['id'];?>" style="margin-left:25%;">
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="mp_transparente_order_status_id_completed"><?php echo $entry_order_status_general; ?></label>
      </div>
      <div class="form-group required">
        <label class="col-sm-2 control-label" for="mp_transparente_order_status_id"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_tooltip; ?> '><?php echo $entry_order_status; ?> </span></label>
        <div class="col-sm-10">
         <select class="form-control" name="mp_transparente_order_status_id" id="mp_transparente_order_status_id">
          <?php foreach ($order_statuses as $order_status) : ?>
            <?php if ($order_status['order_status_id'] == $mp_transparente_order_status_id) : ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php else : ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="mp_transparente_order_status_id_completed"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_completed_tooltip; ?> '><?php echo $entry_order_status_completed; ?></span></label>
      <div class="col-sm-10">
        <select class="form-control" name="mp_transparente_order_status_id_completed" id="mp_transparente_order_status_id_completed">
         <?php foreach ($order_statuses as $order_status) : ?>
          <?php if ($order_status['order_status_id'] == $mp_transparente_order_status_id_completed) : ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
          <?php else : ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="mp_transparente_order_status_id_pending"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_pending_tooltip; ?> '><?php echo $entry_order_status_pending; ?></span></label>
    <div class="col-sm-10">
      <select class="form-control" name="mp_transparente_order_status_id_pending" id="mp_transparente_order_status_id_pending">
       <?php foreach ($order_statuses as $order_status) : ?>
        <?php if ($order_status['order_status_id'] == $mp_transparente_order_status_id_pending) : ?>
          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
        <?php else : ?>
          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
        <?php endif; ?>
      <?php endforeach; ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label" for="mp_transparente_order_status_id_canceled">
    <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_canceled_tooltip; ?> '><?php echo $entry_order_status_canceled; ?></span></label>
    <div class="col-sm-10">
      <select class="form-control" name="mp_transparente_order_status_id_canceled" id="mp_transparente_order_status_id_canceled">
       <?php foreach ($order_statuses as $order_status) : ?>
        <?php if ($order_status['order_status_id'] == $mp_transparente_order_status_id_canceled) : ?>
          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
        <?php else : ?>
          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
        <?php endif; ?>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label" for="mp_transparente_order_status_id_in_process">
    <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_in_process_tooltip; ?> '><?php echo $entry_order_status_in_process; ?></span></label>
    <div class="col-sm-10">
      <select class="form-control" name="mp_transparente_order_status_id_in_process" id="mp_transparente_order_status_id_in_process">
       <?php foreach ($order_statuses as $order_status) : ?>
        <?php if ($order_status['order_status_id'] == $mp_transparente_order_status_id_in_process) : ?>
          <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
        <?php else : ?>
          <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
        <?php endif; ?>
      <?php endforeach; ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label" for="mp_transparente_order_status_id_rejected"><span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_rejected_tooltip; ?> '><?php echo $entry_order_status_rejected; ?></span></label>
  <div class="col-sm-10">
    <select class="form-control" name="mp_transparente_order_status_id_rejected" id="mp_transparente_order_status_id_rejected">
     <?php foreach ($order_statuses as $order_status) : ?>
      <?php if ($order_status['order_status_id'] == $mp_transparente_order_status_id_rejected) : ?>
        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
      <?php else : ?>
        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
      <?php endif; ?>
    <?php endforeach; ?>
  </select>
</div>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label" for="mp_transparente_order_status_id_refunded">
    <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_refunded_tooltip; ?> '><?php echo $entry_order_status_refunded; ?></span></label>
    <div class="col-sm-10">
      <select class="form-control" name="mp_transparente_order_status_id_refunded" id="mp_transparente_order_status_id_refunded">
        <?php foreach ($order_statuses as $order_status) : ?>
          <?php if ($order_status['order_status_id'] == $mp_transparente_order_status_id_refunded) : ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
          <?php  else : ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="mp_transparente_order_status_id_in_mediation">
      <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_in_mediation_tooltip; ?> '><?php echo $entry_order_status_in_mediation; ?></span></label>
      <div class="col-sm-10">
        <select class="form-control" name="mp_transparente_order_status_id_in_mediation" id="mp_transparente_order_status_id_in_mediation">
         <?php foreach ($order_statuses as $order_status) : ?>
          <?php if ($order_status['order_status_id'] == $mp_transparente_order_status_id_in_mediation) : ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
          <?php else : ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="mp_transparente_order_status_chargeback">
      <span data-toggle="tooltip" data-trigger="click" title='<?php echo $entry_order_status_chargeback_tooltip; ?>'>
        <?php echo $entry_order_status_chargeback; ?>
      </span>
    </label>
    <div class="col-sm-10">
      <select class="form-control" name="mp_transparente_order_status_chargeback" id="mp_transparente_order_status_chargeback">
        <?php foreach ($order_statuses as $order_status) : ?>
          <?php if (isset($mp_transparente_order_status_chargeback) && $order_status['order_status_id'] == $mp_transparente_order_status_chargeback) : ?>
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
<script type="text/javascript" src="./view/javascript/mp_transparente/mp_transparente.js"></script>
<script type="text/javascript" src="./view/javascript/mp_transparente/spinner.min.js"></script>
