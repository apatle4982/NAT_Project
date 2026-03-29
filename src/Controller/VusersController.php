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
class VusersController extends AppController
{
    public  $pageLimit = ['limit' => 999999999999, 'maxLimit' => 999999999999];

    private $columnHeaders = ["user_name","user_phone","user_email","vendorid"];

	private $columns_alise = [
                                "ID" => "user_id",
								"Name" => "user_name",
								'Phone'=>'user_phone',
								'State'=>'user_email',
								'Vendor'=>'vendorid',
								"Actions" => ""
                            ];
	private $columnsorder = ['user_id','user_name','user_phone','user_email','vendorid'];

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



    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    /*public function index()
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
    }*/

    public function index(){
        // set page title
		$pageTitle = 'Vendor User Listing';
        $this->set(compact('pageTitle'));

		$vusers = $this->Vusers->newEmptyEntity();

		// step for datatable config : 3
		$this->set('dataJson',$this->CustomPagination->setDataJson($this->columns_alise,['Actions']));

		// step for datatable config : 4

		$isSearch = 0;
		$formpostdata = '';
		if ($this->request->is(['patch', 'post', 'put'])) {
			$formpostdata = $this->request->getData();
			$isSearch = 1;
		}
		$this->set('formpostdata', $formpostdata);
		//end step
		$this->set('isSearch', $isSearch);

		$this->set(compact('vusers'));
    }

    /*public function userList(){
		$this->autoRender = false;
		$modelname = "Vusers";
		array_pop($this->columns_alise);

        $this->CustomPagination->setPaginationData(['request'=>$this->request->getData(),
                                                     'columns'=>$this->columnsorder,
                                                     'columnAlise'=>$this->columns_alise,
                                                     'modelName'=>$modelname
                                                   ]);

		$pdata = $this->CustomPagination->getQueryData();

		// Remove query limit for all records
		if($pdata['condition']['limit'] == -1){
			unset($pdata['condition']['limit']);
			unset($pdata['condition']['offset']);
		} // END

		$query = $this->$modelname->find('search',$pdata['condition']);

		if($pdata['is_search'] === false){
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['id']])->count();
		}else{
			unset($pdata['condition']['limit'], $pdata['condition']['offset']);
			$recordsTotal = $this->$modelname->find('all')->count();
		}

        $results = $query->disableHydration()->all();

        $data = $results->toArray();


		$data = $this->getParsingData($data);
        //echo "<pre>";print_r($data);echo "</pre>";exit;
        $response = array(
            "draw" => intval($pdata['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsTotal),
            "data" => $data
        );

		echo json_encode($response);
        exit;
    }*/
    public function userList(){
    $this->autoRender = false;
    $modelname = "Vusers";
    array_pop($this->columns_alise);

    $this->CustomPagination->setPaginationData([
        'request' => $this->request->getData(),
        'columns' => $this->columnsorder,
        'columnAlise' => $this->columns_alise,
        'modelName' => $modelname
    ]);

    $pdata = $this->CustomPagination->getQueryData();

    // Remove query limit for all records
    if ($pdata['condition']['limit'] == -1) {
        unset($pdata['condition']['limit']);
        unset($pdata['condition']['offset']);
    }

    // Add where condition for vendorid > 0
    $query = $this->$modelname->find('search', $pdata['condition'])
        ->where(['vendorid >' => 0]);

    if ($pdata['is_search'] === false) {
        $recordsTotal = $this->$modelname->find('all', ['fields' => ['id']])
            ->where(['vendorid >' => 0])
            ->count();
    } else {
        unset($pdata['condition']['limit'], $pdata['condition']['offset']);
        $recordsTotal = $this->$modelname->find('all')
            ->where(['vendorid >' => 0])
            ->count();
    }

    $results = $query->disableHydration()->all();
    $data = $results->toArray();

    $data = $this->getParsingData($data);

    $response = [
        "draw" => intval($pdata['draw']),
        "recordsTotal" => intval($recordsTotal),
        "recordsFiltered" => intval($recordsTotal),
        "data" => $data
    ];

    echo json_encode($response);
    exit;
}
    /*public function userList()
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
    }*/

    /*private function getParsingData(array $data){

        foreach ($data as $key => $value) {

			$data[$key]['Name'] = $value['FullName'].' '.$value['LastName'];
			$data[$key]['Email'] = '<a href="mailto:'.$value['Email'].'">'.$value['Email'].'</a>';
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['UserId','FullName']);
        }
		return $data;
	}*/
    private function getParsingData(array $data){

        foreach ($data as $key => $value) {
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','Name']);
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

        $user = $this->Vusers->newEmptyEntity();
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

        //$groups = $this->Vusers->Groups->find('list',['keyField' => 'group_id','valueField' => 'group_name'])->where(['group_id !='=>PARTNER_GROUP])->all();

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
    /*public function edit($id = null)
    {
        // set page title
        $pageTitle = 'Edit Vendor User';
        $this->set(compact('pageTitle'));

        $user = $this->Vusers->get($id, [
            'contain' => ['Groups'],
        ]);
        echo "ID:".$id;exit;
        if ($this->request->is(['patch', 'post', 'put'])) {

            $postData = $this->request->getData();
            if(!empty($postData['new_password'])) {
                $postData['password'] = $postData['new_password'];
               // $postData['original_password'] = $postData['new_password'];
            }

            $user = $this->Vusers->patchEntity($user, $postData);

            if ($this->Vusers->save($user)) {

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
        $this->render('edit');
    }*/

    public function edit($id = null)
    {
        // set page title
		$pageTitle = 'Update Vendor User';
        $this->set(compact('pageTitle'));

        $companyMstexist = $this->Vusers->exists(['user_id'=>$id]);
		if(!$companyMstexist){
			return $this->redirect(['action' => 'index']);exit;
		}

		$companyMst = $this->Vusers->get($id);
       // pr($companyMst);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $companyMst = $this->Vusers->patchEntity($companyMst, $this->request->getData());

            if ($this->Vusers->save($companyMst)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray();


		$this->loadModel('States');
		$stateList = $this->States->stateListArray();
		$this->set('stateList', $stateList);
		$this->set('pageTitle','Update Vendor User');
        $this->set(compact('companyMst'));
        $this->set(compact('user','vendorlist'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function delete($id = null){
        $this->request->allowMethod(['get', 'delete']);
        $companyMst = $this->Vusers->get($id);
        if ($this->Vusers->delete($companyMst)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    /*public function delete($id = null)
    {
        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, ['user_deleted'=>'Y']);
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/

    /** chk
     * List partner users
     * company table has many relation with users table
     */
    public function vendorUser(){
        // set page title
        $pageTitle = 'Vendor User Listing';
        $this->set(compact('pageTitle'));

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
        $this->render('/Vusers/index');
    }

	public function partnerUserList()
    {
        $modelname = $this->name;
        $this->autoRender = false;

        $columns = array(0=>'Vusers.user_id',1=>'Users.user_name',2=>'Users.user_phone',3=>'Users.user_email',4=>'Vendors.name',5=>'Users.user_lastname',6=>'Users.user_deleted');

		$columns_alise = [
								'UserId'=> 'Vusers.user_id',
								"FullName" => 'Vusers.user_name',
								"Phone" =>'Vusers.user_phone',
								"Email" =>'Vusers.user_email',
                                'Partner'=>'CompanyMst.cm_comp_name',
								"Status" => 'Vusers.user_deleted',
								"Actions" => '',
								"LastName" => 'Vusers.user_lastname'
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
		$this->loadModel('Users');
		$pdata['condition']['conditions']['AND'] = ['Vusers.vendorid !='=>0, 'Vusers.user_deleted' => "N"];
		$query = $this->$modelname->find('search', $pdata['condition'])->contain(['CompanyMst']);

		if($pdata['is_search'] === false){
		     $recordsTotal = $this->$modelname->find('all',['fields'=>['Vusers.user_id'],'conditions'=>['Vusers.vendorid !='=>0,'Vusers.user_deleted' => "N"]])->count();
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
    public function vendorAdd()
    {
        $pageTitle = 'Add Vendor User';
        $this->set(compact('pageTitle'));

        $user = $this->Vusers->newEmptyEntity();
        if ($this->request->is('post')) {
            $userdata = $this->request->getData();

            $userdata['user_active'] = 1;
            $userdata['user_deleted'] = 'N';
            $user = $this->Vusers->patchEntity($user, $userdata);

            if ($this->Vusers->save($user)) {

                $user_id =  $user->user_id;

                /*$user_groups = $this->getTableLocator()->get('UsersGroups');
                $usr_grp = $user_groups->newEmptyEntity();
                $usr_grp->user_id = $user_id;
                $usr_grp->group_id = "4";   //4*/
                //$user_groups->addUserGroup($user_id, "4");

                $this->Flash->success(__('The partner user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The partner user could not be saved. Please, try again.'));
        }

        $this->loadModel('Vendors');
        $vendorlist = $this->Vendors->ListArray();
        $this->set(compact('user','vendorlist'));
        $this->render('/Vusers/add');
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editVendor($id = null){
        $pageTitle = 'Update Vendor User';
        $this->set(compact('pageTitle'));

        $user = $this->Vusers->get($id, [

            'contain' => ['Vendors'=> function ($query) {
                return $query->select(['name']);
            }]
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $postData = $this->request->getData();
            if(!empty($postData['new_password'])) {
                $postData['password'] = $postData['new_password'];
              //  $postData['original_password'] = $postData['new_password'];
            }
            $user = $this->Vusers->patchEntity($user, $postData);
            if ($this->Vusers->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'partnerUser']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->loadModel('Vendors');
        $partnerlist = $this->Vendors->ListArray();
        $this->set(compact('user','partnerlist'));
        $this->render('/Vusers/edit');
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