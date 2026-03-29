<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesCheckinData[]|\Cake\Collection\CollectionInterface $filesCheckinData
  */
?>

<!-- ================================================================ -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <?= $this->Form->create($FilesCheckinData, ['horizontal'=>true]) ?>
        <div class="col-lg-12">

        <div class="card">	
            <div class="card-body">
                <div class="live-preview ">
                    <div class="row long-lbl-frm">
						<div class="col-xxl-10 col-md-10 col-sm-12">
                        
						
							<div class="row">
								<div class="col-xxl-4 col-md-4 col-sm-12">
									<h2>File</h2> 
									<div class="row">
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
											<label for="basiInput" class="form-label"><?= (isset($partnerMapField['mappedtitle']['company_id'])? ($partnerMapField['mappedtitle']['company_id'] != 'company_id') ? $partnerMapField['mappedtitle']['company_id']: 'Partner' : 'Partner') ?></label>
											
											<?php 
													echo $this->Form->control('company_id', ['value' => isset($formpostdata['company_id'])? $formpostdata['company_id']: '', 'options' => $companyMsts, 'multiple' => false, 'empty' => 'Select Partner', 'class'=>'form-control','label'=>false, 'required'=>false]);
												?>
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
											<label for="basiInput" class="form-label"><strong><?= ((isset($partnerMapField['mappedtitle']['LoanNumber']) && (!empty($partnerMapField['mappedtitle']['LoanNumber'])))? $partnerMapField['mappedtitle']['LoanNumber']: 'Loan Number') ?></strong></label>
											<?php echo $this->Form->control('LoanNumber', ['value'=>isset($formpostdata['LoanNumber'])? $formpostdata['LoanNumber']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>

											</div>
										</div>
										<div class="col-xxl-12 col-md-12 col-sm-12">
											<div class="input-container-floating">
												<label for="basiInput" class="form-label">FileStartDate</label>
												<div class="two-input">
													<div class="row">
														<div class="col-xxl-12 col-md-12 col-sm-12">
														<?php echo $this->Form->control('FileStartDate', ['value'=>isset($formpostdata['FileStartDate'])? $formpostdata['FileStartDate']: '' ,
														'label' => false, 
														'class'=>'form-control f-control-withdtspan', 'required'=>false]); ?>
														<span class="frm-dt">( yyyy-mm-dd )</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12 col-sm-12">
											<div class="input-container-floating">
												<label for="basiInput" class="form-label">File End Date</label>
												<div  class="two-input">
													<div class="row">
														<div class="col-xxl-12 col-md-12 col-sm-12">
														<?php echo $this->Form->control('FileEndDate', ['value'=>isset($formpostdata['FileEndDate'])? $formpostdata['FileEndDate']: '' ,
														'label' => false, 
														'class'=>'form-control f-control-withdtspan', 'required'=>false]); ?>
														<span class="frm-dt">( yyyy-mm-dd )</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xxl-4 col-md-4 col-sm-12">
									<h2>Property</h2>
									<div class="row">
									 
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= ((isset($partnerMapField['mappedtitle']['StreetNumber']) && (!empty($partnerMapField['mappedtitle']['StreetNumber'])))? $partnerMapField['mappedtitle']['StreetNumber']: 'Street Number') ?></strong></label>
											
											<?php echo $this->Form->control('StreetNumber', ['label' => false, 'value'=>isset($formpostdata['StreetNumber'])? $formpostdata['StreetNumber']: '' ,
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
										<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating">
												<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['City'])? $partnerMapField['mappedtitle']['City']: 'City') ?></strong></label>
												<?php echo $this->Form->control('City', [
												'label' => false, 'class'=>'form-control', 'required'=>false]); ?>
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
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Zip'])? $partnerMapField['mappedtitle']['Zip']: 'Zip') ?></strong></label>
											<?php echo $this->Form->control('Zip', [ 'label' => false,
											'value'=>isset($formpostdata['Zip'])? $formpostdata['Zip']: '' , 'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-xxl-4 col-md-4 col-sm-12">
										
									<div class="row mortage-padd">
										<H2>Grantor</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantor(s) ') ?></strong></label>
											<?php echo $this->Form->control('Grantors', ['value'=>isset($formpostdata['Grantors'])? $formpostdata['Grantors']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['GrantorFirstName1'])? $partnerMapField['mappedtitle']['GrantorFirstName1']: 'First Name (1)') ?></strong></label>
											<?php echo $this->Form->control('GrantorFirstName1', ['value'=>isset($formpostdata['GrantorFirstName1'])? $formpostdata['GrantorFirstName1']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['GrantorFirstName2'])? $partnerMapField['mappedtitle']['GrantorFirstName2']: 'First Name (2)') ?></strong></label>
											<?php echo $this->Form->control('GrantorFirstName2', ['value'=>isset($formpostdata['GrantorFirstName2'])? $formpostdata['GrantorFirstName2']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										<H2>Grantee</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Grantees'])? $partnerMapField['mappedtitle']['Grantees']: 'Grantee(s)') ?></strong></label>
											<?php echo $this->Form->control('Grantees', ['value'=>isset($formpostdata['Grantees'])? $formpostdata['Grantees']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['GranteeFirstName1'])? $partnerMapField['mappedtitle']['GranteeFirstName1']: 'First Name (1)') ?></strong></label>
											<?php echo $this->Form->control('GranteeFirstName1', ['value'=>isset($formpostdata['GranteeFirstName1'])? $formpostdata['GranteeFirstName1']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['GranteeFirstName2'])? $partnerMapField['mappedtitle']['GranteeFirstName2']: 'First Name (2)') ?></strong></label>
											<?php echo $this->Form->control('GranteeFirstName2', ['value'=>isset($formpostdata['GranteeFirstName2'])? $formpostdata['GranteeFirstName2']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<!-- Mortgagor Grantor(s) -->
										<H2>Mortgagor Grantor(s)</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgagorGrantors'])? $partnerMapField['mappedtitle']['MortgagorGrantors']: 'Grantor(s)') ?></strong></label>
											<?php echo $this->Form->control('MortgagorGrantors', ['value'=>isset($formpostdata['MortgagorGrantors'])? $formpostdata['MortgagorGrantors']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgagorGrantorFirstName1'])? $partnerMapField['mappedtitle']['MortgagorGrantorFirstName1']: 'First Name (1)') ?></strong></label>
											<?php echo $this->Form->control('MortgagorGrantorFirstName1', ['value'=>isset($formpostdata['MortgagorGrantorFirstName1'])? $formpostdata['MortgagorGrantorFirstName1']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgagorGrantorFirstName2'])? $partnerMapField['mappedtitle']['MortgagorGrantorFirstName2']: 'First Name (2)') ?></strong></label>
											<?php echo $this->Form->control('MortgagorGrantorFirstName2', ['value'=>isset($formpostdata['MortgagorGrantorFirstName2'])? $formpostdata['MortgagorGrantorFirstName2']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<!-- Mortgagor Grantor(s) end-->
										
										<!-- Mortgagee  -->
										<H2>Mortgagee</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgageeLenderCompanyName'])? $partnerMapField['mappedtitle']['MortgageeLenderCompanyName']: 'Lender/Company Name') ?></strong></label>
											<?php echo $this->Form->control('MortgageeLenderCompanyName', ['value'=>isset($formpostdata['MortgageeLenderCompanyName'])? $formpostdata['MortgageeLenderCompanyName']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgageeFirstName1'])? $partnerMapField['mappedtitle']['MortgageeFirstName1']: 'First Name (1)') ?></strong></label>
											<?php echo $this->Form->control('MortgageeFirstName1', ['value'=>isset($formpostdata['MortgageeFirstName1'])? $formpostdata['MortgageeFirstName1']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['MortgageeFirstName2'])? $partnerMapField['mappedtitle']['MortgageeFirstName2']: 'First Name (2)') ?></strong></label>
											<?php echo $this->Form->control('MortgageeFirstName2', ['value'=>isset($formpostdata['MortgageeFirstName2'])? $formpostdata['MortgageeFirstName2']: '' ,
											'label' => false, 
											'class'=>'form-control', 'required'=>false]); ?>
											</div>
										</div>
										
										<!-- Mortgagee  end-->
										
										
										<!--<H2>Partner Company</H2>
										<div class="col-xxl-12 col-md-12">
											<div class="input-container-floating">
											<label for="basiInput" class="form-label"><strong>Partner Company</strong></label>
											<input type="text" name=""  class="form-control" data-validity-message="This field cannot be left empty" oninvalid="this.setCustomValidity(''); if (!this.value) this.setCustomValidity(this.dataset.validityMessage)" oninput="this.setCustomValidity('')" id="" aria-required="true" maxlength="" placeholder="" tabindex="18">
											</div>
										</div>-->
									</div>
								</div>
							</div>
						</div>					
											
						<div class="col-xxl-2 col-md-2 col-sm-12"> 
							<div class="row">
								<div class="col-xxl-12 col-md-12">
									<div class="submit">
										<?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success flt-rght', 'tabindex' => 14]); ?> 
									</div>
								</div>
								<div class="col-xxl-12 col-md-12">
									<?=$this->Html->link(__('Clear'), ['action'=>'search-records'],['class'=>'btn btn-danger flt-rght']);?>
									 
								</div>
							</div>
						</div>					
					</div>						
                    
					
					
					<div class="row">
						<div class="col-xxl-5 col-md-5 col-sm-12">
							<h2>Transaction Status</h2>
							<div class="input-container-floating">
							   <div class="form-check checkBox">
								  <label class="form-check-label" for="flexRadioDefault2">Not Assigned</label>
								  <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['dnr'=>'Document not received'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input'
                                        ]); 
                                    ?>
							   </div>
							   <div class="form-check checkBox">
								  <label class="form-check-label" for="flexRadioDefault2">Assigned</label>
								  <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['dr'=>'Document received'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input'
                                        ]); 
                                    ?>
							   </div>
							   <!--<div class="form-check checkBox">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                    Rejected
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['rejected'=>'Rejected'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input'
                                        ]); 
                                    ?>
                                </div>-->
							   <div class="form-check checkBox">
								  <label class="form-check-label" for="flexRadioDefault2">All</label>
								  <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['all'=>'All'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input'
                                        ]); 
                                    ?>
							   </div>
							</div>
						</div>
						<div class="col-xxl-7 col-md-7 col-sm-12">
							<h2>Upload/Add Specific Search</h2>
							<div class="row">
								<div class="col-xxl-6 col-md-6 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label">Date Uploaded/Added</label>
										<div style="width:70%; float:left;">
											<div class="row">
												<div class="col-xxl-6 col-md-6 col-sm-6" style="margin-top:0!important;">
												<span class="frm-to">From:</span><?php echo $this->Form->control('fromdate', ['label' => false, 'value'=>isset($formpostdata['fromdate'])? $formpostdata['fromdate']: '', 'placeholder' => '(yyyy-mm-dd)', 'class'=>'form-control f-control-withspan', 'required'=>false]); ?>
												</div>
												<div class="col-xxl-6 col-md-6 col-sm-6" style="margin-top:0!important;">
												<span class="frm-to">To:</span><?php echo $this->Form->control('todate', ['label' => false, 'value'=>isset($formpostdata['todate'])? $formpostdata['todate']: '', 'placeholder' => '(yyyy-mm-dd) ', 'class'=>'form-control f-control-withspan', 'required'=>false]); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--<div class="col-xxl-5 col-md-5 col-sm-12">
									<div class="input-container-floating">
										<label for="basiInput" class="form-label">CSV Sheet Name</label>
										<select class="form-control" name="State" tabindex="26" data-select2-id="select2-data-1-sid5" aria-hidden="true">
										<option value="" data-select2-id="">---Select---</option>
										<option value="">1</option>
										<option value="">2</option>
										<option value="">3</option>
										<option value="">4</option>
										</select>
									</div>
								</div> -->
								<div class="col-xxl-4 col-md-4 col-sm-12">
								<?php // $this->LRS->searchCancelBtn('m-r') ?>
								
								<?php echo $this->Form->control('sno',['type'=>'hidden','id'=>'snoId','value'=>'']); ?>
								<?php echo $this->Form->control('docstatus',['type'=>'hidden','id'=>'docstatusId','value'=>'']); ?>
									
								</div>
								
								<div class="col-xxl-1 col-md-1 col-sm-12"></div>
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
<?php echo $this->LRS->showBarCodeModelPop(); 
		echo $this->LRS->showLockModelPop();
		echo $this->LRS->showPasswordModelPop(); ?>


<?php $this->append('script') ?>

<script type="text/javascript">

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
    });
		
	function loadDataTable(){
        var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'Y'};
        var columndata =<?php echo $dataJson;?>;
        $('#datatable_example').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, 'All']],
            "pageLength": 10,
			"processing": true,			
            "serverSide": true,
            "searching": false,
			"dom": 'Blfrtip',  
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:first-child):not(:last-child)' } }],
            "ajax": {
                url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxList".ucfirst($this->request->getParam('action'))]) ?>',
                data: formdata,
                type: 'POST'
            },
            "columns": columndata,
            "order": [[11, 'desc']],
			createdRow: function( row, data, dataIndex ) {
				if ( data['ECapable'] == "Both SF & CSC" ) {
					$(row).addClass( 'bothColor' );
				} else if( data['ECapable'] == "SF" ) {
					$(row).addClass( 'sfColor' );
				} else if(data['ECapable'] == 'CSC') {
					$(row).addClass( 'cscColor' );
				} else if ( data['lock_status'] == 1 ) {
					$(row).addClass( 'disabledColor' );
				}  
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
	
	function openLockModel(recId, lock_status){
        
        $('#lockRecId').val(recId);
        $('#lock_status').val(lock_status);
        jQuery('#myModalLock').modal('show');
        return false;
	} 

	function saveLockRecord(element){ 
       
	   var lockRecId = $('#'+element).find('#lockRecId').val();
	   var lock_status = $('#'+element).find('#lock_status').val();
	   var lock_comment = $('#'+element).find('#lock_comment').val();

	   $.ajax({
		   type: "POST",
		   url: '<?= $this->Url->build(["controller"=> "FilesCheckinData", "action" => "saveLockRecord"]) ?>',
		   data: {"RecId":lockRecId, "lock_status":lock_status, "lock_comment":lock_comment},
		    error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				},
		   success: function(data){ 
			   $('#'+element).find("input[type=text], input[type=hidden],textarea").val("");
			  jQuery('#myModalLock').modal('hide');
			  alert('Record lock status updated!');
			  

			  $("#datatable_example").DataTable().destroy();
			   // call function to load data table
			   loadDataTable();
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