<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesExamReceipt[]|\Cake\Collection\CollectionInterface $FilesExamReceipt
  */
?>
 
<!-- ================================================================ -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <?= $this->Form->create($FilesExamReceipt, ['horizontal'=>true]) ?>
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
                                    <label for="basiInput" class="form-label"><strong><?= ((isset($partnerMapField['mappedtitle']['transaction_type']) && (!empty($partnerMapField['mappedtitle']['transaction_type']))) ? $partnerMapField['mappedtitle']['transaction_type']: 'Transaction Type'); ?></strong></label>
                                    <?php
                                            echo $this->Form->control('transaction_type', [
                                                'value' => isset($formpostdata['transaction_type'])? $formpostdata['transaction_type']: '', 
                                                'options' => $DocumentTypeData, 
                                                'multiple' => false, 
                                                'empty' => 'Select Transaction Type',
                                                'label' => [ 
                                                        'text' => ((isset($partnerMapField['mappedtitle']['transaction_type']) && (!empty($partnerMapField['mappedtitle']['transaction_type']))))? $partnerMapField['mappedtitle']['transaction_type']: 'Transaction Type',
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
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['state']) ? $partnerMapField['mappedtitle']['state']: 'state') ?></strong></label>
                                    
                                    <?php echo $this->Form->control('state', [
                                                    'label' => false,
                                                'value'=>isset($formpostdata['state'])? $formpostdata['state']: '' , 'class'=>'form-control', 'required'=>false]); ?>
            
                                    </div>
                                </div>



                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4 col-sm-12">
                            <div class="row">
                            <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (((isset($partnerMapField['mappedtitle']['nat_file_number']) && (!empty(trim($partnerMapField['mappedtitle']['nat_file_number'])))))? $partnerMapField['mappedtitle']['nat_file_number']: 'nat_file_number')?></strong></label>
                                    <?php echo $this->Form->control('nat_file_number', [
                                    'label' => false,
                                    'value'=>isset($formpostdata['nat_file_number'])? $formpostdata['nat_file_number']: '' , 'class'=>'form-control', 'required'=>false]); ?>
                                    </div>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['street_name'])? $partnerMapField['mappedtitle']['street_name']: 'street_name') ?></strong></label>
                                    <?php echo $this->Form->control('street_name', ['value'=>isset($formpostdata['street_name'])? $formpostdata['street_name']: '' ,
                                        'label' => false,
                                        'class'=>'form-control', 'required'=>false]); ?>
                                    </div>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['county'])? $partnerMapField['mappedtitle']['county']: 'county') ?></strong></label>
                                    <?php echo $this->Form->control('county', ['value'=>isset($formpostdata['county'])? $formpostdata['county']: '' ,
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
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['partner_file_number'])? $partnerMapField['mappedtitle']['partner_file_number']: 'partner_file_number') ?></strong></label>
                                    <?php echo $this->Form->control('partner_file_number', ['value'=>isset($formpostdata['partner_file_number'])? $formpostdata['partner_file_number']: '' ,
                                    'label' => false, 
                                    'class'=>'form-control', 'required'=>false]); ?>

                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['grantors_g1'])? $partnerMapField['mappedtitle']['grantors_g1']: 'grantors_g1') ?></strong></label>
                                    <?php echo $this->Form->control('grantors_g1', ['value'=>isset($formpostdata['grantors_g1'])? $formpostdata['grantors_g1']: '' ,
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
                                    <label class="form-check-label" for="flexRadioDefault2">
                                     Not Assigned
                                    </label>
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
                                    <label class="form-check-label" for="flexRadioDefault2">
                                    Assigned
                                    </label>
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
                                    <label class="form-check-label" for="flexRadioDefault2">
                                    All
                                    </label>
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
                    </div>
                </div>
                <div class="col-xxl-4 col-md-5 col-sm-12">
                    
                    <h2>Upload/Add Specific Search</h2> 
                        
                    <div class="row" style="margin-bottom: 20px;">
                    <div class="col-xxl-8 col-md-7 col-sm-12">
                        <div class="row">
                            <!--<div class="col-xxl-12 col-md-12">
                                <div class="input-container-floating">
                                <label for="basiInput" class="form-label">CSV Sheet Name</label>
                                    <select class="form-control" name="state" tabindex="12" data-select2-id="select2-data-1-sid5" aria-hidden="true">
                                        <option value="" data-select2-id="">---Select---</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                        <option value="">4</option>
                                    </select>
                                </div>
                            </div>-->
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
                    </div>


                    <h2>Process Specific Search</h2> 
                        
                    <div class="row">
                    <div class="col-xxl-8 col-md-7 col-sm-12">
                        <div class="row">
                            <div class="input-container-floating">
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="flexRadioProcess-all" style="margin-right: 0px !important;">
                                    All
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentProcess', [
                                        
                                        'type' => 'radio',
                                        'options' => ['all'=>'All'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input',
                                        'id'=>'flexRadioProcess',
                                        'checked'=>'checked'
                                        ]); 
                                    ?>
                                </div>
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="flexRadioProcess-processed" style="margin-right: 0px !important;">
                                    Processed
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentProcess', [
                                        
                                        'type' => 'radio',
                                        'options' => ['processed'=>'Document Processed'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "dnr",
                                        'class'=>'form-check-input',
                                        'id'=>'flexRadioProcess'
                                        ]); 
                                    ?>
                                </div>
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="flexRadioProcess-notprocessed" style="margin-right: 0px !important;">
                                     Not Processed
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentProcess', [
                                        
                                        'type' => 'radio',
                                        'options' => ['notprocessed'=>'Document not Processed'],
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
                        <div class="col-xxl-4 col-md-4 col-sm-12">
                        <?= $this->LRS->searchCancelBtnER('m-r') ?>
                        
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
<?php
//echo "<pre>";print_r($vendor);echo "</pre>";
?>
<!-- Barcode Modal helper -->
<?php echo $this->LRS->showBarCodeModelPop($vendorlist, $vendor_services);
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


    $(document).on('change', '.checkSingle', function() {
        var selectedValues = [];

        // Iterate over all checked checkboxes and get their values
        $('.checkSingle:checked').each(function() {
            //alert($(this).val());
            selectedValues.push($(this).val());
        });

        // Update the hidden input with comma-separated values
        $('#file_nos').val(selectedValues.join(','));
    });

    });

    function loadDataTable(){ 

        var formdata = {'formdata':<?php echo json_encode($formpostdata);?>,'is_index':'Y'};
        var columndata =<?php echo $dataJson;?>;

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
                dataSrc: function(json) {
                    console.log("DataTables Response:", json);
                    return json.data; // Ensure this is correct
                },
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
                    console.log("AJAX Error:", error, code, xhr.responseText);
				}
            },
            "columns": columndata,
            "order": [ [11, 'desc'] ],
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
            url: '<?= $this->Url->build(["controller"=> "FilesExamReceipt", "action" => "ajaxLockRecord"]) ?>',
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