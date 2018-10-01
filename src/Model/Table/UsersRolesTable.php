<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersRolesTable extends Table
{

	public function initialize(array $config)
    {
    	parent::initialize($config);
    	
    	$this->setTable('users_roles');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey(['user_id', 'role_id']);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
    }
}