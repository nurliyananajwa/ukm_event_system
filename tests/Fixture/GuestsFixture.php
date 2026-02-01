<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GuestsFixture
 */
class GuestsFixture extends TestFixture
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
                'event_id' => 1,
                'guest_name' => 'Lorem ipsum dolor sit amet',
                'designation' => 'Lorem ipsum dolor sit amet',
                'organization' => 'Lorem ipsum dolor sit amet',
                'guest_type_id' => 1,
            ],
        ];
        parent::init();
    }
}
