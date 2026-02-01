<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentTypes Model
 *
 * @method \App\Model\Entity\DocumentType newEmptyEntity()
 * @method \App\Model\Entity\DocumentType newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DocumentType> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentType get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DocumentType findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DocumentType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DocumentType> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentType|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DocumentType saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentType>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentType> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentType>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentType> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DocumentTypesTable extends Table
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

        $this->setTable('document_types');
        $this->setDisplayField('type_name');
        $this->setPrimaryKey('id');
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
