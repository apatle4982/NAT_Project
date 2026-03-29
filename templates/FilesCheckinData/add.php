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
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['StreetNumber'])) ? $partnerMapFields['mappedtitle']['StreetNumber'] : 'Street Number');?></label>
								<?php 	echo $this->Form->control('StreetNumber', 
									['label'=>false, 'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['StreetName'])) ? $partnerMapFields['mappedtitle']['StreetName'] : 'Street Name') ?></label>
								<?php echo $this->Form->control('StreetName', 
								['label'=>false, 'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">City</label>
								<?php echo $this->Form->control('City', 
								['label'=>['text'=>(isset($partnerMapFields['mappedtitle']['City'])) ? $partnerMapFields['mappedtitle']['City'] : 'City', 'escape'=>false],
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)' , 'label'=>false]); ?>
							
							</div>
											 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Zip</label>
								<?php echo $this->Form->control('Zip', 
								['label'=>['text'=>(isset($partnerMapFields['mappedtitle']['Zip'])) ? $partnerMapFields['mappedtitle']['Zip'] : 'Zip','escape'=>false],
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'label'=>false]); ?>
							
							</div>
											 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['State'])) ? $partnerMapFields['mappedtitle']['State'].' <span style="color:#CA3F48">*</span></label>' : 'State'.' <span style="color:#CA3F48">*</span></label>'); ?></label>
								<?php echo $this->Form->control('State', 
								['label'=>false,
								'options' => $StateList, 'onchange'=>'getCounty(this.value,"company_div")', 'multiple' => false, 'empty' => 'Select State','class'=>'form-control', 'required'=>true]); ?>
							</div>
											 
						</div>
						
					
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['County'])) ? $partnerMapFields['mappedtitle']['County'] : 'County'); ?> <span style="color:#CA3F48">*</span></label>
								<div id="company_div">
								<?php echo $this->Form->control('County', ['label'=>false, 'options' => $CountyList, 'multiple' => false, 'empty' => 'Select County','class'=>'form-control', 'required'=>true]); ?>
								</div>
								<div class="single-btn">
									<label class="form-label mb-0 label-nt-vis">test</label>
									<input type="button"  onclick="window.open('<?= $this->Url->build(["controller" => "CountyMst","action" => "add"]) ?>','','top=70,width=1200,height=620,left=80,right=50')" name="txtx" value="Add County" class="btn btn-success" title="Add County">
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
	
	<!-- Grantees start-->
	<div class="col-xxl-4 col-md-4 col-sm-12">
		 
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['Grantors'])) ? $partnerMapFields['mappedtitle']['Grantors'] : 'Grantor')?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['Grantors'])) ? $partnerMapFields['mappedtitle']['Grantors'] : 'Grantor(s)');?></label>
								<?php echo $this->Form->control('Grantors', ['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
									
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['GrantorFirstName1'])) ? $partnerMapFields['mappedtitle']['GrantorFirstName1'] : 'Grantor First Name (1)'); ?></label>
								
								<?php echo $this->Form->control('GrantorFirstName1', ['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['GrantorFirstName2'])) ? $partnerMapFields['mappedtitle']['GrantorFirstName2'] : 'Grantor First Name (2)'); ?></label>
								
								<?php echo $this->Form->control('GrantorFirstName2', ['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['GrantorMaritalStatus'])) ? $partnerMapFields['mappedtitle']['GrantorMaritalStatus'] : 'Grantor Marital Status'); ?></label>
								
								<?php echo $this->Form->control('GrantorMaritalStatus', ['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['GrantorCorporationName'])) ? $partnerMapFields['mappedtitle']['GrantorCorporationName'] : 'Grantor Corporation Name'); ?></label>
								
								<?php echo $this->Form->control('GrantorCorporationName', ['label'=>false,
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
			<!-- Grantees end-->

			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['Grantees'])) ? $partnerMapFields['mappedtitle']['Grantees'] : 'Grantee'); ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['Grantees'])) ? $partnerMapFields['mappedtitle']['Grantees'] : 'Grantee(s)')?></label>
								
								<?php echo $this->Form->control('Grantees', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['GranteeFirstName1'])) ? $partnerMapFields['mappedtitle']['GranteeFirstName1'] : 'Grantee First Name (1)');?></label>
								
								<?php echo $this->Form->control('GranteeFirstName1', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['GranteeFirstName2'])) ? $partnerMapFields['mappedtitle']['GranteeFirstName2'] : 'Grantee First Name (2)');?></label>
								
								<?php echo $this->Form->control('GranteeFirstName2', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<?php
						if(isset($partnerMapFields['fieldsvalsMGE'])){
						foreach($partnerMapFields['fieldsvalsMGE'] as $fieldsvalMGE){ ?>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalMGE['cfm_maptitle'])) ? $fieldsvalMGE['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>
								<?php  echo $this->Form->control($fieldsvalMGE['fm']['fm_title'], 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']);?>
							</div>
						</div>
						<?php }
						} ?>
					</div>									 
				</div>
				<!--end row-->
			</div>
			<!-- Document Received end-->
			
			
			<!-- Mortgagor Grantor(s) -->
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['MortgagorGrantors'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantors'] : 'Mortgagor'); ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['MortgagorGrantors'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantors'] : 'Mortgagor Grantor(s)')?></label>
								
								<?php echo $this->Form->control('MortgagorGrantors', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['MortgagorGrantorFirstName1'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantorFirstName1'] : 'Mortgagor Grantor First Name (1)');?></label>
								
								<?php echo $this->Form->control('MortgagorGrantorFirstName1', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['MortgagorGrantorFirstName2'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantorFirstName2'] : 'Mortgagor Grantor First Name (2)');?></label>
								
								<?php echo $this->Form->control('MortgagorGrantorFirstName2', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<?php
						if(isset($partnerMapFields['fieldsvalsMGE'])){
						foreach($partnerMapFields['fieldsvalsMGE'] as $fieldsvalMGE){ ?>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalMGE['cfm_maptitle'])) ? $fieldsvalMGE['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>
								<?php  echo $this->Form->control($fieldsvalMGE['fm']['fm_title'], 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']);?>
							</div>
						</div>
						<?php }
						} ?>
					</div>									 
				</div>
				<!--end row-->
			</div>
			<!-- Mortgagor Grantor(s) end-->
			
			
			<!--Mortgagee -->
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['MortgageeLenderCompanyName'])) ? $partnerMapFields['mappedtitle']['MortgageeLenderCompanyName'] : 'Mortgagee'); ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['MortgageeLenderCompanyName'])) ? $partnerMapFields['mappedtitle']['MortgageeLenderCompanyName'] : 'Mortgagee Lender/Company Name')?></label>
								
								<?php echo $this->Form->control('MortgageeLenderCompanyName', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['MortgageeFirstName1'])) ? $partnerMapFields['mappedtitle']['MortgageeFirstName1'] : 'Mortgagee Lender First Name (1)');?></label>
								
								<?php echo $this->Form->control('MortgageeFirstName1', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['MortgageeFirstName2'])) ? $partnerMapFields['mappedtitle']['MortgageeFirstName2'] : 'Mortgagee Lender First Name (2)');?></label>
								
								<?php echo $this->Form->control('MortgageeFirstName2', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div> 
						</div>
						
						<?php
						if(isset($partnerMapFields['fieldsvalsMGE'])){
						foreach($partnerMapFields['fieldsvalsMGE'] as $fieldsvalMGE){ ?>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalMGE['cfm_maptitle'])) ? $fieldsvalMGE['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>
								<?php  echo $this->Form->control($fieldsvalMGE['fm']['fm_title'], 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']);?>
							</div>
						</div>
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
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['NATFileNumber'])) ? $partnerMapFields['mappedtitle']['NATFileNumber'].' <span style="color:#CA3F48">*</span></label>' : 'NAT File Number' .' <span style="color:#CA3F48">*</span></label>');?></label>
								
								<?php echo $this->Form->control('NATFileNumber', 
								['label'=>false,
								'class'=>'form-control', 'value'=>$NATFileNumber, 'required'=>true,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['PartnerFileNumber'])) ? $partnerMapFields['mappedtitle']['PartnerFileNumber'].' <span style="color:#CA3F48">*</span></label>' : 'Partner File Number'.' <span style="color:#CA3F48">*</span></label>');?></label>
								<?php echo $this->Form->control('PartnerFileNumber', 
								['label'=>false, 'class'=>'form-control', 'required'=>true, 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['FileStartDate'])) ? $partnerMapFields['mappedtitle']['FileStartDate'].' <span style="color:#CA3F48">*</span></label>'  : 'FileStartDate'.' <span style="color:#CA3F48">*</span></label>');?></label>
								
								<div class="input-daterange" id="datepicker">
								<?php echo $this->Form->control('FileStartDate', 
								['label'=>false ,
								'type'=>'text','class'=>'form-control', 'required'=>true, 'title'=>'Only numbers and special character are allowed (/ ).', 'placeholder' => '(yyyy-mm-dd)', 'value'=>date('Y-m-d H:i:s')]); ?>
								</div>
						
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Center/Branch</label>
								<?php echo $this->Form->control('CenterBranch', ['label'=>false,'class'=>'form-control', 'required'=>false]); ?>
							</div>	 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['LoanAmount'])) ? $partnerMapFields['mappedtitle']['LoanAmount'] : 'Loan Amount'); ?></label>
								<?php echo $this->Form->control('LoanAmount', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Transaction Type</label>
								<?php echo $this->Form->control('TransactionType', ['label'=>false,'type'=>'text', 'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 ,]+', 'placeholder'=>'Number only (seperated by " , ")']); ?>
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
								
								<?php echo $this->Form->control('LegalDescriptionShortLegal', ['label'=>false, 'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
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
	
	function  getCounty(StateId, divId){ 
		$.ajax({
		  method: "POST",
		  url : '<?= $this->Url->build(["controller" => 'files-checkin-data',"action" => "searchCountyAjax"]) ?>',
		  data: { id: StateId},
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