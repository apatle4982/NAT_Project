<?php
/**
  * @var \App\View\AppView $this
  */
?>
			
<?= $this->Form->create($filesCheckinData, ['horizontal' => true]) ?>
<div class="row">
	<div class="col-lg-12 text-center btm-inline">
		<div class="submit">
		<?= $this->Form->submit(__('Save'),['class'=>'btn btn-success', 'name'=>'saveBtn']); ?> 
		</div>  
		<div class="submit">
		<?= $this->Form->submit(__('Save and Open Another'),['class'=>'btn btn-success', 'name'=>'saveOpenBtn' ]); ?>
		</div>

		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 					
	</div>
</div>
<div class="card" style="margin-top:15px">
	<div class="row">
	<!-- grantees_g2 start-->
	<div class="col-xxl-4 col-md-4 col-sm-12">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= __('AOL Assignment Status') ?></h4>
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
                                <?php //echo "<pre>"; print_r($assignments); echo "</pre>"; ?>

                                <input id="pre_aol_status" name="pre_aol_status" type="checkbox" value="Y"
                                    <?= $assignments['pre_aol_status'] == 'Y' ? 'checked' : '' ?>>
                                Preliminary IAOL<br>

                                <input id="final_aol_status" name="final_aol_status" type="checkbox" value="Y"
                                    <?= $assignments['final_aol_status'] == 'Y' ? 'checked' : '' ?>>
                                Final IAOL to Attorney<br>

                                <input id="submit_aol_status" name="submit_aol_status" type="checkbox" value="Y"
                                    <?= $assignments['submit_aol_status'] == 'Y' ? 'checked' : '' ?>>
                                Approved IAOL to Client
                            </div>
						</div>
					</div>									 
				</div>
				<!--end row-->
			</div>
			<!-- Document Received end-->
	</div> <!-- 2 col close -->
	</div> <!-- row close -->
</div> <!-- card close -->
<?php if(isset($partnerMapFields['fieldsvalsPS'])){ ?>
<div class="row">
	<div class="col-xxl-12 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1"><?= __('Partner Specific Data') ?></h4> 
			</div> 
			<div class="card-body">
				<div class="live-preview">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($fieldsvalsPS['cfm_maptitle'])) ? $fieldsvalsPS['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label>					
							<?php
							foreach($partnerMapFields['fieldsvalsPS'] as $fieldsvalsPS){ ?>
							<?php echo $this->Form->control($fieldsvalsPS['fm']['fm_title'], 
							['label'=>false,
							'class'=>'form-control', 'required'=>false,  'title'=>'Only letters, numbers and special character are allowed (_@./)']); ?>
							<?php } ?>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-lg-12 text-center btm-inline">
		<div class="submit">
		<?= $this->Form->submit(__('Save'),['class'=>'btn btn-success', 'name'=>'saveBtn']); ?> 
		</div>  
		<div class="submit">
		<?= $this->Form->submit(__('Save and Open Another'),['class'=>'btn btn-success', 'name'=>'saveOpenBtn' ]); ?>
		</div> 
	
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 					
	</div>
	
</div>
<!--- use helper to show Help---->

<?php if(!empty($partnerMapFields['help'])){ ?>
<div class="card" style="margin-top:15px">
	<div class="card-body">
	<?php 
	echo $this->Lrs->showMappingHelp($partnerMapFields['help']);
	?>
	</div>
</div>
<?php } ?>
<?= $this->Form->end() ?>
		
	
<?php $this->append('script') ?>


<script>
	
	function  getCounty(stateId, divId){ 
		$.ajax({
		  method: "POST",
		  url : '<?= $this->Url->build(["controller" => 'files-checkin-data',"action" => "searchCountyAjax"]) ?>',
		  data: { id: stateId},
		  error: function (xhr, error, code) {
				if(xhr.status == 500){
					alert("Your session has expired. Would you like to be redirected to the login page?");
					window.location.reload(true); return false;
				}
			}
		}).done(function(returnData){
			
			$('#'+divId).html(returnData);
			$("select").select2();
		});
	}
</script>
<?php $this->end() ?>