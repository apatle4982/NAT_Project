<style type="text/css">
    td {
        text-transform: none !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <?= $this->Form->create(null, ['type' => 'file', 'url' => ['action' => 'uploadSupportingDocument']]) ?>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="row gy-4">
                                <div class="col-xxl-12 col-md-12" style="margin: 0px !important;">
                                    <div class="input-container-floating">
                                        <label><h4 class="card-title mb-0 flex-grow-1">Upload Multiple Supporting Document</h4></label>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="input-container-floating">
                                        <label for="basiInput" class="form-label1">Browse Document</label>
                                        <span class="tiny" style="font-size:10px;color:maroon;"><!-- (Only files are allowed) --></span>
                                        <?= $this->Form->control('supporting_documentation[]', ['type' => 'file','multiple' => true, 'required' => true, 'label' => false]) ?>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3 top-btn-container flt-right">
                                    <div class="submit">
                                        <?= $this->Form->submit(__('Upload Document'),['name'=>'saveBtn', 'class'=>'btn btn-success']); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>        
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="card">
			<!-- <div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Search Result 
				<div class="submit flt-rght export-btn">
				<?php //if ($authUser && $authUser->isSuperAdmin_Or_isLimited()): ?>
                    <?= $this->Html->link(__('Add Partner API Secret Key'), ['controller' => 'CompanyApiKeys', 'action' => 'add'], ['class' => 'btn btn-success']) ?>
				<?php //endif; ?>		
				</div>
				</h4> 
			</div> -->
			<div class="card-body">
				<table id="dataTables-example" class="display table table-bordered" style="width:100%">
					<thead>
						<tr>
                            <th style="width: 30px;"><?= __('Sr.No') ?></th>
							<th ><?= __('Document Name') ?></th>
                            <th><?= __('Created') ?></th>
							<th style="width: 130px;"><?= __('Actions') ?></th>
						</tr>
					</thead>
				</table>
				</div>
		</div>
</div>       
<?php $this->append('script') ?>
<script type="text/javascript">
$(document).ready(function () {

	var formdata = {'formdata':<?php echo json_encode($formpostdata);?>};
	var columndata =<?php echo $dataJson;?>;
    console.log(columndata)
	$('#dataTables-example').DataTable({
		"lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, 'All']],
		"processing": true,
		"pageLength": 10,
		"serverSide": true,
		"searching": false,
		//"dom": 'Blfrtip',  
		//"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)' }  }],
		"ajax": {
			url : '<?= $this->Url->build(["controller" => "FilesExamReceipt","action" => "listSupportingDocuments"]) ?>',
			data: formdata,
			type: 'POST',
				error: function (xhr, error, code) {
					if(xhr.status == 500){
						//alert("Your session has expired. Would you like to be redirected to the login page?");
						//window.location.reload(true); return false;
					}
				}
		},
		"columns": columndata,
		order: [[ 0,"desc" ]]	
	});
});
</script>
<?php $this->end() ?> 