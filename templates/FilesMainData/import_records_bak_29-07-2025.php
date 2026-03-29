<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?> 
<style>
.model-body tbody, td, tfoot, th, thead, tr {border: 1px solid #d9d9d9;}
</style>
<div class="row">

    <div class="col-lg-12">
        <div class="card">
             
            <?= $this->Form->create($FilesMainData, ['action'=>'import-records','horizontal' => true, 'enctype' => 'multipart/form-data']) ?>
  
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Select Partner</label>
                                <?=  $this->Form->select('companyid',$companies,['multiple' => false, 'empty' => 'Select Partner','class'=>'js-example-basic-single form-control', 'required'=>'required','label' => false,'id'=>'companyid']); ?>   
                            </div>
                        </div>
                          
                        <div class="col-xs-12 col-sm-3 col-md-3"> 
                        
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label1">Browse CSV file</label>
                                <?=  $this->Form->control('upload_records',['type'=>'file',  'required'=>'required', 'label' => false]); ?>   
                            </div>
                        </div>
                         
                        <div class="col-xs-12 col-sm-3 col-md-3 top-btn-container flt-right">
                            <div class="submit">
                            <?= $this->Form->submit(__('Import CSV'),['name'=>'saveBtn', 'class'=>'btn btn-success']); ?>  
                            </div> 
                            <div class="cancel"> 
                                <?= $this->Html->link(__('Cancel'), ['action' => 'import-records'], ['class' => 'btn btn-danger']) ?> 
                            </div>
                        </div>
						
						 <div class="col-xs-12 col-sm-2 col-md-2 text-rght">
                            <div class="input-container-floating"> 
                                <button type="button" class="btn btn-info" onclick="return getCSVFormat()">Click here for CSV format</button>
                            </div>
                        </div>
                            
                    </div> 
                </div> 
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

<!-- list download link with count for records -->
        <!-- // downlink for insert -->
        <?php
        
        if(isset($errorViewData['insertTable']) && !empty($errorViewData['insertTable'])) { ?>
            <?php //$errorViewData['errorCountyTable']['insertedCount']; ?>
            <!---Using helper here--->
        <?= $this->Lrs->loadDownloadLink($errorViewData['insertTable']['csvFilename'],'export') ?>
        
        <?php } 
        
            if(isset($errorViewData['uploadTable']) && !empty($errorViewData['uploadTable'])) { ?>
            <!-- // downlink for overwrite -->
            <?php //$errorViewData['errorCountyTable']['updateCount']; ?>
            <!---Using helper here--->
            <?= $this->Lrs->loadDownloadLink($errorViewData['uploadTable']['csvFilename'],'export') ?>
    
        <?php }  ?>
    
    <!-- list download link with count for records END -->

 <!-- County State errors table for continue --> 
 <?php

    if(isset($errorViewData['errorCountyTable']['towstxtErrorCounty']) && !empty($errorViewData['errorCountyTable']['towstxtErrorCounty'])) { ?>
    <div class="ibox float-e-margins">
    <div class="ibox-content">
    <?= $this->Form->create($FilesMainData, ['class'=>'form-horizontal']) ?>
            <div class="errorhearder">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10">
                                <h5><?= __($errorViewData['errorCountyTable']['headerTitleErrorCounty']) ?></h5>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2 top-btn-container flt-right">
                                <div class="ibox-tools">
                                <?= $this->Form->button(__('Continue'), ['name'=>'btnCountyError','value'=>'Continue','class'=>'btn btn-primary pull-right']) ?>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                        
                </div>
            </div>
        <div class="table-responsive">
            
            <table id="example" class="table table-bordered nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed">
                <thead>
                    <tr>
                        <?= __($errorViewData['errorCountyTable']['headerCountyerrorcols']) ?>
                    </tr>
                </thead>
                <tbody>
                    <?= __($errorViewData['errorCountyTable']['towstxtErrorCounty']) ?>
                </tbody>
            </table>
        

        <?= $this->Form->hidden('companyid', ['value'=>$errorViewData['errorCountyTable']['companyid']]); ?>
        <?= $this->Form->hidden('errorFlgCounty', ['value'=>$errorViewData['errorCountyTable']['errorFlgCounty']]); ?>
        <?= $this->Form->hidden('csvmstid', ['value'=>$errorViewData['errorCountyTable']['csvmstid']]); ?>
        <?= $this->Form->hidden('csvFilename', ['value'=>$errorViewData['errorCountyTable']['csvFilename']]); ?>
        <?= $this->Form->hidden('insertedCount', ['value'=>$errorViewData['errorCountyTable']['insertedCount']]); ?>
        <?= $this->Form->hidden('updateCount', ['value'=>$errorViewData['errorCountyTable']['updateCount']]); ?>
        <?= $this->Form->hidden('dbColumnName', ['value'=>$errorViewData['errorCountyTable']['headerCountyerrorcolsarr']]); ?>
        
        <?= $this->Form->hidden('serializeData', ['value'=>$errorViewData['serializeData']]); ?>
        
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-btn-container flt-right">
        <?= $this->Form->button(__('Continue'), ['name'=>'btnCountyError','value'=>'Continue','class'=>'btn btn-primary pull-right']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
    </div></div>
    <?php } // Inserted Rows ?>


    <!-- Inserted rows table  -->
        <?php if(isset($errorViewData['insertTable']['insertRowtxt']) && !empty($errorViewData['insertTable']['insertRowtxt'])) { ?>
            <div class="ibox float-e-margins">
            <div class="successhearder"><h5><?= __($errorViewData['insertTable']['insertflnmHeader']) ?></h5></div>
        <div class="ibox-content">
            <!-- // downlink for insert -->

            <div class="table-responsive">
            

                    <table id="exampleAjaxInsert" class="table table-bordered nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed">
                    <thead>
                        <tr>
                            <?= __($errorViewData['insertTable']['headerRowtxt']) ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?= __($errorViewData['insertTable']['insertRowtxt']) ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        <?php } // Inserted Rows ?>


        <!-- updated rows table -->
        <?php if(isset($errorViewData['uploadTable']['uploadRowtxt']) && !empty($errorViewData['uploadTable']['uploadRowtxt'])) { ?>
            <div class="ibox float-e-margins">
            <div class="successhearder"><h5><?= __($errorViewData['uploadTable']['uploadflnmHeader']) ?></h5></div>
        <div class="ibox-content">

            <div class="table-responsive">
                <!-- // downlink for overwrite --> 
                    <table id="exampleAjaxUpdate" class="table table-bordered nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed">
                    <thead>
                        <tr>
                            <?= __($errorViewData['uploadTable']['headerRowtxt']) ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?= __($errorViewData['uploadTable']['uploadRowtxt']) ?>
                    </tbody>
                </table>
            </div>
        </div></div>
        <?php } // Updated rows ?>
 
</div>

<!-- Model box-->
<div class="modal fade bs-example-modal-xl" id="CSVModel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" style="display:none" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body"> 
				<table border="1" cellpadding="2" cellspacing="0" width="100%"><tbody>
					<tr id="getColumns"></tr>                    
				</tbody></table>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a> 
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<?php $this->append('script') ?>
<!-- Select2 --> 
<script> 
	
	function  getCounty(StateId, divId){
       
		$.ajax({
		  method: "POST",
		  url : '<?= $this->Url->build(["controller" => "FilesMainData","action" => "searchCountyAjax"]) ?>',
		  data: { id: StateId} ,
            error: function (xhr, error, code) {
                if(xhr.status == 500){
                    alert("Your session has expired. Would you like to be redirected to the login page?");
                    window.location.reload(true); return false;
                }
            }  
		}).done(function(returnData){ 
			$('#company_div_'+divId).html(returnData);
			$("select").select2();
		});
	}
	
	function getCSVFormat(){
		var companyid = $("#companyid").val();
		if(companyid == ''){
			alert("Please select Partner"); 
			 return false;
		}else { 
			$.ajax({
			  method: "POST",
			  url : '<?= $this->Url->build(["controller" => "FilesMainData","action" => "getCSVFormatAjax"]) ?>',
			  data: { companyid: companyid} ,
			  error: function (xhr, error, code) {
					if(xhr.status == 500){
						alert("Your session has expired. Would you like to be redirected to the login page?");
						window.location.reload(true); return false;
					}
				}  
			}).done(function(returnData){ 
				$('#getColumns').html(returnData);
				$('#CSVModel').modal('show');
			});
		}
	}
</script>
<?php $this->end() ?>
