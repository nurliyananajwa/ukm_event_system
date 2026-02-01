<?php
/**
 * PDF template
 * @var \App\Model\Entity\Event $event
 */

$this->assign('title', 'Event Submission Copy');

$approval = $event->approval ?? ($event->approvals[0] ?? null);

$status  = (string)($approval->approval_status ?? 'Pending');
$low     = strtolower($status);

$badgeCls = 'badge ';
if ($low === 'approved') $badgeCls .= 'b-approved';
elseif ($low === 'rejected') $badgeCls .= 'b-rejected';
else $badgeCls .= 'b-pending';

$refNo = 'UKMES/EVT/' . str_pad((string)($event->id ?? 0), 6, '0', STR_PAD_LEFT);

$printDate  = date('d/m/Y');
$printStamp = date('Y-m-d H:i');

$venueName = (string)($event->venue?->venue_name ?? '-');

$req = $event->request ?? ($event->requests[0] ?? null);

$requestedBy = (string)($req?->requested_by ?? '-');
$position    = (string)($req?->position ?? '-');
$phone       = (string)($req?->phone_number ?? '-');

$guests = $event->guests ?? [];
$docs   = $event->documents ?? [];

$timeStart = (string)($event->time_start ?? '-');
$timeEnd   = (string)($event->time_end ?? '-');
$timeTxt   = (trim($timeStart) !== '' && trim($timeEnd) !== '') ? ($timeStart . ' - ' . $timeEnd) : '-';
?>

<style>
@page { margin: 22mm 16mm 18mm 16mm; }
body{
  font-family: DejaVu Sans, Arial, sans-serif;
  font-size: 12px;
  color:#0f172a;
}
.header{ position: fixed; top: -14mm; left: 0; right: 0; height: 14mm; }
.footer{
  position: fixed; bottom: -12mm; left: 0; right: 0; height: 12mm;
  font-size: 10px; color:#64748b;
  border-top: 1px solid #e5e7eb; padding-top: 6px;
}
.pagenum:before { content: counter(page); }
.pagecount:before { content: counter(pages); }

.brand{ display:block; font-weight: 800; font-size: 14px; letter-spacing:.3px; }
.subbrand{ display:block; font-size: 11px; color:#475569; margin-top: 2px; }

.meta{ width:100%; border-collapse:collapse; margin-top: 10px; margin-bottom: 10px; }
.meta td{ padding: 2px 0; vertical-align: top; font-size: 11px; color:#334155; }
.meta .right{ text-align:right; }
.hr{ border-top: 2px solid #0f172a; margin: 10px 0 14px; }

.title{ font-size: 13px; font-weight: 900; letter-spacing: .6px; text-transform: uppercase; margin: 0 0 8px; }
.desc{ margin: 0 0 14px; color:#334155; line-height: 1.45; font-size: 11.5px; }

.section-title{
  font-size: 12px; font-weight: 900; letter-spacing:.6px;
  margin: 14px 0 8px; text-transform: uppercase; color:#0f172a;
}

.table{ width:100%; border-collapse:collapse; table-layout: fixed; font-size: 11.5px; }
.table th, .table td{ border: 1px solid #e2e8f0; padding: 8px 9px; vertical-align: top; }
.table th{
  background:#f8fafc; color:#0f172a; font-weight: 900;
  font-size: 10.5px; letter-spacing:.5px; text-transform: uppercase;
}
thead { display: table-header-group; }
tfoot { display: table-footer-group; }
.table tr { page-break-inside: avoid; }
.avoid-break { page-break-inside: avoid; }

.kv td.key{ width: 28%; background:#f8fafc; font-weight: 800; color:#0f172a; }
.kv td.val{ width: 72%; }

.badge{
  display:inline-block; padding: 4px 10px; border-radius: 999px;
  font-weight: 900; font-size: 10px;
  border: 1px solid #e2e8f0; background:#fff;
}
.b-pending{ background:#fff7ed; border-color:#fed7aa; color:#9a3412; }
.b-approved{ background:#ecfdf5; border-color:#bbf7d0; color:#166534; }
.b-rejected{ background:#fef2f2; border-color:#fecaca; color:#991b1b; }

.muted{ color:#64748b; font-size: 11px; }
.prewrap{ white-space: pre-wrap; line-height: 1.45; }
</style>

<div class="header"></div>

<div class="footer">
  <div style="display:flex; justify-content:space-between;">
    <div>This is a system-generated reference copy. Generated on <?= h($printStamp) ?>.</div>
    <div>Page <span class="pagenum"></span> of <span class="pagecount"></span></div>
  </div>
</div>

<div class="brand">UKM Event System</div>
<div class="subbrand">Submission Copy</div>

<table class="meta">
  <tr>
    <td><b>Reference No:</b> <?= h($refNo) ?></td>
    <td class="right"><b>Status:</b> <span class="<?= h($badgeCls) ?>"><?= h($status) ?></span></td>
  </tr>
  <tr>
    <td><b>Date:</b> <?= h($printDate) ?></td>
    <td class="right"></td>
  </tr>
</table>

<div class="hr"></div>

<div class="title">Event Application Submission</div>
<p class="desc">
  This document serves as a reference copy for the event application submitted through the UKM Event System.
  The application details are recorded as follows:
</p>

<div class="section-title">Event Details</div>
<table class="table kv">
  <tr><td class="key">Event Title</td><td class="val"><?= h((string)($event->event_name ?? '-')) ?></td></tr>
  <tr><td class="key">Start Date</td><td class="val"><?= h((string)($event->start_date ?? '-')) ?></td></tr>
  <tr><td class="key">End Date</td><td class="val"><?= h((string)($event->end_date ?? '-')) ?></td></tr>
  <tr><td class="key">Time</td><td class="val"><?= h($timeTxt) ?></td></tr>
  <tr><td class="key">Venue</td><td class="val"><?= h($venueName) ?></td></tr>
  <tr><td class="key">Program Type</td><td class="val"><?= h((string)($event->content_type ?? '-')) ?></td></tr>
  <tr><td class="key">Scope / Target Audience</td><td class="val"><?= h((string)($event->scope ?? '-')) ?></td></tr>
  <tr class="avoid-break">
    <td class="key">Objectives</td>
    <td class="val prewrap"><?= h((string)($event->objectives ?? '-')) ?></td>
  </tr>
</table>

<div class="section-title">Applicant Information</div>
<table class="table kv">
  <tr><td class="key">Requested By</td><td class="val"><?= h($requestedBy) ?></td></tr>
  <tr><td class="key">Position</td><td class="val"><?= h($position) ?></td></tr>
  <tr><td class="key">Phone Number</td><td class="val"><?= h($phone) ?></td></tr>
</table>

<div class="section-title">Guests</div>
<?php if (empty($guests)): ?>
  <div class="muted">No guests added.</div>
<?php else: ?>
  <table class="table">
    <thead>
      <tr>
        <th style="width:18%;">Type</th>
        <th style="width:30%;">Name</th>
        <th style="width:26%;">Designation</th>
        <th style="width:26%;">Organization</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($guests as $g): ?>
      <tr>
        <td><?= h((string)($g->guest_type?->type_name ?? '-')) ?></td>
        <td><?= h((string)($g->guest_name ?? '-')) ?></td>
        <td><?= h((string)($g->designation ?? '-')) ?></td>
        <td><?= h((string)($g->organization ?? '-')) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<div class="section-title">Documents</div>
<?php if (empty($docs)): ?>
  <div class="muted">No documents added.</div>
<?php else: ?>
  <table class="table">
    <thead>
      <tr>
        <th style="width:28%;">Document Type</th>
        <th style="width:38%;">Company / Partner Info</th>
        <th style="width:34%;">File</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($docs as $d): ?>
      <?php
        $docTypeName = '-';
        if (!empty($d->document_type?->type_name))      $docTypeName = (string)$d->document_type->type_name;
        elseif (!empty($d->documentType?->type_name))   $docTypeName = (string)$d->documentType->type_name;
        elseif (!empty($d->doc_type?->type_name))       $docTypeName = (string)$d->doc_type->type_name;
        elseif (!empty($d->document_types?->type_name)) $docTypeName = (string)$d->document_types->type_name;
      ?>
      <tr>
        <td><?= h($docTypeName) ?></td>
        <td><?= h((string)($d->company_info ?? '-')) ?></td>
        <td><?= h((string)($d->file_path ?? '-')) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<div style="margin-top:14px;">
  <div class="muted">
    Prepared by: <?= h($requestedBy) ?> (Organizer)
  </div>
</div>
