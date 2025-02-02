<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'display',
                'home'
            ],
            'authorize' => ['ForumDirect'],
            'unauthorizedRedirect' => '/users/login',
        ]);

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        $this->loadComponent('Flash');

        $this->loadComponent('Security');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'display']);

        $forums = TableRegistry::get('forums');
        $chats_table = TableRegistry::get('chats');
        $groups = TableRegistry::get('roles');

        $query = $forums->find('all');
        $query
            ->contain(['sub_forums']);
        $this->set('query', $query);

        $this->loadModel('Threads');
        $recent_activity = $this->Threads->find('all');
        $recent_activity
            ->order(['last_post_date'  => 'DESC'])
            ->limit(10);
        $this->set('recent_activity', $recent_activity);

        $chats = $chats_table->find('all');
        $this->set('chats', $chats);

        $roles = $groups->find('all');
        $this->set('roles_home', $roles);

        $user = $this->request->getSession()->read('Auth.User');
        $this->set('user', $user);
        $this->set('username', $user['username']);
    }
}
