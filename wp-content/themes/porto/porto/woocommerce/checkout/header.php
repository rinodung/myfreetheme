<div class="row">
	<div class="col-md-12">
		<h2 class="shorter"><strong>Checkout</strong></h2>
        <?php wc_get_template( 'checkout/form-login.php', array( 'checkout' => WC()->checkout() ) ); ?>
	</div>
</div>