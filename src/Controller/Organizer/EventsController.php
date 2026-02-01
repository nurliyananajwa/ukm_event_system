<?php
declare(strict_types=1);

namespace App\Controller\Organizer;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\View\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class EventsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('organizer');
    }

    private function organizerId(): int
    {
        $identity = $this->request->getAttribute('identity');
        return (int)($identity?->get('id') ?? 0);
    }

    public function index()
    {
        $organizerId = $this->organizerId();
        $q = trim((string)$this->request->getQuery('q', ''));

        $Events = $this->fetchTable('Events');

        $query = $Events->find()
            ->where(['Events.organizer_id' => $organizerId])
            ->contain([
                'Venues',
                'Approvals',
            ])
            ->orderDesc('Events.id');

        if ($q !== '') {
            $query->where(['Events.event_name LIKE' => "%{$q}%"]);
        }

        $events = $query->all();

        $this->set(compact('events', 'q'));
    }

    public function add()
{
    $organizerId = $this->organizerId();

    $Events     = $this->fetchTable('Events');
    $Venues     = $this->fetchTable('Venues');
    $Requests   = $this->fetchTable('Requests');
    $Guests     = $this->fetchTable('Guests');
    $GuestTypes = $this->fetchTable('GuestTypes');
    $Documents  = $this->fetchTable('Documents');
    $DocTypes   = $this->fetchTable('DocumentTypes');   
    $Approvals  = $this->fetchTable('Approvals');

    $event = $Events->newEmptyEntity();

    $venues = $Venues->find('list', ['keyField' => 'id', 'valueField' => 'venue_name'])->toArray();
    $guestTypes = $GuestTypes->find('list', ['keyField' => 'id', 'valueField' => 'type_name'])->toArray();
    $documentTypes = $DocTypes->find('list', ['keyField' => 'id', 'valueField' => 'type_name'])->toArray();

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        $event = $Events->patchEntity($event, $data, ['associated' => []]);
        $event->organizer_id = $organizerId;

        if (($data['venue_id'] ?? '') === '') {
            $event->venue_id = null;
        }

        $conn = $Events->getConnection();

        $ok = $conn->transactional(function () use (
            $Events, $Requests, $Guests, $Documents, $Approvals,
            $event, $data
        ) {
            // 1) Save Event
            if (!$Events->save($event)) {
                return false;
            }
            $eventId = (int)$event->id;
            $req = $data['request'] ?? null;
            if (is_array($req)) {
                $requestedBy = trim((string)($req['requested_by'] ?? ''));

                if ($requestedBy !== '') {
                    $Requests->deleteAll(['event_id' => $eventId]);

                    $rEntity = $Requests->newEmptyEntity();
                    $rEntity = $Requests->patchEntity($rEntity, [
                        'event_id'     => $eventId,
                        'requested_by' => $requestedBy,
                        'position'     => trim((string)($req['position'] ?? '')) ?: null,
                        'phone_number' => trim((string)($req['phone_number'] ?? '')) ?: null,
                    ]);

                    if (!$Requests->save($rEntity)) {
                        return false;
                    }
                }
            }

            $postedGuests = $data['guests'] ?? [];
            if (!is_array($postedGuests)) $postedGuests = [];

            foreach ($postedGuests as $row) {
                if (!is_array($row)) continue;

                $typeId = (int)($row['guest_type_id'] ?? 0);
                $name = trim((string)($row['guest_name'] ?? ''));
                $designation = trim((string)($row['designation'] ?? ''));
                $org = trim((string)($row['organization'] ?? ''));

                if ($typeId <= 0 && $name === '' && $designation === '' && $org === '') {
                    continue;
                }

                if ($typeId <= 0 || $name === '') {
                    return false;
                }

                $gEntity = $Guests->newEmptyEntity();
                $gEntity = $Guests->patchEntity($gEntity, [
                    'event_id'      => $eventId,
                    'guest_type_id' => $typeId,
                    'guest_name'    => $name,
                    'designation'   => $designation !== '' ? $designation : null,
                    'organization'  => $org !== '' ? $org : null,
                ]);

                if (!$Guests->save($gEntity)) {
                    return false;
                }
            }

            $postedDocs = $data['documents'] ?? [];
            if (!is_array($postedDocs)) $postedDocs = [];

            foreach ($postedDocs as $row) {
                if (!is_array($row)) continue;

                $docTypeId = (int)($row['doc_type_id'] ?? 0);
                $companyInfo = trim((string)($row['company_info'] ?? ''));
                $uploaded = $row['file'] ?? null;

                $filePath = null;

                if ($uploaded && method_exists($uploaded, 'getError') && $uploaded->getError() === UPLOAD_ERR_OK) {
                    $ext = pathinfo($uploaded->getClientFilename(), PATHINFO_EXTENSION);
                    $safeExt = $ext ? '.' . strtolower($ext) : '';

                    $dir = WWW_ROOT . 'uploads' . DS . 'documents' . DS;
                    if (!is_dir($dir)) mkdir($dir, 0775, true);

                    $filename = 'event_' . $eventId . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . $safeExt;
                    $target = $dir . $filename;

                    $uploaded->moveTo($target);
                    $filePath = 'uploads/documents/' . $filename;
                }

                if ($docTypeId <= 0 && $companyInfo === '' && $filePath === null) {
                    continue;
                }

                if ($docTypeId <= 0) {
                    return false;
                }

                $dEntity = $Documents->newEmptyEntity();
                $dEntity = $Documents->patchEntity($dEntity, [
                    'event_id'     => $eventId,
                    'doc_type_id'  => $docTypeId,
                    'company_info' => $companyInfo !== '' ? $companyInfo : null,
                    'file_path'    => $filePath,
                ]);

                if (!$Documents->save($dEntity)) {
                    return false;
                }
            }

            $approval = $Approvals->find()->where(['event_id' => $eventId])->first();
            if (!$approval) {
                $a = $Approvals->newEmptyEntity();
                $a = $Approvals->patchEntity($a, ['event_id' => $eventId]);
                if (!$Approvals->save($a)) {
                    return false;
                }
            }

            return true;
        });

        if ($ok) {
            $this->Flash->success('Event submitted successfully.');
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('Failed to submit event. If you filled Guests/Documents, make sure type + name (guest) and doc type (document) are selected.');
    }

    $this->set(compact('event', 'venues', 'guestTypes', 'documentTypes'));
}

    public function view($id = null)
    {
        $id = (int)$id;
        if ($id <= 0) throw new NotFoundException('Invalid event');

        $organizerId = $this->organizerId();
        $Events = $this->fetchTable('Events');

        $event = $Events->find()
            ->where(['Events.id' => $id, 'Events.organizer_id' => $organizerId])
            ->contain([
                'Venues',
                'Approvals',
                'Requests',
                'Guests' => ['GuestTypes'],
                'Documents' => ['DocumentTypes'],
            ])
            ->first();

        if (!$event) throw new NotFoundException('Event not found');

        $this->set(compact('event'));
    }

    public function edit($id = null)
    {
        $id = (int)$id;
        if ($id <= 0) throw new NotFoundException('Invalid event');

        $organizerId = $this->organizerId();

        $Events        = $this->fetchTable('Events');
        $Venues        = $this->fetchTable('Venues');
        $Requests      = $this->fetchTable('Requests');
        $Guests        = $this->fetchTable('Guests');
        $GuestTypes    = $this->fetchTable('GuestTypes');
        $Documents     = $this->fetchTable('Documents');
        $DocumentTypes = $this->fetchTable('DocumentTypes');

        $event = $Events->find()
            ->where(['Events.id' => $id, 'Events.organizer_id' => $organizerId])
            ->first();

        if (!$event) throw new NotFoundException('Event not found');

        $venues = $Venues->find('list', ['keyField'=>'id', 'valueField'=>'venue_name'])->toArray();
        $guestTypes = $GuestTypes->find('list', ['keyField'=>'id', 'valueField'=>'type_name'])->toArray();
        $documentTypes = $DocumentTypes->find('list', ['keyField'=>'id', 'valueField'=>'type_name'])->toArray();

        $request = $Requests->find()->where(['event_id' => $id])->first();

        $guestRows = $Guests->find()
            ->select(['id','guest_type_id','guest_name','designation','organization'])
            ->where(['event_id' => $id])
            ->orderAsc('id')
            ->enableHydration(false)
            ->toArray();

        $docRows = $Documents->find()
            ->select(['id','doc_type_id','company_info','file_path'])
            ->where(['event_id' => $id])
            ->orderAsc('id')
            ->enableHydration(false)
            ->toArray();

        if ($this->request->is(['post','put','patch'])) {
            $data = $this->request->getData();

            $event = $Events->patchEntity($event, $data);

            if (($data['venue_id'] ?? '') === '') {
                $event->venue_id = null;
            }

            $conn = $Events->getConnection();

            $ok = $conn->transactional(function () use (
                $Events, $Requests, $Guests, $Documents,
                $event, $data, $id, $request
            ) {
                if (!$Events->save($event)) return false;

                $reqData = $data['request'] ?? null;
                if (is_array($reqData)) {
                    $requestedBy = trim((string)($reqData['requested_by'] ?? ''));
                    if ($requestedBy !== '') {
                        $reqEntity = $request ?: $Requests->newEmptyEntity();
                        $reqEntity = $Requests->patchEntity($reqEntity, [
                            'event_id'     => $id,
                            'requested_by' => $requestedBy,
                            'position'     => trim((string)($reqData['position'] ?? '')) ?: null,
                            'phone_number' => trim((string)($reqData['phone_number'] ?? '')) ?: null,
                        ]);
                        if (!$Requests->save($reqEntity)) return false;
                    }
                }

                $postedGuests = $data['guests'] ?? [];
                if (!is_array($postedGuests)) $postedGuests = [];

                $existingGuests = $Guests->find()
                    ->where(['event_id' => $id])
                    ->all()
                    ->indexBy('id')
                    ->toArray();

                $keepGuestIds = [];

                foreach ($postedGuests as $row) {
                    if (!is_array($row)) continue;

                    $gid = (int)($row['id'] ?? 0);
                    $typeId = (int)($row['guest_type_id'] ?? 0);
                    $name = trim((string)($row['guest_name'] ?? ''));
                    $designation = trim((string)($row['designation'] ?? ''));
                    $org = trim((string)($row['organization'] ?? ''));

                    if ($typeId <= 0 && $name === '' && $designation === '' && $org === '') {
                        continue;
                    }

                    if ($typeId <= 0 || $name === '') {
                        return false;
                    }

                    $gEntity = ($gid > 0 && isset($existingGuests[$gid]))
                        ? $existingGuests[$gid]
                        : $Guests->newEmptyEntity();

                    $gEntity = $Guests->patchEntity($gEntity, [
                        'event_id'      => $id,
                        'guest_type_id' => $typeId,
                        'guest_name'    => $name,
                        'designation'   => $designation !== '' ? $designation : null,
                        'organization'  => $org !== '' ? $org : null,
                    ]);

                    if (!$Guests->save($gEntity)) return false;

                    $keepGuestIds[] = (int)$gEntity->id;
                }

                $existingIds = array_map('intval', array_keys($existingGuests));
                $toDelete = array_diff($existingIds, $keepGuestIds);
                if (!empty($toDelete)) {
                    $Guests->deleteAll(['event_id' => $id, 'id IN' => $toDelete]);
                }

                // ===== Documents update-in-place (keep old file) =====
                $postedDocs = $data['documents'] ?? [];
                if (!is_array($postedDocs)) $postedDocs = [];

                $existingDocs = $Documents->find()
                    ->where(['event_id' => $id])
                    ->all()
                    ->indexBy('id')
                    ->toArray();

                $keepDocIds = [];

                foreach ($postedDocs as $row) {
                    if (!is_array($row)) continue;

                    $did = (int)($row['id'] ?? 0);
                    $docTypeId = (int)($row['doc_type_id'] ?? 0);
                    $companyInfo = trim((string)($row['company_info'] ?? ''));
                    $existingPath = (string)($row['existing_file_path'] ?? '');

                    $uploaded = $row['file'] ?? null;
                    $newPath = null;

                    if ($uploaded && method_exists($uploaded, 'getError') && $uploaded->getError() === UPLOAD_ERR_OK) {
                        $ext = pathinfo($uploaded->getClientFilename(), PATHINFO_EXTENSION);
                        $safeExt = $ext ? '.' . strtolower($ext) : '';

                        $dir = WWW_ROOT . 'uploads' . DS . 'documents' . DS;
                        if (!is_dir($dir)) mkdir($dir, 0775, true);

                        $filename = 'event_' . $id . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . $safeExt;
                        $target = $dir . $filename;

                        $uploaded->moveTo($target);
                        $newPath = 'uploads/documents/' . $filename;
                    }

                    $finalPath = $newPath ?: ($existingPath !== '' ? $existingPath : null);

                    if ($docTypeId <= 0 && $companyInfo === '' && $finalPath === null) {
                        continue;
                    }

                    if ($docTypeId <= 0) {
                        return false;
                    }

                    $dEntity = ($did > 0 && isset($existingDocs[$did]))
                        ? $existingDocs[$did]
                        : $Documents->newEmptyEntity();

                    $dEntity = $Documents->patchEntity($dEntity, [
                        'event_id'     => $id,
                        'doc_type_id'  => $docTypeId,
                        'company_info' => $companyInfo !== '' ? $companyInfo : null,
                        'file_path'    => $finalPath,
                    ]);

                    if (!$Documents->save($dEntity)) return false;

                    $keepDocIds[] = (int)$dEntity->id;
                }

                $existingDocIds = array_map('intval', array_keys($existingDocs));
                $toDeleteDocs = array_diff($existingDocIds, $keepDocIds);
                if (!empty($toDeleteDocs)) {
                    $Documents->deleteAll(['event_id' => $id, 'id IN' => $toDeleteDocs]);
                }

                return true;
            });

            if ($ok) {
                $this->Flash->success('Event updated successfully.');
                return $this->redirect(['action' => 'view', $id]);
            }

            $this->Flash->error('Failed to update event. Check Guests/Documents required fields.');
        }

        $this->set(compact(
            'event','venues','guestTypes','documentTypes',
            'guestRows','docRows','request'
        ));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post','delete']);

        $id = (int)$id;
        $organizerId = $this->organizerId();

        $Events = $this->fetchTable('Events');

        $event = $Events->find()
            ->where(['Events.id' => $id, 'Events.organizer_id' => $organizerId])
            ->first();

        if (!$event) throw new NotFoundException('Event not found');

        if ($Events->delete($event)) {
            $this->Flash->success('Event deleted.');
        } else {
            $this->Flash->error('Failed to delete event.');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function exportPdf($id = null)
    {
        $id = (int)$id;
        if ($id <= 0) throw new NotFoundException('Invalid event');

        $organizerId = $this->organizerId();
        $Events = $this->fetchTable('Events');

        $event = $Events->find()
            ->where(['Events.id' => $id, 'Events.organizer_id' => $organizerId])
            ->contain([
                'Venues',
                'Approvals',
                'Requests',
                'Guests' => ['GuestTypes'],
                'Documents' => ['DocumentTypes'],
            ])
            ->first();

        if (!$event) throw new NotFoundException('Event not found');

        $view = new View($this->request, $this->response);
        $view->setLayout('pdf'); 
        $view->setTemplatePath('Organizer/Events');
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

        $fileName = 'event_' . $id . '.pdf';

        return $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->withStringBody($dompdf->output());
    }
}
