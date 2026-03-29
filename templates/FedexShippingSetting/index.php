<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FedexShippingSetting $fedexShippingSetting
 */
?>

<?= $this->Form->create($fedexShippingSetting) ?>
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
										<label for="basiInput" class="form-label">Sender Name</label>
										<?= $this->Form->control('s_name', ['label' => false, 'class'=>'form-control', 'required'=>true, 'pattern'=>'[A-Za-z0-9_@-.]+', 'title'=>'Only letters and special character are allowed (_@./)', 'tabindex'=>1]) ?>
									</div>
								</div>

								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating"> 
										<label for="basiInput" class="form-label">Sender Number</label>
										<?= $this->Form->control('s_number', ['label' => false, 'class'=>'form-control', 'required'=>true, 'tabindex'=>2]) ?>
									</div>
								</div>

								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating"> 
										<label for="basiInput" class="form-label">Sender Company Name</label>
										<?= $this->Form->control('s_company_name', ['label' => false, 'class'=>'form-control', 'required'=>true, 'pattern'=>'[A-Za-z0-9_@-.]+', 'title'=>'Only letters and special character are allowed (_@./)', 'tabindex'=>3]) ?>
									</div>
								</div>
								
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating"> 
										<label for="basiInput" class="form-label">Sender Address</label>
										<?= $this->Form->control('s_address', ['label' => false, 'class'=>'form-control', 'required'=>true, 'pattern'=>'[A-Za-z0-9_@-.]+', 'title'=>'Only letters, numbers and special character are allowed (_@./)', 'tabindex'=>4]) ?> 
									</div>
								</div>
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										
										<label for="basiInput" class="form-label">Sender Address1</label>
										<?= $this->Form->control('s_address1', ['label' => false, 'class'=>'form-control', 'required'=>false, 'pattern'=>'[A-Za-z0-9_@-.]+', 'title'=>'Only letters, numbers and special character are allowed (_@./)', 'tabindex'=>5]) ?>
										
									</div>
								</div>
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										
										<label for="basiInput" class="form-label">Sender City</label>
										<?= $this->Form->control('s_City', ['label' => false, 'class'=>'form-control', 'required'=>false, 'pattern'=>'[A-Za-z0-9_@-.]+', 'title'=>'Only letters and special character are allowed (_@./)', 'tabindex'=>6]) ?>
										
									</div>
								</div>
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										
										<label for="basiInput" class="form-label">Sender State</label>
										<?= $this->Form->control('s_State', ['label' => false, 'class'=>'form-control', 'required'=>false, 'pattern'=>'[A-Za-z0-9_@-.]+', 'title'=>'Only letters and special character are allowed (_@./)', 'tabindex'=>7]) ?>
										
									</div>
								</div>
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										
										<label for="basiInput" class="form-label">Sender Zip</label>
										<?= $this->Form->control('s_zip', ['label' => false, 'class'=>'form-control', 'required'=>false, 'pattern'=>'[A-Za-z0-9_@-.]+', 'title'=>'Only letters and special character are allowed (_@./)', 'tabindex'=>8]) ?>
										
									</div>
								</div>
								
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										
										<label for="basiInput" class="form-label">Sender Country</label>
										<?= $this->Form->control('s_country',['type' => 'select','options' => ['US' => __('US')],'class' => 'form-control','required' => false, 'label' => false, 'tabindex'=>9]) ?>
									</div>
								</div>
 
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										
										<label for="basiInput" class="form-label">Default Currency</label>
										<?= $this->Form->control('s_defaultCurrency',['type' => 'select','options' => ['USD' => __('USD')],'class' => 'form-control','required' => false, 'label' => false, 'tabindex'=>10]) ?>
									</div>
								</div>
								
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										
										<label for="basiInput" class="form-label">Weight Unit</label>
										<?= $this->Form->control('s_fedexWeight_unit',['type' => 'select','options' => ['LB' => __('LBS')],'class' => 'form-control','required' => false, 'label' => false, 'tabindex'=>11]) ?>
									</div>
								</div>

								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating"> 
										<label for="basiInput" class="form-label">Weight Value</label> 
										<?= $this->Form->control('s_fedexWeight', ['label' => false, 'class'=>'form-control', 'required'=>true, 'pattern'=>'[0-9]+', 'title'=>'Only numbers are allowed.', 'tabindex'=>11]) ?>
									</div>
								</div>
								  
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label label-nt-vis">Test</label>
										<div class="col-lg-12 text-left btm-inline mob-btn-inline"> 
											<div style="display:inline-block;">
												<div class="submit"><?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success', 'tabindex'=>27]); ?></div> 
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