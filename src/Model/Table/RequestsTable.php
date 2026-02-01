<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Requests Model
 *
 * @property \App\Model\Table\EventsTable&\Cake\ORM\Association\BelongsTo $Events
 *
 * @method \App\Model\Entity\Request newEmptyEntity()
 * @method \App\Model\Entity\Request newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Request> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Request get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Request findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Request patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Request> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Request|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Request saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Request>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Request>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Request>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Request> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Request>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Request>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Request>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Request> deleteManyOrFail(iterable $entities, array $options = [])
 */
class RequestsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('requests');
        $this->setDisplayField('requested_by');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('event_id')
            ->notEmptyString('event_id');

        $validator
            ->scalar('requested_by')
            ->maxLength('requested_by', 100)
            ->requirePresence('requested_by', 'create')
            ->notEmptyString('requested_by');

        $validator
            ->scalar('position')
            ->maxLength('position', 100)
            ->allowEmptyString('position');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 20)
            ->allowEmptyString('phone_number');

        $validator
            ->dateTime('submitted_at')
            ->allowEmptyDateTime('submitted_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['event_id'], 'Events'), ['errorField' => 'event_id']);

        return $rules;
    }
}
