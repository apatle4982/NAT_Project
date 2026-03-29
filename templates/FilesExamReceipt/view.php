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
								<h4><?= __('Check In Status for <u>'.$filesMainData['partner_file_number'].'</u>') ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Check In Details')?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __((isset($partnerMapField['mappedtitle']['DocumentReceived'])) ? $partnerMapField['mappedtitle']['DocumentReceived'] : 'Record Status') ?></label>
                                <?= __(($filesCheckinData['DocumentReceived']=='Y') ? 'Physical document received': '	Generate Sheet for not received') ?>
							</div>
						</div> 
                        
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= __((isset($partnerMapField['mappedtitle']['DateAdded'])) ? $partnerMapField['mappedtitle']['DateAdded'] : 'Added Date') ?></label>
                                <?php $date = (array) $filesCheckinData['CheckInProcessingDate']; // convert object to array ?>
                                <?= __((isset($date['date'])) ? date('m/d/Y', strtotime($date['date'])) : date('m/d/Y')) ?>

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
	<?= $this->Form->end() ?>
</div>