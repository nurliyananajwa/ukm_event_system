<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EventsFixture
 */
class EventsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'organizer_id' => 1,
                'event_name' => 'Lorem ipsum dolor sit amet',
                'date' => '2026-01-26',
                'time_start' => '05:58:17',
                'time_end' => '05:58:17',
                'venue_id' => 1,
                'objectives' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'content_type' => 'Lorem ipsum dolor sit amet',
                'scope' => 'Lorem ipsum dolor sit amet',
                'status_id' => 1,
            ],
        ];
        parent::init();
    }
}
