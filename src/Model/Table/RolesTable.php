<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class RolesTable extends Table
{

	public function initialize(array $config)
    {
    	parent::initialize($config);
    	
    	 $this->setTable('roles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Users', [
            'foreignKey' => 'role_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'users_roles'
        ]);
    }
}