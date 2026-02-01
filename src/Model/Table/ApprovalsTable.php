<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ApprovalsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('approvals');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Reviewers', [
            'className'    => 'Users',
            'foreignKey'   => 'reviewed_by',
            'joinType'     => 'LEFT',
            'propertyName' => 'reviewer', 
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('event_id')
            ->requirePresence('event_id', 'create')
            ->notEmptyString('event_id');

        $validator
            ->integer('reviewed_by')
            ->allowEmptyString('reviewed_by');

        $validator
            ->scalar('approval_status')
            ->allowEmptyString('approval_status');

        $validator
            ->allowEmptyString('comments');

        $validator
            ->dateTime('approved_at')
            ->allowEmptyDateTime('approved_at');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['event_id'], 'Events'), [
            'errorField' => 'event_id',
        ]);

        $rules->add($rules->existsIn(['reviewed_by'], 'Reviewers'), [
            'errorField' => 'reviewed_by',
            'allowNullableNulls' => true,
        ]);

        return $rules;
    }
}
