<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \Cake\Collection\CollectionInterface|string[] $groups
 */
?>
 
<?= $this->Form->create($user, ['action'=>'partnerAdd']) ?>

<div class="row">
    
    <div class="col-lg-12 btm-inline lmb-5"> 
        <div style="display:inline-block;">
            <?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success']); ?> 
        </div>  
        <div style="display:inline-block;"> 
            <?= $this->Html->link(__('Cancel'), ['action' => 'partner-user'], ['class' => 'btn btn-danger']) ?> 
        </div>  
    </div>

</div>


 <div class="card">


    <div class="row">
        <div class="col-lg-4">
       
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Partner Details</h4> 
            </div>  
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Partner Name</label>
                                <?=  $this->Form->select('user_companyid',$partnerlist,['empty' => 'Select Partner','class' =>'js-example-basic-single form-control', 'required'=>'required', 'label' => false]); ?> 
                             </div>
                        </div>
                    </div>
                </div> 
            </div><!--end row-->

        </div>
 
        <div class="col-lg-4">
 
         
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Personal Details</h4> 
            </div> 
           
                 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                         
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">First Name</label>
                                <?= $this->Form->control('user_name', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Last Name</label>
                                <?= $this->Form->control('user_lastname', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Phone</label>
                                <?= $this->Form->control('user_phone', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Email</label>
                                <?= $this->Form->control('user_email', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                       
                    </div>
                    <!--end row-->
                </div> 
            </div>
        
        </div>
    <!--end col-->

        <div class="col-lg-4">
         
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Login Details</h4> 
            </div> 
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Login/User name</label>
                                <?= $this->Form->control('user_username', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Password</label>
                                <?= $this->Form->control('password', ['templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'required'=>'required', 'label' => false]) ?> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-container-floating">
                                <label for="basiInput" class="form-label">Confirm Password</label>
                                <?= $this->Form->control('confirm_password', ['type'=> 'password', 'templates' => ['inputContainer' => '{{content}}'], 'class' =>'form-control', 'required'=>'required', 'label' => false]) ?> 
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div> 
            </div>
       
        </div>
    </div>
</div>


<div class="col-lg-12 btm-inline"> 
    <div style="display:inline-block;">
        <?= $this->Form->submit(__('Submit'),['class'=>'btn btn-success']); ?> 
    </div> 

    <div style="display:inline-block;"> 
        <?= $this->Html->link(__('Cancel'), ['action' => 'partner-user'], ['class' => 'btn btn-danger']) ?> 
    </div> 

</div>



<?= $this->Form->end() ?>



 