<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController as BaseAppController;
use Cake\Event\EventInterface;
use Cake\Http\Exception\ForbiddenException;

class AppController extends BaseAppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

    }
}
