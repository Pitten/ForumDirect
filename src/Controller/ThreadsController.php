<?php
namespace App\Controller;

class ThreadsController extends AppController
{
	public $paginate = ['limit' => 4];

	public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Flash');

        $this->loadModel('Posts');

        $this->loadModel('Subforums');

        $this->Auth->deny(['view']);

        if(!$this->request->getSession()->read('Auth.User.id'))
        	$this->Auth->allow(['view']);
    }

    public function view($id = null)
    {
        $thread = $this->Threads->get($id);
        $this->set(compact('thread'));

        $query = $this->Posts->find()->where(['thread_id' => $id]);
        $this->set('posts', $this->paginate($query));
        $this->set('page', $this->request->getQuery('page'));
    }

    public function add($id = null)
    {

        $thread = $this->Threads->newEntity();

        $thread->setDirty('modified', true);

        $query = $this->Subforums->query()
                ->where(['id' => $id]);

        if($query->isEmpty()):
        	$this->Flash->error(__('You are not authorized to access that location.'));
        	
        	return $this->redirect(['action' => '../']);
        endif;

        if ($this->request->is('post')) {
            // Prior to 3.4.0 $this->request->data() was used.
            $thread = $this->Threads->patchEntity($thread, $this->request->getData());
            $thread['author_id'] = $this->request->getSession()->read('Auth.User.id');
            $thread['last_post_uid'] = $this->request->getSession()->read('Auth.User.id');
            $thread['sub_forum_id'] = $id;
            $thread['last_post_date'] = date("Y-m-d H:i:s");
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('Your thread has been saved.'));
                return $this->redirect(['action' => '../']);
            }
            $this->Flash->error(__('Unable to add your thread.'));
        }
        $this->set('thread', $thread);
    }

    public function quote($id = null) {
        $username = $this->Auth->user('username');
        $user_id = $this->Auth->user('id');
        $post = $this->Posts->newEntity();
        $thread = $this->Threads->get($id);
        $query = $this->Threads->find('all')->where(['threads.id' => $id]);

        $this->set('thread', $thread);

        $this->set('default', $thread->body);

        if($thread->closed):
          $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        endif;

        if ($this->request->is('post')) {
            $this->Posts->patchEntity($post, $this->request->getData());
            $post['author_id'] = $this->request->getSession()->read('Auth.User.id');
            $post['thread_id'] = $id;
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

    public function edit($id = null) {
        $username = $this->Auth->user('username');
        $user_id = $this->Auth->user('id');
        $user_role = $this->Auth->user('primary_role');
        $thread = $this->Threads->get($id);

        if($thread->closed):
          $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        endif;

        if($user_id !== $thread['author_id'] && $user_role !== 1){
            $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Threads->patchEntity($thread, $this->request->getData());
            $thread['modified'] = date("Y-m-d H:i:s");
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('Your thread has been updated.'));
                return $this->redirect('/');
            } else {
                $this->Flash->error(__('Unable to update your thread.'));
            }
        }
        $this->set('edit', $thread);
    }

    public function post($id = null)
    {
        $post = $this->Posts->newEntity();

        $post->setDirty('modified', true);

        $query = $this->Threads->query()
                ->where(['id' => $id]);

        if($query->first()->closed):
        	$this->Flash->error(__('You are not authorized to access that location.'));
        	
        	return $this->redirect(['action' => '../']);
        endif;

        if ($this->request->is('post')) {
            // Prior to 3.4.0 $this->request->data() was used.
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            $post['author_id'] = $this->request->getSession()->read('Auth.User.id');
            $post['thread_id'] = $id;
            if ($this->Posts->save($post)) {
            	$query->update()->set(['last_post_date' => date("Y-m-d H:i:s"), 'last_post_uid' => $this->request->getSession()->read('Auth.User.id')])->execute();
                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(['action' => '../threads/view/'.$id.'']);
            }
            $this->Flash->error(__('Unable to add your post.'));
        }
        $this->set('post', $post);
    }
}