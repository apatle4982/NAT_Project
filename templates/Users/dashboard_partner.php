<div class="row">
    <div class="col-xxl-12 col-md-12 col-sm-12">
        <div class="card"> 
            <div class="card-body">
                <div class="live-preview ">
                
                    <div class="row dash-section">
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-search"></i></div>
                                <h2><?php echo $this->Html->link(__('Master Search'), ['controller' => 'master-data', 'action'=>'masterSearchPartner']); ?></h2>
                            </div>
                        </div>
                        
                        <div class="col-xxl-3 col-md-3 col-sm-12 ico-section">
                            <div class="dash-container">
                                <div class="ico-container"><i class="las la-save"></i></div>
                                <h2><?= $this->Html->link('View AOL template', ['controller' => 'FilesVendorAssignment', 'action' => 'aolindexPartner']) ?></h2>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                </div>
            </div>
        </div>
         
    </div>
</div>