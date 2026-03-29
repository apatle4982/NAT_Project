<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($filesShippingData, ['horizontal' => true]) ?>
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
								<?php echo $this->Form->control('docTypeId', ['type' => 'select','value' => $documentData['Id'], 'label' => false, 'options' =>$documentDataList, 'multiple' => false, 'class'=>'form-control','style'=>'max-width: 300px;']);  ?> 
                                <?= $this->Form->hidden('fmdId', ['value'=>$filesMainData['Id']]); ?>
                                <?= $this->Form->hidden('shippingId', ['value'=>(isset($filesShippingData->Id)) ? $filesShippingData->Id: '']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Shipping Details</h4> 
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
                                            'label'=> false,
                                            'class'=>'form-control',
                                            'value'=>(isset($filesShippingData->CarrierName)) ? $filesShippingData->CarrierName: '',
                                            'escape'=>false
                                            ]);
                                ?>	 
							</div>
						</div> 
                        
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['CarrierTrackingNo'])) ? $partnerMapField['mappedtitle']['CarrierTrackingNo'] : 'CarrierTrackingNo');?></label>
                                 
                                <?php 	echo $this->Form->control('CarrierTrackingNo',[
										'type' => 'text',
										'required' => false, 
										'label'=> false,
                                        'class'=>'form-control',
										'value'=>(isset($filesShippingData->CarrierTrackingNo)) ? $filesShippingData->CarrierTrackingNo: '',
										'escape'=>false
										]);  
                                ?>

							</div>
						</div>  

					</div>
					<!--end row-->
				</div> 
			</div>

            <div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Shipping Processing Date</h4> 
			</div>
            
            <div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Processing Date</label>
                                <?php echo $this->Form->control('ShippingProcessingDate', 
										['label'=> false,'class'=>'form-control', 'type'=>'text', 'required'=>false, 'placeholder'=>'(yyyy-mm-dd)', 'value'=>(isset($filesShippingData->ShippingProcessingDate)) ? date('Y-m-d', strtotime($filesShippingData->ShippingProcessingDate)): date('Y-m-d')]); ?>
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
                                <?php echo $this->Form->control('Regarding', ['label'=>false,
                                'class'=>'form-control', 'required'=>false, 'type'=>'textarea', 'style'=>'height:50px']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Public/ Internal Notes end -->	 
	    </div>
	
        <!-- Grantees start-->
        <div class="col-xxl-6 col-md-6 col-sm-12"> 
            <?php echo $this->element('filedata_recordedit', ['partnerMapField'=>$partnerMapField, 'filesMainData'=>$filesMainData]); ?> 
        </div> <!-- 2 col close -->
	</div>
	<!-- row close -->
</div>

<div class="row">
    <div class="col-lg-12">
		<?= $this->Lrs->saveCancelBtn('',$section); ?>			
    </div>	
</div>
 
<!--- use helper to show Help---->
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