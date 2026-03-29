<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
 

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">&nbsp;</h5>
                <div style="float:right;"> 
                    <?= $this->Html->link(__('Add Vendor User'), ['action' => 'vendor-add'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div> 
            <div class="card-body">
				<table id="dataTables-example" class="display table table-bordered" style="width:100%">
					<thead>
					<tr>
						<th style="width: 30px;"><?= __('UserId') ?></th>
						<th><?= __('FullName') ?></th>
						<th><?= __('Phone') ?></th>
						<th><?= __('Email') ?></th>
						<th><?= __('Vendor') ?></th>
						<th><?= __('Status') ?></th>
						<th style="width: 130px;"><?= __('Actions') ?></th>
					</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>
</div>
<?php $this->append('script') ?>
<script type="text/javascript">
$(document).ready(function () {

	var formdata = {'formdata':<?php echo json_encode($formpostdata);?>};
	var columndata =<?php echo $dataJson;?>;
	$('#dataTables-example').DataTable({
		"lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, 'All']],
		"processing": true,
		"pageLength": 10,
		"serverSide": true,
		"searching": false,
		"dom": 'Blfrtip',  
		"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)'} }],
		"ajax": {
			url : '<?= $this->Url->build(["controller" => "Vusers","action" => "partnerUserList"]) ?>',
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
		order: [[ 0 ,"desc" ]]	
	});
});
</script>
<?php $this->end() ?>