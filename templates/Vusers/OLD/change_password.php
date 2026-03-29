<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \Cake\Collection\CollectionInterface|string[] $groups
 */
?>	
<?= $this->Form->create($user) ?>
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
										<label for="basiInput" class="form-label">Old Password</label>
										<?= $this->Form->control('old_password', ['type' => 'password','templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?> 
									</div>
								</div>
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label">New Password</label>
										<?= $this->Form->control('new_password', ['type' => 'password','templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?> 
									</div>
								</div>
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label">Confirm Password</label>
										<?= $this->Form->control('confirm_password', ['type' => 'password','templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?> 
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
												<?php //= $this->Html->link('Cancel', ['controller' => 'Users', 'action' => 'index'], ['class' => 'btn btn-danger']) ?>
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