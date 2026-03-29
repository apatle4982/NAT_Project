<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentTypeMst $documentTypeMst
 */
 
?> 
 
			
<?= $this->Form->create($documentTypeMst) ?>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Document Detail</h4> 
            </div>
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-6 col-md-6 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label">CountyCal Document Type<span style="color:#CA3F48">*</span></label>
                                    <?php
										echo $this->Form->control('document_Countycal_id', ['options' => $docCountycalType, 
											'multiple' => false, 
											'empty' => 'Select CountyCal Document Type',
											'class'=>'form-control', 
											'label'=>false,
											'required'=>true
										]);
                                        ?>
                                    </div>
                                </div>
								<div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label">CSC Document Type<span style="color:#CA3F48">*</span></label>
                                    <?php
										echo $this->Form->control('document_csc_id', ['options' => $docCSCType, 
											'multiple' => false, 
											'empty' => 'Select CSC Document Type',
											'class'=>'form-control', 
											'label'=>false,
											'required'=>true
										]);
                                        ?>
                                    </div>
                                </div>
								<div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label">Simplifile Document Type<span style="color:#CA3F48">*</span></label>
                                    <?php
										echo $this->Form->control('document_simplifile_id', ['options' => $docSimplifileType, 
											'multiple' => false, 
											'empty' => 'Select Simplifile Document Type',
											'class'=>'form-control', 
											'label'=>false,
											'required'=>true
										]);
                                        ?>
                                    </div>
                                </div>
								
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label">Title</label>
										<?= $this->Form->control('Title', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
									</div>
								</div>
								
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label label-nt-vis">Test</label>
										<div class="col-lg-12 text-left btm-inline mob-btn-inline"> 
											<div style="display:inline-block;">
												<div class="submit"><?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success']); ?></div> 
											</div> 
											<div style="display:inline-block;"> 
												<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end row-->
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
<!--end row-->
<?= $this->Form->end() ?>