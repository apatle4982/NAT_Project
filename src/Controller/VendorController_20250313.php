<?php

namespace App\Controller;

use App\Controller\AppController;

class VendorController extends AppController{
    private $columnHeaders = ["name","city","state","vendor_status"];

	private $columns_alise = [
                                "ID" => "id",
								"Name" => "name",
								'City'=>'city',
								'State'=>'state',
								'Status'=>'vendor_status',
								"Actions" => ""
                            ];
	private $columnsorder = ['id','name','city','state','vendor_status'];

    public function initialize(): void {
        parent::initialize();
        $this->loadModel('Vendors');
    }

    public function index(){
        // set page title
		$pageTitle = 'Vendor Listing';
        $this->set(compact('pageTitle'));

		$vendors = $this->Vendors->newEmptyEntity();

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

		$this->set(compact('vendors'));
    }

    public function ajaxListIndex(){
		$this->autoRender = false;
		$modelname = "Vendors";
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
    }

    private function getParsingData(array $data){

        foreach ($data as $key => $value) {
            $data[$key]['Actions'] =  $this->CustomPagination->getActionButtons($this->name,$value,['ID','Name']);
        }
		return $data;
	}

    /*public function index()
    {
        $vendors = $this->paginate($this->Vendors);
        $this->set(compact('vendors'));
    }*/

    public function view($id = null)
    {
        $vendor = $this->Vendors->get($id);
        $this->set(compact('vendor'));
    }

    public function add()
    {
        $vendor = $this->Vendors->newEmptyEntity();
        //echo "<pre>";print_r($this->request->getData());echo "</pre>";exit;
        if ($this->request->is('post')) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->getData());
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the vendor.'));
        }
        $this->set(compact('vendor'));
        $this->render('add');
    }

    public function edit($id = null){
        $vendor = $this->Vendors->get($id);

        if($this->request->getData()){
            $data = $this->request->getData();
            $data['title_exam_services'] = implode(',', $this->request->getData('title_exam_services'));
            $data['aol_generation'] = implode(',', $this->request->getData('aol_generation'));
            $data['full_escrow_closing'] = implode(',', $this->request->getData('full_escrow_closing'));
        }
        //echo "<pre>";print_r($data);echo "</pre>";exit;
        if ($this->request->is(['post', 'put'])) {
            $vendor = $this->Vendors->patchEntity($vendor, $data);
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update the vendor.'));
        }
        $this->set(compact('vendor'));
        $this->render('add');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $vendor = $this->Vendors->get($id);
        if ($this->Vendors->delete($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }
}
