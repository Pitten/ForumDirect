<?php
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class SubForumsController extends AppController
{
  public function beforeFilter(Event $event)
  {
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow('view');
  }

    public function view($id)
    {
      $this->set('user_id', $this->Auth->user('id'));

      $subforums = TableRegistry::get('sub_forums');
      $threads = TableRegistry::get('threads');
      $exists = $subforums->exists(['id' => $id]);

      if(!$exists){
        $this->Flash->error(__("Sub Forum doesn't exist."));
        return $this->redirect(['action' => '../']);
      }

      $query = $subforums->find('all');
      $subforum = $subforums->get($id,[
      'contain' => ['threads']
      ]);

      $recent_activity = $threads->find('all');
      $recent_activity
        ->order(['last_post_date'  => 'DESC'])
        ->limit(5);
      
      $this->set('recent_activity', $recent_activity);
      $this->set('query', $subforum);
      $this->set('username', $this->Auth->user('username'));
    }
}