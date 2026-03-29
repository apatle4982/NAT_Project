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
                                <button type="button" class="btn btn-info " data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">Click here for CSV format</button>
                            </div>
                        </div>
                            
                    </div> 
                </div> 
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <?php if(!empty($fwViewData)){ ?>
    <div class="col-lg-12">
    <div class="card"> 
    <div class="card-body">
    <?php  if(isset($fwViewData['multipleupdstr']) && !empty($fwViewData['multipleupdstr'])) { ?>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <?php echo $fwViewData['multipleupdstr']; ?>
            <?= $this->Form->hidden('colstext', ['value'=>$fwViewData['colstext']]); ?> 
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
          
        if(isset($fwViewData['insstracc']) && !empty($fwViewData['insstracc'])) { 
            echo $this->Lrs->cscTableShow($fwViewData['insstracc'], 'Below records inserted in shipping section');    
        }   

        if(isset($fwViewData['updstracc']) && !empty($fwViewData['updstracc'])) { 
            echo $this->Lrs->cscTableShow($fwViewData['updstracc'], 'Below records updated (overwritten) in shipping section');    
        } 
    ?>
    </div>
    </div>
    </div><?php } ?>  
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             
            <div class="modal-body"> 
                 <table border=1 cellpadding=4 cellspacing=0 style='margin:0 auto'><tr><td><b>VendorReferenceNo</b></td><td><b>TAGReferenceNo</b></td><td><b>Borrower</b></td><td><b>Jurisdiction</b></td><td><b>State</b></td><td><b>Carrier</b></td><td><b>CarrierReferenceNo</b></td></tr><tr><td>2684868</td><td>2184020-06</td><td>LANTRY</td><td>Hamilton</td><td>OH</td><td>Erecord</td><td>Erecord</td></tr></table> 
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
