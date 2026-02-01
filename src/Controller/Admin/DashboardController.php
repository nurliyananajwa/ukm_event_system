<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');

        $Events    = $this->fetchTable('Events');
        $Approvals = $this->fetchTable('Approvals');
        $Users     = $this->fetchTable('Users');
        $Venues    = $this->fetchTable('Venues');

        $totalEvents = (int)$Events->find()->count();

        $pendingCount = (int)$Approvals->find()
            ->where(['Approvals.approval_status' => 'Pending'])
            ->count();

        $approvedCount = (int)$Approvals->find()
            ->where(['Approvals.approval_status' => 'Approved'])
            ->count();

        $rejectedCount = (int)$Approvals->find()
            ->where(['Approvals.approval_status' => 'Rejected'])
            ->count();

        $approvalRowsTotal = (int)$Approvals->find()->count();
        $missingApproval   = max(0, $totalEvents - $approvalRowsTotal);
        $pendingCount     += $missingApproval;

        $totalOrganizers = (int)$Users->find()
            ->matching('Roles', function ($q) {
                return $q->where(['Roles.role_name' => 'Organizer']);
            })
            ->count();

        $Venues = $this->fetchTable('Venues');
            $totalVenues = $Venues->find()->count();

            $this->set(compact('totalVenues'));


        $latestPending = $Events->find()
            ->contain([
                'Venues' => function ($q) {
                    return $q->select(['id', 'venue_name']);
                },
                'Organizers' => function ($q) {
                    return $q->select(['id', 'name', 'email']);
                },
                'Approvals' => function ($q) {
                    return $q->select(['id', 'event_id', 'approval_status']);
                },
            ])
            ->select([
                'Events.id',
                'Events.event_name',
                'Events.start_date',
                'Events.time_start',
                'Events.time_end',
                'Events.venue_id',
                'Events.organizer_id',
            ])
            ->orderDesc('Events.id')
            ->limit(8)
            ->all();

        $den = max(1, $totalEvents);
        $pendingPct  = (int)round(($pendingCount / $den) * 100);
        $approvedPct = (int)round(($approvedCount / $den) * 100);
        $rejectedPct = (int)round(($rejectedCount / $den) * 100);

        $this->set(compact(
            'totalEvents',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalOrganizers',
            'totalVenues',
            'latestPending',
            'pendingPct',
            'approvedPct',
            'rejectedPct'
        ));
    }
}
