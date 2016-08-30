 <div class="grid col-md-12" id="divCustomersAndCards" style="margin-left:-2%;">
 	<div class="row">
 		<div class="col-sm-6">
 			<label class="control-label" id="ccnum_label" for="ccnum"><?php echo($ccnum_placeholder); ?></label>
 			<select class="form-control" type="text" id="cc_num_cc" data-checkout="cardId">
 				<?php foreach($cards as $card): ?>
 					<option value="<?php echo($card['id']); ?>"
 						first_six_digits="<?php echo($card['first_six_digits']);?>" security_code_length="<?php echo($card['security_code']['length']);?>"
 						style="background: url(<?php echo $card['payment_method']['secure_thumbnail']; ?>) 80% 50% no-repeat"> <?php echo $card['issuer']['name']; ?> - **** **** **** <?php echo($card['last_four_digits']);?></option>
 					<?php endforeach;?>
 					<option value="-1"><?php echo $other_card_option; ?></option>
 				</select>
 			</div>
 		</div>
 		<div id="cc_inputs">
 			<div class="row">
 				<div class="form-group col-sm-3">
 					<label id="cvv_label" class="control-label"	 for="cvv_cc">CVV</label>
 					<input class="form-control" type="text" id="cvv_cc" data-checkout="securityCode" size="4" maxlength="4" class="form-control"/>
 				</div>
 			</div>
 			<div class="row">
 				<div class="form-group col-sm-6">
 					<label id="installments_cc_label" class="control-label" for="installments_cc"><?php echo $installments_placeholder;?></label>
 					<select class="form-control" id="installments_cc"></select>
 				</div>
 			</div>
 			<div class="row">
 				<div class="form-group col-sm-6">
 					<button class="btn btn-primary pull-right" id="button_pay_cc"><?php echo($payment_button); ?></button>
 				</div>
 			</div>
 		</div>
 	</div>
 	<script type="text/javascript" src="./catalog/view/javascript/mp_transparente/mp_transparente_cc.js"></script>
