<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesShiptoCountyData[]|\Cake\Collection\CollectionInterface $FilesShiptoCountyData
  */
?>	
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<?= $this->Form->create($FilesShiptoCountyData, ['horizontal'=>true]) ?>
			<div class="col-lg-12">

				<div class="card">
					
					<div class="card-body">
						<div class="live-preview lrs-frm sml-field search-partner">
						<div class="row gy-4">
						<div class="dv-frm-left">
						<div class="row gy-4">
							<div class="col-lg-4 col-md-4 col-sm-12">
								<h2>Partner</h2>
								<div class="row gy-4">
									
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
									<label for="basiInput" class="form-label"><strong><?= ((isset($partnerMapField['mappedtitle']['TransactionType']) && (!empty($partnerMapField['mappedtitle']['TransactionType']))) ? $partnerMapField['mappedtitle']['TransactionType']: 'Document Type'); ?></strong></label>
											<?php
													echo $this->Form->control('TransactionType', [
														'value' => isset($formpostdata['TransactionType'])? $formpostdata['TransactionType']: '', 
														'options' => $documentTypeData, 
														'multiple' => false, 
														'empty' => 'Select Document Type',
														'label' => [ 
																'text' => ((isset($partnerMapField['mappedtitle']['TransactionType']) && (!empty($partnerMapField['mappedtitle']['TransactionType']))))? $partnerMapField['mappedtitle']['TransactionType']: 'Document Type',
																'escape' => false
														],
														'class'=>'form-control', 
														'label'=>false,
														'required'=>false
													]);
										
												?>
									</div>
									</div>
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
									<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['State']) ? $partnerMapField['mappedtitle']['State']: 'State') ?></strong></label>
											
											<?php echo $this->Form->control('State', [
															'label' => false,
														'value'=>isset($formpostdata['State'])? $formpostdata['State']: '' , 'class'=>'form-control', 'required'=>false]); ?>
									</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<h2>Location</h2>
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
									<label for="basiInput" class="form-label"><strong><?= (((isset($partnerMapField['mappedtitle']['NATFileNumber']) && (!empty(trim($partnerMapField['mappedtitle']['NATFileNumber'])))))? $partnerMapField['mappedtitle']['NATFileNumber']: 'NATFileNumber')?></strong></label>
											<?php echo $this->Form->control('NATFileNumber', [
											'label' => false,
											'value'=>isset($formpostdata['NATFileNumber'])? $formpostdata['NATFileNumber']: '' , 'class'=>'form-control', 'required'=>false]); ?>
									</div>
									</div>
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
									<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantors') ?></strong></label>
											<?php echo $this->Form->control('Grantors', ['value'=>isset($formpostdata['Grantors'])? $formpostdata['Grantors']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
									</div>
									</div>
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
									<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County') ?></strong></label>
											<?php echo $this->Form->control('County', ['value'=>isset($formpostdata['County'])? $formpostdata['County']: '' ,
												'label' =>false, 
												'class'=>'form-control', 'required'=>false]); ?>
									</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<h2>Employee</h2>
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
									<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'PartnerFileNumber') ?></strong></label>
											<?php echo $this->Form->control('PartnerFileNumber', ['value'=>isset($formpostdata['PartnerFileNumber'])? $formpostdata['PartnerFileNumber']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
									</div>
									</div>
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
									<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['StreetName'])? $partnerMapField['mappedtitle']['StreetName']: 'StreetName') ?></strong></label>
											<?php echo $this->Form->control('StreetName', ['value'=>isset($formpostdata['StreetName'])? $formpostdata['StreetName']: '' ,
												'label' => false,
												'class'=>'form-control', 'required'=>false]); ?>
									</div>
									</div>
								</div>
							</div> 
						</div>
						<!-- Qc Processing -->
						<div class="row gy-4 QC-form">
							<div class="col-lg-4 col-md-4 col-sm-12 ">
								<h2>QC Processing Date: (yyyy-mm-dd)
								</h2>
								<div class="row gy-4">
									<div class="col-xxl-6 col-md-6 col-sm-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">From:</label> 
										<?php echo $this->Form->control('QCStartDate', ['value'=>isset($formpostdata['QCStartDate'])? $formpostdata['QCStartDate']: '' ,
										'label' => false, 
										'class' => 'form-control',
										'required'=>false]);?>                               
									</div>
									</div>
									<div class="col-xxl-6 col-md-6 col-sm-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">To:</label>
										<?php echo $this->Form->control('QCEndDate', ['value'=>isset($formpostdata['QCEndDate'])? $formpostdata['QCEndDate']: '' ,
										'label' => false, 
										'class' => 'form-control',
										'required'=>false]); ?>
									</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<h2>Accounting Processing Date: (yyyy-mm-dd)</h2>
								<div class="row gy-4">
									<div class="col-xxl-6 col-md-6 col-sm-12">
										<div class="input-container-floating ">
											<label for="basiInput" class="form-label">
											From:</label>
											<?php echo $this->Form->control('AccountingStartDate', ['value'=>isset($formpostdata['AccountingStartDate'])? $formpostdata['AccountingStartDate']: '' ,
											'label' =>false, 
											'class' => 'form-control',
											'required'=>false]);  ?>
										</div>
									</div>
									<div class="col-xxl-6 col-md-6 col-sm-12">
										<div class="input-container-floating ">
											<label for="basiInput" class="form-label">To:</label>
											<?php echo $this->Form->control('AccountingEndDate', ['value'=>isset($formpostdata['AccountingEndDate'])? $formpostdata['AccountingEndDate']: '' ,
											'label' =>false, 
											'class' => 'form-control',
											'required'=>false]); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12">
								<h2>Shipping Status</h2>
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">
										
										<div class="form-check checkBox">
											<label class="form-check-label" for="ShippingStatus">
											Documents not shipped
											</label>
											<?php
												echo $this->Form->input('ShippingStatus', [ 
													'type' => 'radio',
													'options' => ['dns'=>'Documents not shipped'],
													'required' => false,
													'label' => false,
													'default' => "dns",
													'class'=>'form-check-input'
													]); 
											?>
										</div>
										<div class="form-check checkBox">
											<label class="form-check-label" for="ShippingStatus">
											Documents shipped
											</label>
											<?php
												echo $this->Form->input('ShippingStatus', [ 
													'type' => 'radio',
													'options' => ['ds'=>'Document shipped'],
													'required' => false,
													'label' => false,
													'default' => "dns",
													'class'=>'form-check-input'
													]); 
											?>
										</div>
										<div class="form-check checkBox">
											<label class="form-check-label" for="ShippingStatus">
											All
											</label>
											<?php
												echo $this->Form->input('ShippingStatus', [ 
													'type' => 'radio',
													'options' => ['all'=>'All'],
													'required' => false,
													'label' => false,
													'default' => "dns",
													'class'=>'form-check-input'
													]); 
											?>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Qc Processing end -->
		
						</div>
							<div class="dv-frm-right">
							<div class="row gy-4">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="row gy-4">
										<div class="col-xxl-12 col-md-12">
										<div class="submit">
											<?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success flt-rght', 'tabindex' => 14]); ?> 
										</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<?=$this->Html->link(__('Clear'), ['action'=>'index'],['class'=>'btn btn-danger flt-rght']);?>
											 
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
					</div>
				</div> 
				

				<div class="card"> 
					<div class="card-body">
						<div class="live-preview"> 
							<!-- Records Listing -->
							<?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
								<!---Using helper here--->
								<?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
							<?php } ?>
							
							<!-- Records Listing -->
							<?php echo $this->element('common_records_list',$datatblHerader); ?>

						
						</div> 
					</div> 
				</div>

			</div>
		<?= $this->Form->end() ?>

		<?php if(!empty($partnerMapField['help'])){ ?>
			<div class="col-lg-12"> 
		<div class="card" style="margin-top:15px">
			<div class="card-body">
			<?php 
			echo $this->Lrs->showMappingHelp($partnerMapField['help']);
			?>
			</div>
		</div>
		</div>
		<?php } ?>
   	</div>
</div> 
  
<?php $this->append('script') ?>

<script type="text/javascript">
	$(document).ready(function () {
		
		var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'<?= $pageType ?>'};
		var columndata =<?php echo $dataJson;?>;
		$('#datatable_example').DataTable({
			"processing": true,
			"pageLength": 10,
			"serverSide": true,
			"searching": false,
			"dom": 'Blfrtip',
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)' } }],
			"ajax": {
				url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxListIndex"]) ?>',
				data: formdata,
				type: 'POST',
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}
			},
			
			"columns": columndata,
			order: [[ 2 ,"asc" ]],
			createdRow: function( row, data, dataIndex ) {				
				if ( data['ECapable'] == "Both SF & CSC" ) {
					$(row).addClass( 'bothColor' );
				} else if( data['ECapable'] == "SF" ) {
					$(row).addClass( 'sfColor' );
				} else if(data['ECapable'] == 'CSC') {
					$(row).addClass( 'cscColor' );
				} else if ( data['lock_status'] == 1 ) {
					$(row).addClass( 'disabledColor' );
				}  
			}
		});
		 	 

        $("button#generateShipping, button#recordingData, button#sendRecordingDataSheet").click(function(){
			if(!$('.checkSingle:checkbox').is(':checked')){
				alert("Please select at least one record");
				return false;
			}
        });
		
		$("#qrcode").keyup(function(event) {
			
			var newbarcode = $("#qrcode").val();
			if(newbarcode == "" ){
				$("#qrcode").css({"border-color": "#d1d1d1"});
				$('#msgdiv').html('');
			}else{
			
			var chk_arr =  document.getElementsByName("checkAll[]");

			var chklength = chk_arr.length; 
			
				for(k=0;k< chklength;k++){
					var recid= $('#LRSNum_'+k).val();
					if(recid == newbarcode){
						chk_arr[k].checked = true;
						$("#qrcode").css({"border-color": "#d1d1d1"});
						$('#msgdiv').html('Record Found and Checked');
						$('#msgdiv').css({"color": "green", "font-weight": "normal"});
						break;
					}else{
						$("#qrcode").css({"border-color": "red"});
						$('#msgdiv').html('Record Not Found');
						$('#msgdiv').css({"color": "red", "font-weight": "normal"});
					}
				} 

			}
		});
		
    });
</script>
<?php $this->end() ?> 