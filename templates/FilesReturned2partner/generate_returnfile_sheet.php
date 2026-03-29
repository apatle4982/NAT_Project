<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			
			<?= $this->Form->create(null, ['horizontal'=>true]) ?>
			<div class="card-body">
				<div class="live-preview lrs-frm sml-field search-partner">
					<div class="row gy-4">
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label"><b>Partner:</b></label>
										<?= $this->Form->control('company_id', ['type' => 'select', 'label' =>false, 'options' => $companyMsts, 'multiple' => false, 'empty' => 'Select Partner', 'class'=>'form-control', 'required'=>true]) ?>	
									</div>
								</div>
								
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">Return File Processing Date:</label>
										<div class="row">
											<div class="col-xxl-6 col-md-6 col-sm-6" style="margin-top:0!important;">
											<?= $this->Form->control('StartDate', ['placeholder' => '( yyyy-mm-dd )', 'label' => false, 'class'=>'form-control', 'value'=> isset($fromDate) ? $fromDate : date('Y-m-d')]) ?>
											</div>
											<div class="col-xxl-6 col-md-6 col-sm-6" style="margin-top:0!important;">
											<?= $this->Form->control('EndDate', ['placeholder' => '( yyyy-mm-dd )', 'label' => false, 'class'=>'form-control', 'value'=>isset($toDate) ? $toDate : date('Y-m-d')]) ?>
											</div>
										</div>		
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<?= $this->Form->button(__('Generate Sheets'), ['name'=>'generateSheetBtn', 'class'=>'btn btn-primary m-t']) ?>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?= $this->Form->end() ?>
			 
		</div>
	</div>
	<?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
		<!---Using helper here--->
		<?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
	<?php } ?>
			
	<?php if(isset($pdfDownloadLinks) && !empty($pdfDownloadLinks)) { ?>
		<div class="col-lg-12"> 
			<div class="card" style="margin-top:15px">
				<div class="card-body"> 
					<?= $this->Lrs->pdfcsvDownloadLinks($pdfDownloadLinks) ?> 
				</div>
			</div>
		</div>  
	<?php  } ?>
</div>