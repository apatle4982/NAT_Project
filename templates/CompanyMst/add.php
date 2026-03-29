<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($companyMst, ['horizontal' => true, 'enctype' => 'multipart/form-data','action'=>'add']) ?>
<div class="col-lg-12 text-center btm-inline"> 
	<!-- <div style="display:inline-block;">
		<?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success', 'tabindex'=>8]); ?> 
	</div> 

	<div style="display:inline-block;"> 
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger', 'tabindex'=>9]) ?> 
	</div> --> 
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-4 col-md-4 col-sm-12">
							
							<div class="input-container-floating">	
								<label for="basiInput" class="form-label">Partner Name*</label>
	
								<?= $this->Form->control('cm_comp_name', ['label' => false, 'class'=>'form-control', 'required'=>false, 'pattern'=>'[A-Za-z _@./()]+', 'title'=>'Only letters and special character are allowed (_@./).', 'tabindex'=>1]) ?>
							</div>
							
						</div>
						<div class="col-xxl-4 col-md-4 col-sm-12">
							<div class="input-container-floating">
								
								<label for="basiInput" class="form-label">Main Contact</label>
								<?= $this->Form->control('cm_proper_name', ['label' => false, 'class'=>'form-control', 'pattern'=>'[A-Za-z0-9 _@./()]+', 'title'=>'Only letters, numbers and special character are allowed (_@./)', 'required' => false, 'tabindex'=>2]) ?>
								
							</div>
						</div>
						<div class="col-xxl-4 col-md-4 col-sm-12">
							
								<div class="input-container-floating">
								<label for="basiInput" class="form-label">Partner Id #</label>
								<div class="id_container"></div>
								</div>
						</div>
								
								
					</div>
					<div class="row gy-4">
						<div class="col-xxl-4 col-md-4 col-sm-12">
							
							<div class="input-container-floating">													
								<label for="basiInput" class="form-label">Phone</label>
								<?= $this->Form->control('cm_phone', ['label' => false, 'minlength'=>'10', 'maxlength'=>'15', 'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 -/()]+', 'title'=>'Only numbers and special character are allowed (/-).', 'tabindex'=>3]) ?>
							</div>
							
						</div>
						<div class="col-xxl-4 col-md-4 col-sm-12">
							
							<div class="input-container-floating">
								<label for="basiInput" class="form-label">Email Address*</label>
								<?= $this->Form->control('cm_email', ['label' => false, 'type'=>'email', 'class'=>'form-control', 'required'=>false, 'pattern'=>'[A-Za-z0-9_@-.]+', 'title'=>'Only letters and numbers are allowed.', 'tabindex'=>4]) ?>
							</div>
						</div>
								
						<div class="col-xxl-4 col-md-4 col-sm-12">
							<div class="input-container-floating">
								
								<label for="basiInput" class="form-label">Active</label>
								<div class="form-check">
								<?php echo $this->Form->radio('cm_active',
											[
												['value' => 'Yes', 'text'=>__('Yes')],
												['value' => 'No', 'text' => __('No')],
											],
											['required'=>false,
											'default' => 'Yes', 'class'=>'', 'tabindex'=>5
											]); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
					
			</div> 
		</div>
	</div>
</div>
	<!--end row-->

<div class="col-lg-12 text-center btm-inline"> 
	<div style="display:inline-block;">
		<?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success', 'tabindex'=>6]); ?> 
	</div>
	<div style="display:inline-block;"> 
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger', 'tabindex'=>7]) ?> 
	</div> 
</div>
<?= $this->Form->end() ?>	