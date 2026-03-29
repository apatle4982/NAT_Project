<div class="login-pg">

<div class="row">
    <div class="col-lg-12">
        <div class="card login-inputs">

            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <!--<div class="col-xxl-6 col-md-6 col-sm-12 login-lft">
                            <h2 class="login-heading">
                            Welcome to the Lender Recording Services, Inc. re:Cord V2.0
                            Partner Gateway
                            </h2>
                            <p class="text-center bold">Partners please login below (..)</p>
                            <p class="text-center">If you have reached this site in error and are looking to contact Lender Recording Services, please visit LRS' main site located at www.lrsinc.com for information regarding our services.
                            </p>
                        </div>-->
                        <div class="col-xxl-12 col-md-12 col-sm-12 login-rgth">
                            <div class="user-ico">
                                <?=$this->Html->image("lock.jpg", array("alt" => "Login"))?>
                            </div>
                            <?= $this->Form->create() ?>
                                 

                                <div class="row gy-4">
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        <?= $this->Flash->render() ?>
                                    </div>
                                    <div class="col-xxl-12 col-md-12 col-sm-12">
                                        
                                        <div class="input-container-floating"> 

                                            <?= $this->Form->control('user_username', ['placeholder'=>'Username', 'templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?> 

                                        </div>
                                        
                                    </div>
                                    <div class="col-xxl-12 col-sm-12">
                                        
                                            <div class="input-container-floating">
                                                <?= $this->Form->control('password', ['placeholder'=>'Password','templates' => ['inputContainer' => '{{content}}'], 'required' => true, 'class' =>'form-control', 'label' => false]) ?>
                                             
                                            </div>
                                    </div>
                                    <div class="col-xxl-12 col-sm-12">
                                        <div class="submit">
                                            <?= $this->Form->submit(__('Login'),['class'=>'btn btn-success w-100']); ?> 
                                        </div>                        
                                    </div>
                                    <div class="col-xxl-12 col-sm-12">
                                        <?= $this->Html->link('Forgot password?', ['controller' => 'users', 'action' => 'forgot_password'],['class'=>'text-muted']) ?>
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