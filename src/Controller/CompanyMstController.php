<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CompanyMst Controller
 *
 * @property \App\Model\Table\CompanyMstTable $CompanyMst
 * @method \App\Model\Entity\CompanyMst[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyMstController extends AppController
{
	private $columnHeaders = ["cm_comp_name","cm_proper_name","cm_phone","cm_email","cm_active"];
	
	private $columns_alise = [  
                                "ID" => "cm_id",
								"cmCompName" => "cm_comp_name",
								'cmProperName'=>'cm_proper_name',
								'cmPhone'=>'cm_phone',
								'cmEmail'=>'cm_email',
								'cmActive'=>'cm_active',
								"Actions" => ""
                            ];
	private $columnsorder = ['cm_id','cm_comp_name','cm_proper_name','cm_phone','cm_email','cm_active'];
	 
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event); 
		$this->loginAccess();
	}
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // set page title
		$pageTitle = 'Partners Listing';
        $this->set(compact('pageTitle'));
		
		$companyMst = $this->CompanyMst->newEmptyEntity();
		
		/*if($this->request->getData('searchBtn') !== null){
			$formpostdata = $this->request->getData();
		}
		
		$cm_comp_name = '';
		$cm_phone = '';
		$cm_email = '';
		$condArr = [];
		if(!empty($formpostdata)){
			if(!empty($formpostdata['cm_comp_name'])){
				$cm_comp_name = $formpostdata['cm_comp_name'];
				$condArr= array_merge($condArr, ['cm_comp_name LIKE'=>'%'.$cm_comp_name.'%']);
			}
			if(!empty($formpostdata['cm_phone'])){
				$cm_phone = $formpostdata['cm_phone'];
				$condArr= array_merge($condArr, ['cm_phone LIKE'=>'%'.$cm_phone.'%']);
			}
			if(!empty($formpostdata['cm_email'])){
				$cm_email = $formpostdata['cm_email'];
				$condArr= array_merge($condArr, ['cm_email LIKE'=>'%'.$cm_email.'%']);
			}
		}
	 
		$settings = ['limit' => 999999999999, 
					'maxLimit' => 999999999999, 
					'conditions' => [ 
						'or' => $condArr
					],
					];
	 
        $companyMst = $this->paginate($this->CompanyMst, $settings); */
		
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
		
		$this->set(compact('companyMst'));
    }

	public function ajaxListIndex(){ 
		$this->autoRender = false;
		$modelname = $this->name;
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
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['cm_id']])->count();
		}else{ 
			unset($pdata['condition']['limit'], $pdata['condition']['offset']);
			$recordsTotal = $this->$modelname->find('all')->count();
		}
 
        $results = $query->disableHydration()->all();
		
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
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','cmCompName']);
        }
		return $data;
	}
    /**
     * View method
     *
     * @param string|null $id Company Mst id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companyMst = $this->CompanyMst->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('companyMst'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // set page title
		$pageTitle = 'Add Partner';
        $this->set(compact('pageTitle'));
        
        $companyMst = $this->CompanyMst->newEmptyEntity();
        if ($this->request->is('post')) {
            $companyMst = $this->CompanyMst->patchEntity($companyMst, $this->request->getData());
						
			// Code to upload the file
			/* if(!empty($this->request->getData('cm_logo'))){
				
				$cm_logo = $this->request->getData('cm_logo');
				$filename =   $cm_logo['name'];
				$uploadPath = 'files/PatnerLogo/';
				$uploadFile = $uploadPath.date('dmyhis').$filename;
				move_uploaded_file($cm_logo['tmp_name'],WWW_ROOT.$uploadFile);
				$companyMst->cm_logo = $uploadFile;
			} */
            if ($this->CompanyMst->save($companyMst)) {
                $this->Flash->success(__('The partner has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The partner could not be saved. Please, try again.'));
        }
		
		$this->loadModel('States');
		$StateList = $this->States->StateListArray();		
		$this->set('StateList', $StateList);
		$this->set('pageTitle','Add Partner');
        $this->set(compact('companyMst'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company Mst id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // set page title
		$pageTitle = 'Update Partner';
        $this->set(compact('pageTitle'));

        $companyMstexist = $this->CompanyMst->exists(['cm_id'=>$id]);
		if(!$companyMstexist){
			return $this->redirect(['action' => 'index']);exit;
		}
		
		$companyMst = $this->CompanyMst->get($id);
       // pr($companyMst);
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			// Code to upload the file
			/* if(!empty($this->request->getData('cm_logo'))){ 
				$cm_logo = $this->request->getData('cm_logo');
				$filename =   $cm_logo['name'];
				$uploadPath = 'files/PatnerLogo/';
				$uploadFile = $uploadPath.date('dmyhis').$filename;
				move_uploaded_file($cm_logo['tmp_name'],WWW_ROOT.$uploadFile);
				$companyMst->cm_logo = $uploadFile;
			} */
			 
            $companyMst = $this->CompanyMst->patchEntity($companyMst, $this->request->getData());
          
            if ($this->CompanyMst->save($companyMst)) {
                $this->Flash->success(__('The partner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The partner could not be saved. Please, try again.'));
        }
		
		$this->loadModel('States');
		$StateList = $this->States->StateListArray();
		$this->set('StateList', $StateList);
		$this->set('pageTitle','Update Partner');
        $this->set(compact('companyMst'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Mst id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $companyMst = $this->CompanyMst->get($id);
        if ($this->CompanyMst->delete($companyMst)) {
            $this->Flash->success(__('The partner has been deleted.'));
        } else {
            $this->Flash->error(__('The partner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function export() {
        $this->response->withDownload('Partner_Export.csv');
        $data = $this->CompanyMst->find('all',['fields'=>["cm_comp_name","cm_proper_name","cm_phone","cm_email","cm_active"]])->toArray();

        $_serialize = 'data';
        $_header = $this->columnHeaders;
        $this->set(compact('data', '_serialize','_header'));
        $this->viewBuilder()->setClassName('CsvView.Csv');
        return;
    }
}
