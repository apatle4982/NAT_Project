<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesVendorAssignment[]|\Cake\Collection\CollectionInterface $FilesVendorAssignment
  */
?>
 
<!-- ================================================================ -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <?= $this->Form->create($FilesVendorAssignment, ['horizontal'=>true]) ?>
        <div class="col-lg-12">

        <div class="card">	 
            <!--div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Filter By</h4> 
            </div-->	
            <div class="card-body">
                <div class="live-preview ">
                    <div class="row long-lbl-frm">
                    <div class="col-xxl-8 col-md-7 col-sm-12">
                        
                    <h2>Partner</h2> 	
                    <div class="row">
                        <div class="col-xxl-4 col-md-4 col-sm-12">
                            <div class="row">
                                <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><?= (isset($partnerMapField['mappedtitle']['company_id'])? ($partnerMapField['mappedtitle']['company_id'] != 'company_id') ? $partnerMapField['mappedtitle']['company_id']: 'Partner' : 'Partner') ?></label>
                                    
                                    <?php 
                                            echo $this->Form->control('company_id', ['value' => isset($formpostdata['company_id'])? $formpostdata['company_id']: '', 'options' => $companyMsts, 'multiple' => false, 'empty' => 'Select Partner', 'class'=>'form-control','label'=>false, 'required'=>false]);
                                        ?>
                                    </div>
                                </div>
								<div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (((isset($partnerMapField['mappedtitle']['NATFileNumber']) && (!empty(trim($partnerMapField['mappedtitle']['NATFileNumber'])))))? $partnerMapField['mappedtitle']['NATFileNumber']: 'NAT File Number')?></strong></label>
                                    <?php echo $this->Form->control('NATFileNumber', [
                                    'label' => false,
                                    'value'=>isset($formpostdata['NATFileNumber'])? $formpostdata['NATFileNumber']: '' , 'class'=>'form-control', 'required'=>false]); ?>
                                    </div>
								</div>
								<div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'Partner File Number') ?></strong></label>
                                    <?php echo $this->Form->control('PartnerFileNumber', ['value'=>isset($formpostdata['PartnerFileNumber'])? $formpostdata['PartnerFileNumber']: '' ,
                                    'label' => false, 
                                    'class'=>'form-control', 'required'=>false]); ?>

                                    </div>
                                </div>
                                
                                



                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4 col-sm-12">
                            <div class="row">
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
							
                            
                            
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4 col-sm-12">
                            <div class="row">
                                
                                <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantor(s)') ?></strong></label>
                                    <?php echo $this->Form->control('Grantors', ['value'=>isset($formpostdata['Grantors'])? $formpostdata['Grantors']: '' ,
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
                            </div>
                        </div>
                    </div>
                    
                    <h2>Transaction Status</h2> 
                        
                    <div class="row">
                        <div class="col-xxl-12 col-md-12">

                        
                            <div class="input-container-floating">
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="flexRadioProcess-dnr">
                                     Not Assigned
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['dnr'=>'Document not received'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input',
                                        'id'=>'flexRadioProcess'
                                        ]); 
                                    ?>
                                    
                                </div>
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="flexRadioProcess-dr">
                                    Assigned
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['dr'=>'Document received'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input',
                                        'id'=>'flexRadioProcess'
                                        ]); 
                                    ?>
                                    
                                </div>
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="flexRadioProcess-all">
                                    All
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['all'=>'All'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input',
                                        'id'=>'flexRadioProcess'
                                        ]); 
                                    ?>
                                </div>
                               
                            </div>
                            </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-5 col-sm-12">
                    
                    <h2>Upload/Add Specific Search</h2> 
                        
                    <div class="row">
                    <div class="col-xxl-8 col-md-7 col-sm-12">
                        <div class="row">
                            <div class="col-xxl-12 col-md-12 col-sm-12">
                                <div class="input-container-floating">
                                        <label for="basiInput" class="form-label"><strong>Date Uploaded/Added</strong></label>
                                        <div class="two-input">
                                        <div class="row">
                                            <div class="col-xxl-12 col-md-12 col-sm-12">
                                            <span class="frm-to">From:</span>
                                            <?php echo $this->Form->control('fromdate', ['label' => false, 'value'=>isset($formpostdata['fromdate'])? $formpostdata['fromdate']: '', 'placeholder' => '(yyyy-mm-dd)', 'class'=>'form-control f-control-withspan', 'required'=>false]); ?>
        
                                            </div>
                                            <div class="col-xxl-12 col-md-12 col-sm-12">
                                            <span class="frm-to">To:</span>
                                            <?php echo $this->Form->control('todate', ['label' => false, 'value'=>isset($formpostdata['todate'])? $formpostdata['todate']: '', 'placeholder' => '(yyyy-mm-dd) ', 'class'=>'form-control f-control-withspan', 'required'=>false]); ?>
                                                
                                            </div>
                                        </div>


                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-xxl-4 col-md-4 col-sm-12">
                        <?= $this->LRS->searchCancelBtn('m-r') ?>

                        <?php echo $this->Form->control('sno',['type'=>'hidden','id'=>'snoId','value'=>'']); ?>
                        <?php echo $this->Form->control('docstatus',['type'=>'hidden','id'=>'docstatusId','value'=>'']); ?>

                        </div>
                    </div>
                    </div>
                </div>
            </div>

            </div>
            </div>
        </div>
        <!-- table data -->
        <div class="card"> 
			<div class="card-body">
				<div class="live-preview">
				<!-- Records Listing -->
				<?php echo $this->element('checkin_records_list'); ?>
				</div> 
			</div> 
        </div> 
    </div>
   <?= $this->Form->end() ?>
</div>


<!-- Barcode Modal -->

<!-- Barcode Modal helper -->
<?php //echo $this->LRS->showBarCodeModelPop();
//echo "<pre>";print_r($vendor_services);echo "</pre>";
echo $this->LRS->showPasswordModelPop();
echo $this->LRS->showBarCodeModelPop($vendorlist, $vendor_services);
		echo $this->LRS->showLockModelPop();
         ?>

<?php
// DataTrace Exam Receipt Modal — auto-opens after successful API submission
// $dtExamReceipt is set by FilesVendorAssignmentController::index() from session
$dtExam = $dtExamReceipt ?? null;
if (!empty($dtExam)):
    $prop   = $dtExam['property']     ?? [];
    $vest   = $dtExam['vesting']      ?? [];
    $ts     = $dtExam['titleSearch']  ?? [];
    $mtgs   = $dtExam['mortgages']    ?? [];
    $jdg    = $dtExam['judgments']    ?? [];
    $tax    = $dtExam['taxes']        ?? [];
    $liens  = $dtExam['liens']        ?? [];
    $enc    = $dtExam['encumbrances'] ?? [];
    $cot    = $dtExam['chainOfTitle'] ?? [];
    $excep  = $dtExam['standardExceptions'] ?? [];
?>
<div class="modal fade" id="modalDataTraceResult" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="dtModalLabel">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header" style="background:#1a3c6e;color:#fff;">
                <div>
                    <h4 class="modal-title mb-0" id="dtModalLabel" style="color:#fff;">
                        <i class="las la-file-contract"></i> DataTrace — Exam Receipt
                    </h4>
                    <small style="opacity:.8;color:#fff;">Receipt ID: <strong><?= h($dtExam['examReceiptId'] ?? '') ?></strong>
                    &nbsp;|&nbsp; Submitted: <?= h($dtExam['submittedAt'] ?? '') ?>
                    &nbsp;|&nbsp; Examiner: <?= h($dtExam['examiner'] ?? '') ?></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-0">

                <!-- Status Banner -->
                <div class="alert alert-success mb-0 rounded-0 d-flex align-items-center" style="border-radius:0!important;">
                    <i class="las la-check-circle me-2 fs-4"></i>
                    <div>
                        <strong><?= h($dtExam['message'] ?? 'Success') ?></strong>
                        &nbsp;&mdash;&nbsp; Partner File: <strong><?= h($dtExam['partnerFileNo'] ?? '') ?></strong>
                        &nbsp;|&nbsp; NAT File: <strong><?= h($dtExam['natFileNo'] ?? '') ?></strong>
                        &nbsp;|&nbsp; ETA: <strong><?= h($dtExam['eta'] ?? '') ?></strong>
                    </div>
                </div>

                <!-- Nav Tabs -->
                <ul class="nav nav-tabs px-3 pt-2" id="dtTabs" role="tablist" style="background:#f8f9fa;">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#dt-property">Property</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dt-vesting">Vesting</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dt-mortgages">Mortgages</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dt-tax-jdg">Tax &amp; Judgments</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dt-cot">Chain of Title</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dt-exceptions">Exceptions</a></li>
                </ul>

                <div class="tab-content p-3">

                    <!-- TAB 1: Property -->
                    <div class="tab-pane fade show active" id="dt-property">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary border-bottom pb-1">Property Details</h6>
                                <table class="table table-sm table-bordered">
                                    <tr><th style="width:45%">Full Address</th><td><?= h($prop['fullAddress'] ?? '') ?></td></tr>
                                    <tr><th>County</th><td><?= h($prop['county'] ?? '') ?></td></tr>
                                    <tr><th>State</th><td><?= h($prop['state'] ?? '') ?></td></tr>
                                    <tr><th>ZIP Code</th><td><?= h($prop['zip'] ?? '') ?></td></tr>
                                    <tr><th>APN / Parcel No.</th><td><?= h($prop['apn'] ?? '') ?></td></tr>
                                    <tr><th>Property Type</th><td><?= h($prop['propertyType'] ?? '') ?></td></tr>
                                    <tr><th>Lot Size</th><td><?= h($prop['lotSize'] ?? '') ?></td></tr>
                                    <tr><th>Year Built</th><td><?= h($prop['yearBuilt'] ?? '') ?></td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary border-bottom pb-1">Legal Description</h6>
                                <div class="p-2 bg-light border rounded" style="font-size:.88rem;line-height:1.6;">
                                    <?= h($prop['legalDescription'] ?? '') ?>
                                </div>
                                <h6 class="text-primary border-bottom pb-1 mt-3">Title Search Scope</h6>
                                <table class="table table-sm table-bordered">
                                    <tr><th style="width:45%">Search Period</th><td><?= h($ts['searchPeriod'] ?? '') ?></td></tr>
                                    <tr><th>Search From</th><td><?= h($ts['searchFrom'] ?? '') ?></td></tr>
                                    <tr><th>Search To</th><td><?= h($ts['searchTo'] ?? '') ?></td></tr>
                                    <tr><th>County Searched</th><td><?= h($ts['county'] ?? '') ?></td></tr>
                                    <tr><th>Exam Date</th><td><?= h($ts['examDate'] ?? '') ?></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: Vesting -->
                    <div class="tab-pane fade" id="dt-vesting">
                        <h6 class="text-primary border-bottom pb-1">Current Vesting / Ownership</h6>
                        <table class="table table-sm table-bordered">
                            <tr><th style="width:30%">Current Owner</th><td><?= h($vest['currentOwner'] ?? '') ?></td></tr>
                            <tr><th>Ownership Type</th><td><?= h($vest['ownershipType'] ?? '') ?></td></tr>
                            <tr><th>Deed Type</th><td><?= h($vest['deedType'] ?? '') ?></td></tr>
                            <tr><th>Granted To</th><td><?= h($vest['grantedTo'] ?? '') ?></td></tr>
                            <tr><th>Acquisition Date</th><td><?= h($vest['acquisitionDate'] ?? '') ?></td></tr>
                            <tr><th>Recorded Date</th><td><?= h($vest['recordedDate'] ?? '') ?></td></tr>
                            <tr><th>Deed Book</th><td><?= h($vest['deedBook'] ?? '') ?></td></tr>
                            <tr><th>Deed Page</th><td><?= h($vest['deedPage'] ?? '') ?></td></tr>
                            <tr><th>Instrument No.</th><td><?= h($vest['instrumentNo'] ?? '') ?></td></tr>
                            <tr><th>Consideration</th><td><?= h($vest['consideration'] ?? '') ?></td></tr>
                        </table>
                    </div>

                    <!-- TAB 3: Mortgages -->
                    <div class="tab-pane fade" id="dt-mortgages">
                        <h6 class="text-primary border-bottom pb-1">Open Mortgages / Deeds of Trust</h6>
                        <?php if (empty($mtgs)): ?>
                            <div class="alert alert-success"><i class="las la-check-circle"></i> No Open Mortgages Found</div>
                        <?php else: ?>
                            <?php foreach ($mtgs as $m): ?>
                            <table class="table table-sm table-bordered mb-3">
                                <thead class="table-dark"><tr><th colspan="2">Mortgage #<?= h($m['index'] ?? '') ?> — <?= h($m['type'] ?? '') ?></th></tr></thead>
                                <tr><th style="width:30%">Lender</th><td><?= h($m['lenderName'] ?? '') ?></td></tr>
                                <tr><th>Borrower</th><td><?= h($m['borrower'] ?? '') ?></td></tr>
                                <tr><th>Original Amount</th><td><strong><?= h($m['originalAmount'] ?? '') ?></strong></td></tr>
                                <tr><th>Date Executed</th><td><?= h($m['dateExecuted'] ?? '') ?></td></tr>
                                <tr><th>Date Recorded</th><td><?= h($m['dateRecorded'] ?? '') ?></td></tr>
                                <tr><th>Book / Page</th><td><?= h(($m['book'] ?? '') . ' / ' . ($m['page'] ?? '')) ?></td></tr>
                                <tr><th>Instrument No.</th><td><?= h($m['instrumentNo'] ?? '') ?></td></tr>
                                <tr><th>Maturity Date</th><td><?= h($m['maturityDate'] ?? '') ?></td></tr>
                                <tr><th>Status</th><td><span class="badge bg-warning text-dark"><?= h($m['status'] ?? '') ?></span></td></tr>
                            </table>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- TAB 4: Tax & Judgments -->
                    <div class="tab-pane fade" id="dt-tax-jdg">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary border-bottom pb-1">Property Tax Status</h6>
                                <table class="table table-sm table-bordered">
                                    <tr><th style="width:50%">Parcel Number</th><td><?= h($tax['parcelNumber'] ?? '') ?></td></tr>
                                    <tr><th>Taxing Authority</th><td><?= h($tax['taxingAuthority'] ?? '') ?></td></tr>
                                    <tr><th>Tax Year</th><td><?= h($tax['taxYear'] ?? '') ?></td></tr>
                                    <tr><th>Status</th><td><span class="badge bg-success"><?= h($tax['status'] ?? '') ?></span></td></tr>
                                    <tr><th>Annual Amount</th><td><strong><?= h($tax['annualAmount'] ?? '') ?></strong></td></tr>
                                    <tr><th>1st Installment</th><td><?= h($tax['firstInstallment'] ?? '') ?></td></tr>
                                    <tr><th>2nd Installment</th><td><?= h($tax['secondInstallment'] ?? '') ?></td></tr>
                                    <tr><th>Next Due Date</th><td><?= h($tax['nextDueDate'] ?? '') ?></td></tr>
                                    <tr><th>Special Assessments</th><td><?= h($tax['specialAssessments'] ?? '') ?></td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary border-bottom pb-1">Judgment Search</h6>
                                <div class="alert <?= empty($jdg['records']) ? 'alert-success' : 'alert-danger' ?>">
                                    <i class="las la-<?= empty($jdg['records']) ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                                    <strong><?= h($jdg['status'] ?? '') ?></strong>
                                </div>
                                <p class="mb-1"><small><strong>Searched Against:</strong></small></p>
                                <ul class="list-group list-group-sm mb-3">
                                    <?php foreach (($jdg['searchedAgainst'] ?? []) as $name): ?>
                                    <li class="list-group-item py-1"><?= h($name) ?></li>
                                    <?php endforeach; ?>
                                </ul>

                                <h6 class="text-primary border-bottom pb-1">Lien Search</h6>
                                <div class="alert <?= empty($liens['records']) ? 'alert-success' : 'alert-danger' ?>">
                                    <i class="las la-<?= empty($liens['records']) ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                                    <strong><?= h($liens['status'] ?? 'Clear') ?></strong>
                                </div>

                                <?php if (!empty($enc)): ?>
                                <h6 class="text-primary border-bottom pb-1">Easements &amp; Encumbrances</h6>
                                <?php foreach ($enc as $e): ?>
                                <div class="card card-body p-2 mb-2" style="font-size:.85rem;">
                                    <strong><?= h($e['type'] ?? '') ?></strong><br>
                                    <?= h($e['description'] ?? '') ?><br>
                                    <span class="text-muted">Grantee: <?= h($e['grantee'] ?? '') ?> &nbsp;|&nbsp; Book <?= h($e['book'] ?? '') ?>, Pg <?= h($e['page'] ?? '') ?></span>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 5: Chain of Title -->
                    <div class="tab-pane fade" id="dt-cot">
                        <h6 class="text-primary border-bottom pb-1">Chain of Title — Last 3 Conveyances</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Grantor</th>
                                        <th>Grantee</th>
                                        <th>Date</th>
                                        <th>Deed Type</th>
                                        <th>Consideration</th>
                                        <th>Book / Page</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cot as $i => $c): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= h($c['grantor'] ?? '') ?></td>
                                        <td><?= h($c['grantee'] ?? '') ?></td>
                                        <td><?= h($c['date'] ?? '') ?></td>
                                        <td><?= h($c['type'] ?? '') ?></td>
                                        <td><?= h($c['consideration'] ?? '') ?></td>
                                        <td><?= h(($c['book'] ?? '') . ' / ' . ($c['page'] ?? '')) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB 6: Standard Exceptions -->
                    <div class="tab-pane fade" id="dt-exceptions">
                        <h6 class="text-primary border-bottom pb-1">Standard Title Exceptions</h6>
                        <ol class="mt-2">
                            <?php foreach ($excep as $ex): ?>
                            <li class="mb-2"><?= h($ex) ?></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="alert alert-info mt-3">
                            <strong>Note:</strong> This exam receipt is for informational purposes only and reflects the
                            state of title as of the search date. A full title commitment will be issued after review.
                        </div>
                    </div>

                </div><!-- end tab-content -->
            </div><!-- end modal-body -->

            <!-- Footer -->
            <div class="modal-footer" style="background:#f8f9fa;">
                <span class="text-muted me-auto" style="font-size:.82rem;">
                    DataTrace Exam Receipt &nbsp;|&nbsp; <?= h($dtExam['examReceiptId'] ?? '') ?> &nbsp;|&nbsp; <?= h($dtExam['submittedAt'] ?? '') ?>
                </span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="las la-print"></i> Print
                </button>
            </div>

        </div><!-- end modal-content -->
    </div>
</div>

<?php endif; // end datatrace_exam_receipt check ?>


<?php $this->append('script') ?>

<script type="text/javascript">
    $(document).ready(function () {
        // Auto-open DataTrace Exam Receipt modal if data was returned from API
        <?php if (!empty($dtExamReceipt)): ?>
        $('#modalDataTraceResult').modal('show');
        <?php endif; ?>

        // DataTrace delivery type toggle — hide CC vendor section when API is selected
        $(document).on("change", "[name=delivery_type]", function () {
            if ($(this).val() === "api") {
                $("#cc_vendor_wrap").hide();
            } else {
                $("#cc_vendor_wrap").show();
            }
        });

        $(document).on("change", "#vendorid", function () {
			var fileId = $(this).val(); // Get the file ID
			$.ajax({
				url: "<?= $this->Url->build(['controller' => 'FilesVendorAssignment', 'action' => 'getVendorService']) ?>",
				type: "POST",
				data: { file_id: fileId },
				dataType: "json",
				success: function (response) {
					if (response.success) {
						$("#serv").html(response.email); // Set the email in the input field
					} else {
					    var link = "<?= $this->Url->build(['controller' => 'FilesVendorAssignment', 'action' => 'attindex']) ?>";
						$(".asgn_error").html("Attorney is not assigned! Please click <a href='"+link+"'>here</a> to assign.");
					}
				},
				error: function () {
					alert("An error occurred while fetching the email.");
				}
			});
		});
    });

	$(document).ready(function () {
        // call function to load data table
        loadDataTable(); 

        $("button.dreceived").click(function(){
            var docReceived = [];
            $.each($(".checkSingle:checkbox:checked"), function(){ 
                var fileno = $(this).val() 
               // var doctypeval = $(this).parent().parent().find('input[type="text"]').val();
			    var doctypeval = $(this).parent().parent().find('input[name="docTypeInput"]').val();
				var documentTypeHidden = $(this).parent().parent().find('input[name="documentTypeHidden"]').val();
                var docidarray = doctypeval.split(',');
                $.each(docidarray, function( index, value ) {
                    docReceived.push(fileno+"_"+value+"_"+documentTypeHidden);
                });
            });
			
            if(docReceived.length == 0){ 
                alert("Please select at least one record");
                return false;
            }else{
                $("#docstatusId").val("dr");
                $("#snoId").val(docReceived.join(","));
                $( "#searchBtnId" ).trigger("click");
            }
        });


        $("button.dnreceived").click(function(){
            var docNotReceived = [];
            $.each($(".checkSingle:checkbox:checked"), function(){  
                var fileno = $(this).val() 
               // var doctypeval = $(this).parent().parent().find('input[type="text"]').val();
			    var doctypeval = $(this).parent().parent().find('input[name="docTypeInput"]').val();
			   
                var docidarray = doctypeval.split(',');
                $.each(docidarray, function( index, value ) {
                    docNotReceived.push(fileno+"_"+value);
                });
            });

            if(docNotReceived.length == 0){
                alert("Please select at least one record");
                return false;
            }else{
                $("#docstatusId").val("dnr");
				$("#snoId").val(docNotReceived.join(","));
                $( "#searchBtnId" ).trigger("click");
            }
        });

        $(document).on('change', '.checkSingle,#checkedAll', function() {
            var selectedValues = [];
            $('.checkSingle:checked').each(function() {
                selectedValues.push($(this).val());
            });
            $('#file_nos').val(selectedValues.join(','));
        });

        /*$(".assign_vendor").on("click", function(){
            var fileNosValue = $("#file_nos").val().trim(); // Get value and remove spaces

            if (!fileNosValue) { // Check if empty or null
                alert("Please select check box(es) before proceeding");
                return false; // Prevent further action
            }

            getBarcode1(); // Call your function if validation passes
        });*/
    });

    function loadDataTable(){ 
	
		
		
        var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'Y'};
        var columndata =<?php echo $dataJson;?>;
		//var columndata =[{"data":"Checkbox","orderable":false},{"data":"FileNo","orderable":true},{"data":"PartnerFileNumber","orderable":true},{"data":"Extension","orderable":true},{"data":"TransactionType","orderable":true},{"data":"Grantors","orderable":true},{"data":"StreetName","orderable":true},{"data":"County","orderable":true},{"data":"State","orderable":true},{"data":"DocStatus","orderable":true},{"data":"DateAdded","orderable":true},{"data":"Actions","orderable":false}];
		
        $('#datatable_example').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, 'All']],
			"processing": true,
            "pageLength": 10,
            "serverSide": true, 
            "searching": false,
            "dom": 'Blfrtip',  
			      "buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:first-child):not(:last-child)' } }], 
            "ajax": {
                url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxList".ucfirst($this->request->getParam('action'))]) ?>',
                data: formdata,
                type: 'POST',
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}
            },
            "columns": columndata,
            "order": [ [1, 'asc'] ],
            createdRow: function( row, data, dataIndex ) {
				/*if ( data['ECapable'] == "Both SF & CSC" ) {
					$(row).addClass( 'bothColor' );
				} else if( data['ECapable'] == "SF" ) {
					$(row).addClass( 'sfColor' );
				} else if(data['ECapable'] == 'CSC') {
					$(row).addClass( 'cscColor' );
				} else if ( data['lock_status'] == 1 ) {
					$(row).addClass( 'disabledColor' );
				} */ 
			}
        });
    }
	
	function getBarcode(obj,val1,val2){
		if(obj.checked == true){
          
			$.ajax({
				type: "POST",
				url: '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" =>  "generateBarcode"]) ?>',
				data: {"fileno": val1, "doctype": val2},
				success: function(data){
					$('#printThis').html(data);
					jQuery('#myModal').modal('show');
				},
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}
			});
		}
	} 

	function PrintElem(elem)
	{
		var mywindow = window.open('', 'PRINT', 'height=600,width=800');
		mywindow.document.write('<html><head><title>' + document.title  + '</title>');
		mywindow.document.write('</head><body >');
		mywindow.document.write('<h1>' + document.title  + '</h1>');
		mywindow.document.write(document.getElementById(elem).innerHTML);
		mywindow.document.write('</body></html>');

		mywindow.document.close(); // necessary for IE >= 10
		mywindow.focus(); // necessary for IE >= 10*/

		mywindow.print();
		mywindow.close();

		//return true;
	}

	
	function openLockModel(recId,  lock_status){
        
        $('#lockChechinId').val(recId); 
        $('#lock_status').val(lock_status); 
        jQuery('#myModalLock').modal('show');
        return false;
	} 

    function saveLockRecord(element){ 
       
        var lockChechinId = $('#'+element).find('#lockChechinId').val(); 
        var lock_status = $('#'+element).find('#lock_status').val();
        var lock_comment = $('#'+element).find('#lock_comment').val();
 
        $.ajax({
            type: "POST",
            url: '<?= $this->Url->build(["controller"=> "FilesVendorAssignment", "action" => "ajaxLockRecord"]) ?>',
            data: {"chechinId":lockChechinId, "lock_status":lock_status, "lock_comment":lock_comment},
            success: function(data){ 
                $('#'+element).find("input[type=text], input[type=hidden],textarea").val("");
               
               //jQuery('#myModalLock').find('.msg-suceess').html('Record lock status updated!'); 
               jQuery('#myModalLock').modal('hide'); 

               $("#datatable_example").DataTable().destroy();
                // call function to load data table
                loadDataTable();
            },
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}
        });   
        return false;
	}   
	
	
	
	function openPasswordModel(Id){
		$('#checkinId').val(Id);
        jQuery('#myModalPassword').modal('show');
        return false;
	}
</script>


<?php $this->end() ?>