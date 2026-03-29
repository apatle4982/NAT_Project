<style type="text/css">
<!--
label {margin-right: 10px;}
h2 {margin: 20px;}
.form-control, .form-control-sm { padding: 0px 7px !important;}
-->
.jSignature {
    height: 118px !important;
}
#signature-pad {
    cursor: url('https://nat.tiuconsulting.us/assets/images/pen.png'), crosshair !important;
}
</style>
<?php if (isset($reviewId)): ?>
    <!--<p class="text-center">Review ID: <?= h($reviewId) ?></p>-->
<?php
$version = time();
$pdfPath = $this->Url->build("/files/export/aol_assignment/pdf/final/AssignmentDetails-" . h($reviewId).".pdf?v=".$version, ['fullBase' => true]);
?>
<?php endif; ?>
<?php //echo "<pre>";print_r($fmd_data);echo "</pre>"; ?>
<div class="col-lg-12">
<div class="card">
<h2 class="text-center">Attorney Review</h2>
<div class="container">
    <div class="row">
        <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
            <b>NAT File Number:</b> <?= h($fmd_data['NATFileNumber']) ?><br>
            <b>Loan Number:</b> <?= h($fmd_data['LoanNumber']) ?><br>
            <b>Loan Amount:</b> <?= h($fmd_data['LoanAmount']) ?><br>
            <b>Transaction Type:</b> <?= h($fmd_data['TransactionType']) ?><br>
            <b>File Start Date:</b> <?= h($fmd_data['FileStartDate']) ?><br>
        </div>
        <div class="col-md-6">
            <b>Street Number:</b> <?= h($fmd_data['StreetNumber']) ?><br>
            <b>City:</b> <?= h($fmd_data['City']) ?><br>
            <b>State:</b> <?= h($fmd_data['State']) ?><br>
            <b>County:</b> <?= h($fmd_data['County']) ?><br>
            <b>Zip:</b> <?= h($fmd_data['Zip']) ?><br>
        </div>
        </div>
        <div>&nbsp;</div>
            <?= $this->Form->create($review) ?>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="mb-3">
                    <div>
                    <label class="d-block"><?= $i ?>. Question</label>
                    <!--<?= $this->Form->text("question_$i", ['class' => 'form-control mb-2', 'required' => true]) ?>-->
                    </div>
                    <div>
                    <!--<label class="d-block">Answer <?= $i ?></label>-->
                    <?= $this->Form->textarea("answer[$i]", ['class' => 'form-control', 'placeholder'=> "Write your answer here", 'required' => true]) ?>
                    </div>
                </div>
            <?php endfor; ?>
            <div class="mb-3">
                <label class="d-block">I <?= h($attorney_dtl['name']) ?> have reviewed the Search and Exam and approve.....</label>
            </div>
            <div class="mb-3">
                <label class="d-block">Accept / Deny</label>
                <?= $this->Form->radio('status', [
                    'accept' => 'Accept',
                    'deny' => 'Deny'
                ], ['class' => 'form-check-input', 'required' => true, 'id' => 'status']) ?>
            </div>

            <div id="deny_comment" class="mb-3">
                <label class="d-block">Comments</label>
                <?= $this->Form->textarea('comment', ['class' => 'form-control']) ?>
            </div>

            <div class="attorney-signature mb-3" style="height:215px;">
                <label class="d-block">Signature of Reviewing Attorney</label>
                <div id="signature-container">
                    <div id="signature-pad" style="border: 1px solid #000; width: 100%; height: 120px;"></div>
                </div>
                <button type="button" id="clear-signature" class="btn btn-warning mt-2 mb-3">Clear</button>
                <button type="button" id="save-signature" class="btn btn-success mt-2 mb-3">Save Signature</button>
                <label class="d-block">By clicking "Submit", you agree to the terms outlined above and acknowledge that your signature serves as a formal acceptance of this document.</label>  
                <input type="hidden" name="RecIdSign" value="<?= $reviewId;?>">
                <input type="hidden" id="signature-data" name="signature">
            </div>
            <div id="deny_comment" class="mb-3">
            <?= $this->Form->hidden('RecId', ['value' => $reviewId]) ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <button class="btn btn-primary pdf">View PDF</button>
                <button class="btn btn-secondary exam">View Receipt of Exam</button>
            </div>
            <div class="reviewpdf"><iframe src="<?= isset($reviewId) ? $pdfPath . '#view=FitH' : $this->Url->build('/files/sample.pdf', ['fullBase' => true]) . '#view=FitH' ?>" width="100%" height="750px" class="border rounded"></iframe></div>
            <div class="reviewexam" style="display: none;">
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12">
                                <label class="mb-0">Partner: <?= h($companyMsts[$partner_id] ?? 'N/A'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Official Property Address as Titled</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12">
                                <label class="mb-0">Property Address: <?= $examReceiptFields['OfficialPropertyAddress'] ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Vesting - Chain of Title Information</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <?php
                            $vesting_attributes = json_decode($examReceiptFields['vesting_attributes']);echo "</pre>";
                            $fields = [
                                'VestingDeedType' => 'Deed Type: ',
                                'VestingConsiderationAmount' => 'Consideration Amount: ',
                                'VestedAsGrantee' => 'Vested As (Grantee): ',
                                'VestingGrantor' => 'Grantor: ',
                                'VestingDated' => 'Dated: ',
                                'VestingRecordedDate' => 'Recorded Date: ',
                                'VestingBookPage' => 'Book/Page: ',
                                'VestingInstrument' => 'Instrument #: ',
                                'VestingComments' => 'Comments: '
                            ];

                            foreach($vesting_attributes as $vesting){
                                foreach ($fields as $key => $label){ ?>
                                    <div class="col-xxl-12 col-md-12">
                                        <label class="mb-0"><?= h($label); ?> <?= h($vesting->$key ?? 'N/A'); ?></label>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Open Mortgage Information</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <?php
                            $open_mortgage_attributes = json_decode($examReceiptFields['open_mortgage_attributes']);
                            $fields = [
                                'OpenMortgageAmount' => 'Amount $: ',
                                'OpenMortgageDated' => 'Dated: ',
                                'OpenMortgageRecordedDate' => 'Recorded (Date): ',
                                'OpenMortgageBookPage' => 'Book/Page: ',
                                'OpenMortgageInstrument' => 'Instrument #: ',
                                'OpenMortgageBorrowerMortgagor' => 'Borrower (Mortgagor): ',
                                'OpenMortgageLenderMortgagee' => 'Lender (Mortgagee): ',
                                'OpenMortgageTrustee1' => 'Trustee 1: ',
                                'OpenMortgageTrustee2' => 'Trustee 2: ',
                                'OpenMortgageComments' => 'Comments: '
                            ];

                            foreach($open_mortgage_attributes as $open_mortgage){
                                foreach ($fields as $key => $label){ ?>
                                    <div class="col-xxl-12 col-md-12">
                                        <label class="mb-0"><?= h($label); ?> <?= h($open_mortgage->$key ?? 'N/A'); ?></label>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>

                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Open Judgments & Encumbrances</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <?php
                            $open_judgments_attributes = json_decode($examReceiptFields['open_judgments_attributes']);
                            $fields = [
                                'OpenJudgmentsType' => 'Type: ',
                                'OpenJudgmentsLienHolderPlaintiff' => 'Lien Holder/Plaintiff: ',
                                'OpenJudgmentsBorrowerDefendant' => 'Borrower/Defendant: ',
                                'OpenJudgmentsAmount' => 'Amount $: ',
                                'OpenJudgmentsDateEntered' => 'Date Entered: ',
                                'OpenJudgmentsDateRecorded' => 'Date Recorded: ',
                                'OpenJudgmentsBookPage' => 'Book/Page: ',
                                'OpenJudgmentsInstrument' => 'Instrument #: ',
                                'OpenJudgmentsComments' => 'Comments: '
                            ];

                            foreach($open_judgments_attributes as $open_judgments){
                                foreach ($fields as $key => $label){ ?>
                                    <div class="col-xxl-12 col-md-12">
                                        <label class="mb-0"><?= h($label); ?> <?= h($open_judgments->$key ?? 'N/A'); ?></label>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Tax Status and Assessor Information</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <?php foreach ([
                                'Tax Status' => 'TaxStatus',
                                'Tax Year' => 'TaxYear',
                                'Tax Amount' => 'TaxAmount',
                                'Tax Type' => 'TaxType',
                                'Payment Schedule' => 'TaxPaymentSchedule',
                                'Due Date' => 'TaxDueDate',
                                'Deliquent Date' => 'TaxDeliquentDate',
                                'Comments' => 'TaxComments',
                                'Land Value' => 'TaxLandValue',
                                'Building Value' => 'TaxBuildingValue',
                                'Total Value' => 'TaxTotalValue',
                                'APN/Account #' => 'TaxAPNAccount',
                                'Assessed Year' => 'TaxAssessedYear',
                                'Total Value (2)' => 'TaxTotalValue2',
                                'Municipality/County' => 'TaxMunicipalityCounty'
                            ] as $label => $field): ?>
                                <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                        <label class="form-label mb-0"><?= $label ?></label>
                                        <div><?= h($examReceiptFields[$field] ?? '') ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Legal Description</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12">
                                <div class="input-container-floating">
                                    <label class="mb-0">Legal Description: <?= nl2br(h($examReceiptFields['LegalDescription'] ?? '')) ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12">
                                <strong>NAT File Number:</strong> <?= h($FilesMainData['NATFileNumber']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Partner File Number:</strong> <?= h($FilesMainData['PartnerFileNumber']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>File Start Date:</strong> <?= isset($filesCheckinData['file_start_date']) ? h(date('Y-m-d H:i:s', strtotime($filesCheckinData['file_start_date']))) : '' ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Center/Branch:</strong> <?= h($FilesMainData['CenterBranch']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Loan Amount:</strong> <?= h($FilesMainData['LoanAmount']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Loan Number:</strong> <?= h($FilesMainData['LoanNumber']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Transaction Type:</strong> <?= h($FilesMainData['TransactionType']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Street Number:</strong> <?= h($FilesMainData['StreetNumber']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Street Name:</strong> <?= h($FilesMainData['StreetName']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>City:</strong> <?= h($FilesMainData['City']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>County:</strong> <?= h($FilesMainData['County']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>State:</strong> <?= h($FilesMainData['State']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Zip:</strong> <?= h($FilesMainData['Zip']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>APN/Parcel Number:</strong> <?= h($FilesMainData['APNParcelNumber']) ?>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                <strong>Legal Description (Short Legal):</strong> <?= h($FilesMainData['LegalDescriptionShortLegal']) ?>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    /*$('input[name="status"]').on('change', function() {
        if ($(this).val() === "deny") {
            $('#deny_comment').show();
        } else {
            $('#deny_comment').hide();
        }
    });*/

    $(".pdf").click(function () {
        $(".reviewpdf").show();
        $(".reviewexam").hide();
    });

    $(".exam").click(function () {
        $(".reviewexam").show();
        $(".reviewpdf").hide();
    });
});

$(document).ready(function () {
    // Initialize jSignature
    var isSigned = false;
    $("#signature-pad").jSignature({ width: '100%'});
    $(".attorney-signature").hide();

    $("#signature-pad").jSignature().bind('change', function () {
        isSigned = true;
    });

    // Clear Signature
    $("#clear-signature").click(function () {
        $("#signature-pad").jSignature("reset");
        $("#signature-pad").jSignature("clear");
        isSigned = false;
    });

    // Save Signature
    $("#save-signature").click(function (e) {

        let signatureData = $("#signature-pad").jSignature("getData", "image"); // Get PNG Data
        $("#signature-data").val(signatureData);
        e.preventDefault();

        if (!isSigned || !signatureData || signatureData[1].length === 0) {
            alert("Important Notice:\n\nTo acknowledge, signature is mandatory for acceptance of this document.");
            return false;
        }

        var form = $("form"); 
        form.attr("action", "<?= $this->Url->build(['controller' => 'Reviews', 'action' => 'saveSignature']); ?>"); // Set new action
        form.attr("method", "POST");
        form.submit();

    });
    $('input[type=radio][name=status]').change(function() {
        if (this.value == 'accept') {
            $(".attorney-signature").show();
        } else {
            $(".attorney-signature").hide();
        }
    });
});

</script>