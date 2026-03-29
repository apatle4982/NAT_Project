<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeMaster $chargeMaster
 */
?>
<div class="row">
	<div class="col-12">
		<?= $this->Html->link(__('List Charge Master'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
	</div>
</div>


<?= $this->Form->create($chargeMaster) ?>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-6 col-md-6 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12 col-sm-12">
									
									<div class="input-container-floating">													
										<label for="basiInput" class="form-label">Charge Title</label>
										<?= $this->Form->control('cgm_title', ['label' => false, 'class'=>'form-control', 'required'=>false]) ?>
										
									</div>
									
								</div>
								<div class="col-xxl-12 col-md-12 col-sm-12">
									
									<div class="input-container-floating">
									<label for="basiInput" class="form-label">Test/Live mode::</label>
									<?= $this->Form->control('cgm_type',['type' => 'select','options' => [''=>__('Select charge type'),'R' => __('Recording Fee') , 'T' => __('Taxes'), 'A' => __('Additional Fees')],'class' => 'form-control','required' => false,'label' => false]) ?>
									</div>
								</div>
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label label-nt-vis">Test</label>
										<div class="col-lg-12 text-left btm-inline mob-btn-inline"> 
											<div style="display:inline-block;">
												<div class="submit"><?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success']); ?></div> 
											</div> 
											<div style="display:inline-block;"> 
												<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end row-->
						</div>
						
					</div>
				</div>
					
			</div> 
		</div>
	</div>
</div>
<!--end row-->

<?= $this->Form->end() ?>