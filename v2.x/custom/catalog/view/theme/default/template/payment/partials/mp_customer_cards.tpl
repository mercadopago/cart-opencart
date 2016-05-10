<div class="row cartao" id="div_customers_cards" style="display:none; margin-left: 22%;">
		<div class="col-md-12">
		<fieldset class="form-group col-sm-6">
			<label class="control-label" id="ccnum_label" for="ccnum"><?php echo($ccnum_placeholder); ?></label>
			<select class="form-control" type="text" id="cc_num_cc">
				<?php foreach($cards as $card): ?>
					<option value="<?php echo($card['id']); ?>">****<?php echo($card['last_four_digits']);?></option>
				<?php endforeach;?>
			</select>
		</fieldset>
		<fieldset class="form-group col-sm-6">
				<label class="control-label"> <?php echo $installments_placeholder;?></label>
				<select class="form-control">
					<option> Selecione</option>
				</select>
		</fieldset>
		</div>
	<div class="col-md-12">
		<fieldset class="form-group col-sm-6">
			<label class="control-label" id="ccnum_label" for="cvv_cc">CVV</label>
			<input type="text" class="form-control" id="cvv_cc" />
		</fieldset>
		<fieldset class="form-group col-sm-6" style="margin-top: 4.5%;">
			<button type="button" class="btn btn-primary"><?php echo($payment_button); ?></button>
		</fieldset>
	</div>
</div>
<div class="clearfix"></div>