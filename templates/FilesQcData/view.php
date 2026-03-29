<?php
/**
  * @var \App\View\AppView $this
  */

?>
<div class="card" style="margin-top:15px">
	<?= $this->Form->create($filesQcData, ['horizontal' => true]) ?>
	<div class="row">
		<div class="col-xxl-6 col-md-6 col-sm-12">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<h4><?= __('Rejection Status for <u>'.$filesMainData['PartnerFileNumber'].'</u>') ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Rejection Data')?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<?php $options = ['OK'=>'OK <i style="color:green">(Meet recording standards)</i>','OH'=>'On Hold <i style="color:red">(Waiting for client response)</i>','HW'=>'On Hold <i style="color:red">(With walk up resource)</i>','RI'=>'Rejected In Hand <i style="color:red">(PRR/CRN, In hand for correction)</i>','RR'=>'Rejected Returned <i style="color:red">(PRR/CRN, Returned to client)</i>'];							
							?>
							
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['Status'])) ? $partnerMapField['mappedtitle']['Status'] : 'Record Status' ?></label>
                                <?= __((!empty($filesQcData->Status)) ? $options[$filesQcData->Status] : '', ['escape'=>false]) ?>
							</div>
						</div> 
						
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['StatusReason'])) ? $partnerMapField['mappedtitle']['StatusReason'] : 'Status Reason' ?></label>
                                <?= $filesQcData->StatusReason ?>
							</div>
						</div> 
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['StatusNote'])) ? $partnerMapField['mappedtitle']['StatusNote'] : 'Rejection Note' ?></label>
                                <?= $filesQcData->StatusNote ?>
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
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['QCProcessingDate'])) ? $partnerMapField['mappedtitle']['QCProcessingDate'] : 'Processing Date' ?></label>
                                <?= (isset($filesQcData->QCProcessingDate)) ? date('m/d/Y', strtotime($filesQcData->QCProcessingDate)): date('m/d/Y') ?>
								
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __('Added Date') ?></label>
                                <?= (isset($filesQcData->LastModified)) ? date('m/d/Y', strtotime($filesQcData->LastModified)): date('m/d/Y') ?>
								
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
	
	<!--<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="card-body">
				<?php if(!empty($partnerMapField['help'])){ 
					echo $this->Lrs->showMappingHelp($partnerMapField['help']);
				 } ?> 
			</div>
		</div>
	</div>-->
	<!-- row close -->
	<?= $this->Form->end() ?>
</div>