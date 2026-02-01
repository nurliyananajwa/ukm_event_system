<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class EventsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('events');
        $this->setPrimaryKey('id');

        // Organizer user
        $this->belongsTo('Organizers', [
            'className'    => 'Users',
            'foreignKey'   => 'organizer_id',
            'joinType'     => 'INNER',
            'propertyName' => 'organizer',
        ]);

        $this->belongsTo('Venues', [
            'foreignKey' => 'venue_id',
            'joinType'   => 'LEFT',
        ]);

        // approvals table: 1 row per event (unique event_id)
        $this->hasOne('Approvals', [
            'foreignKey'   => 'event_id',
            'dependent'    => true,
            'propertyName' => 'approval',
        ]);

        $this->hasOne('Requests', [
            'foreignKey' => 'event_id',
            'dependent'  => true,
        ]);

        $this->hasMany('Guests', [
            'foreignKey' => 'event_id',
            'dependent'  => true,
        ]);

        $this->hasMany('Documents', [
            'foreignKey' => 'event_id',
            'dependent'  => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('event_name')
            ->maxLength('event_name', 150)
            ->requirePresence('event_name', 'create')
            ->notEmptyString('event_name');

        $validator
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->time('time_start')
            ->requirePresence('time_start', 'create')
            ->notEmptyTime('time_start');

        $validator
            ->time('time_end')
            ->requirePresence('time_end', 'create')
            ->notEmptyTime('time_end');

        $validator->allowEmptyString('objectives');
        $validator->allowEmptyString('scope');
        $validator->allowEmptyString('content_type');

        $validator
            ->integer('venue_id')
            ->allowEmptyString('venue_id');

        return $validator;
    }
}
