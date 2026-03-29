<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesAccountingData[]|\Cake\Collection\CollectionInterface $filesAccountingData
  */
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row"> 
	<?= $this->Form->create($FilesAccountingData, ['horizontal'=>true]) ?>
        <div class="col-lg-12">
            <div class="card">	
                <div class="card-body">
                    <div class="live-preview ">
                        <div class="row">
							<div class="col-xxl-6 col-md-6 col-sm-12 long-lbl-frm ">
								<div class="row">
									<div class="col-xxl-12 col-md-12" style="margin-top:10px;">
										<h2>Processed/Not Processed</h2> 
										<div class="row">
											<div class="col-xxl-12 col-md-12">
												<div class="input-container-floating">
													<div class="form-check checkBox">
														<label class="form-check-label" for="flexRadioDefault2">
														Not Processed
														</label>
														<?php  
															$options = ['NP'=>'Not Processed'];
															echo $this->Form->input('processingstatus', [
																
																'type' => 'radio',
																'options' => $options,
																'required' => 'required',
																'label' => false,
																'default' => "NP",
																'class'=>'form-check-input'
																]); 
															?>
													</div>
													<div class="form-check checkBox">
														<label class="form-check-label" for="flexRadioDefault2">
														Processed
														</label>
														<?php  
															$options = ['P'=>'Processed'];
															echo $this->Form->input('processingstatus', [
																 
																'type' => 'radio',
																'options' => $options,
																'required' => 'required',
																'label' => false,
																'default' => "NP",
																'class'=>'form-check-input'
																]); 
															?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xxl-6 col-md-6 col-sm-12">
								<h2>Processing Date</h2>
								<div class="row">
									<div class="col-xxl-8 col-md-7 col-sm-12">
										<div class="row">
											<div class="col-xxl-12 col-md-12 col-sm-12">
												<div class="input-container-floating">
													<label for="basiInput" class="form-label" style="width:25%;">From</label>
													<div class="two-input" style="width:75%;">
														<div class="row">
															<div class="col-xxl-12 col-md-12 col-sm-12">
															<?php echo $this->Form->control('fromdate', ['label' => false, 'value'=>isset($formpostdata['fromdate'])? $formpostdata['fromdate']: '','label' => false , 'class'=>'form-control f-control-withdtspan', 'required'=>false]); ?>
															<span class="frm-dt">( yyyy-mm-dd )</span>
															</div>
															
														</div>
													</div>
												</div>
											</div>
											<div class="col-xxl-12 col-md-12 col-sm-12">
												<div class="input-container-floating">
													<label for="basiInput" class="form-label" style="width:25%;">To</label>
													<div class="two-input" style="width:75%;">
														<div class="row">
															<div class="col-xxl-12 col-md-12 col-sm-12">
															<?php echo $this->Form->control('todate', ['label' => false, 'value'=>isset($formpostdata['todate'])? $formpostdata['todate']: '','label' => false ,'class'=>'form-control f-control-withdtspan', 'required'=>false]); ?>
															<span class="frm-dt">( yyyy-mm-dd )</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-4 col-md-4 col-sm-12" style="max-width: 200px;  text-align: right; ">
										<?= $this->LRS->searchCancelBtn('m-t') ?>
										<?php echo $this->Form->control('sno',['type'=>'hidden','id'=>'snoId','value'=>'']); ?>
										<?php echo $this->Form->control('docstatus',['type'=>'hidden','id'=>'docstatusId','value'=>'']); ?>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card"> 
                <div class="card-body">
                    <div class="live-preview"> 
                        <?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
                        <!---Using helper here--->
                            <?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
                        <?php } ?>
                        
                        <?php if(isset($pdfDownloadLinks) && !empty($pdfDownloadLinks)) { ?>
                            <?= $this->Lrs->pdfcsvDownloadLinks($pdfDownloadLinks) ?>
                        <?php  } ?> 

                        <!-- Records Listing -->
                        <?php echo $this->element('account_data_list',['is_index'=>$is_index]); ?>
 
                    </div> 
                </div> 
            </div>
 
        </div> 
		<?= $this->Form->end() ?>
    </div>

</div>
  
<?php echo $this->Lrs->showBarCodeModelPop();  ?>
 
<?php $this->append('script') ?>
<!-- Jasny -->
<script type="text/javascript">

	$(document).ready(function () {
		
		var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'<?php echo $is_index; ?>'};
		var columndata =<?php echo $dataJson;?>;
		$('#datatable_example').DataTable({
			"processing": true,
			"pageLength": 10,
			"serverSide": true,
			"searching": false,
			"dom": 'Blfrtip',
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)' } }],
			"ajax": {
				url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxListIndex"]) ?>',
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
			"order": [[ 2 ,"asc" ]],
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
		
    });
		
	function calctotal(fid){
		var total = 0;
		
		if($("#CntyRecFee_"+fid).val() !=""){
			total = total + parseFloat($("#CntyRecFee_"+fid).val());
		}

		if($("#Taxes_"+fid).val() !=""){
			total = total + parseFloat($("#Taxes_"+fid).val());
		}

		if($("#AddnlFees_"+fid).val() !=""){
			total = total + parseFloat($("#AddnlFees_"+fid).val());
		}

		$("#Total_"+fid).val(total.toFixed(2));

	}

</script>

<?php $this->end() ?>