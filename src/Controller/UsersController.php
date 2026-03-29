<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\View\View;
use Cake\View\ViewBuilder;

use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;

use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Utility\Text;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public  $pageLimit = ['limit' => 999999999999, 'maxLimit' => 999999999999];

    private $columns_useralise = [
        'UserId'=> 'user_id',
        "FullName" => 'user_name',
        "Phone" =>'user_phone',
        "Email" =>'user_email',
        "Username" =>'user_username',
        "Actions" => '',
        "LastName" => 'user_lastname'
     ];
     
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
		$this->Authentication->addUnauthenticatedActions(['login']); 
		
	}
	
    public function dashboard()
    {
        $pageTitle = 'Home';
        $this->set(compact('pageTitle'));

		if($this->user_Gateway){
			$this->render('dashboard_partner');
		}
    }

	public function login()
	{ 
		$this->request->allowMethod(['get', 'post']);
		$result = $this->Authentication->getResult();

		if ($result->isValid()) {
			$redirect = $this->request->getQuery('redirect', [
				'controller' => 'Users',
				'action' => 'dashboard',
			]);
            
            $user = $result->getData();   // This gives you the User entity
            $userActive = $user->user_active; 
            
            if($userActive == '0'){
                $this->Flash->error(__('This user is de-activated'));
                $this->logout();
            }
			//return $this->redirect($redirect);
            return $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
		}
		if ($this->request->is('post') && !$result->isValid()) {
			$this->Flash->error(__('Invalid username or password'));
		}
	}

	public function logout()
	{
		$result = $this->Authentication->getResult();
		if ($result->isValid()) {
			$this->Authentication->logout();
			return $this->redirect(['controller' => 'Users', 'action' => 'login']);
		}
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $pageTitle = 'Users Listing';
        $this->set(compact('pageTitle'));
     
        $users = $this->Users;
		 
		array_pop($this->columns_useralise);
		$this->set('dataJson',$this->CustomPagination->setDataJson($this->columns_useralise,['Actions']));
		 
		$formpostdata = '';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$formpostdata = $this->request->data;
		}
		$this->set('formpostdata', $formpostdata);
 
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }
 
    public function userList()
    {
        $modelname = $this->name;
        $this->autoRender = false;

        $columns = array(0=>'user_id',1=>'user_name',2=>'user_phone',3=>'user_email',4=>'user_username',5=>'user_lastname');
 
		unset($this->columns_useralise['Actions']);
		
		$this->CustomPagination->setPaginationData(['request'=>$this->request->getData(),
													 'columns'=>$columns,
													 'columnAlise'=>$this->columns_useralise,
													 'modelName'=>$modelname
													]);
		$pdata = $this->CustomPagination->getQueryData();
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END
		
		$pdata['condition']['conditions']['AND'] = ['Users.user_id !='=>1, 'Users.user_companyid'=>0, 'Users.user_deleted' => "N"];
		$query = $this->$modelname->find('search', $pdata['condition']);

		if($pdata['is_search'] === false){
		     $recordsTotal = $this->$modelname->find('all',['fields'=>['user_id'],'conditions'=>['Users.user_id !='=>1, 'Users.user_companyid'=>0,'Users.user_deleted' => "N"]])->count();
		}else{ 
			unset($pdata['condition']['limit'], $pdata['condition']['offset']);
			$recordsTotal = $this->$modelname->find('search', $pdata['condition'])->count();
		}
 
        $results = $query->disableHydration()->order(['user_id'=>'desc'])->all();
 
        $data = $results->toArray(); 
		$data = $this->getParsingData($data);
        
        $response = array(
            "draw" => intval($pdata['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsTotal),
            "data" => $data
        );
 
        echo json_encode($response);
        exit;
    }

    private function getParsingData(array $data){
		 
        foreach ($data as $key => $value) {
             
			$data[$key]['FullName'] = $value['FullName'].' '.$value['LastName'];
			$data[$key]['Email'] = '<a href="mailto:'.$value['Email'].'">'.$value['Email'].'</a>';
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['UserId','FullName']);
        }
		return $data;
	}

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Groups'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pageTitle = 'Add User';
        $this->set(compact('pageTitle'));
        
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            
            $postData = $this->request->getData(); 
            $postData['user_lastname'] = '';
            $postData['user_companyid'] = 0; 
            $postData['user_deleted'] = 'N';
           // $postData['original_password'] = $postData['password'];

            $user = $this->Users->patchEntity($user, $postData);
             
            if ($result = $this->Users->save($user)) {
                $user_id =  $user->user_id; 
                    
                $user_groups = $this->getTableLocator()->get('UsersGroups'); 
                $usr_grp = $user_groups->newEmptyEntity();
                $usr_grp->user_id = $user_id;
                $usr_grp->group_id = $postData['group_id'];
                $user_groups->save($usr_grp); 
                
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please try again.'));
            }
            
        }
        $groups = $this->Users->Groups->find('list',['keyField' => 'group_id','valueField' => 'group_name'])->where(['Groups.group_id !='=>PARTNER_GROUP])->all(); 
        $statusArr = array("1" => "Active", "0" => "Inactive");
        $this->set(compact('user', 'groups', 'statusArr'));
         
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // set page title
        $pageTitle = 'Edit User';
        $this->set(compact('pageTitle'));
        
        $user = $this->Users->get($id, [
            'contain' => ['Groups'],
        ]);
         
        if ($this->request->is(['patch', 'post', 'put'])) {

            $postData = $this->request->getData(); 
            if(!empty($postData['new_password'])) {
                $postData['password'] = $postData['new_password'];
               // $postData['original_password'] = $postData['new_password'];
            }
             
            $user = $this->Users->patchEntity($user, $postData);
 
            if ($this->Users->save($user)) {
                 
                    $user_groups = $this->getTableLocator()->get('UsersGroups');  
                
                    $user_groups->deleteAll(['user_id' => $id]); // deleting all old enties 
 
                    $usr_grp = $user_groups->newEmptyEntity();
                    $usr_grp->user_id = $id;
                    $usr_grp->group_id = $postData['group_id'];
                    $user_groups->save($usr_grp); 
                  
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
         
        $grs = $this->getTableLocator()->get('Groups'); 
        
        $res = $grs->find()->select(['Groups.group_id','Groups.group_name','ug.user_id'])
                    ->join([
                        'table' => 'users_groups',
                        'alias' => 'ug',
                        'type' => 'LEFT',
                        'conditions' => '(ug.group_id = Groups.group_id and ug.user_id = '.$id.')',
                    ])->where(['Groups.group_id !='=>PARTNER_GROUP])
                    ->enableAutoFields(true);
        $resUG = $res->all();
        
        $statusArr = array("1" => "Active", "0" => "Inactive");

        $this->set(compact('user','resUG','statusArr'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    { 
        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, ['user_deleted'=>'Y']);
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
 
    /** chk
     * List partner users 
     * company table has many relation with users table
     */
    public function partnerUser()
    {
        // set page title
        $pageTitle = 'Partners User Listing';
        $this->set(compact('pageTitle'));
        
		/*$this->paginate = array(
			'conditions' => array(
				'user_deleted' => "N",
                'user_companyid !=' => 0
            ),
             'contain' => ['CompanyMst'=> function ($query) {
                return $query->select(['cm_comp_name']);
            }]                                                                                                                   
		); 

        $users = $this->paginate($this->Users, $this->pageLimit);*/
		
		
		$columns_alise = [
							'UserId'=> 'Users.user_id',
							"FullName" => 'Users.user_name',
							"Phone" =>'Users.user_phone',
							"Email" =>'Users.user_email',
							'Partner'=>'CompanyMst.cm_comp_name',
							"Status" => 'Users.user_deleted',
							"Actions" => '',
							"LastName" => 'Users.user_lastname'
						 ];
	 
		array_pop($columns_alise);
		$this->set('dataJson',$this->CustomPagination->setDataJson($columns_alise,['Actions']));
		
		$isSearch = 0;
		$formpostdata = '';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$formpostdata = $this->request->getData();
			$isSearch = 1;
		}
		$this->set('formpostdata', $formpostdata);
		//end step
		$this->set('isSearch', $isSearch);
		
		$users = $this->Users;

        $this->set(compact('users'));
        $this->render('/Partneruser/index');
    }
 
	public function partnerUserList()
    {
        $modelname = $this->name;
        $this->autoRender = false;

        $columns = array(0=>'Users.user_id',1=>'Users.user_name',2=>'Users.user_phone',3=>'Users.user_email',4=>'Users.cm_comp_name',5=>'Users.user_lastname',6=>'Users.user_deleted');
 
		$columns_alise = [
								'UserId'=> 'Users.user_id',
								"FullName" => 'Users.user_name',
								"Phone" =>'Users.user_phone',
								"Email" =>'Users.user_email',
								'Partner'=>'CompanyMst.cm_comp_name',
								"Status" => 'Users.user_deleted',
								"Actions" => '',
								"LastName" => 'Users.user_lastname'
							 ];
	 
		unset($columns_alise['Actions']);
		
		$this->CustomPagination->setPaginationData(['request'=>$this->request->getData(),
													 'columns'=>$columns,
													 'columnAlise'=>$columns_alise,
													 'modelName'=>$modelname
													]);
		$pdata = $this->CustomPagination->getQueryData();
		
		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END

		$this->loadModel('CompanyMst');	  
		$pdata['condition']['conditions']['AND'] = ['Users.user_companyid !='=>0, 'Users.user_deleted' => "N"];
		$query = $this->$modelname->find('search', $pdata['condition'])->contain(['CompanyMst']);
		
		if($pdata['is_search'] === false){
		     $recordsTotal = $this->$modelname->find('all',['fields'=>['user_id'],'conditions'=>['Users.user_companyid !='=>0,'Users.user_deleted' => "N"]])->count();
		}else{ 
			unset($pdata['condition']['limit'], $pdata['condition']['offset']);
			$recordsTotal = $this->$modelname->find('search', $pdata['condition'])->count();
		}
 
        $results = $query->disableHydration()->all();
	
        $data = $results->toArray(); 
		$data = $this->getParsingDataPartner($data);
       
        $response = array(
            "draw" => intval($pdata['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsTotal),
            "data" => $data
        );
 
        echo json_encode($response);
        exit;
    } 
	
	private function getParsingDataPartner(array $data){
		 
        foreach ($data as $key => $value) {
			$data[$key]['FullName'] = $value['FullName'].' '.$value['LastName'];
			$data[$key]['Status'] = (($value['Status'] == "Y") ? "<font class='error'>Deleted</font>" : "Active");
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['UserId','FullName'], 'Partner');
        }
		return $data;
	}
	
     /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function partnerView($id = null)
    {
        $user = $this->Users->get($id, [
             
             'contain' => ['CompanyMst'=> function ($query) {
                return $query->select(['cm_comp_name']);
            }]
        ]);

        $this->set(compact('user'));
        $this->render('/Partneruser/view');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function partnerAdd()
    { 
        $pageTitle = 'Add Partner User';
        $this->set(compact('pageTitle'));

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $userdata = $this->request->getData();
            
            $userdata['user_active'] = 1;
            $userdata['user_deleted'] = 'N'; 
            $user = $this->Users->patchEntity($user, $userdata);
          
            if ($this->Users->save($user)) {
                
                $user_id =  $user->user_id; 

                $user_groups = $this->getTableLocator()->get('UsersGroups'); 
                $usr_grp = $user_groups->newEmptyEntity();
                $usr_grp->user_id = $user_id;
                $usr_grp->group_id = PARTNER_GROUP;   //4
                $user_groups->save($usr_grp); 

                $this->Flash->success(__('The partner user has been saved.')); 
                return $this->redirect(['action' => 'partnerUser']);
            }
            $this->Flash->error(__('The partner user could not be saved. Please, try again.'));
        }
       
        $this->loadModel('CompanyMst');
        $partnerlist = $this->CompanyMst->companyListArray(); 
        $this->set(compact('user','partnerlist'));
        $this->render('/Partneruser/add');
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editPartner($id = null)
    { 
        
        $pageTitle = 'Update Partner User';
        $this->set(compact('pageTitle'));

        $user = $this->Users->get($id, [
           
            'contain' => ['CompanyMst'=> function ($query) {
                return $query->select(['cm_comp_name']);
            }]
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postData = $this->request->getData(); 
            if(!empty($postData['new_password'])) {
                $postData['password'] = $postData['new_password'];
              //  $postData['original_password'] = $postData['new_password'];
            }
            $user = $this->Users->patchEntity($user, $postData);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The partner user has been saved.'));

                return $this->redirect(['action' => 'partnerUser']);
            }
            $this->Flash->error(__('The partner user could not be saved. Please, try again.'));
        }
        $this->loadModel('CompanyMst');
        $partnerlist = $this->CompanyMst->companyListArray(); 
        $this->set(compact('user','partnerlist'));
        $this->render('/Partneruser/edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function partnerDelete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, ['user_deleted'=>'Y']);
        if ($this->Users->save($user)) { 
            $this->Flash->success(__('The partner user has been deleted.'));
        } else {
            $this->Flash->error(__('The partner user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'partnerUser']);
    } 
	
	public function changePassword(){ 
		//$this->loginAccess();
        $pageTitle = 'Change Password';
        $this->set(compact('pageTitle'));
		$result =  $this->Authentication->getIdentity();
		$id = $result->user_id;
		$user = $this->Users->get($id);
		
		if ($this->request->is(['patch', 'post', 'put'])) {
            $postData = $this->request->getData(); 
			
            if(!empty($postData['old_password']) && !empty($postData['new_password']) && !empty($postData['confirm_password']) ) {
				if($user->original_password == $postData['old_password']){
					$postData['password'] = $postData['new_password'];
					//$postData['original_password'] = $postData['new_password'];
					$user = $this->Users->patchEntity($user, $postData);
 
					if ($this->Users->save($user)) {
						$this->Flash->success(__('Your password has been changed successfully.'));
					} else {
                        $this->Flash->error(__('Error changing password. Please try again.'));
                    }
				}else {
					$this->Flash->error(__('Your old password is not correct. Please try again.'));
				}
            }else {
				$this->Flash->error(__('Please fill all fields. Please, try again.'));
			}
		}
		$this->set('pageTitle','Change Password');
		$this->set(compact('user'));
	}


    public function forgotPassword()
	{ 
		if ($this->request->is('post'))
		{
            $saveBtn = $this->request->getData('saveBtn');
			if ($this->request->is(['patch', 'post', 'put']) && isset($saveBtn)) 
			{
				$email = $this->request->getData('user_email');
				$user = $this->Users->findByUserEmail($email)->select(['user_id', 'user_name', 'user_email','user_username'])->first();

				if (!empty($user))
				{
					$password = sha1(Text::uuid());
					$password_token = Security::hash($password, 'sha256', true);
					$hashval = sha1($user->user_name . rand(0, 100));

					$user->password_reset_token = $password_token;
					$user->hashval = $hashval;

					$reset_token_link = Router::url(['controller' => 'Users', 'action' => 'resetPassword'], TRUE) . '/' . $password_token . '#' . $hashval;
					$this->Users->save($user); 
                    
                    $content = '<p>';
                    $content .=  '<br />';
                    $content .=  'Dear '.ucfirst($user['user_name']).', <br /><br />';
                    $content .=  'We received a request for password change for username '.$user['user_username'].' at '.COMPANY_NAME.'.<br/>';
                    $content .=  'Click to following link to set your new password.<br />';
                    $content .=  '<br />';
                    $content .=  '<div class="aligncenter"><a href="'.$reset_token_link.'" target="_blank" class="btn-primary">Reset Password</a></div> ';
                    $content .=  '<br />';
                    $content .=  '<br />';
                    $content .=  'Best Regards,<br />';
                    $content .=  'The '.COMPANY_NAME.' team'; 
                    $content .= '</p>';
                    
                    $mailer = new Mailer('default');
                    $mailer
                        ->setTransport('default') 
                        ->setFrom([CUSTOMER_EMAIL => COMPANY_NAME])
                        ->setTo($email)
                        ->setEmailFormat('html')
                        ->setSubject('Reset Password!')
                        ->deliver($content);
  
					$this->Flash->success('Please click on password reset link, sent in your email address to reset password.');
				}
				else
				{
					$this->Flash->error('Sorry! Email address is not available here.');
				}
			}
		}
	}
    
    public function resetPassword($token = null)
	 {
  
        if (!empty($token)) {

            $user = $this->Users->findByPasswordResetToken($token)->select(['user_id', 'user_name', 'user_email'])->first();

            if ($user) {

                if (!empty($this->request->getData())) {
					$postData = $this->request->getData();
                    $user = $this->Users->patchEntity($user, [
                        'password' => $postData['new_password'],
						/* 'original_password' => $postData['new_password'], */
                        'new_password' => $postData['new_password'],
                        'confirm_password' => $postData['confirm_password']
                            ] , ['validate' => 'password']
                    );

                    $hashval_new = sha1($user->user_name . rand(0, 100));
                    $user->password_reset_token = $hashval_new;

                    if ($this->Users->save($user)) {
                        $this->Flash->success('Your password has been changed successfully');
						// email not required
                        $this->redirect(['action' => 'login']);
                    } else {
                        $this->Flash->error('Error changing password. Please try again!');
                    }
                }
            } else {
                $this->Flash->error('Sorry your password token has been expired.');
				 $this->redirect(['action' => 'forgotPassword']);
            }
        } else {
            $this->Flash->error('Error loading password reset.');
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

}