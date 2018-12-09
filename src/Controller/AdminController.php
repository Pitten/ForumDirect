<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\BadRequestException;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class AdminController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->deny('index');

        $this->loadComponent('Security');
        $this->loadModel('Users');
        $this->loadModel('Threads');
        $this->loadModel('Posts');
    }

    public function index()
    {
        //$this->set('users', $this->Users->find('all'));
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
        $user = $this->Users->find('all');

        $this->set(compact('user'));
    }

    public function editProfile($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $im = @imagecreatefromstring(file_get_contents($this->request->getData(['avatar'])));
            if ($im) {
                $this->Users->save($user);
                $userRolesRegistry = TableRegistry::get('UsersRoles');
                $query = $userRolesRegistry->query();
                $query->update()
                      ->set([
                      'role_id' => $this->request->getData(['role'])])
                      ->where(['user_id' => $id])
                ->execute();
                $this->Flash->success(__('The user is updated successfully.'));
                return $this->redirect(['action' => 'change-profile']);
            }
            $this->Flash->error(__('An error has occurred'));
        }
        $this->set('edit_profile', $user);
    }
}