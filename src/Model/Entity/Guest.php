<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Guest Entity
 *
 * @property int $id
 * @property int $event_id
 * @property string $guest_name
 * @property string|null $designation
 * @property string|null $organization
 * @property int|null $guest_type_id
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\GuestType $guest_type
 */
class Guest extends Entity
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
        'guest_name' => true,
        'designation' => true,
        'organization' => true,
        'guest_type_id' => true,
        'event' => true,
        'guest_type' => true,
    ];
}
