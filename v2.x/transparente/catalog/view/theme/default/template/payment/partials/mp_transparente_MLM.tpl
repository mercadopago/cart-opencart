    <div class="row">
    	<?php if(isset($installments_placeholder)): ?>
    		<div id="divInstallments" class="col-xs-10 col-md-5">
    			<label class="control-label" id="installments_label" for="installments"><?php echo $installments_placeholder;?></label>
    			<select id="installments" class="form-control" style="width: 70%;"></select>
    		</div>
    	<?php endif; ?>
    	<div class="col-sm-4" id="divIssuer">
    		<label class="control-label" id="issuer_label" for="issuer">Issuer</label>
    		<select id="issuer" class="form-control"></select>
    	</div>
    	<?php if(isset($cardType_placeholder)): ?>
    		<div class="col-sm-3" id="divPaymentType">
    			<label class="control-label" id="cardType_label" for="cardType"><?php echo($cardType_placeholder); ?></label>
    			<select id="cardType" class="form-control">
    				<option value="deb">Debito</option>
    				<option value="cred">Credito</option>
    			</select>
    		</div>     
    	<?php endif; ?>

    </div>