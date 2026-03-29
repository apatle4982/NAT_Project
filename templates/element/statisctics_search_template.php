 
<div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-body">
				<div class="live-preview ">
					 				
					<div class="row">
				 
						<div class="col-xxl-4 col-md-4 col-sm-12">	
							<div class="row">
								
								<?php	if(!($user_Gateway)){ // only for porccessing gateway ?>
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">
									<label for="basiInput" class="form-label"><?= (isset($partnerMapField['mappedtitle']['company_id'])? ($partnerMapField['mappedtitle']['company_id'] != 'company_id') ? $partnerMapField['mappedtitle']['company_id']: 'Partner' : 'Partner') ?></label>
									
									<?php 
										echo $this->Form->control('company_id', ['value' => isset($formpostdata['company_id'])? $formpostdata['company_id']: '', 'options' => $companyMsts, 'multiple' => false, 'empty' => 'Select Partner', 'class'=>'form-control','label'=>false, 'required'=>false]);
									?>
									</div>
								</div>
								<?php } ?> 
					 
									<div class="col-xxl-12 col-md-12">
										<div class="input-container-floating">
										<label for="basiInput" class="form-label"><strong><?= ((isset($partnerMapField['mappedtitle']['TransactionType']) && (!empty($partnerMapField['mappedtitle']['TransactionType']))) ? $partnerMapField['mappedtitle']['TransactionType']: 'Document Type'); ?></strong></label>
										<?php
											echo $this->Form->control('TransactionType', [
												'value' => isset($formpostdata['TransactionType'])? $formpostdata['TransactionType']: '', 
												'options' => $DocumentTypeData, 
												'multiple' => false, 
												'empty' => 'Select Document Type',
												'label' => [ 
														'text' => ((isset($partnerMapField['mappedtitle']['TransactionType']) && (!empty($partnerMapField['mappedtitle']['TransactionType']))))? $partnerMapField['mappedtitle']['TransactionType']: 'Document Type',
														'escape' => false
												],
												'class'=>'form-control', 
												'label'=>false,
												'required'=>false
											]);
									
										?>
										</div>
									</div>
								</div>
								</div>
								<div class="col-xxl-2 col-md-4 col-sm-12">	
								<div class="row">  

									<div class="col-xxl-12 col-md-12">
										<div class="input-container-floating">
										<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['State']) ? $partnerMapField['mappedtitle']['State']: 'State') ?></strong></label>
										<?php
											echo $this->Form->control('State', [
												'value' => isset($formpostdata['State'])? $formpostdata['State']: '', 
												'options' => $StateData, 
												'multiple' => false, 
												'empty' => 'Select State',
												'label' => [ 
														'text' => ((isset($partnerMapField['mappedtitle']['State']) && (!empty($partnerMapField['mappedtitle']['State']))))? $partnerMapField['mappedtitle']['State']: 'State',
														'escape' => false
												],
												'class'=>'form-control', 
												'label'=>false,
												'required'=>false
											]);
									
										?>
									 
										</div>
									</div>
								 
									<div class="col-xxl-12 col-md-12">
										<div class="input-container-floating">
										<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County') ?></strong></label>
										<?php
											echo $this->Form->control('County', [
												'value' => isset($formpostdata['County'])? $formpostdata['County']: '', 
												'options' => $CountyData, 
												'multiple' => false, 
												'empty' => 'Select County',
												'label' => [ 
														'text' => ((isset($partnerMapField['mappedtitle']['County']) && (!empty($partnerMapField['mappedtitle']['County']))))? $partnerMapField['mappedtitle']['County']: 'County',
														'escape' => false
												],
												'class'=>'form-control', 
												'label'=>false,
												'required'=>false
											]);
									
										?>
										</div>
									</div>
								</div>
								</div>
								<div class="col-xxl-4 col-md-4 col-sm-12">	
								<div class="row">
									<div class="col-xxl-12 col-md-12 col-sm-12">
										<div class="input-container-floating">
											<label for="basiInput" class="form-label">Start Date</label>
											<div class="two-input">
												<div class="row">
													<div class="col-xxl-12 col-md-12 col-sm-12">
													<?php echo $this->Form->control('startDate', ['value'=>isset($formpostdata['startDate'])? $formpostdata['startDate']: '' ,
													'label' => false, 
													'class'=>'form-control f-control-withdtspan', 'placeholder' => '(yyyy-mm-dd)', 'required'=>false]); ?>
													
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-12 col-md-12 col-sm-12">
										<div class="input-container-floating">
											<label for="basiInput" class="form-label">End Date</label>
											<div  class="two-input">
												<div class="row">
													<div class="col-xxl-12 col-md-12 col-sm-12">
													<?php echo $this->Form->control('endDate', ['value'=>isset($formpostdata['endDate'])? $formpostdata['endDate']: '' ,
													'label' => false, 
													'class'=>'form-control f-control-withdtspan', 'placeholder' => '(yyyy-mm-dd)', 'required'=>false]); ?>
												
													</div>
												</div>
											</div>
										</div>
									</div>
									 
								</div>
								</div>
								<div class="col-xxl-2 col-md-2 col-sm-12">	
								<div class="row"> 
									<div class="col-xxl-12 col-md-12 col-sm-12">
										<div class="submit">
											<?php echo $this->Form->button(__('Search'), ['class'=>'btn btn-success','id'=>'searchBtnId']); ?>
										</div>
									</div>	
									<div class="col-xxl-12 col-md-12 col-sm-12">
										<div class="submit">
											<?php echo $this->Html->link(__('Clear'), ['action'=> $this->request->getParam('action')],['class'=>'btn btn-danger']); ?>
										</div>
									</div>
									 
								</div>
								</div>
								 
							</div>
							 	
						
					</div>								
				</div>
			</div>
		</div>
		
		 
								
	</div>
</div>