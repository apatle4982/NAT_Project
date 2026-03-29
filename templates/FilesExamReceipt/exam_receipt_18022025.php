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
				<h4 class="card-title mb-0 flex-grow-1">Official Property Address as Titled</h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Property Address</label>
								<?php 	echo $this->Form->control('OfficialPropertyAddress', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OfficialPropertyAddress'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
									<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Vesting - Chain of Title Information<span title="Add New Vesting Details" style="font-size: 17px; float: right;border: 1px solid;border-radius: 12px;padding: 0px 6px;cursor: pointer;" onclick="showNewVesting()">+</span></h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Deed Type</label>
								<?php 	echo $this->Form->control('VestingDeedType', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['VestingDeedType'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Consideration Amount</label>
								<?php echo $this->Form->control('VestingConsiderationAmount', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['VestingConsiderationAmount'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Vested As (Grantee)</label>
								<?php echo $this->Form->control('VestedAsGrantee', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['VestedAsGrantee'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Grantor</label>
								<?php echo $this->Form->control('VestingGrantor', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['VestingGrantor'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Dated</label>
								<?php echo $this->Form->control('VestingDated', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['VestingDated']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['VestingDated'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Recorded Date</label>
								<?php echo $this->Form->control('VestingRecordedDate', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['VestingRecordedDate']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['VestingRecordedDate'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Book/Page</label>
								<?php echo $this->Form->control('VestingBookPage', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['VestingBookPage'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Instrument #</label>
								<?php echo $this->Form->control('VestingInstrument', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['VestingInstrument'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Comments</label>
								<?php echo $this->Form->control('VestingComments', 
								['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['VestingComments'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:100px;']); ?>
							</div>		 
						</div>

					</div>
					<!--end row-->
				</div> 
			</div>
			<!-- /**New Vesting #1**/ -->
			<div class="vesting_new" style="display:none;">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Vesting - Chain of Title Information #2<span title="Remove Vesting Details" style="font-size: 17px; float: right;border: 1px solid;border-radius: 12px;padding: 0px 6px;cursor: pointer;" onclick="removeNewVesting()">x</span></h4> 
				</div>
				<div class="card-body">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">	
									<label class="form-label mb-0">Deed Type</label>
									<?php 	echo $this->Form->control('VestingDeedType1', 
										['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "", 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
								</div>
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Consideration Amount</label>
									<?php echo $this->Form->control('VestingConsiderationAmount1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Vested As (Grantee)</label>
									<?php echo $this->Form->control('VestedAsGrantee1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Grantor</label>
									<?php echo $this->Form->control('VestingGrantor1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Dated</label>
									<?php echo $this->Form->control('VestingDated1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>"",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Recorded Date</label>
									<?php echo $this->Form->control('VestingRecordedDate1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>"",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Book/Page</label>
									<?php echo $this->Form->control('VestingBookPage1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Instrument #</label>
									<?php echo $this->Form->control('VestingInstrument1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Comments</label>
									<?php echo $this->Form->control('VestingComments1', 
									['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:100px;']); ?>
								</div>		 
							</div>

						</div>
						<!--end row-->
					</div> 
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Open Mortgage Information<span title="Add New Open Mortgage" style="font-size: 17px; float: right;border: 1px solid;border-radius: 12px;padding: 0px 6px;cursor: pointer;" onclick="showNewOpenMortgage()">+</span></h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Amount $</label>
								<?php 	echo $this->Form->control('OpenMortgageAmount', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenMortgageAmount'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
									<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Dated</label>
								<?php echo $this->Form->control('OpenMortgageDated', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['OpenMortgageDated']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['OpenMortgageDated'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Recorded (Date)</label>
								<?php echo $this->Form->control('OpenMortgageRecordedDate', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['OpenMortgageRecordedDate']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['OpenMortgageRecordedDate'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Book/Page</label>
								<?php echo $this->Form->control('OpenMortgageBookPage', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenMortgageBookPage'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Instrument #</label>
								<?php echo $this->Form->control('OpenMortgageInstrument', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenMortgageInstrument'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Borrower (Mortgagor)</label>
								<?php echo $this->Form->control('OpenMortgageBorrowerMortgagor', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenMortgageBorrowerMortgagor'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Lender (Mortgagee)</label>
								<?php echo $this->Form->control('OpenMortgageLenderMortgagee', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenMortgageLenderMortgagee'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Trustee 1</label>
								<?php echo $this->Form->control('OpenMortgageTrustee1', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenMortgageTrustee1'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Trustee 2</label>
								<?php echo $this->Form->control('OpenMortgageTrustee2', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenMortgageTrustee2'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Comments</label>
								<?php echo $this->Form->control('OpenMortgageComments', 
								['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenMortgageComments'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:100px;']); ?>
							</div>		 
						</div>

					</div>
				</div>
			</div>

			<!-- /****/ -->
			<div class="open_mortgage_new" style="display:none;">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Open Mortgage Information #2<span title="Remove Open Mortgage" style="font-size: 17px; float: right;border: 1px solid;border-radius: 12px;padding: 0px 6px;cursor: pointer;" onclick="removeNewOpenMortgage()">x</span></h4> 
				</div>
				<div class="card-body">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">	
									<label class="form-label mb-0">Amount $</label>
									<?php 	echo $this->Form->control('OpenMortgageAmount1', 
										['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "", 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
								</div>
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Dated</label>
									<?php echo $this->Form->control('OpenMortgageDated1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>"",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Recorded (Date)</label>
									<?php echo $this->Form->control('OpenMortgageRecordedDate1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>"",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Book/Page</label>
									<?php echo $this->Form->control('OpenMortgageBookPage1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Instrument #</label>
									<?php echo $this->Form->control('OpenMortgageInstrument1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Borrower (Mortgagor)</label>
									<?php echo $this->Form->control('OpenMortgageBorrowerMortgagor1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Lender (Mortgagee)</label>
									<?php echo $this->Form->control('OpenMortgageLenderMortgagee1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Trustee 1</label>
									<?php echo $this->Form->control('OpenMortgageTrustee11', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Trustee 2</label>
									<?php echo $this->Form->control('OpenMortgageTrustee21', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Comments</label>
									<?php echo $this->Form->control('OpenMortgageComments1', 
									['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:100px;']); ?>
								</div>		 
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
				<h4 class="card-title mb-0 flex-grow-1">Open Judgments & Encumbrances<span title="Add New Open Judgments & Encumbrances" style="font-size: 17px; float: right;border: 1px solid;border-radius: 12px;padding: 0px 6px;cursor: pointer;" onclick="showNewOpenJudgments()">+</span></h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Type</label>
								<?php 	echo $this->Form->control('OpenJudgmentsType', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenJudgmentsType'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
									<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Lien Holder/Plaintiff</label>
								<?php echo $this->Form->control('OpenJudgmentsLienHolderPlaintiff', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenJudgmentsLienHolderPlaintiff'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Borrower/Defendant</label>
								<?php echo $this->Form->control('OpenJudgmentsBorrowerDefendant', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenJudgmentsBorrowerDefendant'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Amount $</label>
								<?php echo $this->Form->control('OpenJudgmentsAmount', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenJudgmentsAmount'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Date Entered</label>
								<?php echo $this->Form->control('OpenJudgmentsDateEntered', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['OpenJudgmentsDateEntered']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['OpenJudgmentsDateEntered'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Date Recorded</label>
								<?php echo $this->Form->control('OpenJudgmentsDateRecorded', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['OpenJudgmentsDateRecorded']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['OpenJudgmentsDateRecorded'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Book/Page</label>
								<?php echo $this->Form->control('OpenJudgmentsBookPage', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenJudgmentsBookPage'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Instrument #</label>
								<?php echo $this->Form->control('OpenJudgmentsInstrument', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenJudgmentsInstrument'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Comments</label>
								<?php echo $this->Form->control('OpenJudgmentsComments', 
								['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['OpenJudgmentsComments'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:100px;']); ?>
							</div>		 
						</div>

					</div>
				</div>
			</div>

			<div class="open_judg_encumbrances" style="display:none;">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Open Judgments & Encumbrances #2<span title="Remove Open Judgments & Encumbrances" style="font-size: 17px; float: right;border: 1px solid;border-radius: 12px;padding: 0px 6px;cursor: pointer;" onclick="removeNewOpenJudgments()">x</span></h4> 
				</div>
				<div class="card-body">
					<div class="live-preview ">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">	
									<label class="form-label mb-0">Type</label>
									<?php 	echo $this->Form->control('OpenJudgmentsType1', 
										['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "", 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
										<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
								</div>
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Lien Holder/Plaintiff</label>
									<?php echo $this->Form->control('OpenJudgmentsLienHolderPlaintiff1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Borrower/Defendant</label>
									<?php echo $this->Form->control('OpenJudgmentsBorrowerDefendant1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Amount $</label>
									<?php echo $this->Form->control('OpenJudgmentsAmount1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Date Entered</label>
									<?php echo $this->Form->control('OpenJudgmentsDateEntered1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>"",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Date Recorded</label>
									<?php echo $this->Form->control('OpenJudgmentsDateRecorded1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>"",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Book/Page</label>
									<?php echo $this->Form->control('OpenJudgmentsBookPage1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Instrument #</label>
									<?php echo $this->Form->control('OpenJudgmentsInstrument1', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
								</div>		 
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label class="form-label mb-0">Comments</label>
									<?php echo $this->Form->control('OpenJudgmentsComments1', 
									['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => "",  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:100px;']); ?>
								</div>		 
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- grantees_g2 end-->

			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Tax Status and Assessor Information</h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Tax Status</label>
								<?php 	echo $this->Form->control('TaxStatus', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxStatus'], 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
									<?= $this->Form->hidden('RecId', ['value'=>$fmd_id]); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Tax Year</label>
								<?php echo $this->Form->control('TaxYear', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxYear'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Tax Amount</label>
								<?php echo $this->Form->control('TaxAmount', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxAmount'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Tax Type</label>
								<?php echo $this->Form->control('TaxType', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxType'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Payment Schedule</label>
								<?php echo $this->Form->control('TaxPaymentSchedule', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxPaymentSchedule'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Due Date</label>
								<?php echo $this->Form->control('TaxDueDate', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['TaxDueDate']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['TaxDueDate'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Deliquent Date</label>
								<?php echo $this->Form->control('TaxDeliquentDate', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($examReceiptFields['TaxDeliquentDate']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['TaxDeliquentDate'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Comments</label>
								<?php echo $this->Form->control('TaxComments', 
								['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxComments'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:100px;']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Land Value</label>
								<?php echo $this->Form->control('TaxLandValue', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxLandValue'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Building Value</label>
								<?php echo $this->Form->control('TaxBuildingValue', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxBuildingValue'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Total Value</label>
								<?php echo $this->Form->control('TaxTotalValue', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxTotalValue'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">APN/Account #</label>
								<?php echo $this->Form->control('TaxAPNAccount', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxAPNAccount'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Assessed Year</label>
								<?php echo $this->Form->control('TaxAssessedYear', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxAssessedYear'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Total Value</label>
								<?php echo $this->Form->control('TaxTotalValue2', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxTotalValue2'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Municipality/County</label>
								<?php echo $this->Form->control('TaxMunicipalityCounty', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['TaxMunicipalityCounty'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
					</div>
				</div>
			</div>
			<!-- Document Received end-->
			
			<!-- Mortgagor Grantor(s) end-->
			
			<!-- Mortgagee -->
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Legal Description </h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Legal Description</label>
								<?php echo $this->Form->control('LegalDescription', 
								['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $examReceiptFields['LegalDescription'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:150px;']); ?>
							</div>
						</div>
					</div>									 
				</div>
				<!--end row-->
			</div>
			<!-- Mortgagee end-->
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
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['NATFileNumber'])) ? $partnerMapFields['mappedtitle']['NATFileNumber'].' <span style="color:#CA3F48">*</span></label>' : 'NAT File Number'.' <span style="color:#CA3F48">*</span></label>');?></label>
								
								<?php echo $this->Form->control('NATFileNumber', 
								['label'=>false,
								'class'=>'form-control', 'required'=>true, 'value' => $FilesMainData['NATFileNumber'], 'readonly'=>'readonly', 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['partner_file_number'])) ? $partnerMapFields['mappedtitle']['partner_file_number'].' <span style="color:#CA3F48">*</span></label>' : 'Partner File Number'.' <span style="color:#CA3F48">*</span></label>');?></label>
								<?php echo $this->Form->control('partner_file_number', 
								['label'=>false, 'class'=>'form-control', 'required'=>true, 'value' => $FilesMainData['PartnerFileNumber'], 'readonly'=>'readonly', 'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['file_start_date'])) ? $partnerMapFields['mappedtitle']['file_start_date'].' <span style="color:#CA3F48">*</span></label>'  : 'FileStartDate'.' <span style="color:#CA3F48">*</span></label>');?></label>
								<?php    //pr($filesCheckinData->file_start_date); ?>
								<div class="input-daterange" id="datepicker">
								<?php echo $this->Form->control('file_start_date', 
								['label'=>false ,
								'type'=>'text','class'=>'form-control', 'required'=>true, 'value' => $FilesMainData['FileStartDate'], 'readonly'=>'readonly', 'value'=>(isset($filesCheckinData['file_start_date']) ? date('Y-m-d H:i:s', strtotime($filesCheckinData['file_start_date'])) : '')]); ?>
								</div>
						
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Center/Branch</label>
								<?php echo $this->Form->control('CenterBranch', ['label'=>false,'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['CenterBranch'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>	 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['loan_amount'])) ? $partnerMapFields['mappedtitle']['loan_amount'] : 'Loan Amount'); ?></label>
								<?php echo $this->Form->control('loan_amount', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['LoanAmount'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['loan_number'])) ? $partnerMapFields['mappedtitle']['loan_number'] : 'Loan Number'); ?></label>
								<?php echo $this->Form->control('loan_number', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['LoanNumber'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Transaction Type</label>
								<?php echo $this->Form->control('transaction_type', ['label'=>false,'type'=>'text', 'value'=> $FilesMainData['TransactionType'], 'class'=>'form-control', 'required'=>false, 'readonly'=>'readonly', 'placeholder'=>'Number only (seperated by " , ")']); ?>
								
								<?php echo $this->Form->control('documentTypeHidden', [ 'value'=>($filesCheckinData['transaction_type']==0) ? $filesCheckinData['fcd']['transaction_type'] : $filesCheckinData['fcd']['transaction_type'] , 'type'=>'hidden']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['StreetNumber'])) ? $partnerMapFields['mappedtitle']['StreetNumber'] : 'Street Number'); ?></label>
								<?php echo $this->Form->control('StreetNumber', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['StreetNumber'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['StreetName'])) ? $partnerMapFields['mappedtitle']['StreetName'] : 'Street Name'); ?></label>
								<?php echo $this->Form->control('StreetName', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['StreetName'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['City'])) ? $partnerMapFields['mappedtitle']['City'] : 'City'); ?></label>
								<?php echo $this->Form->control('City', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['City'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['County'])) ? $partnerMapFields['mappedtitle']['County'] : 'County'); ?></label>
								<?php echo $this->Form->control('County', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['County'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['State'])) ? $partnerMapFields['mappedtitle']['State'] : 'State'); ?></label>
								<?php echo $this->Form->control('State', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['State'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['Zip'])) ? $partnerMapFields['mappedtitle']['Zip'] : 'Zip'); ?></label>
								<?php echo $this->Form->control('Zip', 
								['label'=>false,
								'class'=>'form-control', 'required'=>false, 'value' => $FilesMainData['Zip'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>		 
						</div>

						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">APN/Parcel Number</label>
								
								<?php echo $this->Form->control('apn_parcel_number', ['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=> $FilesMainData['APNParcelNumber'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>														 
						</div>
						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Legal Description (Short Legal)</label>
								
								<?php echo $this->Form->control('legal_description_short_legal', ['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=> $FilesMainData['LegalDescriptionShortLegal'], 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>														 
						</div>
						
						<?php 
						if(isset($partnerMapFields['fieldsvalsFL'])){
						foreach($partnerMapFields['fieldsvalsFL'] as $fieldsvalFL){ ?>
						<div class="col-xxl-12 col-md-12" style="display:none;">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalFL['cfm_maptitle'])) ? $fieldsvalFL['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>										
								<?php echo $this->Form->control($fieldsvalFL['fm']['fm_title'], 
								['label'=>false, 
								'class'=>'form-control', 'required'=>false, 'readonly'=>'readonly',  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							</div>
						</div>
						<?php } } ?>
					</div> 
				</div>
			</div>

			<div class="card-header align-items-center d-flex" style="display: none !important;">
				<h4 class="card-title mb-0 flex-grow-1">Added by User Details</h4> 
			</div>
			<div class="card-body" style="display: none;">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Added Date Time</label>
								<?= isset($examReceiptFields['created']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['created'])) : ''?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Modified Date Time</label>
								<?= isset($examReceiptFields['modified']) ? date('Y-m-d H:i:s', strtotime($examReceiptFields['modified'])) : ''?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Added By User Name</label>
								<?= $examReceiptFields['users']['user_name']." ".$examReceiptFields['users']['user_lastname']?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Added By User Email</label>
								<?= $examReceiptFields['users']['user_email']?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0">Added By User Phone</label>
								<?= $examReceiptFields['users']['user_phone']?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	
	</div> <!-- row close -->
</div> <!-- card close -->
<?php if(isset($partnerMapFields['fieldsvalsPS'])){ ?>
<div class="row" style="display:none;">
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