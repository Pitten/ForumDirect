<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{

    public function validationDefault(Validator $validator)
    {
        return $validator

            ->add('username', [
            'length' => [
            'rule' => ['minLength', 4],
            'message' => 'Username need to be at least 4 characters long',
            ]
            ])

            ->add('username', 'unique', 
            ['rule' => 'validateUnique', 'provider' => 'table'])
            ->scalar('username')
            ->maxLength('username', 150)
            ->alphaNumeric('username')
            ->requirePresence('username', 'create')

            ->add('email', [
            'length' => [
            'rule' => ['minLength', 8],
            'message' => 'Email need to be at least 8 characters long',
            ]   
            ])

            ->requirePresence('email', 'create')

            ->add('password', [
            'length' => [
            'rule' => ['minLength', 6],
            'message' => 'Password need to be at least 6 characters long',
            ]
            ])
            ->requirePresence('password', 'create');
    }
}