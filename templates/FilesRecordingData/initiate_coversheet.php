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
			<div class="card-body">
				
				<div class="live-preview lrs-frm sml-field search-partner">
					<div class="row gy-4"> 

				
						<div class="col-lg-6 col-md-6 col-sm-12">
							<fieldset>
							<?= $this->Form->create($recordingData, ['name'=>'scanningForm','horizontal'=>false]) ?>

							 <legend><h2>Initiate Coversheet with QR Code</h2></legend>
								<div class="row">
								<div class="col-xxl-8 col-md-8">
								<div class="row">
									<div class="col-xxl-12 col-md-12">
										<div class="input-container-floating ">
											<label for="basiInput" class="form-label">QR Code (Barcode Gun)</label>
											
												<?php  
													echo $this->Form->control('qrcode',[
														'type' => 'text',
														'required' => false,
														'placeholder' => "QR Code (Barcode Gun)",
														'label'=>false,
														'id'=>'qrcode',
														'value'=> ''
														]); 
												?>
													
																
										</div>		<div id="msgdiv"></div>		
									</div>
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">QR Code (Manual)</label>
										 
											<?php  
												echo $this->Form->control('qrcodeEnter',[
													'type' => 'text',
													'required' => false,
													'placeholder' => "QR Code (Manual)",
													'label'=>false,
													'value'=> ''
													]); 
											?> 
										 									
									</div>
									</div>
								</div>	
								</div> 

								<div class="col-xxl-4 col-md-4">
									<div class="input-container-floating ">
									<?= $this->Form->button(__('Initiate Coversheet'), ['type'=>'submit','class'=>'btn btn-primary m-t', 'name'=>'qrCodeSubmit']) ?> 
									 
									</div>
								</div>
								</div><?= $this->Form->end() ?>
							</fieldset>
							
						</div>
						
 

						<div class="col-lg-6 col-md-6 col-sm-12">
							
							<fieldset>
								<?= $this->Form->create($recordingData, ['name'=>'scanningForm_client','horizontal'=>false]) ?>
					
							 <legend><h2>Initiate Coversheet with PartnerFileNumber</h2></legend>
							 <div class="row">
								<div class="col-xxl-8 col-md-4">
										 <div class="row">
											
											<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating ">
													<label for="basiInput" class="form-label">Client File Number</label>										
													 
														<?php  
															echo $this->Form->control('PartnerFileNumber',[
																'type' => 'text',
																'required' => false,
																'placeholder' => "Client File Number",
																'label'=>false,
																'id'=>'PartnerFileNumber',
																'value'=>$PartnerFileNumber
																]); 
														?>
												 										
													<div id="msgdiv"></div>
												</div>
											</div>
											<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating ">
													<label for="basiInput" class="form-label">Document Type</label>	 
													 
													<?php  
														echo $this->Form->control('TransactionType', [
															'value' => isset($TransactionType)? $TransactionType: '', 
															'options' => $DocumentTypeData, 
															'multiple' => false, 
															'empty' => 'Select Document Type',
															'label' => [ 
																	'text' =>  'Document Type',
																	'escape' => false
															],
															'class'=>'form-control', 
															'label'=>false,
															'required'=>false
														]);
													?> 
													 
												</div>
											</div> 
											</div>
									</div>
									<div class="col-xxl-4 col-md-4">
										<div class="input-container-floating ">
										<?= $this->Form->button(__('Initiate Coversheet'), ['type'=>'submit','class'=>'btn btn-primary m-t', 'name'=>'clientFileSubmit']) ?> 
										</div>
									</div>
								</div>	<?= $this->Form->end() ?>
							</fieldset> 
						</div>
					
 


					</div>
					 
				</div>
  
			</div>
		
			 
		</div>
		
	</div>


</div>



<?php if(!empty($qrerror)){ ?>
	<div class="col-lg-12">
 
				<div class="row"> 
					<div class="col-lg-12 col-md-12 col-sm-12 offset-lg-4">
						<div class="row">
							<div class="qrerrorDiv m-auto col-lg-6 col-md-6 p-lg-4 text-center <?= $qrerror['class'] ?>">
								<div class="sr-box">
									<div class="sr-box-inner">
										<h3><?= $qrerror['text'] ?></h3> 
										<?= $this->Form->button(__('OK'), ['type'=>'button','class'=>'btn btn-danger', 'id'=>'ScannMsgBtn']) ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		 
	</div>
<?php } ?>

<?php if(isset($coverSheetData) && !empty($coverSheetData)) { ?>
<?= $this->Form->create($recordingData, ['name'=>'scanningForm_record','horizontal'=>false]) ?>

<div class="col-lg-12">
	<div class="card">
			<div class="card-body">
			<div class="row"> 

			<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 m-t">

				<?= $this->Form->button(__('Print Coversheet'), ['type'=>'submit','class'=>'btn btn-primary', 'name'=>'btnCoversheet']) ?>
 
				<div class="table-responsive">
					<table class="table datatable_example order-column stripe table-striped table-bordered">
						<thead>
							<tr>
								<th>FileNo</b></th>
								<th>Client File Number</th>
								<th>DocType</th>
								<th>Recording Processing Date</th>
								<th>Instrument Number</th>
								<th>Book</th>
								<th>Page</th>
								<th>E-Capable</th>
							</tr>
						</thead>
							
						<tbody>
							<?= $coverSheetData ?>
						</tbody>
					</table>
				</div>

				<?= $this->Form->button(__('Print Coversheet'), ['type'=>'submit','class'=>'btn btn-primary', 'name'=>'btnCoversheet']) ?>

			</div> 
			
			</div>
			</div>
		</div>
		<?= $this->Form->end() ?>
	</div><?php } ?>

<?php $this->append('script') ?>

<script type="text/javascript">
	$(document).ready(function () {
		
		$("#qrcode").keyup(function(event) {
			var newbarcode = $("#qrcode").val();

			if(newbarcode == "" ){
				$("#qrcode").css({"border-color": "#ec0909"});
				//$('#msgdiv').html('Enter value');
				$('#msgdiv').css({"color": "red", "font-weight": "normal"});
				return false;
				
			}else{
				$('#msgdiv').html('');
				$("#qrcode").css({"border-color": "#05a152"});
				document.scanningForm.submit();
				return false;
			}
		});
		
		$("#ScannMsgBtn").click(function () {
			$('.qrerrorDiv').hide();
		});
 

		$('.datatable_example').DataTable({
			"processing": true,
			"pageLength": 10,
			"serverSide": false,
			"searching": false,
			"dom": 'Blfrtip',  
			"buttons": [{ extend: 'csv', text: 'Export CSV' }], 
			order: [[ 3 ,"asc" ]],
			 
		});
    });
</script>
<?php $this->end() ?>