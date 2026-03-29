<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="card" style="margin-top:15px">
	<?= $this->Form->create($filesAccountingData, ['horizontal' => true]) ?>
	<div class="row">
		<div class="col-xxl-4 col-md-4 col-sm-12">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<h4><?= __('Accounting Status For <u>'.$filesMainData['PartnerFileNumber'].'</u>') ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Fees Details')?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['CountyRecordingFee'])) ? $partnerMapField['mappedtitle']['CountyRecordingFee'] : 'County Recording Fee' ?></label>
                                <?= __((isset($filesAccountingData->CountyRecordingFee)) ? $filesAccountingData->CountyRecordingFee: '') ?>
								
								
							</div>
						</div> 
                        
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['Taxes'])) ? $partnerMapField['mappedtitle']['Taxes'] : 'Taxes' ?></label>
                                 
                                <?= __((isset($filesAccountingData->Taxes)) ? $filesAccountingData->Taxes: '') ?>

							</div>
							
						</div> 
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['AdditionalFees'])) ? $partnerMapField['mappedtitle']['AdditionalFees'] : 'Additional Fees' ?></label>
                                 
                                <?= __((isset($filesAccountingData->AdditionalFees)) ? $filesAccountingData->AdditionalFees: '') ?>

							</div>
							
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['Total'])) ? $partnerMapField['mappedtitle']['Total'] : 'Total' ?></label>
                                 
                                <?= __((isset($filesAccountingData->Total)) ? $filesAccountingData->Total: '') ?>
							</div>
							
						</div>
						
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Accounting Processing Date') ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Processing Date</label>
                                <?= __((isset($filesAccountingData->AccountingProcessingDate)) ? date('m/d/Y', strtotime($filesAccountingData->AccountingProcessingDate)) : date('m/d/Y')) ?>
								
							</div>
						</div> 
					</div>
					<!--end row-->
				</div> 
			</div>
	    </div>
		<div class="col-xxl-4 col-md-4 col-sm-12"> 
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Check Details') ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['CheckNumber1'])) ? $partnerMapField['mappedtitle']['CheckNumber1'] : 'Check Number1' ?></label>
                                <?= __((isset($filesAccountingData->CheckNumber1)) ? $filesAccountingData->CheckNumber1: '') ?>
							</div>
						</div> 
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['CheckNumber2'])) ? $partnerMapField['mappedtitle']['CheckNumber2'] : 'Check Number2' ?></label>
                                <?= __((isset($filesAccountingData->CheckNumber2)) ? $filesAccountingData->CheckNumber2: '') ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['CheckNumber3'])) ? $partnerMapField['mappedtitle']['CheckNumber3'] : 'Check Number3' ?></label>
                                <?= __((isset($filesAccountingData->CheckNumber3)) ? $filesAccountingData->CheckNumber3: '') ?>
							</div>
						</div>
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<div class="card-header align-items-center d-flex">
				<label class="card-title"><?= __('Accounting Note') ?></label> 
			</div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= (isset($partnerMapField['mappedtitle']['AccountingNotes'])) ? $partnerMapField['mappedtitle']['AccountingNotes'] : 'Accounting Notes' ?></label>
                                <?= __((isset($filesAccountingData->AccountingNotes)) ? $filesAccountingData->AccountingNotes: '') ?>
							</div>
						</div>
					</div>
					<!--end row-->
				</div> 
			</div>
        </div>
		
        <div class="col-xxl-4 col-md-4 col-sm-12"> 
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