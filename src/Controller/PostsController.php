<?php
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class PostsController extends AppController
{
  public function beforeFilter(Event $event)
  {
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->loadModel('Threads');
  }

   public function edit($id = null) {
        $username = $this->Auth->user('username');
        $user_id = $this->Auth->user('id');
        $user_role = $this->Auth->user('role');
        $query = $this->Threads->find('all')->where(['threads.id' => $id]);
        $post = $this->Posts->get($id);
        $thread = $this->Threads->get($post->thread_id);

        if($thread->closed):
          $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        endif;

        if($user_id !== $post['author_id'] && $user_role != 1){
            $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Posts->patchEntity($post, $this->request->getData());
            $post['modified'] = date("Y-m-d H:i:s");
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('Your post has been updated.'));
                return $this->redirect('/');
            } else {
                $this->Flash->error(__('Unable to update your post.'));
            }
        }
        $this->set('edit', $post);
    }

    public function quote($id = null) {
        $username = $this->Auth->user('username');
        $user_id = $this->Auth->user('id');
        $post = $this->Posts->newEntity();
        $post_data = $this->Posts->get($id);
        $query = $this->Threads->find('all')->where(['threads.id' => $post_data->thread_id]);
        $thread = $this->Threads->get($post_data->thread_id);

        $this->set('post_data', $post_data);

        $this->set('default', $post_data->body);

        if($thread->closed):
          $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        endif;

        if ($this->request->is('post')) {
            $this->Posts->patchEntity($post, $this->request->getData());
            $post['author_id'] = $this->request->getSession()->read('Auth.User.id');
            $post['thread_id'] = $post_data->thread_id;
            if ($this->Posts->save($post)) {
                $query->update()->set(['last_post_date' => date("Y-m-d H:i:s"), 'last_post_uid' => $this->request->getSession()->read('Auth.User.id')])->execute();
                $this->Flash->success(__('Your post has been updated.'));
                return $this->redirect('/');
            } else {
                $this->Flash->error(__('Unable to update your post.'));
            }
        }
        $this->set('quote', $post);
    }
}