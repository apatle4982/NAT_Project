<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="row">

    <div class="col-lg-12">
        <div class="card">
             
            <?= $this->Form->create($FilesAccountingData, ['horizontal'=>true]) ?>
  
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">

                        <div class="col-xs-12 col-sm-3 col-md-3"> 
                            
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label"><?= __('Partner') ?></label>
                                <?= $this->Form->control('company_id', ['type' => 'select', 'label' =>false, 'options' => $companyMsts, 'multiple' => false, 'empty' => 'Select Partner', 'class'=>'form-control', 'required'=>false]) ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-7 col-md-7"> 
                            <div class="panel-heading" style="padding:0;"><?= __('More Filter Options') ?></div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                    <div class="row input-daterange m-b" id="datepicker">
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        Date Range:
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5"> 
                                            <div class="input-container-floating">
                                                <label for="basiInput" class="form-label"><?= __('From Date') ?></label>
                                                <?= $this->Form->control('fromdate', ['placeholder' => '(yyyy-mm-dd)', 'label' => false, 'class'=>'form-control', 'value' => ($fromdate ? $fromdate : date("Y-m-d"))]) ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                            <div class="input-container-floating">
                                                <label for="basiInput" class="form-label"><?= __('To Date') ?></label>
                                                <?= $this->Form->control('todate', ['placeholder' => '(yyyy-mm-dd)', 'label' => false, 'class'=>'form-control', 'value' => ($todate ? $todate : date("Y-m-d"))]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-2 top-btn-container flt-right"> 
                            <?= $this->Form->button(__('Search'), ['name'=>'search', 'class'=>'btn btn-primary']) ?>
                        </div> 
                    </div>
                    <div class="row gy-4">    
                        
                         
                        

                    </div>
                    
                     
                </div> 
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <?php if(isset($csvFileName)) { ?>
        <div class="col-lg-12">
            <div class="card"> 
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
 
                            <?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
                            <!---Using helper here--->
                            <?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
                            <?php } ?>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php  } ?>                        
</div>