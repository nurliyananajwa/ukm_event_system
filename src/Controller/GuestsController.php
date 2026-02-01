<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Guests Controller
 *
 * @property \App\Model\Table\GuestsTable $Guests
 */
class GuestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Guests->find()
            ->contain(['Events', 'GuestTypes']);
        $guests = $this->paginate($query);

        $this->set(compact('guests'));
    }

    /**
     * View method
     *
     * @param string|null $id Guest id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $guest = $this->Guests->get($id, contain: ['Events', 'GuestTypes']);
        $this->set(compact('guest'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $guest = $this->Guests->newEmptyEntity();
        if ($this->request->is('post')) {
            $guest = $this->Guests->patchEntity($guest, $this->request->getData());
            if ($this->Guests->save($guest)) {
                $this->Flash->success(__('The guest has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The guest could not be saved. Please, try again.'));
        }
        $events = $this->Guests->Events->find('list', limit: 200)->all();
        $guestTypes = $this->Guests->GuestTypes->find('list', limit: 200)->all();
        $this->set(compact('guest', 'events', 'guestTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Guest id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $guest = $this->Guests->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $guest = $this->Guests->patchEntity($guest, $this->request->getData());
            if ($this->Guests->save($guest)) {
                $this->Flash->success(__('The guest has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The guest could not be saved. Please, try again.'));
        }
        $events = $this->Guests->Events->find('list', limit: 200)->all();
        $guestTypes = $this->Guests->GuestTypes->find('list', limit: 200)->all();
        $this->set(compact('guest', 'events', 'guestTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Guest id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $guest = $this->Guests->get($id);
        if ($this->Guests->delete($guest)) {
            $this->Flash->success(__('The guest has been deleted.'));
        } else {
            $this->Flash->error(__('The guest could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
