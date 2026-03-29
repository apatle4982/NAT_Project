<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="row">
    <div class="col-lg-12">
		<!-- search section start-->
		<div class="card">
			<!--<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Search Fields</h4> 
			</div>-->
			<?= $this->Form->create($CountyMst,['horizontal' => true]) ?>
			<div class="card-body">
				<div class="live-preview lrs-frm sml-field search-partner">
					<div class="row gy-4">
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">State</label>
										<?= $this->Form->control('cm_State', ['options' => $StateList, 'multiple' => false, 'empty' => 'Select State','label' => false,'value'=>isset($formpostdata['cm_State'])? $formpostdata['cm_State']: '' , 'class'=>'form-control', 'required'=>false]) ?>
									</div>
								</div>
								
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">County</label>
										<?= $this->Form->control('cm_title', ['label' => false, 'value'=>isset($formpostdata['cm_title'])? $formpostdata['cm_title']: '' , 'placeholder' => 'County', 'class'=>'form-control', 'required'=>false]) ?>	
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating ">
										<label for="basiInput" class="form-label">Code</label>
										<?= $this->Form->control('cm_code', ['label' => false, 'value'=>isset($formpostdata['cm_code'])? $formpostdata['cm_code']: '' , 'placeholder' => 'Code', 'class'=>'form-control', 'required'=>false]) ?>			
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12">
							<div class="row gy-4">
								<div class="col-xxl-12 col-md-12">
									<div class="submit">
									<?= $this->Form->button(__('Search'), ['name'=>'searchBtn','class'=>'btn btn-success flt-rght','id'=>'searchBtnId']); ?>
									</div>
								</div>
 
								<!-- <div class="col-xxl-12 col-md-12">
									<?php //= $this->Html->link('<i class="fa fa-file-excel-o"></i> Export Sheet', ['controller' => 'CountyMst', 'action' => 'export'],['class'=>'btn btn-primary btn-xs w-50 flt-rght','escape'=>false]);  ?>
								</div> -->
 
							</div>
						</div>
					</div>
				</div>
			</div>
			<?= $this->Form->end() ?>
		</div>
		<!-- search section end-->
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1"></h5>
                 <div> 
                    <?= $this->Html->link(__('Add County'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div> 
            <div class="card-body">
			 
					<table id="datatable_example" class="display table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th style="width: 30px;"><?= __('SrNo') ?></th>
							<th><?= __('State') ?></th>
							<th><?= __('County') ?></th>
							  
								<th><?= __('CountyID') ?></th>
							 
								<th ><?= __('Erecord Capable') ?></th>
								<th ><?= __('Portal') ?></th>
								<th ><?= __('Research') ?></th>
								<th ><?= __('Website') ?></th>
							 
							<th><?= __('Last Modified') ?></th>
							<th class="actions" style="width: 105px;"><?= __('Actions') ?></th>
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
		
		$('#datatable_example').DataTable({
			"lengthMenu": [[10, 25, 50, 100, -1],[10, 25, 50, 100, 'All']],
			"processing": true,
			"pageLength": 10,
			"serverSide": true,
			"searching": false, 
			"dom": 'Blfrtip',  
			"buttons": [{ extend: 'csv', text: 'Export CSV', exportOptions: { columns: ':visible:not(:last-child)' } }],
			"ajax": {
				
				url : '<?= $this->Url->build(["controller" => $this->request->getParam('controller'),"action" => "ajaxList".ucfirst($this->request->getParam('action'))]) ?>',
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
