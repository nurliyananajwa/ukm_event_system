<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Guests Model
 *
 * @property \App\Model\Table\EventsTable&\Cake\ORM\Association\BelongsTo $Events
 * @property \App\Model\Table\GuestTypesTable&\Cake\ORM\Association\BelongsTo $GuestTypes
 *
 * @method \App\Model\Entity\Guest newEmptyEntity()
 * @method \App\Model\Entity\Guest newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Guest> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Guest get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Guest findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Guest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Guest> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Guest|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Guest saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Guest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Guest>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Guest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Guest> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Guest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Guest>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Guest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Guest> deleteManyOrFail(iterable $entities, array $options = [])
 */
class GuestsTable extends Table
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

        $this->setTable('guests');
        $this->setDisplayField('guest_name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('GuestTypes', [
            'foreignKey' => 'guest_type_id',
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
            ->scalar('guest_name')
            ->maxLength('guest_name', 100)
            ->requirePresence('guest_name', 'create')
            ->notEmptyString('guest_name');

        $validator
            ->scalar('designation')
            ->maxLength('designation', 100)
            ->allowEmptyString('designation');

        $validator
            ->scalar('organization')
            ->maxLength('organization', 150)
            ->allowEmptyString('organization');

        $validator
            ->integer('guest_type_id')
            ->allowEmptyString('guest_type_id');

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
        $rules->add($rules->existsIn(['guest_type_id'], 'GuestTypes'), ['errorField' => 'guest_type_id']);

        return $rules;
    }
}
