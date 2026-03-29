<style>
h2.headings{ color:#f1702b; }
h4 { margin: 22px 0 0 0 !important;}
select{ background: #FFF !important;}
.question { margin-bottom: 20px; padding: 5px; border: 1px solid #ccc; border-radius: 8px; }
.sub-question { margin-left: 20px; margin-top: 2px; }
.question{ margin-top: 10px; }
b,strong,.input.textarea label{ font-weight: bold; }
</style>
<h1><?php //$vendor->isNew() ? 'Add Vendor' : 'Edit Vendor' ?></h1>

<?= $this->Form->create($AttorneyReviews, ['type' => 'file']) ?> <!-- Fix: Enable file upload -->
    <div class="container card">
        <div class="row">
            <h2 class="headings"><?= __('Edit Review') ?></h2>
            <div class="container mt-4">
                <div class="card shadow-lg p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6 mb-3"><strong>NAT File Number:</strong> <?= h($fmd_data['NATFileNumber']) ?></div>
                        <div class="col-md-6 mb-3"><strong>Status:</strong> <?= h($AttorneyReviews->status) ?></div>
                        <div class="col-md-6 mb-3"><strong>Comment:</strong> <?= h($AttorneyReviews->comment) ?></div>
                        <div class="col-md-6 mb-3"><strong>Reviewed By:</strong> <?= h($AttData->vendor) ?></div>
                        <div class="col-md-6 mb-3"><strong>AOL Ordered Date/Time:</strong> <?= h($AolData->pre_aol_date) ?></div>
                        <div class="col-md-6 mb-3"><strong>AOL Received Date/Time:</strong> <?= h($AolData->final_aol_date) ?></div>
                        <div class="col-md-6 mb-3"><strong>Submitted to Client Date/Time:</strong> <?= h($AolData->submit_aol_date) ?></div>
                    </div>
                    <!-- *************************************** Question Start *********************************************** -->
                    <?php
                    function showAnswer($val) {
                        if($val)
                        return '<div class="answer"><b>Answer: </b> ' . h($val) . '</div>';
                    }
                    function showExplanation($val) {
                        if($val)
                        return !empty($val) ? '<div class="explanation"><b>Explanation: </b>' . h($val) . '</div>' : '';
                    }
                  ?>

                  <div class="question">
                    <label><b>1. Legal Description Match</b></label>
                    <div class="sub-question">Does the legal description of the property match the following documents?</div>
                    <div class="sub-question"><li> Proposed AOL</li></div>
                    <div class="sub-question"><li> Vesting Deed & any proposed Conveyance Deed</li></div>
                    <div class="sub-question"><li> Proposed Security Instrument</li></div>
                    <div class="sub-question"><li> Title Records (e.g., prior recorded docs)</li></div>
                    <div class="sub-question"><li> Property Appraiser search results and/or Tax Certificate</li></div>
                    <?= showAnswer($AttorneyReviews->q1) ?>
                    <?= showExplanation($AttorneyReviews->explain1) ?>
                  </div>

                  <div class="question">
                    <label><b>2. Ownership Status</b></label>
                    <div class="sub-question">According to the Title Records, is the property held in fee simple?</div>
                    <?= showAnswer($AttorneyReviews->q2) ?>
                    <?= showExplanation($AttorneyReviews->explain2) ?>
                  </div>

                  <div class="question">
                    <label><b>3. Borrower(s) as Individuals</b></label>
                    <div class="sub-question">Are all Borrower(s) individuals?</div>
                    <?= showAnswer($AttorneyReviews->q3) ?>
                    <?php //if ($AttorneyReviews->q3 === 'No'): ?>
                    <div class="sub-question">
                      <label>a. Did the Settlement Agent provide organizational documents of the entity or trust that owns the property, and do these documents allow it to own real property?</label>
                      <?= showAnswer($AttorneyReviews->q3a) ?>
                      <?= showExplanation($AttorneyReviews->explain3a) ?>
                    </div>
                    <div class="sub-question">
                      <label>b. Has the entity/trust issued a resolution authorizing an individual to sign the proposed Security Instrument or Conveyance Deed?</label>
                      <?= showAnswer($AttorneyReviews->q3b) ?>
                      <?= showExplanation($AttorneyReviews->explain3b) ?>
                    </div>
                    <?php //endif; ?>
                  </div>

                  <div class="question">
                    <label><b>4. Security Instrument & AOL Consistency</b></label>
                    <div class="sub-question">Do the following match between the proposed Security Instrument and the proposed AOL?</div>
                    <div class="sub-question"><li> Loan number</li></div>
                    <div class="sub-question"><li> Loan amount</li></div>
                    <div class="sub-question"><li> Lender name</li></div>
                    <?= showAnswer($AttorneyReviews->q4) ?>
                    <?= showExplanation($AttorneyReviews->explain4) ?>
                  </div>

                  <div class="question">
                    <label><b>5. Land Boundary Survey</b></label>
                    <div class="sub-question">Did the Settlement Agent provide a land boundary survey for the property?</div>
                    <?= showAnswer($AttorneyReviews->q5) ?>
                    <?php if ($AttorneyReviews->q5 === 'Yes'): ?>
                    <div class="sub-question">
                      <label>a. Have all encroachments, easements, or issues noted on the survey been listed in Exhibit B (Matters of Record) of the proposed AOL?</label>
                      <?= showAnswer($AttorneyReviews->q5a) ?>
                      <?= showExplanation($AttorneyReviews->explain5a) ?>
                    </div>
                    <?php endif; ?>
                  </div>

                  <div class="question">
                    <label><b>6. Encumbrances & Title Matters</b></label>
                    <div class="sub-question">Does Exhibit B (Matters of Record) in the proposed AOL accurately identify all the following, as shown in the Title Records?</div>
                    <div class="sub-question"><li> Encumbrances</li></div>
                    <div class="sub-question"><li> Subsurface interests (e.g., mineral rights)</li></div>
                    <div class="sub-question"><li> Liens, judgments, CC&Rs, easements, etc.</li></div>
                    <div class="sub-question"><li> Any unpaid items not addressed by the payoff statement</li></div>
                    <?= showAnswer($AttorneyReviews->q6) ?>
                    <?= showExplanation($AttorneyReviews->explain6) ?>
                  </div>

                  <div class="question">
                    <label><b>7. Final Approval</b></label>
                    <div class="sub-question">After reviewing all of the above, do you approve the issuance of the Attorney Opinion Letter for this transaction?</div>
                    <?= showAnswer($AttorneyReviews->q7) ?>
                    <?= showExplanation($AttorneyReviews->explain7) ?>
                  </div>
                  <div class="question1">&nbsp;</div>
                    <!-- *************************************** Question End *********************************************** -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label><strong>Supporting Documentation</strong></label>
                            <?php if (!empty($AttorneyReviews->supporting_documentation)): ?>
                                <p>Current File:
                                    <a href="<?= $this->Url->build('/uploads/' . $AttorneyReviews->supporting_documentation, ['fullBase' => true]) ?>" target="_blank">
                                        <?= h($AttorneyReviews->supporting_documentation) ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            <?= $this->Form->control('supporting_documentation', [
                                'type' => 'file',
                                'label' => false,
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <div class="col-md-12 mb-3">
                            <?= $this->Form->control('notes_clearing_curative', [
                                'type' => 'textarea',
                                'label' => 'Notes/Clearing/Curative',
                                'class' => 'form-control',
                                'rows' => 4
                            ]) ?>
                        </div>

                        <div class="col-12 text-center">
                            <?= $this->Form->button(__('Update'), ['class' => 'btn btn-primary px-4']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->Form->end() ?>

