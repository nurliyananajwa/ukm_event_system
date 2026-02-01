<?php
declare(strict_types=1);

namespace App\Controller\Organizer;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->setLayout('organizer');

        $identity = $this->request->getAttribute('identity');
        $userId   = (int)($identity?->id ?? 0);

        $Events    = $this->fetchTable('Events');
        $Approvals = $this->fetchTable('Approvals');

        $totalEvents = (int)$Events->find()
            ->where(['Events.organizer_id' => $userId])
            ->count();

        $pendingCount  = 0;
        $approvedCount = 0;
        $rejectedCount = 0;

        if ($totalEvents > 0) {
            $pendingCount = (int)$Approvals->find()
                ->matching('Events', fn($q) => $q->where(['Events.organizer_id' => $userId]))
                ->where(['Approvals.approval_status' => 'Pending'])
                ->count();

            $approvedCount = (int)$Approvals->find()
                ->matching('Events', fn($q) => $q->where(['Events.organizer_id' => $userId]))
                ->where(['Approvals.approval_status' => 'Approved'])
                ->count();

            $rejectedCount = (int)$Approvals->find()
                ->matching('Events', fn($q) => $q->where(['Events.organizer_id' => $userId]))
                ->where(['Approvals.approval_status' => 'Rejected'])
                ->count();

            $approvalRowsTotal = (int)$Approvals->find()
                ->matching('Events', fn($q) => $q->where(['Events.organizer_id' => $userId]))
                ->count();

            $missingApproval = max(0, $totalEvents - $approvalRowsTotal);
            $pendingCount += $missingApproval;
        }

        $recentEvents = $Events->find()
            ->where(['Events.organizer_id' => $userId])
            ->contain([
                'Venues',
                'Approvals',
            ])
            ->orderDesc('Events.id')
            ->limit(5)
            ->all();

        $sum = max(1, $totalEvents);
        $pendingPct  = (int)round(($pendingCount  / $sum) * 100);
        $approvedPct = (int)round(($approvedCount / $sum) * 100);
        $rejectedPct = (int)round(($rejectedCount / $sum) * 100);

        $announcements = [
            ['title' => 'Reminder', 'desc' => 'Upload required documents in PDF format (if applicable).'],
            ['title' => 'Approval', 'desc' => 'Approval process may take 3–5 working days depending on queue.'],
            ['title' => 'Important', 'desc' => 'Incomplete submissions may be returned for correction.'],
        ];

        $this->set(compact(
            'identity',
            'totalEvents',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'recentEvents',
            'pendingPct',
            'approvedPct',
            'rejectedPct',
            'announcements'
        ));
    }
}
