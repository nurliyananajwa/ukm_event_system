<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class ApprovalsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('admin');
    }

    public function index()
    {
        $q      = trim((string)$this->request->getQuery('q', ''));
        $status = (string)$this->request->getQuery('status', 'Pending'); 

        $Events = $this->fetchTable('Events');

        $query = $Events->find()
            ->contain([
                'Venues',
                'Organizers',
                'Approval',
            ])
            ->orderDesc('Events.id');

        if ($status !== '' && $status !== 'All') {
            if ($status === 'Pending') {
                $query->where([
                    'OR' => [
                        'Approval.approval_status' => 'Pending',
                        'Approval.id IS' => null,
                    ]
                ]);
            } else {
                $query->where(['Approval.approval_status' => $status]);
            }
        }

        if ($q !== '') {
            $query->where([
                'OR' => [
                    'Events.event_name LIKE'   => "%{$q}%",
                    'Organizers.name LIKE'     => "%{$q}%",
                    'Venues.venue_name LIKE'   => "%{$q}%",
                ]
            ]);
        }

        $events = $this->paginate($query, ['limit' => 10]);

        $this->set(compact('events', 'q', 'status'));
    }

    public function view($id = null)
    {
        $Events = $this->fetchTable('Events');
        $Approvals = $this->fetchTable('Approvals');

        $event = $Events->get((int)$id, [
            'contain' => [
                'Venues',
                'Organizers',
                'Request',
                'Guests' => ['GuestTypes'],
                'Documents' => ['DocumentTypes'],
                'Approval' => ['Reviewers'],
            ]
        ]);

        if (!$event->approval) {
            $a = $Approvals->newEmptyEntity();
            $a = $Approvals->patchEntity($a, ['event_id' => (int)$event->id, 'approval_status' => 'Pending']);
            $Approvals->save($a);

            $event = $Events->get((int)$id, [
                'contain' => [
                    'Venues','Organizers','Request',
                    'Guests' => ['GuestTypes'],
                    'Documents' => ['DocumentTypes'],
                    'Approval' => ['Reviewers'],
                ]
            ]);
        }

        $this->set(compact('event'));
    }

    public function decide($id = null)
    {
        $this->request->allowMethod(['post']);

        $identity = $this->request->getAttribute('identity');
        $reviewerId = (int)($identity?->id ?? 0);

        $Events = $this->fetchTable('Events');
        $Approvals = $this->fetchTable('Approvals');

        $event = $Events->get((int)$id, [
            'contain' => ['Approval']
        ]);

        $approval = $event->approval;
        if (!$approval) {
            $approval = $Approvals->newEmptyEntity();
            $approval = $Approvals->patchEntity($approval, ['event_id' => (int)$event->id]);
        }

        $data = $this->request->getData();
        $newStatus = (string)($data['approval_status'] ?? 'Pending');
        $comments  = trim((string)($data['comments'] ?? ''));

        $approval = $Approvals->patchEntity($approval, [
            'approval_status' => in_array($newStatus, ['Pending','Approved','Rejected'], true) ? $newStatus : 'Pending',
            'comments'        => $comments !== '' ? $comments : null,
            'reviewed_by'     => $reviewerId > 0 ? $reviewerId : null,
            'approved_at'     => in_array($newStatus, ['Approved','Rejected'], true) ? date('Y-m-d H:i:s') : null,
        ]);

        if ($Approvals->save($approval)) {
            $this->Flash->success('Decision saved.');
        } else {
            $this->Flash->error('Failed to save decision. Please try again.');
        }

        return $this->redirect(['action' => 'view', $event->id]);
    }
}
