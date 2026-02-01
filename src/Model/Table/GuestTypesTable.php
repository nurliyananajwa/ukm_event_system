<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GuestTypes Model
 *
 * @property \App\Model\Table\GuestsTable&\Cake\ORM\Association\HasMany $Guests
 *
 * @method \App\Model\Entity\GuestType newEmptyEntity()
 * @method \App\Model\Entity\GuestType newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\GuestType> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GuestType get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\GuestType findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\GuestType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\GuestType> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GuestType|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\GuestType saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\GuestType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GuestType>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GuestType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GuestType> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GuestType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GuestType>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GuestType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GuestType> deleteManyOrFail(iterable $entities, array $options = [])
 */
class GuestTypesTable extends Table
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

        $this->setTable('guest_types');
        $this->setDisplayField('type_name');
        $this->setPrimaryKey('id');

        $this->hasMany('Guests', [
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
            ->scalar('type_name')
            ->maxLength('type_name', 50)
            ->requirePresence('type_name', 'create')
            ->notEmptyString('type_name');

        return $validator;
    }
}
