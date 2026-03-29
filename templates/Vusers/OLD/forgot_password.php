<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
  */
?>
<div class="password-pg">

<div class="row">
    <div class="col-lg-12">
        <div class="card login-inputs">

            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        
                        <div class="col-xxl-12 col-md-12 col-sm-12 login-rgth">
                            <div class="user-ico">
                                <h3><?= __('Forgot Password') ?></h3>
                            </div>
                            <?= $this->Form->create() ?>
                                
                            <p><?= __('Please specify your username and the login details will be mailed to you.') ?></p>

                                <div class="row gy-4">
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        <?= $this->Flash->render() ?>
                                    </div>
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        
                                        <div class="input-container-floating">  
                                            <?= $this->Form->control('user_email',['label'=>false, 'type' => 'email', 'class'=>'form-control','placeholder'=>'Registered email address', 'required'=>true]) ?> 
                                        </div> 
                                    </div> 
                                    <div class="col-xxl-12 col-sm-12">
                                        <div class="submit">
                                            <?= $this->Form->button('Submit', ['name'=>'saveBtn', 'class'=>'btn btn-success w-100', 'escap'=>false]) ?> 
                                        </div>                        
                                    </div>
                                    <div class="col-xxl-12 col-sm-12">
                                        <?= $this->Html->link('Back to Login', ['controller' => 'users', 'action' => 'login'],['class'=>'text-muted']) ?>
                                    </div>
                                </div>


                            <?= $this->Form->end() ?>
                            <!--end row-->
                        </div>
                        <!------col right---->
                    </div>
                </div>

            </div> 
        </div>
    </div>
</div>
<!--end row-->
</div>