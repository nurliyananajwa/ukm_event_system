<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * GuestTypes Controller
 *
 * @property \App\Model\Table\GuestTypesTable $GuestTypes
 */
class GuestTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->GuestTypes->find();
        $guestTypes = $this->paginate($query);

        $this->set(compact('guestTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Guest Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $guestType = $this->GuestTypes->get($id, contain: ['Guests']);
        $this->set(compact('guestType'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $guestType = $this->GuestTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $guestType = $this->GuestTypes->patchEntity($guestType, $this->request->getData());
            if ($this->GuestTypes->save($guestType)) {
                $this->Flash->success(__('The guest type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The guest type could not be saved. Please, try again.'));
        }
        $this->set(compact('guestType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Guest Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $guestType = $this->GuestTypes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $guestType = $this->GuestTypes->patchEntity($guestType, $this->request->getData());
            if ($this->GuestTypes->save($guestType)) {
                $this->Flash->success(__('The guest type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The guest type could not be saved. Please, try again.'));
        }
        $this->set(compact('guestType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Guest Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $guestType = $this->GuestTypes->get($id);
        if ($this->GuestTypes->delete($guestType)) {
            $this->Flash->success(__('The guest type has been deleted.'));
        } else {
            $this->Flash->error(__('The guest type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
