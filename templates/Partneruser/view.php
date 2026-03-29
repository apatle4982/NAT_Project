<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
 
 

<div class="row">

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Partner Details</h4> 
            </div>  
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="input-container-floating output-container">
                                <label for="basiInput" class="form-label">Partner Name:</label>
                                <div class="input-value"> <?=  h($user->company_mst->cm_comp_name) ?> </div> 
                            </div>
                        </div>
                         
                    </div>
                    <!--end row-->
                </div> 
            </div>
            
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Personal Details</h4> 
            </div> 
           
                 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                         
                        <div class="col-md-12">
                             <div class="input-container-floating output-container">
                                <label for="basiInput" class="form-label">Name:</label>
                                <div class="input-value"><?=  h($user->user_name) ?> </div> 
                            </div>
                        </div>
                        <div class="col-md-12">
                             <div class="input-container-floating output-container">
                                <label for="basiInput" class="form-label">Email:</label>
                                <div class="input-value"> <?= h($user->user_email) ?> </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-container-floating output-container">
                                <label for="basiInput" class="form-label">Phone:</label>
                                <div class="input-value"> <?= h($user->user_phone) ?> </div>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div> 
            </div>
        </div>
    </div>
    <!--end col-->

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Login Details</h4> 
            </div> 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="input-container-floating output-container">
                                <label for="basiInput" class="form-label">User Name:</label>
                                <div class="input-value"><?= h($user->user_username) ?> </div> 
                            </div>
                        </div>
                         
                    </div>
                    <!--end row-->
                </div> 
            </div>
        </div>
    </div>

 
 

    
</div>
 