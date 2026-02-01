<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class VenuesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('venues');
        $this->setPrimaryKey('id');
        
        $this->hasMany('Events', [
            'foreignKey' => 'venue_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('venue_name')
            ->maxLength('venue_name', 150)
            ->requirePresence('venue_name', 'create')
            ->notEmptyString('venue_name');

        $validator
            ->allowEmptyString('address')
            ->allowEmptyString('type');

        $validator
            ->integer('capacity')
            ->allowEmptyString('capacity');

        return $validator;
    }
}
