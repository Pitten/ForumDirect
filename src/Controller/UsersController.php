<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\BadRequestException;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('add','logout');
        $this->Auth->allow('profile');

        $this->loadComponent('Security');
        $this->loadModel('Threads');
        $this->loadModel('Posts');
    }

    public function index()
    {
        $this->set('users', $this->Users->find('all'));
    }

    public function settings()
    {
        $user = $this->Users->get($this->request->getSession()->read('Auth.User.id'));

        $threads = $this->Threads->query()
                ->where(['author_id' => $this->request->getSession()->read('Auth.User.id')])->toArray();

        $posts = $this->Posts->query()
                ->where(['author_id' => $this->request->getSession()->read('Auth.User.id')])->toArray();

        $this->set(compact('user'));
        $this->set(compact('threads'));
        $this->set(compact('posts'));
    }

    public function changeProfile()
    {
        $user = $this->Users->get($this->request->getSession()->read('Auth.User.id'));
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $im = @imagecreatefromstring(file_get_contents($this->request->getData(['avatar'])));
            if ($im) {
                $this->Users->save($user);
                $this->Flash->success(__('You are updated successfully.'));
                $this->Auth->setUser($user);
                return $this->redirect(['action' => 'change-profile']);
            }
            $this->Flash->error(__('An error has occurred'));
        }
        $this->set('change_profile', $user);
    }

    public function profile($id = null)
    {
        $user = $this->Users->get($id);

        $threads = $this->Threads->query()
                ->where(['author_id' => $id])->toArray();

        $posts = $this->Posts->query()
                ->where(['author_id' => $id])->toArray();

        $this->set(compact('user'));
        $this->set(compact('threads'));
        $this->set(compact('posts'));
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {

                // $_roles = [];
                // $userRolesRegistry = TableRegistry::get('UsersRoles');
                // $userRoles = $userRolesRegistry->find('all', ['contain' => ['Roles']])
                // ->where([
                //     'user_id' => $user['id']
                // ])
                // ->toList();

                // foreach($userRoles as $role) {
                // array_push($_roles, $role->role->name);
                // }

                //  $user['roles'] = $_roles;

                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Unable to login'));
        }

        if ($this->Auth->user()){
            return $this->redirect($this->Auth->redirectUrl('/'));
        }
    }

    public function logout()
    {
        // Check if the is a post-request
        if ($this->request->is(['post', 'delete']) !== true) {
            throw new BadRequestException;
        }
        // Log the user out and redirect away
        return $this->response
            ->withLocation($this->Auth->logout());
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user['role'] = Configure::read('default_role');
            if ($this->Users->save($user)) {
                $userRolesRegistry = TableRegistry::get('UsersRoles');
                $query = $userRolesRegistry->find('all');
                $query->insert(['role_id', 'user_id'])
                      ->values([
                      'role_id' => Configure::read('default_role'),
                      'user_id' => $user->id])
                ->execute();

                $this->Flash->success(__('You are registered successfully.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('An error has occurred'));
        }
        $this->set('user', $user);

        if ($this->Auth->user()){
            return $this->redirect($this->Auth->redirectUrl('/'));
        }
    }
}