<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Security;
use Cake\Utility\Text;

class CompanyApiKeysController extends AppController
{
    private $columnHeaders = ["id","company_mst.cm_comp_name","secret_key","is_active","created"];
	
	private $columns_alise = [  
                                "id" => "id",
								"company_mst.cm_comp_name" => "cm_comp_name",
								'secret_key'=>'secret_key',
								'is_active'=>'is_active',
								'created'=>'created',
								"Actions" => ""
                            ];
	private $columnsorder = ['id','company_mst.cm_comp_name','secret_key','is_active','created','cm_active'];
	 
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event); 
		$this->loginAccess();
	}
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('CompanyApiKeys');
        $this->loadModel('CompanyMst');
    }

    public function index()
    {
        /* $this->paginate = [
            'contain' => ['CompanyMst'],
        ];
        $companyApiKeys = $this->paginate($this->CompanyApiKeys);

        $this->set(compact('companyApiKeys')); */
        // set page title
		$pageTitle = "Partners API Kye's Listing";
        $this->set(compact('pageTitle'));

        $companyKyes = $this->CompanyApiKeys->newEmptyEntity();

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
		
		$this->set(compact('companyKyes'));
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
		//print_r($pdata['condition']['search']['cm_comp_name']);exit;
		//$query = $this->$modelname->find('search',['contain' => ['CompanyMst'],$pdata['condition']]);

        $searchValue = $pdata['condition']['search']['cm_comp_name'];
        $query = $this->$modelname->find('search', [
            'search' => $searchValue,
            'contain' => ['CompanyMst'],
            'limit' => 25,
            'offset' => 0
        ]); 
		
		if($pdata['is_search'] === false){
		    $recordsTotal = $this->$modelname->find('all',['contain' => ['CompanyMst'],'fields'=>['cm_id']])->count();
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

    public function view($id)
    {
        $apiKey = $this->CompanyApiKeys->get($id, ['contain' => ['Companies']]);
        $this->set(compact('apiKey'));
    }

    public function add()
    {
        // set page title
		$pageTitle = 'Add Api Secret Key';
        $this->set(compact('pageTitle'));
        $apiKey = $this->CompanyApiKeys->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['secret_key'] = Security::hash(Text::uuid() . time(), 'sha256', true);
            $apiKey = $this->CompanyApiKeys->patchEntity($apiKey, $data);
            if ($this->CompanyApiKeys->save($apiKey)) {
                $this->Flash->success(__('API Key has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to save API Key. Please check for duplicate or invalid data.'));
        }
        $companies = $this->CompanyMst->find('list', [
            'keyField' => 'cm_id',
            'valueField' => 'cm_comp_name', // adjust if company name column is different
        ]);
        $this->set(compact('apiKey', 'companies'));
    }

    public function edit($id)
    {
        $apiKey = $this->CompanyApiKeys->get($id, ['contain' => ['CompanyMst']]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $apiKey = $this->CompanyApiKeys->patchEntity($apiKey, $this->request->getData());

            if ($this->CompanyApiKeys->save($apiKey)) {
                $this->Flash->success('API Key updated.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Unable to update API Key.');
        }

        $companies = $this->CompanyMst->find('list', [
            'keyField' => 'cm_id',
            'valueField' => 'cm_comp_name',
        ])->toArray();

        $this->set(compact('apiKey', 'companies'));
    }

    public function delete($id)
    {
        //$this->request->allowMethod(['post', 'delete']);
        $apiKey = $this->CompanyApiKeys->get($id);
        if ($this->CompanyApiKeys->delete($apiKey)) {
            $this->Flash->success('API Key deleted.');
        } else {
            $this->Flash->error('Could not delete API Key.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function regenerate($id)
    {
        $apiKey = $this->CompanyApiKeys->get($id);
        $apiKey->secret_key = Security::hash(Text::uuid() . time(), 'sha256', true);
        if ($this->CompanyApiKeys->save($apiKey)) {
            $this->Flash->success('API Key regenerated.');
        } else {
            $this->Flash->error('Regeneration failed.');
        }
        return $this->redirect(['action' => 'index']);
    }
    private function getParsingData(array $data){
		 
        foreach ($data as $key => $value) {
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['id','company_id']);
        }
		return $data;
	}
}