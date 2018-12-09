<?php

namespace App\Auth;

use Cake\Auth\BaseAuthorize;

use Cake\Network\Request;

use App\Model\Entity\User;

use Cake\ORM\TableRegistry;

class ForumDirectAuthorize extends BaseAuthorize

{

    public function authorize($user, Request $request)

    {

        $this->_user = $user;

        $authorized = false;

        if ($this->userHasRole('administrator')) {

            return true;

        }

        if ($this->userHasRole('banned')) {

            return false;
        }

        switch($request->getParam('controller')) {

            case 'Threads':
                
                if ($request->getParam('action') == 'view') {

                    if ($this->userHasRole('banned')) {

                        $authorized = false;
                    
                    } else {
                        $authorized = true;
                    }

                }else{
                    $authorized = true;
                }

            break;

            case 'Admin':
                
                if ($request->getParam('action') == 'index') {

                    if ($this->userHasRole('administrator')) {

                        $authorized = true;
                    
                    } else {
                        $authorized = false;
                    }

                }else{
                    $authorized = false;
                }

            break;

            case 'Mod':
                
                if ($request->getParam('action') == 'index') {

                    if ($this->userHasRole('moderator')) {

                        $authorized = true;
                    
                    } else {
                        $authorized = false;
                    }

                }else{
                    $authorized = false;
                }

            break;

            case 'Users':

                if ($request->getParam('action') == 'logout') {

                    $authorized = true;

                }else{
                    $authorized = true;
                }

                break;

            default:

                if (!empty($user)) {

                    $authorized = true;

                }

                break;

        }

        return $authorized;

    }

    /* Another solution: get role by login and then delete the session of a user if role has been changed */

    protected function userHasRole($role) {

        $role_id;

        $users_roles = TableRegistry::get('users_roles');
        $query = $users_roles->find('all');
        $query
            ->where(['user_id'  => $this->_user['id']]);
        foreach($query as $row){
            $role_id = $row->role_id;
        }

        $roles = TableRegistry::get('roles');
        $query = $roles->find('all');
        $query
            ->where(['id'  => $role_id]);
        
        foreach($query as $row){
            $name = $row->name;
        }


        if (isset($query) && $role === $name) {

            return true;

        }

        return false;

    }

}