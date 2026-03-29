<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <?= $this->Form->create(null, ['type' => 'file', 'url' => ['action' => 'upload']]) ?>
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-xs-12 col-sm-3 col-md-3">

                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label1">Browse CSV file</label>
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
                                <a type="button" class="btn btn-info" href="<?= $this->Url->build('/uploads/receiptofexam_sample.csv', ['fullBase' => true]) ?>">Download sample CSV format</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php //echo "<pre>";print_r($errorids);echo "</pre>"; ?>
            <?= $this->Form->end() ?>
            <?php if(count($successids)>0 or count($errorids)>0){?>
            <div class="card-body">
                <div class="row gy-4">


                    <div class="col-xs-12 col-sm-3 col-md-3">
                    <?php if(count($successids)>0){
                      echo "<span id='success'>Success Records:<br></span><span id='success_val'>".implode("<br>", $successids)."</span>";
                    } ?>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3">

                    <?php if(count($errorids)>0){
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#downloadCsv").click(function () {
            // Extract success records
            let successData = $("#success_val").text().trim();

            // Extract error records and split by line break
            let errorData = $("#error_val").html().trim().replace(/<br\s*\/?>/g, "\n").split("\n");

            // Convert data into two columns (A = Success, B = Error)
            let csvContent = "Success Records,Error Records\n";

            let maxLength = Math.max(1, errorData.length);
            for (let i = 0; i < maxLength; i++) {
                let successVal = i === 0 ? successData : ""; // Only show success in the first row
                let errorVal = errorData[i] ? errorData[i] : "";
                csvContent += `"${successVal}","${errorVal}"\n`;
            }

            // Create a Blob and download the CSV file
            let blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
            let link = document.createElement("a");
            let url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "records.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>