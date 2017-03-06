 <div class="form-group">
    <?php foreach ($methods as $method) : ?>
          <div style="<?php echo $payment_style; ?>" id="<?php echo $method['name'];?>">
            <?php if($method['id'] != 'account_money') : ?>
                <?php if($mp_ticket_methods != null && in_array($method['id'], $mp_ticket_methods)) : ?>
              <img src="<?php echo $method['secure_thumbnail'];?>"><br /><input name="mp_ticket_methods[]" type="checkbox" checked="yes" value="<?php echo $method['id'];?>" style="margin-left:25%;">
            </div>
            <?php   else : ?>
                <img src="<?php echo $method['secure_thumbnail'];?>"><br/><input name="mp_ticket_methods[]" type="checkbox" value="<?php echo $method['id'];?>" style="margin-left:25%;">
              </div> 
        <?php endif; ?>
      <?php endif; ?>
      <?php endforeach; ?>