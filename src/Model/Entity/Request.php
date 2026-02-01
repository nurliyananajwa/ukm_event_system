<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Request Entity
 *
 * @property int $id
 * @property int $event_id
 * @property string $requested_by
 * @property string|null $position
 * @property string|null $phone_number
 * @property \Cake\I18n\DateTime|null $submitted_at
 *
 * @property \App\Model\Entity\Event $event
 */
class Request extends Entity
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
        'requested_by' => true,
        'position' => true,
        'phone_number' => true,
        'submitted_at' => true,
        'event' => true,
    ];
}
