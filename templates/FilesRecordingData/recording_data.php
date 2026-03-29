<?php
/**
  * @var \App\View\AppView $this
  */
?>
			
<?= $this->Form->create($FilesRecordingData, ['horizontal' => true]) ?>
<div class="row">
	<div class="col-lg-12 text-center btm-inline">
		<div class="submit">
		<?= $this->Form->submit(__('Save'),['class'=>'btn btn-success', 'name'=>'saveBtn']); ?> 
		</div>

		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 					
	</div>
</div>
<div class="card" style="margin-top:15px">

	<!-- /*Tax Status Row*/ -->
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Recording Data Information Information</h4> 
					</div>
				</div>
			</div>
			<div class="tax-status-field-group-<?php echo $index;?> tax-status-groups live-preview">
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-4 col-md-4 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">	
											<label class="form-label mb-0">Recording Processing Date</label>
											<?php echo $this->Form->control('RecordingProcessingDate',
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($recordingDataFields['RecordingProcessingDate']) ? date('Y-m-d', strtotime($recordingDataFields['RecordingProcessingDate'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
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
											<label class="form-label mb-0">Recording Processing Time</label>
											<?php echo $this->Form->control('RecordingProcessingTime',
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($recordingDataFields['RecordingProcessingTime']) ? date('H:i:s', strtotime($recordingDataFields['RecordingProcessingTime'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
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
											<label class="form-label mb-0">Recording Date</label>
											<?php echo $this->Form->control('RecordingDate',
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($recordingDataFields['RecordingDate']) ? date('Y-m-d', strtotime($recordingDataFields['RecordingDate'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
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
											<label class="form-label mb-0">Recording Time</label>
											<?php echo $this->Form->control('RecordingTime',
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($recordingDataFields['RecordingTime']) ? date('H:i:s', strtotime($recordingDataFields['RecordingTime'])) : ''),  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
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
											<label class="form-label mb-0">Instrument Number</label>
											<?php echo $this->Form->control('InstrumentNumber', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $recordingDataFields['InstrumentNumber'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
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
											<label class="form-label mb-0">Book</label>
											<?php echo $this->Form->control('Book', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $recordingDataFields['Book'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
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
											<label class="form-label mb-0">Page</label>
											<?php echo $this->Form->control('Page', 
											['label'=>false, 'class'=>'form-control', 'required'=>false, 'value' => $recordingDataFields['Page'],  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
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
			</div><!-- /*Tax Status Main Container*/ -->
		</div><!-- /*Tax Status Column*/ -->
	</div>

	<!-- /*Tax Status Row*/ -->
	<div class="row">
		<div class="col-xxl-12 col-md-12 col-sm-12">
			<div class="row">
				<div class="col-xxl-12 col-md-12 col-sm-12" style="margin-bottom:10px !important">
					<div class="card-header align-items-center d-flex">
						<h4 class="card-title mb-0 flex-grow-1">Recording Notes</h4> 
					</div>
				</div>
			</div>
			<div class="tax-status-field-group-0 tax-status-groups live-preview">
				<!-- /*Row*/ -->
				<div class="row">
					<!-- /*1*/ -->
					<div class="col-xxl-12 col-md-12 col-sm-12" style="margin: 0px !important;">
						<div class="card-body" style="padding: 0px 15px 5px !important;">
							<div class="live-preview ">
								<div class="row gy-4">
									<div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
										<div class="input-container-floating">	
											<label class="form-label mb-0">Recording Notes</label>
											<?php echo $this->Form->control('RecordingNotes', 
											['label'=>false,'type'=>'textarea', 'class'=>'form-control', 'required'=>false, 'value' => $recordingDataFields['RecordingNotes'],  'title'=>'Only letters, numbers and special character are allowed (_@./)', 'style'=>'height:40px;']); ?>
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
			<div class="tax-status-field-group-<?php echo $index;?> tax-status-groups live-preview">
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