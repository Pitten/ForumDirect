<?php
namespace App\View\Cell;
use Cake\View\Cell;
use Cake\ORM\TableRegistry;
/**
 * Forum cell
*/
class ForumCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];
    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {

    }

    public function get_latest_thread($sid){
        $threads = TableRegistry::get('threads');
        $posts = TableRegistry::get('posts');

        $query = $threads->find()
            ->select(['id', 'title', 'slug', 'last_post_uid', 'last_post_date'])
            ->where(['sub_forum_id' => $sid])
            ->order(['last_post_date' => 'DESC'])
            ->limit(1);

        $this->set(compact('query'));

        if(!$query->isEmpty()){
            $posts_query = $posts->query()
            ->where(['thread_id' => $query->first()->id])->toArray();
            $this->set(compact('posts_query'));
        }
    }

    public function getRole($id){
        $role_id;

        $users_roles = TableRegistry::get('users_roles');
        $query = $users_roles->find('all');
        $query
            ->where(['user_id'  => $id]);
        foreach($query as $row){
            $role_id = $row->role_id;
        }

        $roles = TableRegistry::get('roles');
        $query = $roles->find('all');
        $query
            ->where(['id'  => $role_id]);

        $this->set(compact('query'));
    }

    public function getUsername($id){
        $users = TableRegistry::get('users');
        $query = $users->find('all');
        $query
            ->where(['id'  => $id]);

        $this->set(compact('query'));
    }

    public function getUserTitle($id){
        $users = TableRegistry::get('users');
        $query = $users->find('all');
        $query
            ->where(['id'  => $id]);

        $this->set(compact('query'));
    }
    
    public function getAvatar($id){
        $users = TableRegistry::get('users');
        $query = $users->find('all');
        $query
        ->where(['id'  => $id]);

        $this->set(compact('query')); 
    }

     public function checkDuplicateSlugs($slug, $tid){
        $threads = TableRegistry::get('threads');
        $query = $threads->find('all');
        $query
        ->where(['slug'  => $slug]);

        $this->set('tid', $tid);

        $this->set(compact('query')); 
    }
}