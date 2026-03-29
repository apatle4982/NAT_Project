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
						<div class="col-xs-12 col-sm-10 col-md-10"> 
							<div class="row gy-4">
								<div class="col-xs-12 col-sm-3 col-md-3"> 

                                    <div class="input-container-floating">
                                        <label for="basiInput" class="form-label"><?= __('Partner') ?></label>
                                        <?= $this->Form->control('company_id', ['type' => 'select', 'label' =>false, 'options' => $companyMsts, 'multiple' => false, 'empty' => 'Select Partner', 'class'=>'form-control', 'required'=>false]) ?>

                                    </div>
								</div>

								<div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="input-container-floating">
                                        <label for="basiInput" class="form-label"><?= __('Document Type(s)') ?></label>
                                        <?php
                                            echo $this->Form->control('TransactionType', [
                                                'options' => $DocumentTypeData, 
                                                'multiple' => false, 
                                                'label' =>false,
                                                'empty' =>'Select Document Type',
                                                'class'=>'form-control', 
                                                'required'=>false
                                            ]);
                                        ?> 
                                    </div>
								</div>
							</div>
                            <div class="row gy-4">
                                <div class="col-xs-12 col-sm-12 col-md-12"> 
                                    
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <div class="panel-heading" style="padding:0;"><?= __('More Filter Options') ?></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                    <div class="input-container-floating">
                                                        <label for="basiInput" class="form-label"><?= __('State') ?></label>
                                                        <?= $this->Form->control('State', ['label' => false, 'class'=>'input-sm form-control']) ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="input-container-floating">
                                                        <label for="basiInput" class="form-label"><?= __('County') ?></label>
                                                        <?= $this->Form->control('County', ['label' => false, 'class'=>'input-sm form-control']) ?>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                    <div class="input-container-floating">
                                                        <label for="basiInput" class="form-label">Date Range</label>
                                                        
                                                        <div class="row">  
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="margin-top:0;">
                                                                <div class="input-container-floating">
                                                                    <label for="basiInput" class="form-label"><?= __('From') ?></label>
                                                                    <?= $this->Form->control('fromdate', ['placeholder' => '(yyyy-mm-dd)', 'label' => false, 'required' => true,'class'=>'form-control', 'value' => ($fromdate ? $fromdate : date("Y-m-d"))]) ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="margin-top:0;">
                                                                <div class="input-container-floating">
                                                                    <label for="basiInput" class="form-label"><?= __('To') ?></label>
                                                                    <?= $this->Form->control('todate', ['placeholder' => '(yyyy-mm-dd)', 'label' => false, 'class'=>'form-control', 'value' => ($todate ? $todate : date("Y-m-d"))]) ?>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                                
                                            </div>
                                    
                                                <!--div class="row">   
                                                
                                                
                                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                    Date Range:
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                        <div class="row">  
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="input-container-floating">
                                                                    <label for="basiInput" class="form-label"><?= __('From') ?></label>
                                                                    <?= $this->Form->control('fromdate', ['placeholder' => '(yyyy-mm-dd)', 'label' => false, 'class'=>'form-control', 'value' => ($fromdate ? $fromdate : date("Y-m-d"))]) ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="input-container-floating">
                                                                    <label for="basiInput" class="form-label"><?= __('To') ?></label>
                                                                    <?= $this->Form->control('todate', ['placeholder' => '(yyyy-mm-dd)', 'label' => false, 'class'=>'form-control', 'value' => ($todate ? $todate : date("Y-m-d"))]) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div-->
                                            </div>
                                    
                                </div>																																							
                            </div>
						<div class="col-xs-12 col-sm-2 col-md-2"> 
							<div class="row gy-4">
								<div class="col-xs-12 col-sm-12 col-md-12 top-btn-container flt-right"> 
								<?= $this->Form->button(__('Search'), ['name'=>'search', 'class'=>'btn btn-primary']) ?>
								</div>
							</div>
						</div>
                    </div>
                  
                </div>
            </div> 
            <?= $this->Form->end() ?>
        </div>
    </div>

    <?php if(isset($csvFileName) || isset($pdfDownloadLinks) || isset($csvFileNameCounty)) { ?>
        <div class="col-lg-12">
            <div class="card"> 
                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">

                            <div class="panel panel-default">
								<div class="panel-heading">
								<?= __('Your search results have returned the following results:') ?>
								</div>
								<div class="panel-body">
									<div>
										<b>Date Range:</b> <b>From: </b> <?php if(isset($fromdate)) { ?><?= $fromdate ?><?php } ?><b> To: </b> <?php if(isset($todate)) { ?><?= $todate ?><?php } ?>
										<br><br>
										
										<b>State:</b>  <?php if(isset($State)) { ?><?= $State ?><?php } ?><br><br>	
										
										<b>County(s):</b> <?php if(isset($estimateFeeDetails['Countyarr'])) { ?> <?= $estimateFeeDetails['Countyarr'] ?><?php } ?><br><br>
										<b>Doc Type(s):</b> <?php if(isset($estimateFeeDetails['doctypearr'])) { ?> <?= $estimateFeeDetails['doctypearr'] ?><?php } ?><br><br>
										<b>Number of records found:</b> <?php if(isset($estimateFeeDetails['totalcnt'])) { ?> <?= $estimateFeeDetails['totalcnt'] ?><?php } ?><br><br>
										
										<b>Average Recording Fee:</b> <?php if(isset($estimateFeeDetails['totalrecfee'])) { ?> <?= $estimateFeeDetails['totalrecfee'] ?><?php } ?>
										<br><br>
										
										<b>Average Tax if applicable:</b><?php if(isset($estimateFeeDetails['totaltax'])) { ?>  <?= $estimateFeeDetails['totaltax'] ?><?php } ?><br><br>
										
										<b>Average Total Combined:</b> <?php if(isset($estimateFeeDetails['totalrec'])) { ?>
										<?= $estimateFeeDetails['totalrec'] ?>
										<?php } ?>
										<br><br>
									</div>
								</div>
							</div>

                            <?php if(isset($csvFileName) && !empty($csvFileName)) { ?>
                            <!---Using helper here--->
                            <?= $this->Lrs->loadDownloadLink($csvFileName,'export') ?>
                            <?php } ?>
                            
                            <?php if(isset($csvFileNameCounty) && !empty($csvFileNameCounty)) { ?>
                            <!---Using helper here--->
                            <?= $this->Lrs->loadDownloadLink($csvFileNameCounty,'export','Generate County Average Sheet') ?>
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