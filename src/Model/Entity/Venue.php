<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Venue Entity
 *
 * @property int $id
 * @property string $venue_name
 * @property string|null $address
 * @property string|null $type
 * @property int|null $capacity
 *
 * @property \App\Model\Entity\Event[] $events
 */
class Venue extends Entity
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
        'venue_name' => true,
        'address' => true,
        'type' => true,
        'capacity' => true,
        'events' => true,
    ];
}
