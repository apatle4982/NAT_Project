<?php
/** 
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?> 
<style>
.model-body tbody, td, tfoot, th, thead, tr {border: 1px solid #d9d9d9;}
</style>
<div class="row">

    <div class="col-lg-12">
        <div class="card">
             
            <?= $this->Form->create($FilesMainData, ['horizontal' => true, 'enctype' => 'multipart/form-data']) ?>
  
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
                                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?> 
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 col-md-4 text-rght">
                            <div class="input-container-floating"> 
                                <button type="button" class="btn btn-info " data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">Click here for CSV format</button>
                            </div>
                        </div>
                            
                    </div> 
                </div> 
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <?php  if(!empty($fwViewData)){ ?>
    <div class="col-lg-12">
    <div class="card"> 
        <div class="card-body">
    <?php if(isset($fwViewData['multipleupdstr']) && !empty($fwViewData['multipleupdstr'])) { ?>
    <div class="ibox float-e-margins">
    <div class="ibox-content">
    <?= $this->Form->create($FilesMainData, ['class'=>'form-horizontal', 'onsubmit'=>'return checkdt()']) ?>
            <div class="errorhearder">
                <div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10">
                    <h5><?= __('Below records have multiple document types. Please select document type and proceed') ?></h5>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2 top-btn-container flt-right">
                    <div class="ibox-tools"><?= $this->Form->button(__('Proceed'), ['name'=>'btnProceed', 'value'=>'btnProceed', 'class'=>'btn btn-primary pull-right']) ?></div>
                    </div>
                </div></div></div>
            </div>

        <div class="table-responsive">
            <?php echo $fwViewData['multipleupdstr']; ?>
            <?= $this->Form->hidden('colstext', ['value'=>$fwViewData['colstext']]); ?>
            <?= $this->Form->hidden('DBFieldsAcc', ['value'=>$fwViewData['DBFieldsAcc']]); ?>
            <?= $this->Form->hidden('DBFieldsShip', ['value'=>$fwViewData['DBFieldsShip']]); ?>
            <?= $this->Form->hidden('DBFieldsRec', ['value'=>$fwViewData['DBFieldsRec']]); ?>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 top-btn-container flt-right">
          <?= $this->Form->button(__('Proceed'), ['name'=>'btnProceed','value'=>'btnProceed', 'class'=>'btn btn-primary pull-right']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
    </div></div>
    <?php }  // Inserted Rows ?> 

    <!-- Inserted rows table  from helper -->
    <?php 

        if(isset($fwViewData['errrows']) && !empty($fwViewData['errrows'])) { 
           echo $this->Lrs->cscTableShow($fwViewData['errrows'], 'Below records have error in column data');
        }  
    
        if(isset($fwViewData['errrowsCFN']) && !empty($fwViewData['errrowsCFN'])) { 
            echo $this->Lrs->cscTableShow($fwViewData['errrowsCFN'], 'Below records not found in system', 'errorhearder');    
        }  
    
        if(isset($fwViewData['erecrows']) && !empty($fwViewData['erecrows'])) { 
          echo $this->Lrs->cscTableShow($fwViewData['erecrows'], 'Below records are found to be E-RECORDS in Accounting section. The data has not been updated for below records in Accounting section.');    
        } 
        
        if(isset($fwViewData['errrowsQC']) && !empty($fwViewData['errrowsQC'])) {
          echo $this->Lrs->cscTableShow($fwViewData['errrowsQC'], 'Below records inserted/updated in QC section');    
        }
    
        if(isset($fwViewData['insstrqc']) && !empty($fwViewData['insstrqc'])) { 
            echo $this->Lrs->cscTableShow($fwViewData['insstrqc'], 'Below records inserted in QC section');    
        }   
         
        if(isset($fwViewData['updstrqc']) && !empty($fwViewData['updstrqc'])) {
            echo $this->Lrs->cscTableShow($fwViewData['updstrqc'], 'Below records updated (overwritten) in QC section');    
        } 

        // cuntinue button for document type update  
    
        if(isset($fwViewData['insstracc']) && !empty($fwViewData['insstracc'])) { 
            echo $this->Lrs->cscTableShow($fwViewData['insstracc'], 'Below records inserted in Accounting section');    
        }   

        if(isset($fwViewData['updstracc']) && !empty($fwViewData['updstracc'])) { 
            echo $this->Lrs->cscTableShow($fwViewData['updstracc'], 'Below records updated (overwritten) in Accounting section');    
        } 
        
        if(isset($fwViewData['insstrship']) && !empty($fwViewData['insstrship'])) {
            echo $this->Lrs->cscTableShow($fwViewData['insstrship'], 'Below records inserted in Shipping section');    
        }  
        
        if(isset($fwViewData['updstrship']) && !empty($fwViewData['updstrship'])) { 
             echo $this->Lrs->cscTableShow($fwViewData['updstrship'], 'Below records updated (overwritten) in Shipping section'); 
        }   

        if(isset($fwViewData['insstrrec']) && !empty($fwViewData['insstrrec'])) {  
            echo $this->Lrs->cscTableShow($fwViewData['insstrrec'], 'Below records inserted in Recording section'); 
        } 
     
        if(isset($fwViewData['updstrrec']) && !empty($fwViewData['updstrrec'])) { 
            echo $this->Lrs->cscTableShow($fwViewData['updstrrec'], 'Below records updated (overwritten) in Recording section');    
        } 

    ?>
    </div>
    </div>
    </div>
    <?php }  ?>
</div>

 
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
             
            <div class="modal-body"> 
            <table border="0" cellpadding="2" cellspacing="0" width="100%"><tbody>
                    <tr><td><b>County</b></td><td><b>Package</b></td><td><b>File Number</b></td><td><b>Document</b></td><td><b>Type</b></td><td><b>Pages</b></td><td><b>Entry</b></td><td><b>Recording Date</b></td><td><b>Bank Date</b></td><td><b>Recording Fee</b></td><td><b>Submission Fee</b></td><td><b>Tax</b></td><td><b>Accounting</b></td><td><b>Carrier</b></td><td><b>CarrierTrackingNumber</b></td></tr>
                    <tr><td>Albany County, NY</td><td>4256271-03</td><td>4256271-03</td><td>4256271-03</td><td>MORTGAGE</td><td>6</td><td>E R2019-17457</td><td>08/26/2019 09:11 AM</td><td>08/27/2019 02:00 AM</td><td>60</td><td>2</td><td>0</td><td>I</td><td>E-RECORD</td><td>E-RECORD</td></tr>
            </tbody></table>

            <p style="text-align:left;padding-left:20px"><br><br>Note:
                <br>Column C: File Number - is mapped as PartnerFileNumber
                <br>Column D: Document - is mapped as FileName. A script adds .pdf as extension at end of entry
                <br>Carrier and CarrierTrackingNumber columns are optional
            </p>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a> 
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<?php $this->append('script') ?>
<!-- Select2 --> 
<script type="text/javascript">
  
  function checkdt() {
	for(var i=0;i<document.forms['documenttypefrm'].elements.length;i++){
		if(document.forms['documenttypefrm'].elements[i].name == "dt[]"){
			if(document.forms['documenttypefrm'].elements[i].selectedIndex == 0){
				alert("Please select Document Type");
				document.forms['documenttypefrm'].elements[i].focus();
				return false;
			}
		}
	}
}
</script>
<?php $this->end() ?>
