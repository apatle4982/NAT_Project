<style>
    h2.headings{ color:#f1702b; }
    h4 { margin: 22px 0 0 0 !important;}
    select{ background: #FFF !important;}
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
                        <div class="col-md-6 mb-3"><strong>AOL Ordered Date/Time:</strong> <?= h($AolData->created_date) ?></div>
                        <div class="col-md-6 mb-3"><strong>AOL Received Date/Time:</strong> <?= h($AolData->created_date) ?></div>
                        <div class="col-md-6 mb-3"><strong>Submitted to Client Date/Time:</strong> <?= h($AttorneyReviews->created_date) ?></div>
                    </div>
                    <?php $answer = json_decode($AttorneyReviews->answer);
                    //if(count($answer)>0){ ?>
                    <h4 class="headings mb-3"><?= __('Questions and Answers') ?></h4>
                        <?php
                        foreach($answer as $que=>$ans){ ?>
                        <div class="row g-3 mb-3">
                            <div class="col-md-12 mb-1"><strong>Question <?=$que ?>:</strong></div>
                            <div class="col-md-12 mb-2"><strong>Answer: <?=$ans ?></strong></div>
                        </div>
                        <?php } ?>
                    <?php //} ?>

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

