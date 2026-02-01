<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Approval Entity
 *
 * @property int $id
 * @property int $event_id
 * @property int $admin_id
 * @property string|null $comments
 * @property string|null $approval_status
 * @property string|null $decision_letter
 * @property \Cake\I18n\DateTime|null $approved_at
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\User $admin
 */
class Approval extends Entity
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
        'admin_id' => true,
        'comments' => true,
        'approval_status' => true,
        'decision_letter' => true,
        'approved_at' => true,
        'event' => true,
        'admin' => true,
    ];
}
