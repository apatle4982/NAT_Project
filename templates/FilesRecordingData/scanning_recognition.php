<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FilesRecordingData $filesRecordingData
 */
?>
<style>
	.sr-box-danger{
		border: 5px solid red; 
		text-align: center; 
		font-size: 12px; 
		width: 400px; 
		margin-bottom: 10px; 
		position: absolute; 
		left: 1px; top: 0px; 
		margin-top: 400px; 
		margin-left: 36%; 
		background-color:#f9e5e6;
		z-index: 1;
	}
	.sr-box-ok{
		border: 5px solid green; 
		text-align: center; 
		font-size: 12px; 
		width: 400px; 
		margin-bottom: 10px; 
		position: absolute; 
		left: 1px; 
		top: 0px; 
		margin-top: 400px;
		margin-left: 36%; 
		background-color:#bae7cb;
		z-index: 1;
	}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<?= $this->Form->create($recordingData, ['name'=>'scanningForm','horizontal'=>false]) ?>
			<div class="card-body">
				<div class="live-preview lrs-frm sml-field search-partner">
					<div class="row gy-4">
						 
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									 &nbsp;
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="row">
							 
								<div class="col-xxl-6 col-md-6">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">&nbsp;</label>
										<div class="row">
											<div class="col-xxl-6 col-md-6 col-sm-6" style="margin-top:0!important;">
												<?php  
													echo $this->Form->control('qrcode',[
														'type' => 'text',
														'required' => false,
														'placeholder' => "QR Code (Barcode Gun)",
														'label'=>false,
														'id'=>'qrcode',
														'value'=>$qrcode
														]); 
												?>
												<div id="msgdiv"></div>
											</div> 
										</div>	
											
									</div>
								</div> 

								<div class="col-xxl-6 col-md-6">
									<div class="input-container-floating ">
										<?= $this->Form->button(__('Scanning Recognition'), ['name'=>'qrCodeSubmit', 'class'=>'btn btn-primary m-t']) ?>
									</div>
								</div>
							 
 
							</div>
						</div>
						

						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									 &nbsp;
								</div>
							</div>
						</div>

						 
					</div>
					

					
					 
				</div>
  
			</div>
			<?= $this->Form->end() ?>
			 
		</div>
		
	</div>
	<?php if(!empty($qrerror)){ ?>
			<div class="col-lg-12 col-md-12 col-sm-12 offset-lg-4">
				<div class="row">
					<div class="qrerrorDiv m-auto col-lg-6 col-md-6 p-lg-4 text-center <?= $qrerror['class'] ?>">
						<div class="sr-box">
							<div class="sr-box-inner">
								<h3><?= $qrerror['text'] ?></h3>
								
								<?= $this->Form->button(__('OK'), ['type'=>'button','class'=>'btn btn-danger', 'id'=>'ScannMsg']) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
</div>


<?php $this->append('script') ?>

<script type="text/javascript">
	$(document).ready(function () {
		$("#qrcode").keyup(function(event) {

			var newbarcode = $("#qrcode").val();
			
			if(newbarcode == "" ){ 
				$("#qrcode").css({"border-color": "#ec0909"});
				$('#msgdiv').html('Enter value');
				$('#msgdiv').css({"color": "red", "font-weight": "normal"});
				return false; 
			}else{
				$('#msgdiv').html('');
				$("#qrcode").css({"border-color": "#05a152"});
 
				document.scanningForm.submit();return true;
			}
		});
		
		$("#ScannMsg").click(function () {
			$('.qrerrorDiv').hide();
		});
    });
</script>
<?php $this->end() ?>