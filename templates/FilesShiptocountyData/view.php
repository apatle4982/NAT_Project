<?php
/**
  * @var \App\View\AppView $this
  */

?>
<div class="card" style="margin-top:15px">
	<?= $this->Form->create(null, ['horizontal' => true]) ?>
	<div class="row">
		<div class="col-xxl-6 col-md-6 col-sm-12">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<h4><?= __('Shipping record for <u>'.$filesMainData['PartnerFileNumber'].'</u>') ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Shipping Details')?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __((isset($partnerMapField['mappedtitle']['CarrierName'])) ? $partnerMapField['mappedtitle']['CarrierName'] : 'Carrier Name') ?></label>
                                <?= __((isset($filesShippingData->CarrierName)) ? $filesShippingData->CarrierName: '') ?>
							</div>
						</div> 
                        
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __((isset($partnerMapField['mappedtitle']['CarrierTrackingNo'])) ? $partnerMapField['mappedtitle']['CarrierTrackingNo'] : 'Carrier Tracking No') ?></label>
                                <?= __((isset($filesShippingData->CarrierTrackingNo)) ? $filesShippingData->CarrierTrackingNo: '') ?>
							</div>
						</div> 
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Shipping Processing Date') ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Date</label>
                                <?= __((isset($filesAccountingData->AccountingProcessingDate)) ? date('m/d/Y', strtotime($filesAccountingData->AccountingProcessingDate)) : date('m/d/Y')) ?>
								
							</div>
						</div> 
					</div>
					<!--end row-->
				</div> 
			</div>
	    </div>
		
		
        <div class="col-xxl-6 col-md-6 col-sm-12"> 
            <?php echo $this->element('filedata_recordedit', ['partnerMapField'=>$partnerMapField, 'filesMainData'=>$filesMainData]); ?>
        </div>
	</div> 
	
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<?php echo $this->Html->link(__('Go back'), $this->request->referer(), ['class'=>'btn btn-danger', 'role'=>'button','escape'=>false]) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="card-body">
				<?php if(!empty($partnerMapField['help'])){ 
					echo $this->Lrs->showMappingHelp($partnerMapField['help']);
				 } ?> 
			</div>
		</div>
	</div>
	<!-- row close -->
	<?= $this->Form->end() ?>
</div>