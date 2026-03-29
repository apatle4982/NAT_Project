<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <?= $this->Form->create($FilesRecordingData, ['horizontal'=>true]) ?>
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                            
                        <div class="col-xs-12 col-sm-3 col-md-3"> 
                            
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label"><?= __('Partner') ?></label>
                                <?= $this->Form->control('company_id', ['type' => 'select', 'label' =>false, 'options' => $companyMsts, 'multiple' => false, 'empty' => 'Select Partner', 'class'=>'form-control', 'required'=>true]) ?>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-7 col-md-7"> 
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                    <div class="row input-daterange m-b" id="datepicker">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="panel-heading"><?= __('Recording Processing Date') ?></div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"> 
                                            <div class="input-container-floating">
                                                <label for="basiInput" class="form-label"><?= __('From Date') ?></label> 
                                                <?= $this->Form->control('StartDate', ['placeholder' => '(yyyy-mm-dd)', 'label' => false, 'class'=>'input-sm form-control', 'value' => ($recStartDate ? $recStartDate : date("Y-m-d"))]) ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="input-container-floating">
                                                <label for="basiInput" class="form-label"><?= __('To Date') ?></label>
                                                <?= $this->Form->control('EndDate', ['placeholder' => '(yyyy-mm-dd)', 'label' =>false, 'class'=>'input-sm form-control', 'value' => ($recEndDate ? $recEndDate : date("Y-m-d"))]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
 
                            </div>
                        </div>
                         
                        <div class="col-xs-12 col-sm-2 col-md-2 top-btn-container flt-right"> 
                            <?= $this->Form->button(__('Generate Sheet'), ['name'=>'generateSheetBtn', 'class'=>'btn btn-primary m-t','escape'=>false]) ?>
                        </div>
 
                    </div> 
                </div> 
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
    
    <?php if(isset($csvFileName) || isset($pdfDownloadLinks)) { ?>
        <div class="col-lg-12">
            <div class="card"> 
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
                            <!---Using helper here--->
                            <?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
                            <?php } ?>
                            
                            <!-----Using helper here----->
                            <?php if(isset($pdfDownloadLinks) && !empty($pdfDownloadLinks)) { ?>
                                <?= $this->Lrs->pdfcsvDownloadLinks($pdfDownloadLinks) ?>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php  } ?>                        
</div> 