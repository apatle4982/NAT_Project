<?php
/**
  * @var \App\View\AppView $this
  */
?>
<style>
	.toolTip-show {
		position:absolute;
		visibility:hidden;
		border:1px solid #ced4da;
		padding:10px;
		background: #e2e2e2;
		min-width:40%;
	}
</style>
<?= $this->Form->create($filesQcData, ['horizontal' => true]) ?>
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
                                <?= $this->Form->hidden('qcId', ['value'=>(isset($filesQcData->qcId)) ? $filesQcData->qcId: '']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">QC/Rejection Data</h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Rejection Status</label>
                                <?php
                                $options = ['OK'=>'OK','RTP'=>'RTP','RIH'=>'RIH'];
                                echo $this->Form->radio('Status', $options, ['required'=>false, 'default' => 'RTP', 'class'=>'i-checks']);
                                ?> 
							</div>
						</div> 
                        
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['RejectionReason'])) ? $partnerMapField['mappedtitle']['RejectionReason'] : 'Rejection Reason');?></label>
                                 
                                <?php echo $this->Form->control('RejectionReason', ['label'=>false, 'class'=>'form-control', 'required'=>false, 'type'=>'textarea', 'style'=>'height:50px', 'value' => $filesQcData->RejectionReason]);  ?> 

							</div>
						</div>  

                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['TrackingNo4RR'])) ? $partnerMapField['mappedtitle']['TrackingNo4RR'] : 'Tracking No (RTP)');?></label>
                                  
                                <?php echo $this->Form->control('TrackingNo4RR', ['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>$filesQcData->TrackingNo4RR]); ?>

							</div>
						</div> 
                        
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating" id="datepicker">	
								<label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['ProcessingDate'])) ? $partnerMapField['mappedtitle']['ProcessingDate'] : 'Processing Date');?></label>
                                  
                                <?php echo $this->Form->control('ProcessingDate', 
                                ['label'=>false,

                                'class'=>'form-control', 'required'=>false, 'placeholder'=>'yyyy-mm-dd', 'value'=>date('Y-m-d')]); ?>

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
						<!-- <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
 								<label for="basiInput" class="form-label">Type</label>
								    <?php
									/* echo $this->Form->radio('publicType',
										[
											['value' => 'I', 'text'=>__('Internal')],
											['value' => 'P', 'text' => __('Public')],
										],['required'=>false, 'default' => 'I', 'class'=>'i-checks']); */
									?>
							</div>
						</div> -->
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

        <div class="col-xxl-6 col-md-6 col-sm-12"> 
            <?php echo $this->element('filedata_recordedit', ['partnerMapField'=>$partnerMapField, 'filesMainData'=>$filesMainData]); ?> 
        </div>
	</div> 
	<!-- row close -->
</div>

<div class="row">
	<div class="col-lg-12">
		<?= $this->Lrs->saveCancelBtn('',$section); ?>
	</div>	
</div>

<div class="card" style="margin-top:15px">
	<div class="row">
		<div class="col-xxl-8 col-md-8 col-sm-12">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Rejection History</h4> 
			</div>

			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<?= $this->element('rejection_SH_table')?>
						</div>
						<!-- <div class="col-xxl-8 col-md-8">
							<div class="input-container-floating">
							<label for="basiInput" class="form-label">Clearance Note</label>
								<?php echo $this->Form->control('ClearanceNote', ['label'=>false, 'class'=>'form-control', 'required'=>false, 'type'=>'textarea', 'style'=>'height:50px', 'value'=>'']); ?>
							</div>
						</div>
						<div class="col-xxl-8 col-md-8">
							<?= $this->Form->button(__('Clear'), ['type'=>'submit', 'value'=>"clearsave",'id'=>'clearsave', 'name'=>'clearsave','class'=>'btn btn-primary']); ?>
							<?= $this->Form->button(__('Clear & Save status'), ['type'=>'submit', 'value'=>"clearsaveStatus", 'id'=>'clearsaveStatus', 'name'=>'clearsaveStatus','class'=>'btn btn-primary']); ?>
						</div> -->
					</div>
				</div>
			</div>
		</div>
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
 
<?php $this->append('script') ?>
<script>
    $(document).ready(function () {
		$("button#clearsave, button#clearsaveStatus").click(function(){
			if(!$('.checkSingle:checkbox').is(':checked')){
				alert("Please select at least one record");
				return false;
			}
		});

    }); 
</script>
<?php $this->end() ?>