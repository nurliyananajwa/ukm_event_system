<?php
/**
 * PDF template
 * @var \App\Model\Entity\Event $event
 */

$this->assign('title', 'Event Application Letter');

$approval = $event->approvals[0] ?? null;
$status = (string)($approval->approval_status ?? 'Pending');

$venueName = (string)($event->venue->venue_name ?? '-');

$req = $event->request ?? ($event->requests[0] ?? null);

$guests = $event->guests ?? [];
$docs   = $event->documents ?? [];

$today = date('d/m/Y');
$refNo = 'UKMES/EVT/' . str_pad((string)($event->id ?? '0'), 6, '0', STR_PAD_LEFT);
?>
<style>
    @page { margin: 30px 36px; }

    body{
        font-family: DejaVu Sans, Arial, sans-serif;
        font-size: 12px;
        color:#0f172a;
        line-height: 1.55;
    }

    .header{
        border-bottom: 2px solid #0f172a;
        padding-bottom: 10px;
        margin-bottom: 14px;
    }
    .brand{
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .3px;
    }
    .dept{
        font-size: 12px;
        color:#334155;
        margin-top: 2px;
    }
    .meta{
        margin-top: 10px;
        width: 100%;
    }
    .meta td{
        vertical-align: top;
        padding: 2px 0;
    }
    .meta .label{
        width: 90px;
        color:#475569;
        font-weight: 700;
    }

    .title{
        margin: 16px 0 8px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .para{ margin: 8px 0; }
    .muted{ color:#475569; }

    .box{
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 12px;
        margin-top: 10px;
        background: #fafafa;
    }

    .section{
        margin-top: 14px;
    }
    .section h3{
        margin: 0 0 6px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        color:#0f172a;
        letter-spacing: .4px;
    }

    table.grid{
        width: 100%;
        border-collapse: collapse;
        margin-top: 6px;
    }
    .grid td{
        border: 1px solid #e5e7eb;
        padding: 8px 10px;
        vertical-align: top;
    }
    .grid td.label{
        width: 170px;
        background: #f8fafc;
        font-weight: 700;
        color:#334155;
    }

    table.list{
        width:100%;
        border-collapse: collapse;
        margin-top: 8px;
    }
    .list th, .list td{
        border: 1px solid #e5e7eb;
        padding: 8px 10px;
        vertical-align: top;
    }
    .list th{
        background:#f8fafc;
        font-weight: 800;
        color:#334155;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .35px;
    }

    .signature{
        margin-top: 22px;
    }
    .sigline{
        margin-top: 34px;
        border-top: 1px solid #0f172a;
        width: 240px;
    }

    .footer{
        margin-top: 18px;
        font-size: 10px;
        color:#64748b;
        border-top: 1px solid #e5e7eb;
        padding-top: 8px;
    }
</style>

<div class="header">
    <div class="brand">UKM Event System</div>
    <div class="dept">Organizer Submission Copy</div>

    <table class="meta">
        <tr>
            <td>
                <div><span class="muted">Reference No:</span> <b><?= h($refNo) ?></b></div>
                <div><span class="muted">Date:</span> <b><?= h($today) ?></b></div>
            </td>
            <td style="text-align:right;">
                <div><span class="muted">Status:</span> <b><?= h($status) ?></b></div>
            </td>
        </tr>
    </table>
</div>

<div class="title">Event Application Submission</div>

<p class="para">
    This letter serves as a reference copy for the event application submitted through the UKM Event System.
    The application details are recorded as follows:
</p>

<div class="section">
    <h3>Event Details</h3>
    <table class="grid">
        <tr>
            <td class="label">Event Title</td>
            <td><b><?= h((string)($event->event_name ?? '-')) ?></b></td>
        </tr>
        <tr>
            <td class="label">Start Date</td>
            <td><?= h((string)($event->start_date ?? '-')) ?></td>
        </tr>
        <tr>
            <td class="label">End Date</td>
            <td><?= h((string)($event->end_date ?? '-')) ?></td>
        </tr>
        <tr>
            <td class="label">Time</td>
            <td><?= h((string)($event->time_start ?? '-')) ?> - <?= h((string)($event->time_end ?? '-')) ?></td>
        </tr>
        <tr>
            <td class="label">Venue</td>
            <td><?= h($venueName) ?></td>
        </tr>
        <tr>
            <td class="label">Program Type</td>
            <td><?= h((string)($event->content_type ?? '-')) ?></td>
        </tr>
        <tr>
            <td class="label">Scope / Target Audience</td>
            <td><?= h((string)($event->scope ?? '-')) ?></td>
        </tr>
        <tr>
            <td class="label">Objectives</td>
            <td style="white-space:pre-wrap;"><?= h((string)($event->objectives ?? '-')) ?></td>
        </tr>
    </table>
</div>

<div class="section">
    <h3>Applicant Information</h3>

    <table class="grid">
        <tr>
            <td class="label">Requested By</td>
            <td><?= h((string)($req?->requested_by ?? '-')) ?></td>
        </tr>
        <tr>
            <td class="label">Position</td>
            <td><?= h((string)($req?->position ?? '-')) ?></td>
        </tr>
        <tr>
            <td class="label">Phone Number</td>
            <td><?= h((string)($req?->phone_number ?? '-')) ?></td>
        </tr>
    </table>

    <?php if ($req === null): ?>
        <div class="box">
            <b>Note:</b> Applicant information was not found in the record. Please ensure the Request data is saved for this event.
        </div>
    <?php endif; ?>
</div>

<div class="section">
    <h3>Guests</h3>
    <?php if (empty($guests)): ?>
        <div class="box muted">No guests were provided for this submission.</div>
    <?php else: ?>
        <table class="list">
            <thead>
                <tr>
                    <th style="width:18%;">Type</th>
                    <th style="width:28%;">Name</th>
                    <th style="width:24%;">Designation</th>
                    <th>Organization</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($guests as $g): ?>
                <tr>
                    <td><?= h((string)($g->guest_type->type_name ?? '-')) ?></td>
                    <td><?= h((string)($g->guest_name ?? '-')) ?></td>
                    <td><?= h((string)($g->designation ?? '-')) ?></td>
                    <td><?= h((string)($g->organization ?? '-')) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div class="section">
    <h3>Documents</h3>
    <?php if (empty($docs)): ?>
        <div class="box muted">No documents were attached for this submission.</div>
    <?php else: ?>
        <table class="list">
            <thead>
                <tr>
                    <th style="width:22%;">Document Type</th>
                    <th style="width:48%;">Company / Partner Info</th>
                    <th>File Path</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($docs as $d): ?>
                <tr>
                    <td><?= h((string)($d->doc_type->type_name ?? '-')) ?></td>
                    <td><?= h((string)($d->company_info ?? '-')) ?></td>
                    <td><?= h((string)($d->file_path ?? '-')) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div class="signature">
    <p class="para">Prepared by:</p>
    <div class="sigline"></div>
    <p class="para" style="margin-top:6px;">
        <b><?= h((string)($req?->requested_by ?? 'Organizer')) ?></b><br>
        <?= h((string)($req?->position ?? '')) ?><br>
        <span class="muted">UKM Event System (Organizer)</span>
    </p>
</div>

<div class="footer">
    This is a system-generated reference copy. Generated on <?= h(date('Y-m-d H:i')) ?>.
</div>
