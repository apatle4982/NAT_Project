<?php
/**
  * @var \App\View\AppView $this
  */
?>
			
<?= $this->Form->create($filesCheckinData, ['horizontal' => true]) ?>
<div class="row">
	<div class="col-lg-12 text-center btm-inline">
		<div class="submit">
		<?= $this->Form->submit(__('Save'),['class'=>'btn btn-success', 'name'=>'saveBtn']); ?> 
		</div>  
		<div class="submit">
		<?= $this->Form->submit(__('Save and Open Another'),['class'=>'btn btn-success', 'name'=>'saveOpenBtn' ]); ?>
		</div>

		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 					
	</div>
</div>
<div class="card" style="margin-top:15px">
	<div class="row">
		<div class="col-xxl-4 col-md-4 col-sm-12">
			 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							<label class="form-label mb-0">Partner <span style="color:#CA3F48">*</span></label></label>
							<?php echo $this->Form->control('company_id', ['type' => 'select','value' => $partner_id, 'label' => false, 'options' => $companyMsts, 'multiple' => false, 'empty' => 'Select Partner', 'escape'=>false, 'class'=>'form-control', 'required'=>true, 'onchange'=>'this.form.submit()']);?>
							<?= $this->Form->hidden('fmd_id', ['value'=>$fmd_id]); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Address</h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['street_number'])) ? $partnerMapFields['mappedtitle']['street_number'] : 'street_number');?></label>
								<?php 	echo $this->Form->control('street_number', 
									['label'=>false, 'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['street_name'])) ? $partnerMapFields['mappedtitle']['street_name'] : 'street_name') ?></label>
								<?php echo $this->Form->control('street_name', 
								['label'=>false, 'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">city</label>
								<?php echo $this->Form->control('city', 
								['label'=>['text'=>(isset($partnerMapFields['mappedtitle']['city'])) ? $partnerMapFields['mappedtitle']['city'] : 'city', 'escape'=>false],
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)' , 'label'=>false]); ?>
							
							</div>
											 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">zip</label>
								<?php echo $this->Form->control('zip', 
								['label'=>['text'=>(isset($partnerMapFields['mappedtitle']['zip'])) ? $partnerMapFields['mappedtitle']['zip'] : 'zip','escape'=>false],
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'label'=>false]); ?>
							
							</div>
											 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['state'])) ? $partnerMapFields['mappedtitle']['state'].' <span style="color:#CA3F48">*</span></label>' : 'state'.' <span style="color:#CA3F48">*</span></label>'); ?></label>
								<?php echo $this->Form->control('state', 
								['label'=>false,
								'options' => $stateList, 'onchange'=>'getCounty(this.value,"company_div")', 'multiple' => false, 'empty' => 'Select state','class'=>'form-control', 'required'=>true]); ?>
							</div>
											 
						</div>
						
					
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['county'])) ? $partnerMapFields['mappedtitle']['county'] : 'county'); ?> <span style="color:#CA3F48">*</span></label>
								<div id="company_div">
								<?php echo $this->Form->control('county', ['label'=>false, 'options' => $countyList, 'multiple' => false, 'empty' => 'Select county','class'=>'form-control', 'required'=>true]); ?>
								</div>
								<div class="single-btn">
									<label class="form-label mb-0 label-nt-vis">test</label>
									<input type="button"  onclick="window.open('<?= $this->Url->build(["controller" => "CountyMst","action" => "add"]) ?>','','top=70,width=1200,height=620,left=80,right=50')" name="txtx" value="Add county" class="btn btn-success" title="Add county">
								</div>   
							</div>
						</div>
						
						<?php 
							if(isset($partnerMapFields['fieldsvalsAD'])){
							foreach($partnerMapFields['fieldsvalsAD'] as $fieldsvalsAD) { ?>
							
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalsAD['cfm_maptitle'])) ? $fieldsvalsAD['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : ''); ?> </label>
								<?php echo $this->Form->control($fieldsvalsAD['fm']['fm_title'], ['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
									</div> 
								</div>
						<?php } } ?>										
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
						<!--<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label for="basiInput" class="form-label">Type</label>
								
								<?php
									echo $this->Form->radio('Public_Internal',
										[
											['value' => 'I', 'text'=>__('Internal')],
											['value' => 'P', 'text' => __('Public')],
										],['required'=>false, 'default' => 'P', 'class'=>'form-check-label']);
									?>
							</div>
						</div>-->
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							<label for="basiInput" class="form-label">Regarding</label>
							<?php echo $this->Form->control('Regarding', ['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'style'=>'height:50px;']); // onblur="changereasonnotes()" ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Public/ Internal Notes end -->		
		
	</div>
	
	<!-- grantees_g2 start-->
	<div class="col-xxl-4 col-md-4 col-sm-12">
		 
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['grantors_g1'])) ? $partnerMapFields['mappedtitle']['grantors_g1'] : 'Grantor')?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['grantors_g1'])) ? $partnerMapFields['mappedtitle']['grantors_g1'] : 'Grantor(s)');?></label>
								<?php echo $this->Form->control('grantors_g1', ['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
									
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['first_name_1_g1'])) ? $partnerMapFields['mappedtitle']['first_name_1_g1'] : 'First Name (1)'); ?></label>
								
								<?php echo $this->Form->control('first_name_1_g1', ['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['first_name_2_g1'])) ? $partnerMapFields['mappedtitle']['first_name_2_g1'] : 'First Name (2)'); ?></label>
								
								<?php echo $this->Form->control('first_name_2_g1', ['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						
						<?php
						if(isset($partnerMapFields['fieldsvalsMGR'])){
							foreach($partnerMapFields['fieldsvalsMGR'] as $fieldsvalsMGR){ ?>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($fieldsvalsMGR['cfm_maptitle'])) ? $fieldsvalsMGR['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : ''); ?></label>
								<?php 
							
								echo $this->Form->control($fieldsvalsMGR['fm']['fm_title'], 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>
							</div>
						<?php }
						} ?>
					</div>
																 
				</div>
					<!--end row-->
			</div>
			<!-- grantees_g2 end-->

			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['grantees_g2'])) ? $partnerMapFields['mappedtitle']['grantees_g2'] : 'Grantee'); ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['grantees_g2'])) ? $partnerMapFields['mappedtitle']['grantees_g2'] : 'Grantee(s)')?></label>
								
								<?php echo $this->Form->control('grantees_g2', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['first_name_1_g2'])) ? $partnerMapFields['mappedtitle']['first_name_1_g2'] : 'First Name (1)');?></label>
								
								<?php echo $this->Form->control('first_name_1_g2', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['first_name_2_g2'])) ? $partnerMapFields['mappedtitle']['first_name_2_g2'] : 'First Name (2)');?></label>
								
								<?php echo $this->Form->control('first_name_2_g2', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<?php
						if(isset($partnerMapFields['fieldsvalsMGE'])){
						foreach($partnerMapFields['fieldsvalsMGE'] as $fieldsvalMGE){ ?>
						<!--<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalMGE['cfm_maptitle'])) ? $fieldsvalMGE['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>
								<?php  echo $this->Form->control($fieldsvalMGE['fm']['fm_title'], 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']);?>
							</div>
						</div>-->
						<?php }
						} ?>
					</div>									 
				</div>
				<!--end row-->
			</div>
			<!-- Document Received end-->
			
			<!-- Mortgagor Grantor(s) -->
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['grantors_g3'])) ? $partnerMapFields['mappedtitle']['grantors_g3'] : 'Mortgagor'); ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['grantors_g3'])) ? $partnerMapFields['mappedtitle']['grantors_g3'] : 'Grantor(s)')?></label>
								
								<?php echo $this->Form->control('grantors_g3', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['first_name_1_g3'])) ? $partnerMapFields['mappedtitle']['first_name_1_g3'] : 'First Name (1)');?></label>
								
								<?php echo $this->Form->control('first_name_1_g3', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['first_name_2_g3'])) ? $partnerMapFields['mappedtitle']['first_name_2_g3'] : 'First Name (2)');?></label>
								
								<?php echo $this->Form->control('first_name_2_g3', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<?php
						if(isset($partnerMapFields['fieldsvalsMGE'])){
						foreach($partnerMapFields['fieldsvalsMGE'] as $fieldsvalMGE){ ?>
						<!--<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalMGE['cfm_maptitle'])) ? $fieldsvalMGE['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>
								<?php  echo $this->Form->control($fieldsvalMGE['fm']['fm_title'], 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']);?>
							</div>
						</div>-->
						<?php }
						} ?>
					</div>									 
				</div>
				<!--end row-->
			</div>
			<!-- Mortgagor Grantor(s) end-->
			
			<!-- Mortgagee -->
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['lender_company_name_g4'])) ? $partnerMapFields['mappedtitle']['lender_company_name_g4'] : 'Mortgagee'); ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['lender_company_name_g4'])) ? $partnerMapFields['mappedtitle']['lender_company_name_g4'] : 'Lender/Company Name')?></label>
								
								<?php echo $this->Form->control('lender_company_name_g4', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['first_name_1_g4'])) ? $partnerMapFields['mappedtitle']['first_name_1_g4'] : 'First Name (1)');?></label>
								
								<?php echo $this->Form->control('first_name_1_g4', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['first_name_2_g4'])) ? $partnerMapFields['mappedtitle']['first_name_2_g4'] : 'First Name (2)');?></label>
								
								<?php echo $this->Form->control('first_name_2_g4', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<?php
						if(isset($partnerMapFields['fieldsvalsMGE'])){
						foreach($partnerMapFields['fieldsvalsMGE'] as $fieldsvalMGE){ ?>
						<!--<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalMGE['cfm_maptitle'])) ? $fieldsvalMGE['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>
								<?php  echo $this->Form->control($fieldsvalMGE['fm']['fm_title'], 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']);?>
							</div>
						</div>-->
						<?php }
						} ?>
					</div>									 
				</div>
				<!--end row-->
			</div>
			<!-- Mortgagee end-->
			
			
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= __('Document Received') ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<?php
								echo $this->Form->radio('DocumentReceived',
								[
									['value' => 'Y', 'text'=>__('Yes')],
									['value' => 'N', 'text' => __('No')],
								],['required'=>false, 'default' => 'N', 'class'=>'form-check-label']);
								?>
							</div> 
						</div>
					</div>									 
				</div>
				<!--end row-->
			</div>
			<!-- Document Received end-->
			
		
	</div> <!-- 2 col close -->
	
	<div class="col-xxl-4 col-md-4 col-sm-12">
		
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= __('File') ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">										
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['nat_file_number'])) ? $partnerMapFields['mappedtitle']['nat_file_number'].' <span style="color:#CA3F48">*</span></label>' : 'NAT File Number'.' <span style="color:#CA3F48">*</span></label>');?></label>
								
								<?php echo $this->Form->control('nat_file_number', 
								['label'=>false,
								'class'=>'form-control', 'required'=>true, 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['partner_file_number'])) ? $partnerMapFields['mappedtitle']['partner_file_number'].' <span style="color:#CA3F48">*</span></label>' : 'Partner File Number'.' <span style="color:#CA3F48">*</span></label>');?></label>
								<?php echo $this->Form->control('partner_file_number', 
								['label'=>false, 'class'=>'form-control', 'required'=>true, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['file_start_date'])) ? $partnerMapFields['mappedtitle']['file_start_date'].' <span style="color:#CA3F48">*</span></label>'  : 'FileStartDate'.' <span style="color:#CA3F48">*</span></label>');?></label>
								<?php    //pr($filesCheckinData->file_start_date); ?>
								<div class="input-daterange" id="datepicker">
								<?php echo $this->Form->control('file_start_date', 
								['label'=>false ,
								'type'=>'text','class'=>'form-control', 'required'=>true, 'value'=>(isset($filesCheckinData['file_start_date']) ? date('Y-m-d H:i:s', strtotime($filesCheckinData['file_start_date'])) : '')]); ?>
								</div>
						
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Center/Branch</label>
								<?php echo $this->Form->control('CenterBranch', ['label'=>false,'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>	 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['loan_amount'])) ? $partnerMapFields['mappedtitle']['loan_amount'] : 'Loan Amount'); ?></label>
								<?php echo $this->Form->control('loan_amount', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Transaction Type</label>
								<?php echo $this->Form->control('transaction_type', ['label'=>false,'type'=>'text', 'value'=> $filesCheckinData['fcd']['transaction_type'], 'class'=>'form-control', 'required'=>false, 'placeholder'=>'Number only (seperated by " , ")']); ?>
								
								<?php echo $this->Form->control('documentTypeHidden', [ 'value'=>($filesCheckinData['transaction_type']==0) ? $filesCheckinData['fcd']['transaction_type'] : $filesCheckinData['fcd']['transaction_type'] , 'type'=>'hidden']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">APN/Parcel Number</label>
								
								<?php echo $this->Form->control('apn_parcel_number', ['label'=>false, 'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>														 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Legal Description (Short Legal)</label>
								
								<?php echo $this->Form->control('legal_description_short_legal', ['label'=>false, 'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>														 
						</div>
						
						<?php 
						if(isset($partnerMapFields['fieldsvalsFL'])){
						foreach($partnerMapFields['fieldsvalsFL'] as $fieldsvalFL){ ?>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalFL['cfm_maptitle'])) ? $fieldsvalFL['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>										
								<?php echo $this->Form->control($fieldsvalFL['fm']['fm_title'], 
								['label'=>false, 
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>
						</div>
						<?php } } ?>
							
					<!--end row-->
					</div> 
				</div>
			</div>
		
		</div>
	
	</div> <!-- row close -->
</div> <!-- card close -->
<?php if(isset($partnerMapFields['fieldsvalsPS'])){ ?>
<div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= __('Partner Specific Data') ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalsPS['cfm_maptitle'])) ? $fieldsvalsPS['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>					
							<?php
							foreach($partnerMapFields['fieldsvalsPS'] as $fieldsvalsPS){ ?>
							<?php echo $this->Form->control($fieldsvalsPS['fm']['fm_title'], 
							['label'=>false,
							'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							<?php } ?>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-lg-12 text-center btm-inline">
		<div class="submit">
		<?= $this->Form->submit(__('Save'),['class'=>'btn btn-success', 'name'=>'saveBtn']); ?> 
		</div>  
		<div class="submit">
		<?= $this->Form->submit(__('Save and Open Another'),['class'=>'btn btn-success', 'name'=>'saveOpenBtn' ]); ?>
		</div> 
	
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 					
	</div>
	
</div>
<!--- use helper to show Help---->

<?php if(!empty($partnerMapFields['help'])){ ?>
<div class="card" style="margin-top:15px">
	<div class="card-body">
	<?php 
	echo $this->Lrs->showMappingHelp($partnerMapFields['help']);
	?>
	</div>
</div>
<?php } ?>
<?= $this->Form->end() ?>
		
	
<?php $this->append('script') ?>


<script>
	
	function  getCounty(stateId, divId){ 
		$.ajax({
		  method: "POST",
		  url : '<?= $this->Url->build(["controller" => 'files-checkin-data',"action" => "searchCountyAjax"]) ?>',
		  data: { id: stateId},
		  error: function (xhr, error, code) {
				if(xhr.status == 500){
					alert("Your session has expired. Would you like to be redirected to the login page?");
					window.location.reload(true); return false;
				}
			}
		}).done(function(returnData){
			
			$('#'+divId).html(returnData);
			$("select").select2();
		});
	}
</script>
<?php $this->end() ?>