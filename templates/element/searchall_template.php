<?php
// Get the current controller and action
$currentController = $this->request->getParam('controller');
$currentAction = $this->request->getParam('action');
$slug = $currentController.'_'.$currentAction;
?>

<?php
	// implortant array to active/show widgets from search all element will chenge as per page requirment
	
	if(!isset($widgets)){
		// set default
		$widgets = ['noDate', 'RecordsAdded', 'ProcessedNot', 'ShippingStatus', 'Research', $slug];
	}
	
	if(!isset($is_generate)){
		$is_generate = false;
	}
	
	if(!isset($is_fedEx)){
		$is_fedEx = false;
	}
?>
<div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-body">
				<div class="live-preview ">
					 				
					<div class="row">
						<div class="col-xxl-11 col-md-10 col-sm-12 long-lbl-frm frm-dv-lft">
								
							<div class="row">
								
								<div class="col-xxl-4 col-md-4 col-sm-12">
								<?php if(!in_array('File',$widgets)){ ?>
									<h2>File</h2> 
									<div class="row">
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (((isset($partnerMapField['mappedtitle']['NATFileNumber']) && (!empty(trim($partnerMapField['mappedtitle']['NATFileNumber'])))))? $partnerMapField['mappedtitle']['NATFileNumber']: 'NAT File Number')?></strong></label>
											<?php echo $this->Form->control('NATFileNumber', [
											'label' => false,
											'value'=>isset($formpostdata['NATFileNumber'])? $formpostdata['NATFileNumber']: '' , 'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<?php
						
										if(!($user_Gateway)){ // only for porccessing gateway ?>
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
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'Partner File Number') ?></strong></label>
											<?php echo $this->Form->control('PartnerFileNumber', ['value'=>isset($formpostdata['PartnerFileNumber'])? $formpostdata['PartnerFileNumber']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>

											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= ((isset($partnerMapField['mappedtitle']['TransactionType']) && (!empty($partnerMapField['mappedtitle']['TransactionType']))) ? $partnerMapField['mappedtitle']['TransactionType']: 'Transaction Type'); ?></strong></label>
											<?php
													echo $this->Form->control('TransactionType', [
														'value' => isset($formpostdata['TransactionType'])? $formpostdata['TransactionType']: '', 
														'options' => $DocumentTypeData, 
														'multiple' => false, 
														'empty' => 'Select Transaction Type',
														'label' => [ 
																'text' => ((isset($partnerMapField['mappedtitle']['TransactionType']) && (!empty($partnerMapField['mappedtitle']['TransactionType']))))? $partnerMapField['mappedtitle']['TransactionType']: 'Transaction Type',
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
											<label for="basiInput" class="form-label"><strong><?= ((isset($partnerMapField['mappedtitle']['LoanNumber']) && (!empty($partnerMapField['mappedtitle']['LoanNumber'])))? $partnerMapField['mappedtitle']['LoanNumber']: 'Loan Number') ?></strong></label>
											<?php echo $this->Form->control('LoanNumber', ['value'=>isset($formpostdata['LoanNumber'])? $formpostdata['LoanNumber']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>

											</div>
										</div>
										<div class="col-xxl-12 col-md-12 col-sm-12">
											<div class="input-container-floating">
												<label for="basiInput" class="form-label">FileStartDate</label>
												<div class="two-input">
													<div class="row">
														<div class="col-xxl-12 col-md-12 col-sm-12">
														<?php echo $this->Form->control('FileStartDate', ['value'=>isset($formpostdata['FileStartDate'])? $formpostdata['FileStartDate']: '' ,
														'label' => false, 
														'class'=>'form-control f-control-withdtspan', 'required'=>false]); ?>
														<span class="frm-dt">( yyyy-mm-dd )</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--<div class="col-xxl-12 col-md-12 col-sm-12">
											<div class="input-container-floating">
												<label for="basiInput" class="form-label">File End Date</label>
												<div  class="two-input">
													<div class="row">
														<div class="col-xxl-12 col-md-12 col-sm-12">
														<?php echo $this->Form->control('FileEndDate', ['value'=>isset($formpostdata['FileEndDate'])? $formpostdata['FileEndDate']: '' ,
														'label' => false, 
														'class'=>'form-control f-control-withdtspan', 'required'=>false]); ?>
														<span class="frm-dt">( yyyy-mm-dd )</span>
														</div>
													</div>
												</div>
											</div>
										</div>-->
									</div>
								<?php } ?>	
								
								<?php if(!in_array('Property',$widgets)){ ?>								
									<h2>Property</h2>
									<div class="row">
									 
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= ((isset($partnerMapField['mappedtitle']['StreetNumber']) && (!empty($partnerMapField['mappedtitle']['StreetNumber'])))? $partnerMapField['mappedtitle']['StreetNumber']: 'Street Number') ?></strong></label>
											
											<?php echo $this->Form->control('StreetNumber', ['label' => false, 'value'=>isset($formpostdata['StreetNumber'])? $formpostdata['StreetNumber']: '' ,
											'label' => false,
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['StreetName'])? $partnerMapField['mappedtitle']['StreetName']: 'Street Name') ?></strong></label>
											<?php echo $this->Form->control('StreetName', ['value'=>isset($formpostdata['StreetName'])? $formpostdata['StreetName']: '' ,
												'label' => false,
												'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating">
												<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['City'])? $partnerMapField['mappedtitle']['City']: 'City') ?></strong></label>
												<?php echo $this->Form->control('City', [
												'label' => false, 'class'=>'form-control', 'required'=>false]); ?>
												</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['State']) ? $partnerMapField['mappedtitle']['State']: 'State') ?></strong></label>
											
											<?php echo $this->Form->control('State', [
															'label' => false,
														'value'=>isset($formpostdata['State'])? $formpostdata['State']: '' , 'class'=>'form-control', 'required'=>false]); ?>
					
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['County'])? $partnerMapField['mappedtitle']['County']: 'County') ?></strong></label>
											<?php echo $this->Form->control('County', ['value'=>isset($formpostdata['County'])? $formpostdata['County']: '' ,
												'label' =>false, 
												'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Zip'])? $partnerMapField['mappedtitle']['Zip']: 'Zip') ?></strong></label>
											<?php echo $this->Form->control('Zip', [ 'label' => false,
											'value'=>isset($formpostdata['Zip'])? $formpostdata['Zip']: '' , 'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
									</div>
									
									
								</div>
								<?php } ?>
								
								<?php if(!in_array('Mortgagor',$widgets)){ ?>
								<div class="col-xxl-4 col-md-4 col-sm-12">
									<div class="row mortage-padd">
										<H2>Grantors</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantor(s) ') ?></strong></label>
											<?php echo $this->Form->control('Grantors', ['value'=>isset($formpostdata['Grantors'])? $formpostdata['Grantors']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['GrantorFirstName1'])? $partnerMapField['mappedtitle']['GrantorFirstName1']: 'First Name (1)') ?></strong></label>
											<?php echo $this->Form->control('GrantorFirstName1', ['value'=>isset($formpostdata['GrantorFirstName1'])? $formpostdata['GrantorFirstName1']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['GrantorFirstName2'])? $partnerMapField['mappedtitle']['GrantorFirstName2']: 'First Name (2)') ?></strong></label>
											<?php echo $this->Form->control('GrantorFirstName2', ['value'=>isset($formpostdata['GrantorFirstName2'])? $formpostdata['GrantorFirstName2']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<H2>Grantee</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Grantees'])? $partnerMapField['mappedtitle']['Grantees']: 'Grantee(s)') ?></strong></label>
											<?php echo $this->Form->control('Grantees', ['value'=>isset($formpostdata['Grantees'])? $formpostdata['Grantees']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['GranteeFirstName1'])? $partnerMapField['mappedtitle']['GranteeFirstName1']: 'First Name (1)') ?></strong></label>
											<?php echo $this->Form->control('GranteeFirstName1', ['value'=>isset($formpostdata['GranteeFirstName1'])? $formpostdata['GranteeFirstName1']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['GranteeFirstName2'])? $partnerMapField['mappedtitle']['GranteeFirstName2']: 'First Name (2)') ?></strong></label>
											<?php echo $this->Form->control('GranteeFirstName2', ['value'=>isset($formpostdata['GranteeFirstName2'])? $formpostdata['GranteeFirstName2']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
								
								<?php if(!in_array('Mortgagor',$widgets)){ ?>
								<div class="col-xxl-4 col-md-4 col-sm-12">
										
									<div class="row mortage-padd">
										
										
										<!-- Mortgagor Grantor(s) -->
										<H2>Mortgagor Grantor(s)</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgagorGrantors'])? $partnerMapField['mappedtitle']['MortgagorGrantors']: 'Grantor(s)') ?></strong></label>
											<?php echo $this->Form->control('MortgagorGrantors', ['value'=>isset($formpostdata['MortgagorGrantors'])? $formpostdata['MortgagorGrantors']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgagorGrantorFirstName1'])? $partnerMapField['mappedtitle']['MortgagorGrantorFirstName1']: 'First Name (1)') ?></strong></label>
											<?php echo $this->Form->control('MortgagorGrantorFirstName1', ['value'=>isset($formpostdata['MortgagorGrantorFirstName1'])? $formpostdata['MortgagorGrantorFirstName1']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgagorGrantorFirstName2'])? $partnerMapField['mappedtitle']['MortgagorGrantorFirstName2']: 'First Name (2)') ?></strong></label>
											<?php echo $this->Form->control('MortgagorGrantorFirstName2', ['value'=>isset($formpostdata['MortgagorGrantorFirstName2'])? $formpostdata['MortgagorGrantorFirstName2']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<!-- Mortgagor Grantor(s) end-->
										
										<!-- Mortgagee  -->
										<H2>Mortgagee</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgageeLenderCompanyName'])? $partnerMapField['mappedtitle']['MortgageeLenderCompanyName']: 'Lender/Company Name') ?></strong></label>
											<?php echo $this->Form->control('MortgageeLenderCompanyName', ['value'=>isset($formpostdata['MortgageeLenderCompanyName'])? $formpostdata['MortgageeLenderCompanyName']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgageeFirstName1'])? $partnerMapField['mappedtitle']['MortgageeFirstName1']: 'First Name (1)') ?></strong></label>
											<?php echo $this->Form->control('MortgageeFirstName1', ['value'=>isset($formpostdata['MortgageeFirstName1'])? $formpostdata['MortgageeFirstName1']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgageeFirstName2'])? $partnerMapField['mappedtitle']['MortgageeFirstName2']: 'First Name (2)') ?></strong></label>
											<?php echo $this->Form->control('MortgageeFirstName2', ['value'=>isset($formpostdata['MortgageeFirstName2'])? $formpostdata['MortgageeFirstName2']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<!-- Mortgagee end-->
										
										<?php if(!($user_Gateway)){ // only for porccessing gateway ?>
										<!--<H2>Partner Company</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong>Partner Company</strong></label>
											<?php
												echo $this->Form->control('cm_partner_cmp', [
													'value' => '', 
													'options' => $partnerCompanyList, 
													'multiple' => false, 
													'empty' => 'Select Partner Company',
													'label' =>false,
													'required'=>false,
													'class' => 'form-control'
												]);
											?>
											</div>
										</div>-->
										<?php } ?>
										
									</div>
								</div>
								<?php } ?>
							</div>
							
							<?php if(!in_array('Research',$widgets)){ ?>
							<div class="row">	
								<div class="col-xxl-4 col-md-4 col-sm-12">  
									<h2><?= __('E-File Enabled') ?></h2>
									<div class="row">
										<div class="col-xxl-12 col-md-12 col-sm-12">
											<div class="input-container-floating">
												<?= $this->Form->checkbox('cm_file_enabled', ['value' => 'Y','label' => 'E-File Enabled', 'required'=>false]) ?> <?= __('E-File Enabled') ?>
											</div>
										</div> 
									</div> 
								</div>

								<div class="col-xxl-4 col-md-4 col-sm-12">  
									<h2><?= __('Exclude Research Status') ?></h2>
									<div class="row">
										<div class="col-xxl-12 col-md-12 col-sm-12">
											<div class="input-container-floating">
												<?php 
												$chked = ($reseach_status1 == "S" ? "checked" : "");
												echo $this->Form->checkbox('reseach_status1', ['value' => 'S','label' => 'Success', 'required'=>false, "checked" =>$chked]) ?> <?= __('Success') ?>
												
												<?= $this->Form->checkbox('reseach_status2', ['value' => 'F','label' => 'Fail-No Find', 'required'=>false]) ?> <?= __('Fail-No Find') ?>
												
												<?= $this->Form->checkbox('reseach_status3', ['value' => 'E','label' => 'Fail-Effective Date', 'required'=>false]) ?> <?= __('Fail-Effective Date') ?>
											</div>
										</div> 
									</div> 
								</div>

								<div class="col-xxl-4 col-md-4 col-sm-12"> 
									<h2><?= __('Show Research Status') ?></h2>
									<div class="row">
										<div class="col-xxl-12 col-md-12 col-sm-12">
											<div class="input-container-floating">
												<?= $this->Form->checkbox('reseach_status4', ['value' => 'EF','label' => 'Fail-No Find or Fail-Effective Date', 'required'=>false]) ?> <?= __('Fail-No Find or Fail-Effective Date') ?>
											</div>
										</div> 
									</div>
								</div>
								 
							</div>
							<?php } ?>

							<div class="row">
								<?php if(!in_array('noDate',$widgets)){ ?>
								<div class="col-xxl-6 col-md-6 col-sm-6">
									<h2>Processing Dates (Format: yyyy-mm-dd)</h2>
									<div class="row">
										<!--<div class="col-xxl-4 col-md-4 col-sm-12">
											<div class="input-container-floating">
											
												<?php
												echo $this->Form->control('file_search_type', [
													'value' => isset($formpostdata['file_search_type'])? $formpostdata['file_search_type']: '', 
													'options' => $fileSearchType, 
													'multiple' => false, 
													'empty' => 'Select',
													'label' =>false,
													'required'=>false,
													'class' => 'form-control file_search_type',
												]);
												?>
											</div>
										</div>-->
										<div class="col-xxl-8 col-md-8 col-sm-12">
											<div style="width:100%; float:left;">
												<div class="row">
													<div class="col-xxl-6 col-md-6 col-sm-6" style="margin-top:0!important;">
													<span class="frm-to">From:</span>
													<?php echo $this->Form->control('StartDate', ['value'=>isset($formpostdata['StartDate'])? $formpostdata['StartDate']: '' ,
														'label' => false, 
														'class'=>'form-control f-control-withspan', 'required'=>false]); ?>
													</div>
													<div class="col-xxl-6 col-md-6 col-sm-6" style="margin-top:0!important;">
													<span class="frm-to">To:</span>
													<?php echo $this->Form->control('EndDate', ['value'=>isset($formpostdata['EndDate'])? $formpostdata['EndDate']: '' ,
														'label' => false, 
														'class'=>'form-control f-control-withspan', 'required'=>false]); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>

								<?php if(!in_array('ProcessedNot',$widgets)){ ?>
									<div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<h2>Processed/Not Processed</h2>

										<div class="row">
											<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating">
													<div class="form-check checkBox">
														<label class="form-check-label" for="flexRadioDefault2">
														Not Processed
														</label>
														<?php  
															$options = ['NP'=>'Not Processed'];
															echo $this->Form->input('processingstatus', [
																
																'type' => 'radio',
																'options' => $options,
																'required' => 'required',
																'label' => false,
																'default' => "NP",
																'class'=>'form-check-input'
																]); 
															?>
													</div>
													<div class="form-check checkBox">
														<label class="form-check-label" for="flexRadioDefault2">
														Processed
														</label>
														<?php  
															$options = ['P'=>'Processed'];
															echo $this->Form->input('processingstatus', [
																	
																'type' => 'radio',
																'options' => $options,
																'required' => 'required',
																'label' => false,
																'default' => "NP",
																'class'=>'form-check-input'
																]); 
															?>
													</div>
												</div>
											</div>

											 
										</div>
										 	
									</div>
								<?php } ?>


								<?php if(in_array('FilesQcData_index',$widgets)){ ?>
									<div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<h2>Status</h2>

										<div class="row">
											<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating">
													
													<div class="form-check checkBox">
														<label class="form-check-label" for="flexRadioDefault2">
														Not Processed
														</label>
														<?php  
															$options = ['p'=>'Processed'];
															echo $this->Form->input('searchQcRecordes', [
																	
																'type' => 'radio',
																'options' => $options,
																'required' => 'required',
																'label' => false,
																'default' => "p",
																'class'=>'form-check-input'
																]); 
															?>
													</div>

													<div class="form-check checkBox">
														<label class="form-check-label" for="flexRadioDefault2">
														RTP
														</label>
														<?php  
															$options = ['rtp'=>'RTP'];
															echo $this->Form->input('searchQcRecordes', [
																
																'type' => 'radio',
																'options' => $options,
																'required' => 'required',
																'label' => false,
																'default' => "p",
																'class'=>'form-check-input'
																]); 
															?>
													</div>

													<div class="form-check checkBox">
														<label class="form-check-label" for="flexRadioDefault2">
														RIH
														</label>
														<?php  
															$options = ['rih'=>'RIH'];
															echo $this->Form->input('searchQcRecordes', [
																
																'type' => 'radio',
																'options' => $options,
																'required' => 'required',
																'label' => false,
																'default' => "p",
																'class'=>'form-check-input'
																]); 
															?>
													</div>

													<div class="form-check checkBox">
														<label class="form-check-label" for="flexRadioDefault2">
														All
														</label>
														<?php  
															$options = ['all'=>'All'];
															echo $this->Form->input('searchQcRecordes', [
																
																'type' => 'radio',
																'options' => $options,
																'required' => 'required',
																'label' => false,
																'default' => "p",
																'class'=>'form-check-input'
																]); 
															?>
													</div>

												</div>
											</div>

											 
										</div>
										 	
									</div>
								<?php } ?>

							</div>
							
						</div>
						<div class="col-xxl-1 col-md-2 col-sm-12 btn-dv-rght">	
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
								<?php echo $this->Form->control('sno',['type'=>'hidden','id'=>'snoId','value'=>'']); ?>
								<?php echo $this->Form->control('docstatus',['type'=>'hidden','id'=>'docstatusId','value'=>'']); ?>
							</div>
						</div>
					</div>								
				</div>
			</div>
		</div>
		
		<div class="row gy-4" style="margin-bottom:15px;">
			<div class="col-xxl-6 col-md-6 col-sm-12">
				<div class="submit" style="text-align:left!important;">
					<?php /* if(isset($currentURL) && $currentURL == '/master-data/master-search' && $is_generate ) { 
						echo  $this->Form->button(__('Generate Sheetss'), ['name'=>'generateDataSheet', 'class'=>'btn btn-primary pull-left dreceived']); 
					  } */ ?>
					<?php if($isSearch == 1 && $is_generate){
						// $iclass = ($currentUser->user_Gateway) ? 'dreceived': 'dreceived'; .$iclass
						echo  $this->Form->button(__('Generate Sheet'), ['name'=>'generateDataSheet', 'id'=>'generateDataSheet', 'class'=>'btn btn-primary pull-left dreceived']); 
					}  ?>   
					<?php if($is_fedEx){
						echo  $this->Form->button(__('Process FedEx Mapping'), ['name'=>'fedexMapping', 'class'=>'btn btn-primary dreceived pull-left', 'id'=>'fedexMapping']); 
					}  ?>
				</div>
			</div>
		</div>
								
	</div>
</div>