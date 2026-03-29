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

	<!-- NAT File Overview -->
	<div class="col-xxl-3 col-md-3 col-sm-12">
		
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= __('NAT File Overview') ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50 label-50">NAT File Number</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Partner File Number</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Partner Name (ID #)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">FileStartDate</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Transaction Type</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Purchase Price (Consideration)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Loan Amount</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Loan Number</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Street Number</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Street Name</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">City</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">County</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">State</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Zip</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">APN/Parcel Number</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Legal Description (Short Legal)</label>
							</div> 
						</div>


						<div class="card-header align-items-center d-flex" style="margin-top: 80px;">
							<h4 class="card-title mb-0 flex-grow-1">Recording Data</h4>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">RecordingProcessingDate</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">RecordingDate</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">RecordingTime</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">InstrumentNumber</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Book</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Page</label>
							</div> 
						</div>

						<div class="card-header align-items-center d-flex">
							<h4 class="card-title mb-0 flex-grow-1">Return to Partner Data</h4>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">rtpsubmissionTrackingnumber</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">dateDelivered</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">receipient</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">deliveredTo</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">receivedBy</label>
							</div> 
						</div>

							
					<!--end row-->
					</div> 
				</div>
			</div>
		
		</div>
		<!-- NAT File Overview END-->


		<!-- Party Names -->
		<div class="col-xxl-3 col-md-3 col-sm-12">
		 
			<div class="card-header align-items-center d-flex">
				<!-- <h4 class="card-title mb-0 flex-grow-1"><?= ((isset($partnerMapFields['mappedtitle']['MortgagorGrantor'])) ? $partnerMapFields['mappedtitle']['MortgagorGrantor'] : 'MortgagorGrantor')?></h4>  -->
				<h4 class="card-title mb-0 flex-grow-1">Party Names</h4>
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="card-title mb-0 flex-grow-1">Grantor(s)</label>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">First Name (1)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Last Name (1)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">First Name (2)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Last Name (2)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Marital Status</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Corporation Name</label>
							</div> 
						</div>


						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="card-title mb-0 flex-grow-1">Grantee(s)</label>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">First Name (1)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Last Name (1)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">First Name (2)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Last Name (2)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Marital Status</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Corporation Name</label>
							</div> 
						</div>

						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="card-title mb-0 flex-grow-1">Mortgagor</label>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">First Name (1)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Last Name (1)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">First Name (2)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Last Name (2)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Marital Status</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Corporation Name</label>
							</div> 
						</div>

						
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="card-title mb-0 flex-grow-1">Mortgagee</label>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Lender/Company Name</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">First Name (1)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Last Name (1)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">First Name (2)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Last Name (2)</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Marital Status</label>
							</div> 
						</div>
					</div>
																 
				</div>
					<!--end row-->
			</div>
		</div>
		<!-- Party Names END-->

		<!-- Search and Exam Data -->
		<div class="col-xxl-3 col-md-3 col-sm-12">
		 
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Search and Exam Data</h4>
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="card-title mb-0 flex-grow-1">Vendor</label>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Exam Ordered Date/Time</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Search Type</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Exam Received (Completed) Date/Time</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Exam</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Supporting Documentation</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Reviewed By</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Submitted to Client Date/Time</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Notes/Clearing/Curative</label>
							</div> 
						</div>

						<div class="card-header align-items-center d-flex">
							<h4 class="card-title mb-0 flex-grow-1">Attorney (AOL) Data</h4>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="card-title mb-0 flex-grow-1">Vendor</label>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">AOL Ordered Date/Time</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">AOL Received Date/Time</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Supporting Documentation</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Reviewed By</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Submitted to Client Date/Time</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Notes/Clearing/Curative</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Final AOL & Policy Submitted to Client Date and Time</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Final AOL & Policy Submitted to Client Date and Time</label>
							</div> 
						</div>

						
						<div class="card-header align-items-center d-flex">
							<h4 class="card-title mb-0 flex-grow-1">CountyCalc API Estimated Recording Fees</h4>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">CountyRecordingFeeCC</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">transferTaxCC</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">intangibleMtgTaxCC</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">TaxesCC</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">nonstandardFeeCC</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">walkupAbstractorFeeCC</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">AdditionalFeesCC</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">TotalCC</label>
							</div> 
						</div>

					</div>
																 
				</div>
					<!--end row-->
			</div>
		</div>
		<!-- Search and Exam Data END-->

		<div class="col-xxl-3 col-md-3 col-sm-12">
			 <div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Escrow/Closing</h4>
			</div> 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="card-title mb-0 flex-grow-1">Vendor</label>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Closing Package Received</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Ok To Close Notification</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Closing Package Submitted Date/Time</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">File Closed</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Funds Disbursed</label>
							</div> 
						</div>

						<div class="card-header align-items-center d-flex">
							<h4 class="card-title mb-0 flex-grow-1">Revenue/Accounting Data Fields</h4>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="card-title mb-0 flex-grow-1">Search and Exam</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">AOL Premium</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">AOL Remittance</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Endorsements</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">AOL Creation (Attorney Network)Fee</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Closing and Escrow Fees</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">CountyRecordingFee</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">transferTax</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">intangibleMtgTax</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Taxes</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">nonstandardFee</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">walkupAbstractorFee</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">AdditionalFees</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">checkCleared</label>
							</div> 
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0 label-50">Total</label>
							</div> 
						</div>

					</div>
																 
				</div>
					<!--end row-->
			</div>
		</div>
	
	<!-- MortgageeGrantee start-->
	 <!-- 2 col close -->
	
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
								<label class="form-label mb-0 label-50"><?= ((isset($fieldsvalsPS['cfm_maptitle'])) ? $fieldsvalsPS['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>					
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