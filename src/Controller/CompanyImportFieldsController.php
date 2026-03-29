<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CompanyImportFields Controller
 *
 * @property \App\Model\Table\CompanyImportFieldsTable $CompanyImportFields
 * @method \App\Model\Entity\CompanyImportField[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyImportFieldsController extends AppController
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
        $companyImportFields = $this->paginate($this->CompanyImportFields);

        $this->set(compact('companyImportFields'));
    }

    /**
     * View method
     *
     * @param string|null $id Company Import Field id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companyImportField = $this->CompanyImportFields->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('companyImportField'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $companyImportField = $this->CompanyImportFields->newEmptyEntity();
        if ($this->request->is('post')) {
            $companyImportField = $this->CompanyImportFields->patchEntity($companyImportField, $this->request->getData());
            if ($this->CompanyImportFields->save($companyImportField)) {
                $this->Flash->success(__('The company import field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company import field could not be saved. Please, try again.'));
        }
        $this->set(compact('companyImportField'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company Import Field id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $companyImportField = $this->CompanyImportFields->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companyImportField = $this->CompanyImportFields->patchEntity($companyImportField, $this->request->getData());
            if ($this->CompanyImportFields->save($companyImportField)) {
                $this->Flash->success(__('The company import field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company import field could not be saved. Please, try again.'));
        }
        $this->set(compact('companyImportField'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Import Field id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyImportField = $this->CompanyImportFields->get($id);
        if ($this->CompanyImportFields->delete($companyImportField)) {
            $this->Flash->success(__('The company import field has been deleted.'));
        } else {
            $this->Flash->error(__('The company import field could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
