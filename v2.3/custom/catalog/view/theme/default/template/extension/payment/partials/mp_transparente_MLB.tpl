<div class="row">
<input type="hidden" value="CPF" id="doc_type"></input>
  <div class="form-group" style="margin-bottom: 4%; margin-left: 3%" id="docInfo">
    <?php if(isset($docnumber_placeholder)): ?>
      <div class="col-xs-12 col-md-4" id="divDocNumber" style="margin-left: -3%">
        <label class="control-label" id="doc_number_label" for="doc_number">CPF</label>
        <input class="form-control" type="text" id="doc_number" data-checkout="docNumber"/>
      </div>
    <?php endif; ?>
    <?php if(isset($installments_placeholder)): ?>
      <div class="row">
        <div id="divInstallments" class="col-xs-12 col-md-5" style="margin-left: -3%">
          <label class="control-label" id="installments_label" for="installments"><?php echo $installments_placeholder;?></label>
          <select id="installments" class="form-control" style="width: 90%"></select>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>