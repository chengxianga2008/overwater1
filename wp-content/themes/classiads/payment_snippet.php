<div class="creditcard_well">
  						<form id="payment_form">
						  <div class="form-group">
						    <label class="field_header" for="credit_card_first_name">First Name</label>
						    <input type="text" class="form-control" id="credit_card_first_name" name="credit_card_first_name">
						  </div>
						  <div class="form-group">
						    <label class="field_header" for="credit_card_last_name">Last Name</label>
						    <input type="text" class="form-control" id="credit_card_last_name" name="credit_card_last_name">
						  </div>
						  <div class="form-group">
						    <label class="field_header" for="credit_card_phone">Phone</label>
						    <input type="phone" class="form-control" id="credit_card_phone" name="credit_card_phone">
						  </div>
						  <div class="form-group">
						    <label class="field_header" for="credit_card_email">Email Address</label>
						    <input type="email" class="form-control" id="credit_card_email" name="credit_card_email">
						  </div>
						  <div class="form-group">
						    <label class="field_header" for="credit_card_invoice_no">Invoice No.</label>
						    <div class="input-group">
						    	<span class="input-group-addon">#</span>
						    	<input type="text" class="form-control" id="credit_card_invoice_no"  data-rule-required="true" name="credit_card_invoice_no">
						    </div>						    
						  </div>
						  <div class="form-group">
						    <label class="field_header" for="credit_card_aud_amount">AUD amount <span class="credit_subscript">(1.5% credit card surcharge applies)</span></label>
						    <div class="input-group">
						    	<span class="input-group-addon">$</span>
						    	<input type="text" class="form-control" id="credit_card_aud_amount"  data-rule-required="true" name="credit_card_aud_amount">
						    </div>					    
						  </div>
						  <script src="https://cdn.pin.net.au/pin.v2.js"></script> 
						  <a id="pin-payment" class="pin-payment-button" href="javascript:;">
							<img src="<?php echo get_template_directory_uri() . "/images/pay-button.png"; ?>" alt="Pay Now" width="86" height="38">
						  </a>
						  
						</form>
</div>