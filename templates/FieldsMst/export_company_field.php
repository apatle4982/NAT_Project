<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\FieldsMst> $fieldsMst
 */ 

 	if(!empty($postData)){
		$reportData = $postData;  
		$reportData['id']= $postData['report_id']; //(!empty($postData['report_id']) ? $postData['report_id'] : '');
	} 
 
?>
 <div class="col-xxl-12 col-md-12">
		<?php if(isset($csvFilename)) echo $this->Lrs->loadDownloadLink($csvFilename,'export', 'Download Export Sheet'); ?>
	</div>
<div class="container-fluid lrs-frm sml-field">
	
	<?= $this->Form->create($fieldsMsts, ['action'=>'export-company-field']) ?>
		<div class="row">
		<div class="col-xxl-8 col-md-8 col-sm-12">
			<div class="card">
				
				<div class="card-body">
				
					<div class="live-preview"> 
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12" id="selectDrop"> 
								<input type="checkbox" id="select_all" value="all"> Select All
								<select multiple="multiple" name="export_fields[]" id="multiselect-optiongroup">
									<?php  
										$is_selected = ''; foreach($fieldsSectionData as $fieldSection):  ?>
										<optgroup label="<?= h($fieldSection['section_name']) ?>"> 
											<?php foreach($fieldSection['fields_mst'] as $fieldsMst): 
												//if(!empty($reportData)) $postData['export_fields'] = $reportData['export_fields'] ;
												if(isset($reportData['export_fields'])): 
													foreach($reportData['export_fields'] as $fieldsKey):
														$is_selected = (($fieldsKey == $fieldsMst['fm_id']) ? 'selected': '');
														if(!empty($is_selected)) break; 
													endforeach;
												endif;
											?>
										<option <?= __($is_selected) ?> value="<?= $fieldsMst['fm_id']; ?>"><?= h($fieldsMst['display_fm_title']) // (!empty($partnerMapFields['mappedtitle'][$fieldsMst['fm_title']]) ? $partnerMapFields['mappedtitle'][$fieldsMst['fm_title']] : h($fieldsMst['display_fm_title']))  ?></option>
										<?php endforeach;  	
									endforeach; ?>
								</select> 
							</div>
							
						</div>
						<!--end row-->
					</div> 
				</div>
			</div>
		</div> 
		<div class="col-xxl-4 col-md-4 col-sm-12">
			<div class="card">
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Choose Filter</h4> 
				</div> 
				<div class="card-body">
					<div class="live-preview  img-availability">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label for="basiInput" class="form-label">Select Client</label>
									<?=  $this->Form->select('company_id',$partnerlist,['multiple' => false, 'value'=>(!empty($reportData) ? $reportData['company_id']: ''), 'empty' => 'ALL', 'class'=>'js-example-basic-single form-control', 'label' => false]); ?> 
				  				</div>
							</div>
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									<label for="basiInput" class="form-label">Transaction Type</label>
									<?=  $this->Form->select('document_status',['1'=>"1 - Purchase Complete", '2'=>"2 - Purchase AOL Only", '3'=>"3 - Refinance Complete", '4'=>"4 - Refinance AOL Only"],['multiple' => false, 'value'=>(!empty($reportData) ? $reportData['document_status']: ''), 'empty' => 'Select Transaction Type','class'=>'js-example-basic-single form-control', 'label' => false]); ?> 
						
									</div>
							</div>
							<!--<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
								<label for="basiInput" class="form-label">Section</label>
								<?=  $this->Form->select('date_section',[/* 'fmd'=>"Record Listing",  */'fcd'=>"Record Check In", 'fqcd'=>"Record Rejection", 'fsad'=>"Shipping Data", 'fad'=>"Accounting Data", 'frd'=>"Recording Data", 'frtp'=>"Return File To Partner"],['multiple' => false, 'value'=>(!empty($reportData) ? $reportData['date_section']: ''), 'empty' => 'Select Section','class'=>'js-example-basic-single form-control', 'required'=>'required', 'label' => false]); ?> 
								</div>
							</div>-->
							<!---- Date range start------->
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
								
									<label class="form-label mb-0">Date Range</label>
									<div style="width:60%; float:left;">
										<div class="row">
											<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating">
													<label class="form-label mb-0">From</label>
													<input name="date_from" class="form-control flatpickr-input" required data-provider="flatpickr" placeholder="YYYY-MM-DD" value="<?= (!empty($reportData['date_from']) ? date('Y-m-d', strtotime($reportData['date_from'])): '');?>"> 
													 
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
												<label class="form-label mb-0">To</label>
												<input name="date_to" class="form-control flatpickr-input" data-provider="flatpickr" placeholder="YYYY-MM-DD" value="<?= (!empty($reportData['date_to']) ? date('Y-m-d', strtotime($reportData['date_to'])) : '');?>"> 
											</div>
											</div>
										</div>
									</div>
									
								</div>					 
							</div>
							<!---- Date range ends------->
							 
						<!--end row-->
					</div> 
				</div>
				</div>
				<div class="card-header align-items-center d-flex">
					<h4 class="card-title mb-0 flex-grow-1">Memorize  / Save Report</h4> 
				</div> 
				<div class="card-body">
					<div class="live-preview  img-availability">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating"> 
								
									<label class="form-label mb-0">Save As</label>
									<input type="text" id="sheet_name" name="sheet_name" value="<?= (!empty($reportData) ? $reportData['sheet_name']: '');?>" class="form-control" Placeholder="Reportsettingfile">
									
								</div> 
							</div>
							</div>
						 									
						</div>
						<!--end row-->
					</div> 
					
				<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Choose Memorized Report </h4> 
				</div> 
				<div class="card-body">
					<div class="live-preview img-availability">
						<div class="row gy-4">
							<div class="col-xxl-12 col-md-12">
								<div class="input-container-floating">
									 
									<div class="card-body"> 
										<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
											<table class="display table table-bordered table-striped" style="width:100%">
												<thead>
													<tr>
														<th>List all memorized Reports</th>
														<th>Action</th> 
													</tr>
												</thead>
												<tbody>  
													<?php $r = 0; foreach($listReports as $report):?>
													
														<tr class="<?= (($r%2) ? 'even' : 'odd'); ?> map-fld-title"> 
															<td>
																<?= $this->Html->link(__($report['sheet_name']), ['controller' => 'FieldsMst', 'action' => 'exportCompanyField', "?"=>['record_id'=>$report['id']]]) ?>
															</td> 
															<td>	
																<input class="form-check-input mr-5" value="<?= __($report['id']); ?>" type="radio" disabled name="report_id_rd" <?= ((!empty($reportData)&& ($reportData['id'] == $report['id']))? 'checked': '');?>> 
															
																<?= $this->Html->link('<i class="ri-delete-bin-line"></i>', ['controller' => 'FieldsMst', 'action' => 'deleteReport/'.$report['id']], ['confirm' => __('Are you sure you want to delete this report?'), 'escape'=>false,'class' => 'link-danger fs-15', 'title'=>'Delete Report']); ?>
 															</td>
														</tr>
														<?php endforeach; ?>
											
												</tbody>      
										</table>
										<input name="report_id" type="hidden" value="<?= (!empty($reportData) ? $reportData['id']: ''); ?>">
										</div>
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
		
	
	<!--------------row end------------->	 
			
			<div class="col-lg-12 text-center btm-inline"> 
				<div style="display:inline-block;">
					<?= $this->Form->submit(__('Memorize Report'),['name'=>'saveReportBtn', 'id'=>'saveReportBtn', 'class'=>'btn btn-success']); ?>
				</div> 	
				<div style="display:inline-block;">
					<?= $this->Form->submit(__('Run Report'),['name'=>'runReportBtn', 'id'=>'runReportBtn', 'class'=>'btn btn-success', /* 'onclick'=>'if (confirm("Are you sure you want to save this report?")) { return true; } event.returnValue = false; return false;' */]); ?>
				</div> 

				<div style="display:inline-block;"> 
					<?= $this->Html->link(__('Cancel'), ['action' => 'export-company-field'], ['class' => 'btn btn-danger']) ?> 
				</div>  
			</div>
			
		</div>
		
	</div>

	<?= $this->Form->end() ?>						                
</div> 

 
<?php $this->append('script') ?>
 
 <script>
  document.addEventListener('DOMContentLoaded', function() {
    var selectElement = document.getElementById('multiselect-optiongroup');
    var selectAllCheckbox = document.getElementById('select_all');

    if (selectElement && selectAllCheckbox) {
        // Initialize Multi.js
        multi(selectElement);

        // Check if all options are selected
        var allSelected = Array.from(selectElement.options).every(option => option.selected);
        selectAllCheckbox.checked = allSelected;

        // Handle 'Select All' checkbox change event
        selectAllCheckbox.addEventListener('change', function() {
            for (var i = 0; i < selectElement.options.length; i++) {
                selectElement.options[i].selected = selectAllCheckbox.checked;
            }
            // Trigger change event to update Multi.js UI
            var event = new Event('change');
            selectElement.dispatchEvent(event);
        });
    } else {
        console.error('Required elements are not present in the DOM.');
    }
});
</script>

<script type="text/javascript">
	$('#saveReportBtn').click(function() {
		let save_report = $('#sheet_name').val();
		if(save_report == ""){
			alert('Please provide report name to memorize report!');
			$('#sheet_name').focus();
			return false;
		}
	});
</script>

<?php $this->end() ?>