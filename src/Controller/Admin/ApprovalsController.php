<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\View\View;
use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Http\Exception\NotFoundException;


class ApprovalsController extends AppController
{
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');

        $q      = trim((string)$this->request->getQuery('q', ''));
        $status = (string)$this->request->getQuery('status', 'Pending');

        $Events = $this->fetchTable('Events');

        $query = $Events->find()
            ->contain(['Venues', 'Organizers', 'Approvals'])
            ->orderDesc('Events.id');

        $st = strtolower($status);

        if ($st === 'pending') {
            $query = $query
                ->leftJoinWith('Approvals')
                ->where([
                    'OR' => [
                        'Approvals.approval_status' => 'Pending',
                        'Approvals.id IS' => null,
                    ],
                ])
                ->distinct(['Events.id']);
        } elseif ($st === 'approved') {
            $query = $query
                ->matching('Approvals', fn($aq) => $aq->where(['Approvals.approval_status' => 'Approved']))
                ->distinct(['Events.id']);
        } elseif ($st === 'rejected') {
            $query = $query
                ->matching('Approvals', fn($aq) => $aq->where(['Approvals.approval_status' => 'Rejected']))
                ->distinct(['Events.id']);
        } else {
        }

        if ($q !== '') {
            $query = $query
                ->leftJoinWith('Organizers')
                ->leftJoinWith('Venues')
                ->where([
                    'OR' => [
                        'Events.event_name LIKE' => "%{$q}%",
                        'Organizers.name LIKE'   => "%{$q}%",
                        'Venues.venue_name LIKE' => "%{$q}%",
                    ],
                ])
                ->distinct(['Events.id']);
        }

        $events = $this->paginate($query, ['limit' => 10]);
        $this->set(compact('events', 'q', 'status'));
    }

    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');

        $Events = $this->fetchTable('Events');

        $event = $Events->get((int)$id, [
            'contain' => [
                'Venues',
                'Organizers',
                'Requests',
                'Guests'    => ['GuestTypes'],
                'Documents' => ['DocumentTypes'],
                'Approvals' => ['Reviewers'],
            ],
        ]);

        $approval = $event->approval ?? null;

        $this->set(compact('event', 'approval'));
    }

    public function decide($id = null)
        {
            $this->request->allowMethod(['post']);
            $this->viewBuilder()->setLayout('admin');

            $eventId = (int)$id;

            $Approvals = $this->fetchTable('Approvals');
            $Events    = $this->fetchTable('Events');

            $Events->get($eventId); 

            $identity = $this->request->getAttribute('identity');
            $adminId  = (int)($identity?->id ?? 0);

            $data      = $this->request->getData();
            $newStatus = (string)($data['approval_status'] ?? 'Pending');
            $comments  = trim((string)($data['comments'] ?? ''));

            if (!in_array($newStatus, ['Approved', 'Rejected', 'Pending'], true)) {
                $this->Flash->error('Invalid status.');
                return $this->redirect(['action' => 'view', $eventId]);
            }

            $approval = $Approvals->find()->where(['event_id' => $eventId])->first();
            if (!$approval) {
                $approval = $Approvals->newEmptyEntity();
                $approval->event_id = $eventId;
            }

            $approval->approval_status = $newStatus;
            $approval->comments        = ($comments !== '') ? $comments : null;
            $approval->reviewed_by     = $adminId ?: null;

            $approval->approved_at = in_array($newStatus, ['Approved', 'Rejected'], true)
                ? date('Y-m-d H:i:s')
                : null;

            if ($Approvals->save($approval)) {
                $this->Flash->success('Decision saved.');
            } else {
                $this->Flash->error('Failed to save decision.');
            }

            return $this->redirect(['action' => 'view', $eventId]);
        }

        public function exportPdf($id = null)
    {
        $this->request->allowMethod(['get']);

        $eventId = (int)$id;
        if ($eventId <= 0) {
            throw new NotFoundException('Invalid event');
        }

        $Events = $this->fetchTable('Events');

        // IMPORTANT: guna contain sama macam view supaya status/comments up-to-date
        $event = $Events->find()
            ->where(['Events.id' => $eventId])
            ->contain([
                'Venues',
                'Organizers',
                'Requests',
                'Guests'    => ['GuestTypes'],
                'Documents' => ['DocumentTypes'],
                'Approvals' => ['Reviewers'],
            ])
            ->first();

        if (!$event) {
            throw new NotFoundException('Event not found');
        }

        // Render HTML guna template PDF khas untuk admin
        $view = new View($this->request, $this->response);
        $view->setLayout('pdf'); // pastikan kau ada templates/layout/pdf.php
        $view->setTemplatePath('Admin/Approvals');
        $view->setTemplate('pdf');
        $view->set('event', $event);

        $html = $view->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'event_' . $eventId . '_admin_copy.pdf';

        return $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->withStringBody($dompdf->output());
    }

}
