<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?> 

<div class="row">

    <div class="col-lg-12">
        <div class="card">
             
            <?= $this->Form->create($FilesAccountingData, ['horizontal' => true, 'enctype' => 'multipart/form-data']) ?>
  
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                         
                        <div class="col-xs-12 col-sm-4 col-md-4"> 
                        
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Browse CSV file</label>
                                <?=  $this->Form->control('upload_records',['type'=>'file',  'required'=>'required', 'label' => false]); ?>   
                            </div>
                        </div>
                         
                        <div class="col-xs-12 col-sm-4 col-md-4 top-btn-container flt-right">
                            <div class="submit">
                            <?= $this->Form->submit(__('Import CSV'),['name'=>'saveBtn', 'class'=>'btn btn-success']); ?>  
                            </div> 
                            <div class="cancel"> 
                                <?= $this->Html->link(__('Cancel'), ['controller'=>'HuntingtonAccounting','action' => 'index'], ['class' => 'btn btn-danger']) ?> 
                            </div>
                        </div>
                            
                    </div> 
                </div> 
            </div>
            <?= $this->Form->end() ?>
        </div>


            
        <?php  if(!empty($fwViewData)){  ?>
            <div class="col-lg-12">
                <div class="card"> 
                    <div class="card-body"> 

                        <!-- Inserted rows table  from helper -->
                        <?php 

                          /*   if(isset($fwViewData['errrows']) && !empty($fwViewData['errrows'])) { 
                            echo $this->Lrs->cscTableShow($fwViewData['errrows'], 'Below records have error in column data');
                            } */  
                        
                            if(isset($fwViewData['errrowsCFN']) && !empty($fwViewData['errrowsCFN'])) { 
                                echo $this->Lrs->cscTableShow($fwViewData['errrowsCFN'], 'Below records not found in system', 'errorhearder');    
                            }  
                        
                            // cuntinue button for document type update  
                        
                            if(isset($fwViewData['insstracc']) && !empty($fwViewData['insstracc'])) { 
                                echo $this->Lrs->cscTableShow($fwViewData['insstracc'], 'Below records inserted in Accounting section');    
                            }   

                            if(isset($fwViewData['updstracc']) && !empty($fwViewData['updstracc'])) { 
                                echo $this->Lrs->cscTableShow($fwViewData['updstracc'], 'Below records updated (overwritten) in Accounting section');    
                            } 
                            

                        ?>
                        </div>
                </div>
            </div>
        <?php }  ?>
    </div>
       
 
 
</div>
 
