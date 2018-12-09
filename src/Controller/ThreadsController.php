<?php
namespace App\Controller;

use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;

class ThreadsController extends AppController
{
	public $paginate = ['limit' => 7];

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

    public function view($slug = null, $id = null)
    {
        $thread = $this->Threads->findBySlug($slug)->first();
        if($id != null) $thread = $this->Threads->query()->where(['id' => $id, 'slug' => $slug])->first();
        $this->set(compact('thread'));

        if(is_null($thread)) throw new NotFoundException();

        $tid = $thread->id;

        $query = $this->Posts->find()->where(['thread_id' => $thread->id]);
        $this->set('posts', $this->paginate($query));
        $this->set('page', $this->request->getQuery('page'));

        if($this->request->query('action') == 'lastpost'){
            $totalPages = $this->request->param('paging')['Posts']['pageCount'];

            $action = $this->request->here;

            $query =  $this->Posts->query()->where(['thread_id' => $tid])->order(['id' => 'DESC'])->first();

            if(is_null($query)){
                return $this->redirect(['action' => '../'.$action.'']);
            }else{      
                $lastpost_id = $query->id;
            }

            if($totalPages == 1){
                return $this->redirect(['action' => '../'.$action.'/#pid'.$lastpost_id.'']);
            }

            return $this->redirect(['action' => '../'.$action.'?page='.$totalPages.'#pid'.$lastpost_id.'']);
        }
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
            $thread = $this->Threads->patchEntity($thread, $this->request->getData());
            $thread['slug'] = Inflector::slug($this->request->getData('title'));
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
        $user_role = $this->Auth->user('role');
        $thread = $this->Threads->get($id);

        if($thread->closed):
          $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        endif;

        if($user_id == $thread['author_id'] and $user_role == 1){
        }else{
            if($user_role !== 2 && $user_role !== 3){
                $this->Flash->error(__('You are not authorized to access that location.'));
                return $this->redirect('/');
            }
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

    public function open($id = null) {
        $user_role = $this->Auth->user('role');
        $query = $this->Threads->query()
                ->where(['id' => $id]);

        if($user_role !== 2 && $user_role !== 3){
            $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        }

        if($query->update()->set(['closed' => 0])->execute()){
            $this->Flash->success(__('The given thread has been opened.'));
            return $this->redirect('/');
        }
    }

    public function close($id = null) {
        $user_role = $this->Auth->user('role');
        $query = $this->Threads->query()
                ->where(['id' => $id]);

        if($user_role !== 2 && $user_role !== 3){
            $this->Flash->error(__('You are not authorized to access that location.'));
            return $this->redirect('/');
        }

        if($query->update()->set(['closed' => 1])->execute()){
            $this->Flash->success(__('The given thread has been closed.'));
            return $this->redirect('/');
        }
    }

    public function post($id = null)
    {
        $post = $this->Posts->newEntity();

        $post->setDirty('modified', true);

        $query = $this->Threads->query()
                ->where(['id' => $id]);

        $slug = $query->first()->slug;

        if($query->first()->closed):
        	$this->Flash->error(__('You are not authorized to access that location.'));
        	
        	return $this->redirect(['action' => '../']);
        endif;

        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            $post['author_id'] = $this->request->getSession()->read('Auth.User.id');
            $post['thread_id'] = $id;
            if ($this->Posts->save($post)) {
            	$query->update()->set(['last_post_date' => date("Y-m-d H:i:s"), 'last_post_uid' => $this->request->getSession()->read('Auth.User.id')])->execute();
                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(['action' => '../thread/'.$id . $slug.'']);
            }
            $this->Flash->error(__('Unable to add your post.'));
        }
        $this->set('post', $post);
    }
}