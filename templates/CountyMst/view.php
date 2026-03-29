<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentTypeMst $documentTypeMst
 */
?>

 

 
    <div class="row">
<div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">County Detail</h4> 
            </div> 
           
 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                       <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">State</label>
                                <?= $CountyMst->cm_State ?> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">County</label>
                                <?= $CountyMst->cm_title ?> 
                            </div>
                        </div>
                           
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Country Code</label>
                                <?= $CountyMst->cm_code ?> 
                            </div>
                        </div> 
 
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Erecord Capable</label>
                                <?= $CountyMst->file_avl ?> 
                            </div>
                        </div>
                           
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Portal</label>
                                <?= $CountyMst->cm_file_enabled ?> 
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Research</label>
                                <?= $CountyMst->rec_info_avl ?> 
                            </div>
                        </div>
                           
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Website</label>
                                <?= $CountyMst->cm_link ?> 
                            </div>
                        </div> 
 
                       
                    
                    </div>
                    <!--end row-->
                </div> 
            </div>
        </div>
    </div>
    <!--end col-->


 
