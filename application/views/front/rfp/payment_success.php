<!-- -->
<section>
	<div class="container">
		
		<!-- CHECKOUT FINAL MESSAGE -->
		<div class="panel panel-default">
			<div class="panel-body">
				<h3>Thank you, <?=$this->session->userdata['client']['fname']." ".$this->session->userdata['client']['lname']?>.</h3>

				<p>
					Your Request has been successfully submitted. In a few moments you will receive an confirmation email from us.<br />
					If you like, you can see Request list <a href="<?=base_url('rfp')?>">click Here</a>.
				</p>

				<hr />

				<p>
					Thank you very much for choosing us,<br />
					<strong><?=config('site_mname')?></strong>
				</p>
			</div>
		</div>
		<!-- /CHECKOUT FINAL MESSAGE -->
		
	</div>
</section>
<!-- / -->