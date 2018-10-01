<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ThreadsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notBlank('title', 'A title is required')
            ->notBlank('body', 'A message is required')
            ->notBlank('subforum', 'A subforum is required');
    }
}