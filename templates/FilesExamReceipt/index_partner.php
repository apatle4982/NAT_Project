<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\FilesExamReceipt[]|\Cake\Collection\CollectionInterface $FilesExamReceipt
  */
?>

<div class="row">
    <?= $this->Form->create($FilesExamReceipt, ['horizontal'=>true]) ?>
        <div class="col-lg-12">

			<div class="card">
				<div class="card-body">
					<div class="live-preview">
						<div class="row long-lbl-frm">
							<div class="col-xxl-8 col-md-7 col-sm-12">
								<h2>Process Status Search</h2> 
                        
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
						</div></div>	
						<div class="col-xxl-4 col-md-5 col-sm-12">
						
								<h2>Upload/Add Specific Search</h2> 
								
								<div class="row">
									<div class="col-xxl-8 col-md-7 col-sm-12">
										<div class="row">
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
				<?php //echo $this->element('checkin_records_list',['is_index'=>$is_index,'is_generate'=>false]); ?>
				<?php echo $this->element('checkin_records_list'); ?>
				</div> 
			</div> 
        </div> 
    
	<?= $this->Form->end() ?>
</div> 

 
<!-- Barcode Modal -->

<!-- Barcode Modal helper -->
<?php echo $this->LRS->showBarCodeModelPop($vendorlist, $vendor_services);  echo $this->LRS->showLockModelPop();  ?>


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
            "processing": true,
            "pageLength": 10,
            "serverSide": true,
            "searching": false,
			"dom": 'Blfrtip',
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:first-child):not(:last-child)'}}],
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
            "order": [[2, 'asc']],
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

	 
	
</script>

<?php $this->end() ?>