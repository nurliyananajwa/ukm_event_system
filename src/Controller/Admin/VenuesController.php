<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

class VenuesController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');

        $q = trim((string)$this->request->getQuery('q', ''));

        $Venues = $this->fetchTable('Venues');

        $query = $Venues->find()
            ->select([
                'Venues.id',
                'Venues.venue_name',
                'Venues.address',
                'Venues.type',
                'Venues.capacity',
                // events_count (requires hasMany Events)
                'events_count' => $query = $Venues->find()->func()->count('Events.id')
            ])
            ->leftJoinWith('Events')
            ->groupBy([
                'Venues.id',
                'Venues.venue_name',
                'Venues.address',
                'Venues.type',
                'Venues.capacity',
            ])
            ->orderAsc('Venues.venue_name');

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'Venues.venue_name LIKE' => "%{$q}%",
                    'Venues.address LIKE'    => "%{$q}%",
                    'Venues.type LIKE'       => "%{$q}%",
                ],
            ]);
        }

        $venues = $this->paginate($query, ['limit' => 10]);

        $this->set(compact('venues', 'q'));
    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');

        $id = (int)$id;
        if ($id <= 0) {
            throw new NotFoundException('Invalid venue');
        }

        $Venues = $this->fetchTable('Venues');
        $Events = $this->fetchTable('Events');

        $venue = $Venues->get($id);

        $eventsQuery = $Events->find()
            ->where(['Events.venue_id' => $id])
            ->contain([
                'Organizers',
                'Approvals',
            ])
            ->orderDesc('Events.id');

        $events = $this->paginate($eventsQuery, ['limit' => 8]);

        $this->set(compact('venue', 'events'));
    }

    public function add()
    {
        $this->viewBuilder()->setLayout('admin');

        $Venues = $this->fetchTable('Venues');
        $venue = $Venues->newEmptyEntity();

        if ($this->request->is('post')) {
            $venue = $Venues->patchEntity($venue, $this->request->getData());

            if ($Venues->save($venue)) {
                $this->Flash->success('Venue added.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Failed to add venue. Please check the form.');
        }

        $this->set(compact('venue'));
    }

    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin');

        $id = (int)$id;
        if ($id <= 0) {
            throw new NotFoundException('Invalid venue');
        }

        $Venues = $this->fetchTable('Venues');
        $venue = $Venues->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $venue = $Venues->patchEntity($venue, $this->request->getData());

            if ($Venues->save($venue)) {
                $this->Flash->success('Venue updated.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Failed to update venue. Please check the form.');
        }

        $this->set(compact('venue'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->viewBuilder()->setLayout('admin');

        $id = (int)$id;
        if ($id <= 0) {
            throw new NotFoundException('Invalid venue');
        }

        $Venues = $this->fetchTable('Venues');
        $venue = $Venues->get($id);

        if ($Venues->delete($venue)) {
            $this->Flash->success('Venue deleted.');
        } else {
            $this->Flash->error('Failed to delete venue.');
        }

        return $this->redirect(['action' => 'index']);
    }
}
