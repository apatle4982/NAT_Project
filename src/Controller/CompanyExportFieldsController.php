<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CompanyExportFields Controller
 *
 * @property \App\Model\Table\CompanyExportFieldsTable $CompanyExportFields
 * @method \App\Model\Entity\CompanyExportField[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyExportFieldsController extends AppController
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
        $companyExportFields = $this->paginate($this->CompanyExportFields);

        $this->set(compact('companyExportFields'));
    }

    /**
     * View method
     *
     * @param string|null $id Company Export Field id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $companyExportField = $this->CompanyExportFields->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('companyExportField'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $companyExportField = $this->CompanyExportFields->newEmptyEntity();
        if ($this->request->is('post')) {
            $companyExportField = $this->CompanyExportFields->patchEntity($companyExportField, $this->request->getData());
            if ($this->CompanyExportFields->save($companyExportField)) {
                $this->Flash->success(__('The company export field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company export field could not be saved. Please, try again.'));
        }
        $this->set(compact('companyExportField'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company Export Field id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $companyExportField = $this->CompanyExportFields->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $companyExportField = $this->CompanyExportFields->patchEntity($companyExportField, $this->request->getData());
            if ($this->CompanyExportFields->save($companyExportField)) {
                $this->Flash->success(__('The company export field has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company export field could not be saved. Please, try again.'));
        }
        $this->set(compact('companyExportField'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company Export Field id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $companyExportField = $this->CompanyExportFields->get($id);
        if ($this->CompanyExportFields->delete($companyExportField)) {
            $this->Flash->success(__('The company export field has been deleted.'));
        } else {
            $this->Flash->error(__('The company export field could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
