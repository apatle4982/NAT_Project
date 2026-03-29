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



                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-4 col-sm-12">
                            <div class="row">
                            <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (((isset($partnerMapField['mappedtitle']['NATFileNumber']) && (!empty(trim($partnerMapField['mappedtitle']['NATFileNumber'])))))? $partnerMapField['mappedtitle']['NATFileNumber']: 'NATFileNumber')?></strong></label>
                                    <?php echo $this->Form->control('NATFileNumber', [
                                    'label' => false,
                                    'value'=>isset($formpostdata['NATFileNumber'])? $formpostdata['NATFileNumber']: '' , 'class'=>'form-control', 'required'=>false]); ?>
                                    </div>
                            </div>
                            <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['StreetName'])? $partnerMapField['mappedtitle']['StreetName']: 'StreetName') ?></strong></label>
                                    <?php echo $this->Form->control('StreetName', ['value'=>isset($formpostdata['StreetName'])? $formpostdata['StreetName']: '' ,
                                        'label' => false,
                                        'class'=>'form-control', 'required'=>false]); ?>
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
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['PartnerFileNumber'])? $partnerMapField['mappedtitle']['PartnerFileNumber']: 'PartnerFileNumber') ?></strong></label>
                                    <?php echo $this->Form->control('PartnerFileNumber', ['value'=>isset($formpostdata['PartnerFileNumber'])? $formpostdata['PartnerFileNumber']: '' ,
                                    'label' => false, 
                                    'class'=>'form-control', 'required'=>false]); ?>

                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <div class="input-container-floating">
                                    <label for="basiInput" class="form-label"><strong><?= (isset($partnerMapField['mappedtitle']['Grantors'])? $partnerMapField['mappedtitle']['Grantors']: 'Grantors') ?></strong></label>
                                    <?php echo $this->Form->control('Grantors', ['value'=>isset($formpostdata['Grantors'])? $formpostdata['Grantors']: '' ,
                                    'label' => false, 
                                    'class'=>'form-control', 'required'=>false]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h2>Vendor Assigned Status</h2> 
                        
                    <div class="row">
                        <div class="col-xxl-12 col-md-12">

                        
                            <div class="input-container-floating">
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="documentreceived-all">
                                    All
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['all'=>'All'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "all",
                                        'class'=>'form-check-input'
                                        ]); 
                                    ?>
                                </div>
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="documentreceived-assigned">
                                    Assigned
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['assigned'=>'Assigned'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "assigned",
                                        'class'=>'form-check-input'
                                        ]); 
                                    ?>
                                    
                                </div>
                                <div class="form-check checkBox">
                                    <label class="form-check-label" for="documentreceived-notassigned">
                                     Not Assigned
                                    </label>
                                    <?php 
                                    echo $this->Form->input('DocumentReceived', [
                                        
                                        'type' => 'radio',
                                        'options' => ['notassigned'=>'Not Assigned'],
                                        'required' => 'required',
                                        'label' => false,
                                        'default' => "notassigned",
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
        var isSearch = '<?= $isSearch; ?>';
        if(isSearch==0) {$("#flexRadioProcess-notprocessed").prop('checked', true)}

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

        /*$.ajax({
            url: '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxList".ucfirst($this->request->getParam('action'))]) ?>',
            type: "POST",        // HTTP request method
            data: { id: 123 },   // Data to send
            success: function(response) {
                console.log("Success:", response);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            },
            complete: function(xhr, status) {
                console.log("Request completed with status:", status);
            }
        });
        return;
        */
        //alert('<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxList".ucfirst($this->request->getParam('action'))]) ?>');
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
            "order": [ [8, 'desc'] ],
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