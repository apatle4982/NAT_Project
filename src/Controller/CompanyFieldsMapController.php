<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CompanyFieldsMap Controller
 *
 * @property \App\Model\Table\CompanyFieldsMapTable $CompanyFieldsMap
 * @method \App\Model\Entity\CompanyFieldsMap[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyFieldsMapController extends AppController
{
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
        $companyFieldsMap = $this->paginate($this->CompanyFieldsMap);

        $this->set(compact('companyFieldsMap'));
    }

    /**
     * View method
     *
     * @param string|null $id Company Fields Map id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companyFieldsMap = $this->CompanyFieldsMap->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('companyFieldsMap'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $companyFieldsMap = $this->CompanyFieldsMap->newEmptyEntity();
        if ($this->request->is('post')) {
            $companyFieldsMap = $this->CompanyFieldsMap->patchEntity($companyFieldsMap, $this->request->getData());
            if ($this->CompanyFieldsMap->save($companyFieldsMap)) {
                $this->Flash->success(__('The company fields map has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company fields map could not be saved. Please, try again.'));
        }
        $this->set(compact('companyFieldsMap'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company Fields Map id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $companyFieldsMap = $this->CompanyFieldsMap->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companyFieldsMap = $this->CompanyFieldsMap->patchEntity($companyFieldsMap, $this->request->getData());
            if ($this->CompanyFieldsMap->save($companyFieldsMap)) {
                $this->Flash->success(__('The company fields map has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company fields map could not be saved. Please, try again.'));
        }
        $this->set(compact('companyFieldsMap'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Fields Map id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyFieldsMap = $this->CompanyFieldsMap->get($id);
        if ($this->CompanyFieldsMap->delete($companyFieldsMap)) {
            $this->Flash->success(__('The company fields map has been deleted.'));
        } else {
            $this->Flash->error(__('The company fields map could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
