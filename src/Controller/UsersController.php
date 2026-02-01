<?php
declare(strict_types=1);

namespace App\Controller;

class UsersController extends AppController
{

    public function registerStaff()
    {
        $this->viewBuilder()->setLayout('auth');

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $user = $this->Users->patchEntity($user, $data);
            $user->role_id = 1;

            if ($this->Users->save($user)) {
                $this->Flash->success('Admin account created. Please login.');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('Failed to create admin account. Please check input.');
        }

        $this->set(compact('user'));
    }

    public function register()
    {
        $this->viewBuilder()->setLayout('auth');

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $user->role_id = 2;

            if ($this->Users->save($user)) {
                $this->Flash->success('Registration successful. Please login.');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('Registration failed. Please check your input.');
        }

        $this->set(compact('user'));
    }

    public function login()
{
    $this->viewBuilder()->setLayout('auth');
    $this->request->allowMethod(['get', 'post']);

    if ($this->request->is('post')) {
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $user = $this->request->getAttribute('identity');
            $roleId = (int)$user->role_id;

            if (in_array($roleId, [1, 3], true)) {
                return $this->redirect(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']);
            }

            return $this->redirect(['prefix' => 'Organizer', 'controller' => 'Dashboard', 'action' => 'index']);
        }

        $errorMessage = 'Invalid email or password.';
        $errors = $result->getErrors(); 
        
        if (!empty($errors)) {
            $errorMessage .= ' (Debug: ' . implode(', ', $errors) . ')';
        }
        
        $this->Flash->error($errorMessage);
    }
}

    public function logout()
    {
        $this->request->allowMethod(['post', 'get']);

        $this->Authentication->logout();

        $this->Flash->success('You have been logged out.');

        return $this->redirect(['action' => 'login']);
    }

}
