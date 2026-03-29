<style>
.get-csv-btn{
    background:#eee;
    border-color:#c8bfbf !important;
    color:#000;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <?= $this->Form->create(null, ['type' => 'file', 'url' => ['action' => 'upload']]) ?>
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Select Partner</label>
                                <?=  $this->Form->select('companyid',$companies,['multiple' => false, 'empty' => 'Select Partner','class'=>'js-example-basic-single form-control', 'required'=>'required','label' => false,'id'=>'companyid',"onchange"=>"activateCsvButton()"]); ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label1">Browse CSV file</label>
                                <span class="tiny" style="font-size:10px;color:maroon;">(Only CSV or XML files are allowed)</span>
                                <?= $this->Form->control('csv_file', ['type' => 'file', 'required' => true, 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-3 col-md-3 top-btn-container flt-right">
                            <div class="submit">
                            <?= $this->Form->submit(__('Import CSV'),['name'=>'saveBtn', 'class'=>'btn btn-success']); ?>
                            </div>
                            <div class="cancel">
                                <?= $this->Html->link(__('Cancel'), ['action' => 'upload'], ['class' => 'btn btn-danger']) ?>
                            </div>
                        </div>

						 <div class="col-xs-12 col-sm-2 col-md-2 text-rght">
                            <div class="input-container-floating">
                                <!--<a type="button" class="btn btn-info" href="<?= $this->Url->build('/uploads/receiptofexam_sample.csv', ['fullBase' => true]) ?>">Download sample CSV format</a>-->
                                <button type="button" id="get-csv-btn" class="btn get-csv-btn" onclick="return getCSVFormat()">Click here for CSV format</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php //echo "<pre>";print_r($errorids);echo "</pre>"; ?>
            <?= $this->Form->end() ?>
            <?php if(count($successids)>0 || count($errorids)>0){ ?>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <?php if(count($successids) > 0){
                                echo "<span id='success'>Success Records:<br></span><span id='success_val'>".implode("<br>", $successids)."</span>";
                            } ?>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <?php if(count($errorids) > 0){
                                echo "<span id='error'>Error Records:<br></span><span id='error_val'>".implode("<br>", $errorids)."</span>";
                            } ?>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <button id="downloadCsv" class="btn btn-primary">Download Success/Error Records CSV</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    
    $('#get-csv-btn').prop('disabled', true); 
})     
function activateCsvButton(){
    
    if($("#companyid").val() > 0){
        $('#get-csv-btn').prop('disabled', false); 
        $('#get-csv-btn').removeClass('get-csv-btn');
        $('#get-csv-btn').addClass('btn-info');
    }
    else{
        $('#get-csv-btn').prop('disabled', true); 
        $('#get-csv-btn').addClass('get-csv-btn');
        $('#get-csv-btn').removeClass('btn-info');
    }
}    
$(document).ready(function () {
    $("#downloadCsv").click(function () {

        /**
         * By default Deisabled "Click here for CSV Format Button"
         */
        $('#get-csv-btn').prop('disabled', true); 

        // Get success records and split by line break
        let successElement = $("#success_val");
        let successData = successElement.length ? successElement.html().trim().replace(/<br\s*\/?>/g, "\n").split("\n") : [];

        // Get error records and split by line break
        let errorElement = $("#error_val");
        let errorData = errorElement.length ? errorElement.html().trim().replace(/<br\s*\/?>/g, "\n").split("\n") : [];

        // Get the maximum number of rows
        let maxLength = Math.max(successData.length, errorData.length, 1);

        let csvContent = "Success Records,Error Records\n";
        for (let i = 0; i < maxLength; i++) {
            let successVal = successData[i] ? successData[i] : "";
            let errorVal = errorData[i] ? errorData[i] : "";
            csvContent += `"${successVal}","${errorVal}"\n`;
        }

        // Trigger CSV download
        let blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
        let link = document.createElement("a");
        let url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "Import-Sheet-Records.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
});

function getCSVFormat(){
    var companyid = $("#companyid").val();
    if(companyid == ''){
    	alert("Please select Partner");
    	 return false;
    }else {
    	$.ajax({
    	  method: "POST",
    	  url : '<?= $this->Url->build(["controller" => "FieldsMstExam","action" => "getCSVFormatAjax"]) ?>',
    	  data: { companyid: companyid} ,
    	  error: function (xhr, error, code) {
    			if(xhr.status == 500){
    				alert("Your session has expired. Would you like to be redirected to the login page?");
    				window.location.reload(true); return false;
    			}
    		}
    	}).done(function(returnData){
    	    if(returnData != ""){ $('#getColumns').html(returnData); }
            else{ $('#getColumns').html("Receipt of Exam import fields are not set."); }
    		$('#CSVModel').modal('show');
    	});
    }
}
</script>