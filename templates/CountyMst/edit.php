<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentTypeMst $documentTypeMst
 */
?>
<?= $this->Form->create($CountyMst) ?>
<div class="col-lg-12 text-center btm-inline"> 
	<div style="display:inline-block;">
		<?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success']); ?> 
	</div> 

	<div style="display:inline-block;"> 
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 
	</div> 
</div>
<div class="row">
	<div class="col-lg-12">
        <div class="card">
            <!--<div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">County Detail</h4> 
            </div>-->
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                       <div class="col-md-6">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">State</label>
                              
                                <?=  $this->Form->select('cm_State',$StateList,['empty' => 'Select State','class' =>'js-example-basic-single form-control', 'required'=>'required', 'label' => false]); ?> 
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">County Name</label>
                                <?= $this->Form->control('cm_title', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                           
                        <div class="col-md-6">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">County Identifier</label>
                                <?= $this->Form->control('cm_code', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div> 
 
                        <div class="col-md-6">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">eRecord Enabled</label>
                                <?= $this->form->control('file_avl', ['type' => 'select', 'label'=>false, 'class'=>'form-control', 'options'=>['Yes'=>'Yes', 'No'=>'No'],'default' =>$CountyMst->file_avl]); ?> 
                            </div>
                        </div>
                           
                        <div class="col-md-6">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Portal</label>
                                <?=  $this->form->control('cm_file_enabled', ['type' => 'select', 'label'=>false, 'class'=>'form-control', 'options'=>['1'=>'CSC', '2'=>'SF', '3'=>'CSC / SF'],'default' =>$CountyMst->cm_file_enabled]); ?> 
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Research</label>
                                <?= $this->form->control('rec_info_avl', ['type' => 'select', 'label'=>false, 'class'=>'form-control', 'options'=>['imagesNoCost'=>'Rec Info & Images No Cost', 'NoimageNocost'=>'Rec Info No Images No Cost', 'fbr'=>'Fee Based Research'],'default' =>$CountyMst->rec_info_avl]); ?> 
                            </div>
                        </div>
                           
                        <div class="col-md-6">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">County Website</label>
                                <?= $this->Form->control('cm_link', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control','placeholder'=>'www.example.com', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-md-6"></div>

                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">FedEx Detail</h4> 
                        </div>

                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Person Name</label>
                                <?= $this->Form->control('fedex_person_name', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Phone Number</label>
                                <?= $this->Form->control('fedex_phone_number', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Company Name</label>
                                <?= $this->Form->control('fedex_company_name', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Address Line 1</label>
                                <?= $this->Form->control('fedex_address_1', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Address Line 2</label>
                                <?= $this->Form->control('fedex_address_2', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">City</label>
                                <?= $this->Form->control('fedex_City', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">State</label>
                                <?= $this->Form->control('fedex_State', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Postal Code</label>
                                <?= $this->Form->control('fedex_postal', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Country Code</label>
                                <?= $this->Form->control('fedex_country_code', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false, 'placeholder' => 'US']) ?> 
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div> 
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<div class="col-lg-12 text-center btm-inline"> 
	<div style="display:inline-block;">
		<?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success']); ?> 
	</div> 

	<div style="display:inline-block;"> 
		<?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 
	</div> 
</div>
<?= $this->Form->end() ?>