<?php
/**
  * @var \App\View\AppView $this
  */   
?>
<?php $this->append('css') ?>
<style>
table.table-bordered.dataTable thead tr:first-child th{ padding-right:4px!important; padding-left:4px!important; }
</style> 
<?php $this->end() ?>
<?= $this->Form->create($filesAccountingData, ['horizontal' => true]) ?>

<div class="row">
    <div class="col-xxl-12 col-md-12 col-sm-12" style="margin-top:0px;">
        <div class="row gy-4" style="margin-bottom:10px;">
            <div class="col-xxl-12 col-md-12 col-sm-12" style="margin-top:0px;">
                <?= $this->Lrs->saveCancelBtn('',$section); ?>
            </div>                   
        </div>
        <div class="card">	 
            <div class="card-body">
                <div class="live-preview ">
                    <div class="row account-entry">
                        <div class="row gy-4">
                            <div class="col-xxl-6 col-md-6">
                                <div class="input-container-floating">
                                <label class="form-label mb-0"><?= ((isset($partnerMapField['mappedtitle']['TransactionType'])) ? $partnerMapField['mappedtitle']['TransactionType'] : 'TransactionType');?></label>
                                <?php echo $this->Form->control('docTypeId', ['type' => 'select','value' => $documentData['Id'], 'label' => false, 'options' =>$documentDataList, 'multiple' => false, 'class'=>'form-control','style'=>'max-width: 300px;']);?>
                            
                                <?= $this->Form->hidden('fmdId', ['value'=>$filesMainData['Id']]); ?>
                                <?= $this->Form->hidden('accountId', ['value'=>(isset($filesAccountingData->accountId)) ? $filesAccountingData->accountId: '']); ?> 
                                </div>
                            </div>
                        </div>
                        
                            <div class="col-xxl-8 col-md-8 col-sm-12 long-lbl-frm ">
                                <div class="col-xxl-12 col-md-12 col-xs-12">
                                    <div id="model-datatables_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">  
                                        <table id="model-datatables" class="table table-bordered nowrap
                                                            align-middle dataTable no-footer dtr-inline
                                                            collapsed" style="width: 100%;" aria-describedby="model-datatables_info">
                                            <thead>
                                                <tr>
                                                    <th>Data Fields</th>
                                                    <th>CountyCalc Estimated Govt. Fees (API)</th>
                                                    <th>Initial Calculated Government Fees</th>
                                                    <th>Curative Entry</th>
                                                    <th>Final Billed Government fees</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr >
                                                    <th>County Recording Fee</th>
                                                    <td>
                                                        <?php 	echo $this->Form->control('jrf_cc_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcCCTotal()','title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->jrf_cc_fees)) ? $filesAccountingData->jrf_cc_fees: '200']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('jrf_icg_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal1()', 'onkeyup'=>'calcICTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->jrf_icg_fees)) ? $filesAccountingData->jrf_icg_fees: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('jrf_curative', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal1()','onkeyup'=>'calcCETotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->jrf_curative)) ? $filesAccountingData->jrf_curative: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('jrf_final_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->jrf_final_fees)) ? $filesAccountingData->jrf_final_fees: '']); ?> 
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <th>Transfer Tax</th>
                                                    <td>
                                                        <?php 	echo $this->Form->control('tt_cc_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcCCTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->tt_cc_fees)) ? $filesAccountingData->tt_cc_fees: '200']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('tt_icg_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal2()','onkeyup'=>'calcICTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->tt_icg_fees)) ? $filesAccountingData->tt_icg_fees: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('tt_curative', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal2()','onkeyup'=>'calcCETotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->tt_curative)) ? $filesAccountingData->tt_curative: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('tt_final_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->tt_final_fees)) ? $filesAccountingData->tt_final_fees: '']); ?> 
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <th>Intangible / Mtg Tax</th>
                                                    <td>
                                                        <?php 	echo $this->Form->control('it_cc_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+',  'onkeyup'=>'calcCCTotal()','title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->it_cc_fees)) ? $filesAccountingData->it_cc_fees: '200']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('it_icg_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal3()','onkeyup'=>'calcICTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->it_icg_fees)) ? $filesAccountingData->it_icg_fees: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('it_curative', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal3()','onkeyup'=>'calcCETotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->it_curative)) ? $filesAccountingData->it_curative: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('it_final_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->it_final_fees)) ? $filesAccountingData->it_final_fees: '']); ?> 
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <th>Taxes</th>
                                                    <td>
                                                        <?php 	echo $this->Form->control('ot_cc_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcCCTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->ot_cc_fees)) ? $filesAccountingData->ot_cc_fees: '200']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('ot_icg_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal4()','onkeyup'=>'calcICTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->ot_icg_fees)) ? $filesAccountingData->ot_icg_fees: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('ot_curative', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal4()','onkeyup'=>'calcCETotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->ot_curative)) ? $filesAccountingData->ot_curative: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('ot_final_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->ot_final_fees)) ? $filesAccountingData->ot_final_fees: '']); ?> 
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <th>Nonstandard Fee</th>
                                                    <td>
                                                        <?php 	echo $this->Form->control('ns_cc_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcCCTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->ns_cc_fees)) ? $filesAccountingData->ns_cc_fees: '200']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('ns_icg_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal5()','onkeyup'=>'calcICTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->ns_icg_fees)) ? $filesAccountingData->ns_icg_fees: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('ns_curative', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal5()','onkeyup'=>'calcCETotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->ns_curative)) ? $filesAccountingData->ns_curative: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('ns_final_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->ns_final_fees)) ? $filesAccountingData->ns_final_fees: '']); ?> 
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <th>Walkup / Abstractor Fee</th>
                                                    <td>
                                                        <?php 	echo $this->Form->control('wu_cc_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcCCTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->wu_cc_fees)) ? $filesAccountingData->wu_cc_fees: '200']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('wu_icg_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal6()', 'onkeyup'=>'calcICTotal()','title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->wu_icg_fees)) ? $filesAccountingData->wu_icg_fees: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('wu_curative', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal6()','onkeyup'=>'calcCETotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->wu_curative)) ? $filesAccountingData->wu_curative: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('wu_final_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->wu_final_fees)) ? $filesAccountingData->wu_final_fees: '']); ?> 
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <th>Additional Fees</th>
                                                    <td>
                                                        <?php 	echo $this->Form->control('of_cc_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcCCTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->of_cc_fees)) ? $filesAccountingData->of_cc_fees: '200']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('of_icg_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal7()','onkeyup'=>'calcICTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->of_icg_fees)) ? $filesAccountingData->of_icg_fees: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('of_curative', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onchange'=>'calctotal7()','onkeyup'=>'calcCETotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->of_curative)) ? $filesAccountingData->of_curative: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('of_final_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'onkeyup'=>'calcTotal()', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->of_final_fees)) ? $filesAccountingData->of_final_fees: '']); ?> 
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <th>Total</th>
                                                    <td>
                                                        <?php 	echo $this->Form->control('total_cc_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->total_cc_fees)) ? $filesAccountingData->total_cc_fees: '1400']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('total_icg_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->total_icg_fees)) ? $filesAccountingData->total_icg_fees: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('total_curative', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->total_curative)) ? $filesAccountingData->total_curative: '']); ?> 
                                                    </td>
                                                    <td>
                                                    <?php 	echo $this->Form->control('total_final_fees', 
                                                            ['label'=>false, 'type'=> 'number', 'style'=>'max-width:100px;',
                                                            'class'=>'form-control', 'required'=>false, 'pattern'=>'[0-9 (.)]+', 'title'=>'Only letters are allowed', 'value'=>(isset($filesAccountingData->total_final_fees)) ? $filesAccountingData->total_final_fees: '']); ?> 
                                                    </td>
                                                </tr>
                                                 
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="row mt-2 mb-2">
                                    <div class="col-xxl-6 col-md-6"> 
                                        <div class="input-container-floating">
                                            <label for="basiInput" class="form-label" style="width: 160px;"><strong>Check Cleared</strong></label>
                                            <div style="width: calc(100% - 160px);"> 
                                                <?php  
                                                $options = ['Y'=>'Yes'];
                                                echo $this->Form->input('check_cleared', [ 
                                                    'type' => 'radio',
                                                    'options' => $options,
                                                    'required' => 'required',
                                                    'label' => false, 
                                                    'class'=>'form-check-input'
                                                    ]); 
                                                ?>
                                                Yes
                                             
                                                <?php  
                                                $options = ['N'=>'No'];
                                                echo $this->Form->input('check_cleared', [ 
                                                    'type' => 'radio',
                                                    'options' => $options,
                                                    'required' => 'required',
                                                    'label' => false, 
                                                    'default' => "N",
                                                    'class'=>'form-check-input'
                                                    ]); 
                                                ?>
                                                No 
                                            </div>
                                        </div>
                                        
                                        <div class="input-container-floating">
                                            <label for="basiInput" class="form-label" style="width: 160px;"><strong>Accounting Processing Date</strong></label>
                                            <?php echo $this->Form->control('AccountingProcessingDate', 
										    ['label'=> false,'class'=>'form-control', 'type'=>'text', 'required'=>false, 'style' => 'width: calc(100% - 320px);' , 'placeholder'=>'(yyyy-mm-dd)', 'value'=>(isset($filesAccountingData->AccountingProcessingDate)) ? date('Y-m-d', strtotime($filesAccountingData->AccountingProcessingDate)): date('Y-m-d')]);?>
                                        </div>
                                    </div>
                                </div>

                                <h2><?= __('Notes') ?></h2>
                                    <div class="row">
                                        <!-- <div class="col-xxl-3 col-md-4"> 
                                            <div class="input-container-floating">
                                            <label for="basiInput" class="form-label" style="width:50px;"><strong>Type</strong></label>
                                            <?php 
                                                /* echo $this->Form->radio('publicType',
                                                    [
                                                        ['value' => 'I', 'text'=>__('Internal')],
                                                        ['value' => 'P', 'text' => __('Public')],
                                                    ],
                                                    ['required'=>false,
                                                    'default' => 'I', 'class'=>'i-checks'
                                                    ]); */
                                            ?>
                                            </div> 
                                        </div> -->
                                
                                        <div class="col-xxl-5 col-md-6">
                                            <div class="input-container-floating">
                                            <label for="basiInput" class="form-label" style="width:70px;"><strong>Regarding</strong></label>
                                            <?php echo $this->Form->control('Regarding', ['label'=>'Regarding',
                                            'class'=>'form-control', 'label'=>false, 'required'=>false, 'type'=>'textarea', 'style'=>'height:50px;width:calc(100% - 70px);']); ?> 
                                        </div>
                                    </div>
                                </div>
                                                                
                            </div>
                            
                            <div class="col-xxl-4 col-md-4 col-sm-12 long-lbl-frm ">
                                <div class="col-xxl-12 col-md-12 col-xs-12 table-responsive">
                                    <div id="model-datatables_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                        <?php echo $this->element('filedata_recordedit', ['partnerMapField'=>$partnerMapField, 'filesMainData'=>$filesMainData]); ?>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="row gy-4" style="margin-bottom:10px;">
                <div class="col-xxl-12 col-md-12 col-sm-12" style="margin-top:0px;">
                    <?= $this->Lrs->saveCancelBtn('',$section); ?>
                </div>                   
            </div>

            <div class="card" style="margin-top:15px">
                <div class="row">
                    <div class="col-xxl-10 col-md-10 col-sm-12">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Accounting History</h4> 
                        </div>

                        <div class="card-body">
                            <div class="live-preview ">
                                <div class="row gy-4">
                                    <div class="col-xxl-12 col-md-12">
                                        <?= $this->element('accounting_history')?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">                              
                <div class="card-body">
                    <div class="live-preview">
                        <!--end row-->
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12 col-xs-12">
                                <div class="col-xxl-12 col-md-12 col-sm-12 detail-list">
                                <?php if(!empty($partnerMapField['help'])){ 
                                    echo $this->Lrs->showMappingHelp($partnerMapField['help']);
                                } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
    </div>
</div>
<?= $this->Form->end() ?>
<?php $this->append('script') ?>

<script type="text/javascript">
   	
	function calctotal1(){
		var total1 = 0;		

        if($('#jrf-curative').val() > 0){
			total1 = parseFloat($("#jrf-curative").val());
		} else {
            total1 = parseFloat($("#jrf-icg-fees").val());
        }
 
		$("#jrf-final-fees").val(total1); 		//total1.toFixed(2)
        calcTotal();
	}

    function calctotal2(){
		var total1 = 0;		
		 
		if($('#tt-curative').val() > 0){
			total1 = parseFloat($("#tt-curative").val());
		} else {
            total1 = parseFloat($("#tt-icg-fees").val());
        }
		
		$("#tt-final-fees").val(total1); 	
        calcTotal();	
	}

    function calctotal3(){
		var total1 = 0;		
		 
		if($('#it-curative').val() > 0){
			total1 = parseFloat($("#it-curative").val());
		} else {
            total1 = parseFloat($("#it-icg-fees").val());
        }
		
		$("#it-final-fees").val(total1); 	
        calcTotal();	
	}

    function calctotal4(){
		var total1 = 0;		
		 
		if($('#ot-curative').val() > 0){
			total1 = parseFloat($("#ot-curative").val());
		} else {
            total1 = parseFloat($("#ot-icg-fees").val());
        }
		
		$("#ot-final-fees").val(total1); 
        calcTotal();		
	}

    function calctotal5(){
		var total1 = 0;		
		 
		if($('#ns-curative').val() > 0){
			total1 = parseFloat($("#ns-curative").val());
		} else {
            total1 = parseFloat($("#ns-icg-fees").val());
        }
		
		$("#ns-final-fees").val(total1); 
        calcTotal();		
	}

    function calctotal6(){
		var total1 = 0;		
		 
		if($('#wu-curative').val() > 0){
			total1 = parseFloat($("#wu-curative").val());
		} else {
            total1 = parseFloat($("#wu-icg-fees").val());
        }
		
		$("#wu-final-fees").val(total1); 
        calcTotal();		
	}

    function calctotal7(){
		var total1 = 0;		
		 
		if($('#of-curative').val() > 0){
			total1 = parseFloat($("#of-curative").val());
		} else {
            total1 = parseFloat($("#of-icg-fees").val());
        }
		
		$("#of-final-fees").val(total1); 	
        calcTotal();	
	}
 
    function calcTotal() {
        var total1 = 0;		
		if($('#jrf-final-fees').val() !=""){
			total1 = total1 + parseFloat($("#jrf-final-fees").val());
		}
		if($('#tt-final-fees').val() !=""){
			total1 = total1 + parseFloat($("#tt-final-fees").val());
		}
        if($('#it-final-fees').val() !=""){
			total1 = total1 + parseFloat($("#it-final-fees").val());
		}
        if($('#ot-final-fees').val() !=""){
			total1 = total1 + parseFloat($("#ot-final-fees").val());
		}
		if($('#ns-final-fees').val() !=""){
			total1 = total1 + parseFloat($("#ns-final-fees").val());
		}
        if($('#wu-final-fees').val() !=""){
			total1 = total1 + parseFloat($("#wu-final-fees").val());
		}
        if($('#of-final-fees').val() !=""){
			total1 = total1 + parseFloat($("#of-final-fees").val());
		}

		$("#total-final-fees").val(total1); 	
    }

    function calcCCTotal() {
        var total1 = 0;	 
		if($('#jrf-cc-fees').val() !=""){
			total1 = total1 + parseFloat($("#jrf-cc-fees").val());
		}
		if($('#tt-cc-fees').val() !=""){
			total1 = total1 + parseFloat($("#tt-cc-fees").val());
		}
        if($('#it-cc-fees').val() !=""){
			total1 = total1 + parseFloat($("#it-cc-fees").val());
		}
        if($('#ot-cc-fees').val() !=""){
			total1 = total1 + parseFloat($("#ot-cc-fees").val());
		}
		if($('#ns-cc-fees').val() !=""){
			total1 = total1 + parseFloat($("#ns-cc-fees").val());
		}
        if($('#wu-cc-fees').val() !=""){
			total1 = total1 + parseFloat($("#wu-cc-fees").val());
		}
        if($('#of-cc-fees').val() !=""){
			total1 = total1 + parseFloat($("#of-cc-fees").val());
		}

		$("#total-cc-fees").val(total1);
    }

    function calcICTotal() {
        var total1 = 0;		
		if($('#jrf-icg-fees').val() !=""){
			total1 = total1 + parseFloat($("#jrf-icg-fees").val());
		}
		if($('#tt-icg-fees').val() !=""){
			total1 = total1 + parseFloat($("#tt-icg-fees").val());
		}
        if($('#it-icg-fees').val() !=""){
			total1 = total1 + parseFloat($("#it-icg-fees").val());
		}
        if($('#ot-icg-fees').val() !=""){
			total1 = total1 + parseFloat($("#ot-icg-fees").val());
		}
		if($('#ns-icg-fees').val() !=""){
			total1 = total1 + parseFloat($("#ns-icg-fees").val());
		}
        if($('#wu-icg-fees').val() !=""){
			total1 = total1 + parseFloat($("#wu-icg-fees").val());
		}
        if($('#of-icg-fees').val() !=""){
			total1 = total1 + parseFloat($("#of-icg-fees").val());
		}

		$("#total-icg-fees").val(total1);
    }

    function calcCETotal() {
        var total1 = 0;		
		if($('#jrf-curative').val() !=""){
			total1 = total1 + parseFloat($("#jrf-curative").val());
		}
		if($('#tt-curative').val() !=""){
			total1 = total1 + parseFloat($("#tt-curative").val());
		}
        if($('#it-curative').val() !=""){
			total1 = total1 + parseFloat($("#it-curative").val());
		}
        if($('#ot-curative').val() !=""){
			total1 = total1 + parseFloat($("#ot-curative").val());
		}
		if($('#ns-curative').val() !=""){
			total1 = total1 + parseFloat($("#ns-curative").val());
		}
        if($('#wu-curative').val() !=""){
			total1 = total1 + parseFloat($("#wu-curative").val());
		}
        if($('#of-curative').val() !=""){
			total1 = total1 + parseFloat($("#of-curative").val());
		}

		$("#total-curative").val(total1);
    }
</script>
<?php $this->end() ?>