<?php
/**
  * @var \App\View\AppView $this
  */

?>
  <?= $this->Form->create($FilesReturned2partner, ['horizontal' => true]) ?>
  	<div class="row">
        <div class="col-lg-12">
            <?= $this->Lrs->saveCancelBtn('',$section); ?>			
        </div>	
    </div>
<div class="card" style="margin-top:15px">
	<div class="row">
		<div class="col-xxl-6 col-md-6 col-sm-12">
			 
      	  
				<div class="card-body">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['TransactionType'])) ? $partnerMapField['mappedtitle']['TransactionType'] : 'TransactionType');?></label> 
									<?php echo $this->Form->control('docTypeId', ['type' => 'select','value' => $documentData['Id'], 'label' =>false, 'options' =>$documentDataList, 'multiple' => false, 'class'=>'form-control']);?> 
									<?= $this->Form->hidden('fmdId', ['value'=>$filesMainData['Id']]); ?>
									<?= $this->Form->hidden('returnId', ['value'=>(isset($FilesReturned2partner->Id)) ? $FilesReturned2partner->Id: '']); ?>
								</div>
							</div>
						</div> 
					</div>
				</div>
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Return File Details</h4> 
				</div>

				<div class="card-body">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">	
									<label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['CarrierName'])) ? $partnerMapField['mappedtitle']['CarrierName'] : 'CarrierName');?></label>
									<?php  
										echo $this->Form->control('CarrierName',[
												'type' => 'text',
												'required' => false,
												'class'=>'form-control',
												'placeholder' => "Carrier Name",
												'label'=> false,
												'value'=>(isset($FilesReturned2partner->CarrierName)) ? $FilesReturned2partner->CarrierName: '', 'escape'=>false
												]);
										?>	
								</div>
							</div> 
							
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">	
									<label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['CarrierTrackingNo'])) ? $partnerMapField['mappedtitle']['CarrierTrackingNo'] : 'CarrierTrackingNo');?></label>
									
									<?php echo $this->Form->control('CarrierTrackingNo',[
											'type' => 'text',
											'required' => false,
											'class'=>'form-control',
											'placeholder' => "Carrier Tracking No",
											'label'=> false,
											'value'=>(isset($FilesReturned2partner->CarrierTrackingNo)) ? $FilesReturned2partner->CarrierTrackingNo: '', 'escape'=>false
											]);  ?> 
								</div>
							</div>  

						</div>
						<!--end row-->
					</div> 
				</div>
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Processing Date</h4> 
				</div>

				<div class="card-body">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">	
									<label class="form-label mb-0">Processing Date</label>
									<?php echo $this->Form->control('RTPProcessingDate', 
											['label'=> false, 'type'=>'text', 'class'=>'form-control', 'required'=>false, 'placeholder'=>'(yyyy-mm-dd)', 'value'=>(isset($FilesReturned2partner->RTPProcessingDate)) ? date('Y-m-d', strtotime($FilesReturned2partner->RTPProcessingDate)) : date('Y-m-d')]); ?>
								</div>
							</div>  
						</div>
						<!--end row-->
					</div> 
				</div>							
				
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Notes</h4> 
				</div>
				<div class="card-body">
					<div class="live-preview ">
						<div class="row gy-4">
							
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
								<label for="basiInput" class="form-label">Regarding</label>
									<?php 
										echo $this->Form->control('publicType', ['type'=>'hidden', 'value'=>"I"]);
									?>
									<?php echo $this->Form->control('Regarding', ['label'=>false,
											'class'=>'form-control', 'required'=>false, 'type'=>'textarea', 'style'=>'height:50px']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>

			<div class="col-xxl-6 col-md-6 col-sm-12"> 
				<?php echo $this->element('filedata_recordedit', ['partnerMapField'=>$partnerMapField, 'filesMainData'=>$filesMainData]); ?> 
			</div>
	</div> 
</div>

<div class="row">
    <div class="col-lg-12">
		<?= $this->Lrs->saveCancelBtn('',$section); ?>			
    </div>	
</div>


<?php if(!empty($partnerMapField['help'])){ ?>
<div class="card" style="margin-top:15px">
	<div class="card-body">
	<?php 
	echo $this->Lrs->showMappingHelp($partnerMapField['help']);
	?>
	</div>
</div>
<?php } ?>
 
<?= $this->Form->end() ?> 