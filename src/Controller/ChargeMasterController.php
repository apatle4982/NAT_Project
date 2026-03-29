<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ChargeMaster Controller
 *
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChargeMasterController extends AppController
{
	private $columns_alise = [  
                                "ID" => "cgm_id",
                                "ChargeTitle" => "cgm_title",
                                "ChargeType" => "cgm_type",
								"Actions" => ""
                            ];
	private $columnsorder = ['cgm_id','cgm_title','cgm_type'];
	
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
		 $pageTitle = 'Banking Detail Charge types List';
		 $this->set(compact('pageTitle'));

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
		
        $this->set('pageTitle','Banking Detail Charge types List');
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
		    $recordsTotal = $this->$modelname->find('all',['fields'=>['cgm_id']])->count();
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
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','ChargeTitle']);
        }
		return $data;
	}
	
    /**
     * View method
     *
     * @param string|null $id Charge Master id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chargeMaster = $this->ChargeMaster->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('chargeMaster'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chargeMaster = $this->ChargeMaster->newEmptyEntity();
        if ($this->request->is('post')) {
            $chargeMaster = $this->ChargeMaster->patchEntity($chargeMaster, $this->request->getData());
            if ($this->ChargeMaster->save($chargeMaster)) {
                $this->Flash->success(__('The charge master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The charge master could not be saved. Please, try again.'));
        }
		$this->set('pageTitle','Add Banking Detail Charge types');
        $this->set(compact('chargeMaster'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Charge Master id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chargeMaster = $this->ChargeMaster->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $chargeMaster = $this->ChargeMaster->patchEntity($chargeMaster, $this->request->getData());
            if ($this->ChargeMaster->save($chargeMaster)) {
                $this->Flash->success(__('The charge master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The charge master could not be saved. Please, try again.'));
        }
		$this->set('pageTitle','Update Banking Detail Charge types');
        $this->set(compact('chargeMaster'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Charge Master id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chargeMaster = $this->ChargeMaster->get($id);
        if ($this->ChargeMaster->delete($chargeMaster)) {
            $this->Flash->success(__('The charge master has been deleted.'));
        } else {
            $this->Flash->error(__('The charge master could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
