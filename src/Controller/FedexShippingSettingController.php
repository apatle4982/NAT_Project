<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FedexShippingSetting Controller
 *
 * @property \App\Model\Table\FedexShippingSettingTable $FedexShippingSetting
 * @method \App\Model\Entity\FedexShippingSetting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FedexShippingSettingController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
	 
	public function beforeFilter(\Cake\Event\EventInterface $event)
    {
		parent::beforeFilter($event);
		$this->loginAccess();
	}
	
    public function index()
    {
        // set page title
		 $pageTitle = 'Fedex Shipping Setting Details';
		 $this->set(compact('pageTitle'));

        //$fedexShippingSetting = $this->paginate($this->FedexShippingSetting);
        //$this->set(compact('fedexShippingSetting'));
		
		$id = 1;
		$fedexShippingSetting = $this->FedexShippingSetting->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fedexShippingSetting = $this->FedexShippingSetting->patchEntity($fedexShippingSetting, $this->request->getData());
            if ($this->FedexShippingSetting->save($fedexShippingSetting)) {
                $this->Flash->success(__('The fedex shipping setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The fedex shipping setting could not be saved. Please, try again.'));
        }
		 
        $this->set(compact('fedexShippingSetting'));
    }

    
}
