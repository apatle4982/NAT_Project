<?php
/**
  * @var \App\View\AppView $this
  */
   
?>
<?php $this->append('css') ?>
<?= $this->Html->css(['/assets/css/jasny-bootstrap.min']) ?>
<style>
	span.input-group-addon.btn.btn-primary.btn-file {
		border-radius: 4px!important;
	}
a.input-group-addon.btn.btn-primary.fileinput-exists {
	border-radius: 4px 4px 4px 4px!important;
	margin-left: 5px!important;
	display: inline-block;
}
.fileinput.input-group.col-md-4.pull-right.fs-20.fileinput-exists i.las.la-file-pdf {
    margin-top: 0;
    display: inline-block;
    vertical-align: middle;
}
.fileinput.fileinput-new.input-group.col-md-4.pull-right.fs-20 i.las.la-file-pdf {
    vertical-align: middle!important;
}
</style>
<?php $this->end() ?>
<?= $this->Form->create($FilesRecordingData, ['horizontal' => true]) ?>
    <div class="row">
        <div class="col-lg-12">
			<?php
				 if(($pageType == 'index') && !empty($FilesRecordingData['RecordingProcessingDate']) && !empty($FilesRecordingData['File'])){ 
					echo $this->Form->button(__('Recording Confirmation Coversheets'), ['name'=>'coversheetsSave','class'=>'btn btn-primary']);
				 }
				 
			 ?>
            <?= $this->Lrs->saveCancelBtn('',$section); ?>		
        </div>	
    </div>

<div class="card" style="margin-top:15px">
	<div class="row">
		<div class="col-xxl-6 col-md-6 col-sm-12">
			 
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0">Partner</label> 
								<?php echo $this->Form->control('Partner', ['type' => 'text','value' => $filesMainData['comp_mst']['cm_comp_name'], 'label' =>false, 'readonly'=>'readonly', 'class'=>'form-control']);?>
							</div>
						</div>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
								<label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['TransactionType'])) ? $partnerMapField['mappedtitle']['TransactionType'] : 'TransactionType');?></label> 
								<?php echo $this->Form->control('docTypeId', ['type' => 'select','value' => $documentData['Id'], 'label' => false, 'options' =>$documentDataList, 'multiple' => false, 'class'=>'form-control']);?>
                                
				 				<?= $this->Form->hidden('fmdId', ['value'=>$filesMainData['Id']]); ?>
								<?php 
								$recordId = $FilesRecordingData['Id'];
								echo $this->Form->hidden('recordId', ['value'=>(isset($recordId)) ? $recordId: '']); ?>
								<?php 
									if($pageType == 'index'){
										echo $this->Form->hidden('KNI', ['value'=>2]);
									}
									if($pageType == 'keyno-image'){
										echo $this->Form->hidden('KNI', ['value'=>1]);
									}
								?>
								<?= $this->Form->hidden('pageType', ['value'=>$pageType]); ?>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Recording Entry</h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">

					<?php if($pageType != 'keyno-image'){   ?>

						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['File'])) ? $partnerMapFields['mappedtitle']['File'] : 'File');?></label>
								<?php  
									echo $this->Form->control('File',['type' => 'text', 'required' => false, 'label'=> false, 'class'=>'form-control', 'value'=>(isset($FilesRecordingData['File'])) ? $FilesRecordingData['File']: '', 'escape'=>false ]);
								?> 
 
								<div class="fileinput fileinput-new input-group col-md-4 pull-right fs-20" data-provides="fileinput">
									
									<span class="input-group-addon btn btn-primary btn-file">
										<span class="fileinput-new">Upload File</span>
										<span class="fileinput-exists">Change</span>
										<?= $this->Form->file('DocumentImageFile',['id'=>'DocumentImageFile', 'onchange'=>'GetDirectory()']) ?>
									</span>
									<a href="#" class="input-group-addon btn btn-primary fileinput-exists" data-dismiss="fileinput">Remove</a>
									
									<?php 
										if(!empty($FilesRecordingData['File'])){
											echo $this->html->link(['<i class="las la-file-pdf" aria-hidden="true"></i>'],['controller' => 'MasterData','action' => 'viewpdf/'.$FilesRecordingData['RecId'].'/'.$documentData['Id']], ['title'=>'View file', 'target'=>'_blank', 'class'=>'pull-right','escape'=>false]);
										}
									?>
								</div>
  
							</div>
						</div> 

					<?php 	}  ?>
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['RecordingDate'])) ? $partnerMapFields['mappedtitle']['RecordingDate'] : 'RecordingDate');?></label>
                                <?php echo $this->Form->control('RecordingDate', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'placeholder'=>'yyyy-mm-dd', 'type'=>'text', 'value'=>(isset($FilesRecordingData['RecordingDate'])) ? date('Y-m-d', strtotime($FilesRecordingData['RecordingDate'])): '']); ?>	 
							</div>
						</div> 
                        
                        <div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['RecordingTime'])) ? $partnerMapFields['mappedtitle']['RecordingTime'] : 'RecordingTime');?></label> 
								<?php 
									echo $this->Form->control('RecordingTime', 
									['label'=>false, 'class'=>'form-control', 'type'=>'text', 'required'=>false, 'placeholder'=>'hh:mm', 'value'=>(isset($FilesRecordingData['RecordingTime'])) ? date('H:i', strtotime($FilesRecordingData['RecordingTime'])): '']);
								?>

							</div>
						</div>  

						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['InstrumentNumber'])) ? $partnerMapFields['mappedtitle']['InstrumentNumber'] : 'InstrumentNumber');?></label> 
								<?php echo $this->Form->control('InstrumentNumber', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($FilesRecordingData['InstrumentNumber'])) ? $FilesRecordingData['InstrumentNumber']: '']); ?>
							</div>
						</div> 

						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['Book'])) ? $partnerMapFields['mappedtitle']['Book'] : 'Book');?></label> 
								<?php echo $this->Form->control('Book', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($FilesRecordingData['Book'])) ? $FilesRecordingData['Book']: '']); ?>
							</div>
						</div> 

						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['Page'])) ? $partnerMapFields['mappedtitle']['Page'] : 'Page');?></label> 
								<?php echo $this->Form->control('Page', 
								['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($FilesRecordingData['Page']) ? $FilesRecordingData['Page']: '')]); ?>
							</div>
						</div> 

						<!--- Partner Specific Data LAST DIV--->
						<?php if(isset($partnerMapFields['fieldsvalsPS'])){ ?>
							<h4 class="card-title mb-0 flex-grow-1"><?= __('Partner Specific Data') ?></h4>
							<?php
								foreach($partnerMapFields['fieldsvalsPS'] as $fieldsvalsPS){ ?>
								<div class="col-xxl-12 col-md-12">
									<div class="input-container-floating">	
										<label class="form-label mb-0"><?= ((isset($fieldsvalsPS['cfm_maptitle'])) ? $fieldsvalsPS['cfm_maptitle'].'<sup><font color=red size=1><i>1</i></font></sup>' : '');?></label> 
										<?php echo $this->Form->control('fmd'.$fieldsvalsPS['fm']['fm_title'], 
										['label'=>false, 'class'=>'form-control', 'required'=>false, 'value'=>(isset($FilesRecordingData[$fieldsvalsPS['fm']['fm_title']]) ? $FilesRecordingData[$fieldsvalsPS['fm']['fm_title']]: '')]);  
										?>
									</div>
								</div>  
							<?php } ?>
							 
						<?php } ?>
						<!-- END--->

					</div> 
				</div> 
			</div>

            <div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Recording Processing Date</h4> 
			</div>
            
            <div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<label class="form-label mb-0"><?= ((isset($partnerMapFields['mappedtitle']['RecordingProcessingDate'])) ? $partnerMapFields['mappedtitle']['RecordingProcessingDate'] : 'Recording Processing Date');?></label> 
								<div class="input-daterange" id="datepicker4">
									<?php echo $this->Form->control('RecordingProcessingDate', 
									['label'=>false, 'class'=>'form-control', 'required'=>false, 'type'=>'text', 'placeholder'=>'yyyy-mm-dd', 'value'=> (isset($FilesRecordingData['RecordingProcessingDate'])) ? date("Y-m-d", strtotime($FilesRecordingData['RecordingProcessingDate'])) : date('Y-m-d')]); ?>
								</div>
							</div>
						</div>  
					</div>
					<!--end row-->
				</div> 
			</div>


			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Research Status</h4> 
			</div>
            
            <div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">	
								<?php 
									echo $this->Form->radio('fcd.search_status',
										[
											['value' => 'S', 'text'=>__('Success')],
											['value' => 'F', 'text' => __('Fail-No Find')],
											['value' => 'E', 'text' => __('Fail-Effective Date')],
										],
										['required'=>false,
										'class'=>'i-checks',
										'value'=>isset($search_status) ? $search_status : ''
										]
									); 
								?>
							</div>
						</div>  
					</div>
					<!--end row-->
				</div> 
			</div>
			
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Notes</h4> 
			</div>
			<div class="card-body">
				<div class="live-preview ">
					<div class="row gy-4">
						 
						<div class="col-xxl-12 col-md-12">
							<div class="input-container-floating">
							<label for="basiInput" class="form-label">Regarding</label>
							<?php 
								echo $this->Form->control('public.Regarding', ['label'=>false,
								'class'=>'form-control', 'required'=>false, 'type'=>'textarea', 'style'=>'height:50px']);
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Public/ Internal Notes end -->	 
	    </div>

		<div class="col-xxl-6 col-md-6 col-sm-12"> 
            <?php echo $this->element('filedata_recordedit', ['partnerMapField'=>$partnerMapFields, 'filesMainData'=>$filesMainData]); ?> 
        </div>
	 
	</div>
	<!-- row close -->
</div>

<div class="row">
    <div class="col-lg-12">
		<?= $this->Lrs->saveCancelBtn('',$section); ?>			
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
<?= $this->Html->script('/assets/js/jasny-bootstrap.min') ?>
<script>
	function GetDirectory() {
	  strFile = $('#DocumentImageFile').val();  
	  intPos = strFile.lastIndexOf("\\");
	  strDirectory = strFile.substring(intPos+1,strFile.length);
		if(strDirectory !=""){
			$("#file").val(strDirectory) 
		}
 	}
</script>
<?php $this->end() ?>