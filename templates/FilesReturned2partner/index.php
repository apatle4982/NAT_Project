<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesReturned2partner[]|\Cake\Collection\CollectionInterface $FilesReturned2partner
  */

?> 
<!-- ================================================================ -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<?= $this->Form->create($FilesReturned2partner, ['horizontal'=>true]) ?>
		<div class="col-lg-12">
			<div class="ibox float-e-margins">

				<!-- Data filter Section -->
				<?php 
					// important array to active/show widgets from search all element will chenge as per page requirment
					$widgets = ['RecordsAdded','ShippingStatus', 'Research'];
					echo $this->element('searchall_template',['widgets'=>$widgets, 'isSearch'=>$isSearch]); 
				?>
				
				<div class="card"> 
					<div class="card-body"> 
						<div class="form-group">
							<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="row">
									<div class="col-xxl-12 col-md-12 col-sm-6">
										<?= $this->Form->button(__('Record Data'), ['type'=>'submit','class'=>'btn btn-primary block m-r', 'name'=>'recordingData', 'id'=>'recordingData']) ?>
										<?= $this->Form->button(__('Complete Order & Generate Sheet'), ['name'=>'completeOrderDataSheet', 'class'=>'btn btn-primary', 'id'=>'completeOrderDataSheet']) ?>
									</div>
			
									<div class="col-xxl-6 col-md-6 col-sm-6">	
										<div class="row">
										<div class="col-xxl-4 col-md-4 col-sm-12">
											<?php  
												echo $this->Form->control('CarrierName',[
													'type' => 'text',
													'required' => false,
													'placeholder' => "Carrier Name",
													'label'=> false,
													'class'=>'form-control',
													'value'=>''
													]);
											?>	
											</div>
											<div class="col-xxl-4 col-md-4 col-sm-12">
											<?php  
												echo $this->Form->control('CarrierTrackingNo',[
													'type' => 'text',
													'required' => false,
													'placeholder' => "Carrier Tracking No",
													'label'=> false,
													'class'=>'form-control',
													'value'=>''
													]); 
											?>	 
											</div>
											<div class="col-xxl-4 col-md-4 col-sm-12">
											<?php  
												/* echo $this->Form->control('qrcode',[
													'type' => 'text',
													'required' => false,
													'placeholder' => "QR Code",
													'label'=> false,
													'class'=>'form-control',
													'value'=>''
													]);  */
											?>	
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
							<?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
							<!---Using helper here--->
							<?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
							<?php } ?>
							
							<!-- Records Listing -->
							<?php echo $this->element('common_records_list',$datatblHerader); ?>
						</div>
					</div>
				</div>
				<div class="ibox-content">	
					<div class="form-group">
						<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="row">
								<div class="col-lg-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
									 
										<?= $this->Form->button(__('Record Data'), ['type'=>'submit','class'=>'btn btn-primary block m-r', 'name'=>'recordingData', 'id'=>'recordingData']) ?>
									
									
										<?= $this->Form->button(__('Complete Order & Generate Sheet'), ['name'=>'completeOrderDataSheet', 'class'=>'btn btn-primary', 'id'=>'completeOrderDataSheet']) ?>
									 
								</div>
							</div>
						</div>
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
<!-- Barcode Modal helper -->
 
<?php $this->append('script') ?>

<script type="text/javascript">
	$(document).ready(function () {
		
		var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'<?= $pageType ?>'};
		var columndata =<?php echo $dataJson;?>;
		$('#datatable_example').DataTable({
			"lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, 'All']],
			"processing": true,
			"pageLength": 10,
			"serverSide": true,
			"searching": false,
			"dom": 'Blfrtip',  
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:first-child):not(:last-child)' } }],
			"ajax": {
				url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxListIndex"]) ?>',
				data: formdata,
				type: 'POST'  ,
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}  
			},
			
			"columns": columndata,
			order: [[ 2 ,"asc" ]]
		});


        $("button#recordingData, button#completeOrderDataSheet").click(function(){
			if(!$('.checkSingle:checkbox').is(':checked')){
				alert("Please select at least one record");
				return false;
			}
        });
		
    });

 
</script>
<?php $this->end() ?>
