<?php
/**
  * @var \App\View\AppView $this
  */
?>

<?= $this->Form->create($FilesExamReceipt, ['type' => 'file', 'horizontal' => true]) ?>
<div class="row">
	<div class="col-lg-12 text-center btm-inline">
		<div class="submit">
		<?= $this->Form->submit(__('Save'),['class'=>'btn btn-success', 'name'=>'saveBtn']); ?> 
		</div>

		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 					
	</div>
</div>
<div class="card" style="margin-top:15px">

	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<!-- /*1*/ -->
				<div class="col-xxl-4 col-md-4 col-sm-12">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Official Property Address as Titled</h4> 
					</div>
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
				</div>
				<!-- /*2*/ -->
				<div class="col-xxl-4 col-md-4 col-sm-12">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Official Property Address as Titled</h4> 
					</div>
					<div class="card-body">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">	
										<label class="form-label mb-0">Property Address</label>
										<?php 	echo $this->Form->control('OfficialPropertyAddress', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OfficialPropertyAddress'], 'title'=>'Only letters, numbers and special character are allowed (_@./)','style'=>'margin-bottom:6px !important;']); ?>
											<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>

										<label class="form-label mb-0">City</label>
										<?php echo $this->Form->control('OfficialPropertyCity', 
										['label'=>['text'=>(isset($partnerMapFields['mappedtitle']['City'])) ? $partnerMapFields['mappedtitle']['City'] : 'City', 'escape'=>false],
										'class'=>'form-control', 'required'=>false,'value' => $examReceiptFields['OfficialPropertyCity'],  'title'=>'Only letters, numbers and special character are allowed (_@./)' , 'label'=>false,'style'=>'margin-bottom:6px !important;']); ?>

										<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['State'])) ? $partnerMapFields['mappedtitle']['State'].'</label>' : 'State'.' <span style="color:#CA3F48">*</span></label>'); ?></label>
											<?php echo $this->Form->control('OfficialPropertyState', 
											['label'=>false,
											'options' => $StateList,'value' => $examReceiptFields['OfficialPropertyState'], 'onchange'=>'getCounty(this.value,"company_div")', 'multiple' => false, 'empty' => 'Select State','class'=>'form-control', 'required'=>false,'style'=>'margin-bottom:6px !important;']); ?>	

										<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['County'])) ? $partnerMapFields['mappedtitle']['County'] : 'County'); ?></label>
										<div id="company_div">
											<?php echo $this->Form->control('OfficialPropertyCounty', ['label'=>false, 'options' => $CountyList,'value' => $examReceiptFields['OfficialPropertyCounty'], 'multiple' => false, 'empty' => 'Select County','class'=>'form-control', 'required'=>false,'style'=>'margin-bottom:6px !important;']); ?>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /*3*/ -->
				<div class="col-xxl-4 col-md-4 col-sm-12">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">File</h4> 
					</div>
					<div class="card-body">
						<div class="live-preview ">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">										
										<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['NATFileNumber'])) ? $partnerMapFields['mappedtitle']['NATFileNumber'].' <span style="color:#CA3F48">*</span></label>' : 'NAT File Number'.' <span style="color:#CA3F48">*</span></label>');?></label>
										
										<?php echo $this->Form->control('NATFileNumber', 
										['label'=>false,
										'class'=>'form-control', 'required'=>true, 'value' => $FilesMainData['NATFileNumber'], 'readonly'=>'readonly', 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
									</div>		 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- /*Column Rowe*/ -->
		</div><!-- /*Column*/ -->
	</div><!-- /*Main Row*/ -->

	<!-- /*Vesting Row*/ -->
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Vesting - Chain of Title Information<span title="Add New Vesting Details" style="font-size: 17px; float: right;border: 1px solid #f1702b;border-radius: 12px;padding: 0px 6px;cursor: pointer;background-color: #f1702b; color: #FFF;" onclick="addFieldGroup('vesting')">+</span></h4> 
					</div>
				</div>
			</div>
			<?php 
			$buttonIndex=0;
			if (empty($vesting_attributes)) {
				$vesting_attributes[0]['VestingDeedType'] ="";
			} ?>
			<?php if (!empty($vesting_attributes)) { ?>
			<?php foreach ($vesting_attributes as $index => $vesting_attribute) { $buttonIndex++; ?>
			<div class="vesting-field-group-<?php echo $index;?> vesting-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
				<!-- <div class="row">
					<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
						<div class="card-header align-items-center d-flex" style="border: none !important;">
							<h4 class="card-title mb-0 flex-grow-1">#<?php echo $buttonIndex; ?> Vesting</h4> 
						</div>
					</div>
				</div> -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">	
											<label class="form-label mb-0">Deed Type</label>
											<?php 	echo $this->Form->control("vesting_attributes[".$index."][VestingDeedType]", 
												['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $vesting_attribute['VestingDeedType'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Consideration Amount</label>
											<?php echo $this->Form->control("vesting_attributes[".$index."][VestingConsiderationAmount]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $vesting_attribute['VestingConsiderationAmount'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Vested As (Grantee)</label>
											<?php echo $this->Form->control("vesting_attributes[".$index."][VestedAsGrantee]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $vesting_attribute['VestedAsGrantee'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>		 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Grantor</label>
											<?php echo $this->Form->control("vesting_attributes[".$index."][VestingGrantor]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $vesting_attribute['VestingGrantor'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Dated</label>
											<?php echo $this->Form->control("vesting_attributes[".$index."][VestingDated]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($vesting_attribute['VestingDated']) ? $vesting_attribute['VestingDated'] : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Recorded Date</label>
											<?php echo $this->Form->control("vesting_attributes[".$index."][VestingRecordedDate]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($vesting_attribute['VestingRecordedDate']) ? $vesting_attribute['VestingRecordedDate'] : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Book/Page</label>
											<?php echo $this->Form->control("vesting_attributes[".$index."][VestingBookPage]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $vesting_attribute['VestingBookPage'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Instrument #</label>
											<?php echo $this->Form->control("vesting_attributes[".$index."][VestingInstrument]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $vesting_attribute['VestingInstrument'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Comments</label>
											<?php echo $this->Form->control("vesting_attributes[".$index."][VestingComments]", 
											['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $vesting_attribute['VestingComments'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:40px;']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<?php if($index > 0) { ?>
				<button class="btn btn-danger mt-2 remove-btn" onclick="removeFieldGroup('vesting',<?php echo $index;?>)" style="margin: 0px 15px 15px;" type="button">#<?php echo $buttonIndex; ?> Remove</button>
			<?php } ?>
			</div><!-- /*Vesting Main Container*/ -->
			<?php } ?>
			<?php } ?>
			<div class="vesting-fields-container-clone">
			</div>
		</div><!-- /*Vesting Column*/ -->
	</div><!-- /*Vesting Main Row*/ -->

	<!-- /*Open Mortgage Row*/ -->
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Open Mortgage Information<span title="Add New Vesting Details" style="font-size: 17px; float: right;border: 1px solid #f1702b;border-radius: 12px;padding: 0px 6px;cursor: pointer;background-color: #f1702b; color: #FFF;" onclick="addFieldGroup('open-mortgage')">+</span></h4> 
					</div>
				</div>
			</div>
			<?php 
			$buttonIndex=0;
			if (empty($open_mortgage_attributes)) {
				$open_mortgage_attributes[0]['VestingDeedType'] ="";
			} ?>
			<?php if (!empty($open_mortgage_attributes)) { ?>
			<?php foreach ($open_mortgage_attributes as $index => $open_mortgage_attribute) { $buttonIndex++; ?>
			<div class="open-mortgage-field-group-<?php echo $index;?> open-mortgage-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
				<!-- <div class="row">
					<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
						<div class="card-header align-items-center d-flex" style="border: none !important;">
							<h4 class="card-title mb-0 flex-grow-1">#<?php echo $buttonIndex; ?> Open Mortgage</h4> 
						</div>
					</div>
				</div> -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">	
											<label class="form-label mb-0">Amount $</label>
											<?php 	echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageAmount]", 
												['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_mortgage_attribute['OpenMortgageAmount'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
												<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Dated</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageDated]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($open_mortgage_attribute['OpenMortgageDated']) ? $open_mortgage_attribute['OpenMortgageDated'] : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Recorded (Date)</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageRecordedDate]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($open_mortgage_attribute['OpenMortgageRecordedDate']) ? $open_mortgage_attribute['OpenMortgageRecordedDate'] : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->

				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Book/Page</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageBookPage]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_mortgage_attribute['OpenMortgageBookPage'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Instrument #</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageInstrument]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_mortgage_attribute['OpenMortgageInstrument'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Borrower (Mortgagor)</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageBorrowerMortgagor]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_mortgage_attribute['OpenMortgageBorrowerMortgagor'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->

				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Lender (Mortgagee)</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageLenderMortgagee]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_mortgage_attribute['OpenMortgageLenderMortgagee'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Trustee 1</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageTrustee1]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_mortgage_attribute['OpenMortgageTrustee1'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Trustee 2</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageTrustee2]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_mortgage_attribute['OpenMortgageTrustee2'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>	 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->

				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Comments</label>
											<?php echo $this->Form->control("open_mortgage_attributes[".$index."][OpenMortgageComments]", 
											['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $open_mortgage_attribute['OpenMortgageComments'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:40px;']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">	 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<?php if($index > 0) { ?>
				<button class="btn btn-danger mt-2 remove-btn" onclick="removeFieldGroup('open-mortgage',<?php echo $index;?>)" style="margin: 0px 15px 15px;" type="button">#<?php echo $buttonIndex; ?> Remove</button>
			<?php } ?>
			</div><!-- /*Open Mortgage Main Container*/ -->
			<?php } ?>
			<?php } ?>
			<div class="open-mortgage-fields-container-clone">
			</div>
		</div><!-- /*Open Mortgage Column*/ -->
	</div><!-- /*Open Mortgage Main Row*/ -->

	<!-- /*Open Mortgage Row*/ -->
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Open Judgments & Encumbrances<span title="Add New Vesting Details" style="font-size: 17px; float: right;border: 1px solid #f1702b;border-radius: 12px;padding: 0px 6px;cursor: pointer;background-color: #f1702b; color: #FFF;" onclick="addFieldGroup('open-judgments')">+</span></h4> 
					</div>
				</div>
			</div>
			<?php 
			$buttonIndex=0;
			if (empty($open_judgments_attributes)) {
				$open_judgments_attributes[0]['OpenJudgmentsType'] ="";
			} ?>
			<?php if (!empty($open_judgments_attributes)) { ?>
			<?php foreach ($open_judgments_attributes as $index => $open_judgments_attribute) { $buttonIndex++; ?>
			<div class="open-judgments-field-group-<?php echo $index;?> open-judgments-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
				<!-- <div class="row">
					<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
						<div class="card-header align-items-center d-flex" style="border: none !important;">
							<h4 class="card-title mb-0 flex-grow-1">#<?php echo $buttonIndex; ?> Open Judgments & Encumbrances</h4> 
						</div>
					</div>
				</div> -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">	
											<label class="form-label mb-0">Type</label>
											<?php 	echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsType]", 
												['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_judgments_attribute['OpenJudgmentsType'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
												<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Lien Holder/Plaintiff</label>
											<?php echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsLienHolderPlaintiff]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_judgments_attribute['OpenJudgmentsLienHolderPlaintiff'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Borrower/Defendant</label>
											<?php echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsBorrowerDefendant]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_judgments_attribute['OpenJudgmentsBorrowerDefendant'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Amount $</label>
											<?php echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsAmount]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_judgments_attribute['OpenJudgmentsAmount'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Date Entered</label>
											<?php echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsDateEntered]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($open_judgments_attribute['OpenJudgmentsDateEntered']) ? $open_judgments_attribute['OpenJudgmentsDateEntered'] : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Date Recorded</label>
											<?php echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsDateRecorded]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($open_judgments_attribute['OpenJudgmentsDateRecorded']) ? $open_judgments_attribute['OpenJudgmentsDateRecorded'] : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Book/Page</label>
											<?php echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsBookPage]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_judgments_attribute['OpenJudgmentsBookPage'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Instrument #</label>
											<?php echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsInstrument]", 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $open_judgments_attribute['OpenJudgmentsInstrument'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Comments</label>
											<?php echo $this->Form->control("open_judgments_attributes[".$index."][OpenJudgmentsComments]", 
											['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $open_judgments_attribute['OpenJudgmentsComments'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:40px;']); ?>
										</div>	 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<?php if($index > 0) { ?>
				<button class="btn btn-danger mt-2 remove-btn" onclick="removeFieldGroup('open-judgments',<?php echo $index;?>)" style="margin: 0px 15px 15px;" type="button">#<?php echo $buttonIndex; ?> Remove</button>
			<?php } ?>
			</div><!-- /*Open Mortgage Main Container*/ -->
			<?php } ?>
			<?php } ?>
			<div class="open-judgments-fields-container-clone">
			</div>
		</div><!-- /*Open Mortgage Column*/ -->
	</div><!-- /*Open Mortgage Main Row*/ -->

	<!-- /*Tax Status Row*/ -->
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Tax Status and Assessor Information</h4> 
					</div>
				</div>
			</div>
			<div class="tax-status-field-group-<?php echo $index;?> tax-status-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">	
											<label class="form-label mb-0">Tax Status</label>
											<?php 	echo $this->Form->control('TaxStatus', 
												['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxStatus'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
												<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Tax Year</label>
											<?php echo $this->Form->control('TaxYear', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxYear'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Tax Amount</label>
											<?php echo $this->Form->control('TaxAmount', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxAmount'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Tax Type</label>
											<?php echo $this->Form->control('TaxType', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxType'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Payment Schedule</label>
											<?php echo $this->Form->control('TaxPaymentSchedule', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxPaymentSchedule'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Due Date</label>
											<?php echo $this->Form->control('TaxDueDate', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['TaxDueDate']) ? $examReceiptFields['TaxDueDate'] : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Deliquent Date</label>
											<?php echo $this->Form->control('TaxDeliquentDate', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['TaxDeliquentDate']) ? $examReceiptFields['TaxDeliquentDate'] : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Comments</label>
											<?php echo $this->Form->control('TaxComments', 
											['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxComments'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:40px;']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Land Value</label>
											<?php echo $this->Form->control('TaxLandValue', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxLandValue'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Building Value</label>
											<?php echo $this->Form->control('TaxBuildingValue', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxBuildingValue'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Total Value</label>
											<?php echo $this->Form->control('TaxTotalValue', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxTotalValue'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">APN/Account #</label>
											<?php echo $this->Form->control('TaxAPNAccount', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxAPNAccount'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Assessed Year</label>
											<?php echo $this->Form->control('TaxAssessedYear', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxAssessedYear'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Total Value</label>
											<?php echo $this->Form->control('TaxTotalValue2', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxTotalValue2'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Municipality/County</label>
											<?php echo $this->Form->control('TaxMunicipalityCounty', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxMunicipalityCounty'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
			</div><!-- /*Tax Status Main Container*/ -->
		</div><!-- /*Tax Status Column*/ -->
	</div>

	<!-- /*Tax Status Row*/ -->
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Legal Description</h4>
					</div>
				</div>
			</div>
			<div class="tax-status-field-group-0 tax-status-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">	
											<label class="form-label mb-0">Legal Description</label>
											<?php echo $this->Form->control('LegalDescription', 
											['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['LegalDescription'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:40px;']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
			</div><!-- /*Tax Status Main Container*/ -->
		</div><!-- /*Tax Status Column*/ -->
	</div>

	<!-- /*Tax Status Row*/ -->
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">File</h4> 
					</div>
				</div>
			</div>
			<div class="tax-status-field-group-<?php echo $index;?> tax-status-groups live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">										
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['NATFileNumber'])) ? $partnerMapFields['mappedtitle']['NATFileNumber'].' <span style="color:#CA3F48">*</span></label>' : 'NAT File Number'.' <span style="color:#CA3F48">*</span></label>');?></label>
											
											<?php echo $this->Form->control('NATFileNumber', 
											['label'=>false,
											'class'=>'form-control', 'required'=>true, 'value' => $FilesMainData['NATFileNumber'], 'readonly'=>'readonly', 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['partner_file_number'])) ? $partnerMapFields['mappedtitle']['partner_file_number'].' <span style="color:#CA3F48">*</span></label>' : 'Partner File Number'.' <span style="color:#CA3F48">*</span></label>');?></label>
											<?php echo $this->Form->control('partner_file_number', 
											['label'=>false, 'class'=>'form-control', 'required'=>true, 'value' => $FilesMainData['PartnerFileNumber'], 'readonly'=>'readonly', 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['FileStartDate'])) ? $partnerMapFields['mappedtitle']['FileStartDate'].' <span style="color:#CA3F48">*</span></label>'  : 'FileStartDate'.' <span style="color:#CA3F48">*</span></label>');?></label>
											<?php    //pr($filesCheckinData->FileStartDate); ?>
											<div class="input-daterange" id="datepicker">
											<?php echo $this->Form->control('FileStartDate', 
											['label'=>false ,
											'type'=>'text','class'=>'form-control', 'required'=>true, 'value' => $FilesMainData['FileStartDate'], 'readonly'=>'readonly', 'value'=>(isset($FilesMainData['FileStartDate']) ? date('Y-m-d H:i:s', strtotime($FilesMainData['FileStartDate'])) : '')]); ?>
											</div>
									
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Center/Branch</label>
											<?php echo $this->Form->control('CenterBranch', ['label'=>false,'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['CenterBranch'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['loan_amount'])) ? $partnerMapFields['mappedtitle']['loan_amount'] : 'Loan Amount'); ?></label>
											<?php echo $this->Form->control('loan_amount', 
											['label'=>false,
											'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['LoanAmount'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['loan_number'])) ? $partnerMapFields['mappedtitle']['loan_number'] : 'Loan Number'); ?></label>
											<?php echo $this->Form->control('loan_number', 
											['label'=>false,
											'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['LoanNumber'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Transaction Type</label>
											<?php echo $this->Form->control('transaction_type', ['label'=>false,'type'=>'text', 'value'=> $FilesMainData['TransactionType'], 'class'=>'form-control', 'required'=>false, 'readonly'=>'readonly', 'placeholder'=>'Number only (seperated by " , ")']); ?>
											
											<?php echo $this->Form->control('documentTypeHidden', [ 'value'=>($FilesMainData['transaction_type']==0) ? $FilesMainData['fcd']['transaction_type'] : $FilesMainData['fcd']['transaction_type'] , 'type'=>'hidden']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['StreetNumber'])) ? $partnerMapFields['mappedtitle']['StreetNumber'] : 'Street Number'); ?></label>
											<?php echo $this->Form->control('StreetNumber', 
											['label'=>false,
											'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['StreetNumber'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['StreetName'])) ? $partnerMapFields['mappedtitle']['StreetName'] : 'Street Name'); ?></label>
											<?php echo $this->Form->control('StreetName', 
											['label'=>false,
											'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['StreetName'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['City'])) ? $partnerMapFields['mappedtitle']['City'] : 'City'); ?></label>
											<?php echo $this->Form->control('City', 
											['label'=>false,
											'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['City'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['County'])) ? $partnerMapFields['mappedtitle']['County'] : 'County'); ?></label>
											<?php echo $this->Form->control('County', 
											['label'=>false,
											'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['County'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['State'])) ? $partnerMapFields['mappedtitle']['State'] : 'State'); ?></label>
											<?php echo $this->Form->control('State', 
											['label'=>false,
											'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['State'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /*Column Row*/ -->
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['Zip'])) ? $partnerMapFields['mappedtitle']['Zip'] : 'Zip'); ?></label>
											<?php echo $this->Form->control('Zip', 
											['label'=>false,
											'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['Zip'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*2*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">APN/Parcel Number</label>
											
											<?php echo $this->Form->control('apn_parcel_number', ['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=> $FilesMainData['APNParcelNumber'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /*3*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label class="form-label mb-0">Legal Description(Short Legal)</label>
											
											<?php echo $this->Form->control('legal_description_short_legal', ['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=> $FilesMainData['LegalDescriptionShortLegal'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <!-- Added by Vinit for Supporting Docs start -->
                    <div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">
											<label><strong>Supporting Documentation</strong></label>
											<?php
												if (!empty($filesExamReceiptNew['supporting_documentation']))
												{

													$filePath_1 = WWW_ROOT . 'uploads' . DS . $filesExamReceiptNew['supporting_documentation'];
													$filePath_2 = WWW_ROOT . 'supporting_documents' . DS . $filesExamReceiptNew['supporting_documentation'];
													
													if (file_exists($filePath_2) ) {

														$buldUrl = $this->Url->build('/supporting_documents/' . $filesExamReceiptNew['supporting_documentation'], ['fullBase' => true]);
													}	
													else if (file_exists($filePath_1) ) {	
														$buldUrl = $this->Url->build('/uploads/' . $filesExamReceiptNew['supporting_documentation'], ['fullBase' => true]);
													}		
											?>
												<p>Current File:
													<a href="<?= $buldUrl ?>" target="_blank">
													<?= h($filesExamReceiptNew['supporting_documentation']) ?></a>
											<?php		
													
													if (!file_exists($filePath_1) && !file_exists($filePath_2)) {
														echo '<p style="color:red;"><b>Note:</b> Supporting document file does not exist. Please choose a file below to upload.</p>';
													}
												}
											?>
                                            
                                            <?= $this->Form->control('supporting_documentation', [
                                                'type' => 'file',
                                                'label' => false,
                                                'class' => 'form-control'
                                            ]) ?><br>
                                            </p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <!-- Added by Vinit for Supporting Docs end -->

				</div><!-- /*Column Row*/ -->
			</div><!-- /*Tax Status Main Container*/ -->
		</div><!-- /*Tax Status Column*/ -->
	</div>
	
</div> <!-- card close -->


<?php if(isset($partnerMapFields['fieldsvalsPS'])){ ?>
<div class="row" style="display:none;">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= __('Partner Specific Data') ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview" style="border: 1px solid #c2c2c2; margin: 5px 5px 15px 5px; padding: 15px 5px 10px 5px; border-radius: 5px;">
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
	let domIndex = 0; let titleIndex = 1;
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

	function addFieldGroup(groupName) {

		domIndex = $("."+groupName+"-groups").length;
		titleIndex = $("."+groupName+"-groups").length;
		titleIndex++;
    let container = document.querySelector("."+groupName+"-fields-container-clone");
    let newFieldGroup = document.querySelector("."+groupName+"-field-group-0").cloneNode(true); // Clone existing fields

    // Update name attributes dynamically
    newFieldGroup.querySelectorAll("div, label, input, select, textarea").forEach(field => {
        let oldName = field.getAttribute("name");
        if (oldName) {
            let newName = oldName.replace(/\[\d+\]/, "[" + domIndex + "]");
            field.setAttribute("name", newName);
            field.value = ""; // Clear input values
        }
    });
    let removeBtn = document.createElement("button");
    removeBtn.innerText = "#"+titleIndex+" Remove";
    removeBtn.classList.add("btn", "btn-danger", "mt-2", "remove-btn");
    removeBtn.style.margin = "0px 15px 15px 15px";
    removeBtn.type = "button";
    removeBtn.onclick = function () {
    	if ( confirm("Would you like to delete all this record?\n\nClick on OK or Cancel.")  == true ) {
        this.closest("."+groupName+"-field-group-0").remove();
      }
    };
    newFieldGroup.appendChild(removeBtn);
    container.appendChild(newFieldGroup);

	}
	function removeFieldGroup(field, groupIndex) {
		if ( confirm("Would you like to delete all this record?\n\nClick on OK or Cancel.")  == true ) {
			$("."+field+"-field-group-"+groupIndex).remove();
		}
	}
	function showNewVesting(argument) {
		$(".vesting_new").show();
	}
	function removeNewVesting(argument) {
		$(".vesting_new").hide();
	}
	function showNewOpenMortgage(argument) {
		$(".open_mortgage_new").show();
	}
	function removeNewOpenMortgage(argument) {
		$(".open_mortgage_new").hide();
	}

	function showNewOpenJudgments(argument) {
		$(".open_judg_encumbrances").show();
	}
	function removeNewOpenJudgments(argument) {
		$(".open_judg_encumbrances").hide();
	}
</script>
<?php $this->end() ?>