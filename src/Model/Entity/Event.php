<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity
 *
 * @property int $id
 * @property int $organizer_id
 * @property string $event_name
 * @property \Cake\I18n\Date $date
 * @property \Cake\I18n\Time $time_start
 * @property \Cake\I18n\Time $time_end
 * @property int|null $venue_id
 * @property string|null $objectives
 * @property string|null $content_type
 * @property string|null $scope
 * @property int|null $status_id
 *
 * @property \App\Model\Entity\User $organizer
 * @property \App\Model\Entity\Venue $venue
 * @property \App\Model\Entity\Approval[] $approvals
 * @property \App\Model\Entity\Document[] $documents
 * @property \App\Model\Entity\Guest[] $guests
 * @property \App\Model\Entity\Request[] $requests
 */
class Event extends Entity
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
        'organizer_id' => true,
        'event_name' => true,
        'date' => true,
        'start_date' => true, 
        'end_date' => true,   
        'time_start' => true,
        'time_end' => true,
        'venue_id' => true,
        'objectives' => true,
        'content_type' => true,
        'scope' => true,
        'status_id' => true,
        'organizer' => true,
        'venue' => true,
        'approvals' => true,
        'documents' => true,
        'guests' => true,
        'requests' => true,
    ];
}
