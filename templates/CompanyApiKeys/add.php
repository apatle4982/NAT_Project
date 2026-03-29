<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Form->create($apiKey, ['horizontal' => true, 'enctype' => 'multipart/form-data','action'=>'add']) ?>
<div class="col-lg-12 text-center btm-inline"> 
	<div style="display:inline-block;">
		<?= $this->Form->submit(__('Create Secret Key'),['class'=>'btn btn-success', 'tabindex'=>8]); ?> 
	</div> 

	<div style="display:inline-block;"> 
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger', 'tabindex'=>9]) ?> 
	</div> 
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-4 col-md-4 col-sm-12">
							
							<div class="input-container-floating">	
								<label for="basiInput" class="form-label">Select Patner*</label>
	
								<?= $this->Form->control('company_id', ['options' => $companies,'empty' => '-- Select Company --','required' => true,'label' => false, 'class'=>'form-control']) ?>
							</div>
							
						</div>
						<div class="col-xxl-4 col-md-4 col-sm-12">
							<div class="input-container-floating">
								
								<label for="basiInput" class="form-label">Is Active</label>
								<?= $this->Form->control('is_active', ['type' => 'checkbox', 'label' => false]) ?>
								
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
		<?= $this->Form->submit(__('Create Secret Key'),['class'=>'btn btn-success', 'tabindex'=>6]); ?> 
	</div>
	<div style="display:inline-block;"> 
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger', 'tabindex'=>7]) ?> 
	</div> 
</div>
<?= $this->Form->end() ?>	