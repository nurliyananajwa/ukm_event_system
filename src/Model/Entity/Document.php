<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property int $id
 * @property int $event_id
 * @property int|null $doc_type_id
 * @property string|null $company_info
 * @property string|null $file_path
 * @property \Cake\I18n\DateTime|null $uploaded_at
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\DocumentType $doc_type
 */
class Document extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'event_id' => true,
        'doc_type_id' => true,
        'company_info' => true,
        'file_path' => true,
        'uploaded_at' => true,
        'event' => true,
        'doc_type' => true,
    ];
}
