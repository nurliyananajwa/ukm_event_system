<?php
$this->assign('title', 'Review Event');

$event    = $event ?? null;
$approval = $approval ?? null;

$status = (string)($approval->approval_status ?? 'Pending');
$low    = strtolower($status);
$badgeCls = 'badge ' . ($low === 'approved' ? 'b-approved' : ($low === 'rejected' ? 'b-rejected' : 'b-pending'));

$req    = $event->request ?? ($event->requests[0] ?? null);
$guests = $event->guests ?? [];
$docs   = $event->documents ?? [];
?>

<style>
.head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;margin-bottom:14px;}
.head h2{margin:0;font-size:22px;font-weight:800;}
.head p{margin:6px 0 0;color:#64748b;font-size:13px;}
.btn2{display:inline-block;text-decoration:none;font-weight:800;font-size:13px;padding:10px 14px;border-radius:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;transition:.15s;white-space:nowrap;}
.btn2:hover{transform:translateY(-1px);background:#f8fafc;}
.btn2.primary{border:none;color:#fff;background:linear-gradient(135deg,#2563eb,#0ea5e9);box-shadow:0 12px 26px rgba(37,99,235,.18);}
.panel{border:1px solid #e5e7eb;border-radius:16px;padding:16px;background:#fff;}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;}
.item{padding:12px;border-radius:14px;background:#f8fafc;border:1px solid #e5e7eb;}
.item b{display:block;font-size:12px;letter-spacing:.6px;color:#64748b;text-transform:uppercase;}
.item span{display:block;margin-top:6px;font-weight:600;color:#0f172a;}
.badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:800;font-size:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;}
.b-pending{background:#fff7ed;border-color:#fed7aa;color:#9a3412;}
.b-approved{background:#ecfdf5;border-color:#bbf7d0;color:#166534;}
.b-rejected{background:#fef2f2;border-color:#fecaca;color:#991b1b;}
.section-title{margin-top:18px;font-size:14px;font-weight:900;color:#0f172a;letter-spacing:.6px;text-transform:uppercase;}
textarea{width:100%;min-height:110px;border-radius:12px;border:1px solid #cbd5e1;padding:12px;background:#f8fafc;outline:none;}
select{width:100%;border-radius:12px;border:1px solid #cbd5e1;padding:10px;background:#fff;}
@media (max-width:900px){.grid{grid-template-columns:1fr;}.head{flex-direction:column;}}
</style>

<div class="head">
  <div>
    <h2><?= h((string)($event->event_name ?? 'Event')) ?></h2>
    <p>Status: <span class="<?= h($badgeCls) ?>"><?= h($status) ?></span></p>
  </div>
  <div style="display:flex;gap:10px;flex-wrap:wrap;">
    <?= $this->Html->link('Back', ['action'=>'index'], ['class'=>'btn2']) ?>
    <?= $this->Html->link(
    'Export PDF',
    ['action' => 'exportPdf', $event->id],
    ['class' => 'btn2']
) ?>

  </div>
  
</div>

<div class="panel">
  <div class="section-title">Event Information</div>
  <div class="grid">
    <div class="item"><b>Start Date</b><span><?= h((string)($event->start_date ?? '-')) ?></span></div>
    <div class="item"><b>End Date</b><span><?= h((string)($event->end_date ?? '-')) ?></span></div>
    <div class="item"><b>Time</b><span><?= h((string)($event->time_start ?? '-')) ?> - <?= h((string)($event->time_end ?? '-')) ?></span></div>
    <div class="item"><b>Venue</b><span><?= h((string)($event->venue?->venue_name ?? '-')) ?></span></div>
    <div class="item"><b>Organizer</b><span><?= h((string)($event->organizer?->name ?? '-')) ?></span></div>
    <div class="item"><b>Scope</b><span><?= h((string)($event->scope ?? '-')) ?></span></div>
  </div>

  <div class="item" style="margin-top:14px;">
    <b>Objectives</b>
    <span style="white-space:pre-wrap;"><?= h((string)($event->objectives ?? '-')) ?></span>
  </div>

  <div class="section-title">Applicant / Request</div>
  <div class="grid">
    <div class="item"><b>Requested By</b><span><?= h((string)($req?->requested_by ?? '-')) ?></span></div>
    <div class="item"><b>Position</b><span><?= h((string)($req?->position ?? '-')) ?></span></div>
    <div class="item"><b>Phone</b><span><?= h((string)($req?->phone_number ?? '-')) ?></span></div>
    <div class="item"><b>Submitted At</b><span><?= h((string)($req?->submitted_at ?? '-')) ?></span></div>
  </div>

  <div class="section-title">Guests</div>
  <?php if (empty($guests)): ?>
    <div class="item"><span>No guests added.</span></div>
  <?php else: ?>
    <?php foreach ($guests as $g): ?>
      <div class="item" style="margin-top:10px;">
        <b><?= h((string)($g->guest_type?->type_name ?? 'Guest')) ?></b>
        <span>
          <b style="display:inline;font-size:11px;">NAME:</b> <?= h((string)($g->guest_name ?? '-')) ?><br>
          <b style="display:inline;font-size:11px;">DESIGNATION:</b> <?= h((string)($g->designation ?? '-')) ?><br>
          <b style="display:inline;font-size:11px;">ORGANIZATION:</b> <?= h((string)($g->organization ?? '-')) ?>
        </span>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <div class="section-title">Documents</div>
  <?php if (empty($docs)): ?>
    <div class="item"><span>No documents added.</span></div>
  <?php else: ?>
    <?php foreach ($docs as $d): ?>
      <div class="item" style="margin-top:10px;">
        <b><?= h((string)($d->document_type?->type_name ?? '-')) ?></b>
        <span>
          <?= h((string)($d->company_info ?? '-')) ?><br>
          <?php if (!empty($d->file_path)): ?>
            <?= $this->Html->link(
              'Open File',
              '/' . ltrim((string)$d->file_path, '/'),
              ['target'=>'_blank','class'=>'btn2','style'=>'padding:6px 10px;font-size:12px;display:inline-block;margin-top:8px;']
            ) ?>
          <?php endif; ?>
        </span>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <div class="section-title">Decision</div>

  <?= $this->Form->create(null, ['url'=>['action'=>'decide', $event->id]]) ?>

    <div class="grid">
      <div class="item">
        <b>Update Status</b>
        <?= $this->Form->select('approval_status', [
          'Pending'  => 'Pending',
          'Approved' => 'Approved',
          'Rejected' => 'Rejected',
        ], ['default' => $status]) ?>
      </div>
    </div>

    <div class="item" style="margin-top:10px;">
      <b>Comments (to Organizer)</b>
      <?= $this->Form->textarea('comments', ['value'=>(string)($approval->comments ?? '')]) ?>
    </div>

    <div style="margin-top:12px; display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap;">
      <button class="btn2 primary" type="submit">Save</button>
    </div>

  <?= $this->Form->end() ?>
</div>
