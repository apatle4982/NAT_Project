<?php
/**
  * @var \App\View\AppView $this
  */

?>
<div class="card" style="margin-top:15px">
	<?= $this->Form->create($FilesReturned2partner, ['horizontal' => true]) ?>
	<div class="row">
		<div class="col-xxl-6 col-md-6 col-sm-12">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<h4><?= __('Return File for <u>'.$filesMainData['PartnerFileNumber'].'</u>') ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Return File Details')?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['CarrierName'])) ? $partnerMapField['mappedtitle']['CarrierName'] : 'Carrier Name' ?></label>
                                <?= __((isset($FilesReturned2partner->CarrierName)) ? $FilesReturned2partner->CarrierName: '') ?>
							</div>
						</div> 
                        	
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['CarrierTrackingNo'])) ? $partnerMapField['mappedtitle']['CarrierTrackingNo'] : 'Carrier Tracking No' ?></label>
                                <?= __((isset($FilesReturned2partner->CarrierTrackingNo)) ? $FilesReturned2partner->CarrierTrackingNo: '') ?>
							</div>
						</div> 
						
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Processing Date') ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['RTPProcessingDate'])) ? $partnerMapField['mappedtitle']['RTPProcessingDate'] : 'Processing Date' ?></label>
                                <?= __((isset($filesShippingData->RTPProcessingDate)) ? date('m/d/Y', strtotime($FilesReturned2partner->RTPProcessingDate)) : date('m/d/Y')) ?>
								
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
	
	
	<!-- row close -->
	

	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<?php 
									echo $this->Html->link(__('Go back'), $this->request->referer(), ['class'=>'btn btn-danger', 'role'=>'button','escape'=>false]);
 ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>