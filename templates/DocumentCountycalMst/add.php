<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentCountycalMst $documentCountycalMst
 * @var \Cake\Collection\CollectionInterface|string[] $States
 */
?>
<?= $this->Form->create($documentCountycalMst) ?>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-6 col-md-6 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label">State<span style="color:#CA3F48">*</span></label>
										
										<?php echo $this->Form->control('State_code', 
										['label'=>false,
										'options' => $StateList, 'onchange'=>'getCounty(this.value,"company_div")', 'multiple' => false, 'empty' => 'Select State','class'=>'form-control', 'required'=>true]); ?>
									</div>
								</div>
								
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">
										
										<label class="form-label mb-0">County<span style="color:#CA3F48">*</span></label>
										<div id="company_div">
											<?php echo $this->Form->control('County_id', ['label'=>false, 'options' => $CountyList, 'multiple' => false, 'empty' => 'Select County','class'=>'form-control', 'required'=>true]); ?>
										</div>
										  
									</div>
								</div>
								
								<div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label">Document Type<span style="color:#CA3F48">*</span></label>
                                    <?php
										echo $this->Form->control('document_type_id', ['options' => $DocumentTypeData, 
											'multiple' => false, 
											'empty' => 'Select Document Type',
											'class'=>'form-control', 
											'label'=>false,
											'required'=>true
										]);
                                        ?>
                                    </div>
                                </div>
								<div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label">CountyCal Document Type Name<span style="color:#CA3F48">*</span></label>
                                    
                                    <?php echo $this->Form->control('document_type_name', ['label' => false, 'class'=>'form-control', 'required'=>true]); ?>
            
                                    </div>
                                </div>
								<div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label">CountyCal Document Type Id<span style="color:#CA3F48">*</span></label>
                                    
                                    <?php echo $this->Form->control('document_type_id', ['type' => 'text', 'label' => false, 'class'=>'form-control', 'required'=>true]); ?>
            
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


<?php $this->append('script') ?>


<script>
	
	function  getCounty(StateId, divId){ 
		$.ajax({
		  method: "POST",
		  url : '<?= $this->Url->build(["controller" => 'DocumentCountycalMst',"action" => "searchCountyAjax"]) ?>',
		  data: { id: StateId}
		}).done(function(returnData){
			
			$('#'+divId).html(returnData);
			$("select").select2();
		});
	}
</script>
<?php $this->end() ?>