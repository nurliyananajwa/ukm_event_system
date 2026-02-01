<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Utility\Text;

class UsersController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');

        $q = trim((string)$this->request->getQuery('q', ''));
        $role = (string)$this->request->getQuery('role', ''); // role_id filter optional

        $query = $this->Users->find()
            ->contain(['Roles'])
            ->orderDesc('Users.id');

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'Users.name LIKE'  => "%{$q}%",
                    'Users.email LIKE' => "%{$q}%",
                    'Roles.role_name LIKE' => "%{$q}%",
                ],
            ]);
        }

        if ($role !== '') {
            $query->where(['Users.role_id' => (int)$role]);
        }

        $users = $this->paginate($query, ['limit' => 10]);

        $roles = $this->fetchTable('Roles')
            ->find('list', ['keyField' => 'id', 'valueField' => 'role_name'])
            ->toArray();

        $this->set(compact('users', 'q', 'role', 'roles'));
    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');

        $user = $this->Users->get((int)$id, [
            'contain' => ['Roles'],
        ]);

        // optional: show latest events if organizer
        $events = [];
        if (!empty($user->role?->role_name) && strtolower((string)$user->role->role_name) === 'organizer') {
            $events = $this->fetchTable('Events')->find()
                ->where(['Events.organizer_id' => (int)$user->id])
                ->contain(['Venues', 'Approvals'])
                ->orderDesc('Events.id')
                ->limit(8)
                ->all();
        }

        $this->set(compact('user', 'events'));
    }

    public function add()
    {
        $this->viewBuilder()->setLayout('admin');

        $user = $this->Users->newEmptyEntity();

        $roles = $this->fetchTable('Roles')
            ->find('list', ['keyField' => 'id', 'valueField' => 'role_name'])
            ->toArray();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // IMPORTANT: if you already use Authentication password hasher, fine.
            // If not using hasher, you MUST hash password manually (but usually Cake Auth handles this).
            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success('User created.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Failed to create user. Please check the form.');
        }

        $this->set(compact('user', 'roles'));
    }

    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin');

        $user = $this->Users->get((int)$id, ['contain' => ['Roles']]);

        $roles = $this->fetchTable('Roles')
            ->find('list', ['keyField' => 'id', 'valueField' => 'role_name'])
            ->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // if password empty, don't overwrite
            if (isset($data['password']) && trim((string)$data['password']) === '') {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success('User updated.');
                return $this->redirect(['action' => 'view', $user->id]);
            }

            $this->Flash->error('Failed to update user.');
        }

        $this->set(compact('user', 'roles'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->viewBuilder()->setLayout('admin');

        $user = $this->Users->get((int)$id);

        $identity = $this->request->getAttribute('identity');
        $me = (int)($identity?->id ?? 0);
        if ($me && (int)$user->id === $me) {
            $this->Flash->error('You cannot delete your own account.');
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Users->delete($user)) {
            $this->Flash->success('User deleted.');
        } else {
            $this->Flash->error('Failed to delete user.');
        }

        return $this->redirect(['action' => 'index']);
    }
}
