<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentTypeMst $documentTypeMst
 */
?>
 
 


<div class="row">

    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Transaction Type</h4> 
            </div> 
           
                 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                         
                        <div class="col-md-12">
                            <div>
                                <label for="basiInput" class="form-label">Name: </label>
                                <?=  h($documentTypeMst->Title) ?> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <label for="basiInput" class="form-label">Status: </label>
                                <?= ($this->Number->format($documentTypeMst->status) ? 'Active': 'Inactive' )  ?> 
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

 
