<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CompanyMst> $companyMst
 */
?>

<!-- push command test by pramod -->
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			
			<?= $this->Form->create($companyMst,['horizontal' => true]) ?>
			<div class="card-body">
				<div class="live-preview lrs-frm sml-field search-partner">
					<div class="row gy-4">
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">Partner Name</label>
										<?= $this->Form->control('cm_comp_name', ['value'=>isset($formpostdata['cm_comp_name'])? $formpostdata['cm_comp_name']: '' , 'label' => false, 'class'=>'form-control', 'required'=>false, 'tabindex'=>1]) ?>		
									</div>
								</div>
								
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">Phone Number</label>
										<?= $this->Form->control('cm_phone', [ 'value'=>isset($formpostdata['cm_phone'])? $formpostdata['cm_phone']: '' , 'label' => false, 'class'=>'form-control', 'required'=>false, 'tabindex'=>2]) ?>			
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">Email</label>
										<?= $this->Form->control('cm_email', ['value'=>isset($formpostdata['cm_email'])? $formpostdata['cm_email']: '' , 'label' => false, 'class'=>'form-control', 'required'=>false, 'tabindex'=>3]) ?>			
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="submit">
									<?= $this->Form->button(__('Search'), ['name'=>'searchBtn','class'=>'btn btn-success  flt-rght','id'=>'searchBtnId', 'tabindex'=>4]); ?>
									</div>
								</div> 
								<div class="col-xxl-12 col-md-12">
									<?= $this->Html->link(__('Clear'), '',['class'=>'btn btn-danger flt-rght', 'tabindex'=>5]); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?= $this->Form->end() ?>
		</div>
		
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Search Result 
				<div class="submit flt-rght export-btn">
 
                    <?= $this->Html->link(__('Add Partner'), ['controller' => 'CompanyMst', 'action' => 'add'], ['class' => 'btn btn-success']) ?>
                    
					<!-- <?= $this->Html->link(__('<i class="fa fa-file-excel-o"></i> Partner Export'), ['controller' => 'CompanyMst', 'action' => 'export'], ['class'=>'btn btn-success', 'role'=>'button','escape'=>false]) ?> -->
				</div>
				</h4> 
			</div>
			<div class="card-body">
				<table id="dataTables-example" class="display table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th style="width: 30px;"><?= __('ID') ?></th>
							<th ><?= __('Partner Name') ?></th>
							<th><?= __('Main Contact') ?></th>
							<th><?= __('Phone') ?></th>
							<th><?= __('Email Address') ?></th>
							<th><?= __('Active') ?></th>
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
		"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)' }  }],
		"ajax": {
			url : '<?= $this->Url->build(["controller" => "companyMst","action" => "ajaxListIndex"]) ?>',
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
		order: [[ 0,"desc" ]],
		orderable: false	
	});
});
</script>
<?php $this->end() ?>
