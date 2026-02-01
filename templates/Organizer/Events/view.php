<?php
$this->assign('title', 'View Event');

$event = $event ?? null;

// hasOne Approvals => propertyName = approval
$approval = $event->approval ?? null;

$status = (string)($approval?->approval_status ?? 'Pending');
$low = strtolower($status);

$badgeCls = 'badge ';
if ($low === 'approved') $badgeCls .= 'b-approved';
elseif ($low === 'rejected') $badgeCls .= 'b-rejected';
else $badgeCls .= 'b-pending';

$adminComments = trim((string)($approval?->comments ?? ''));

$req = $event->request ?? ($event->requests[0] ?? null);
?>

<style>
.head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;margin-bottom:14px;}
.head h2{margin:0;font-size:22px;}
.head p{margin:6px 0 0;color:#64748b;font-size:13px;}
.btn2{display:inline-block;text-decoration:none;font-weight:900;font-size:13px;padding:10px 14px;border-radius:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;transition:.15s;white-space:nowrap;}
.btn2:hover{transform:translateY(-1px);background:#f8fafc;}
.btn2.primary{border:none;color:#fff;background:linear-gradient(135deg,#2563eb,#0ea5e9);box-shadow:0 12px 26px rgba(37,99,235,.18);}
.btn2.danger{border:1px solid #fecaca;color:#ef4444;background:#fff;}
.panel{border:1px solid #e5e7eb;border-radius:16px;padding:16px;background:#fff;box-shadow:0 8px 18px rgba(0,0,0,0.04),0 3px 6px rgba(0,0,0,0.03);}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;}
.item{padding:12px;border-radius:14px;background:#f8fafc;border:1px solid #e5e7eb;}
.item b{display:block;font-size:12px;letter-spacing:.6px;color:#64748b;text-transform:uppercase;}
.item span{display:block;margin-top:6px;font-weight:600;color:#0f172a;}
.badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:950;font-size:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;}
.b-pending{background:#fff7ed;border-color:#fed7aa;color:#9a3412;}
.b-approved{background:#ecfdf5;border-color:#bbf7d0;color:#166534;}
.b-rejected{background:#fef2f2;border-color:#fecaca;color:#991b1b;}
.note{margin-top:14px;padding:14px;border-radius:14px;border:1px solid #e5e7eb;background:#f8fafc;}
.note b{display:block;font-size:12px;letter-spacing:.6px;color:#64748b;text-transform:uppercase;}
.note .txt{margin-top:8px;white-space:pre-wrap;color:#0f172a;font-weight:700;}
.small-link{font-weight:900;color:#2563eb;text-decoration:none;}
.small-link:hover{text-decoration:underline;}
@media (max-width:900px){.grid{grid-template-columns:1fr;}.head{flex-direction:column;}}
</style>

<div class="head">
  <div>
    <h2><?= h((string)($event->event_name ?? 'Event')) ?></h2>
    <p>Status: <span class="<?= h($badgeCls) ?>"><?= h($status) ?></span></p>
  </div>

  <div style="display:flex;gap:10px;flex-wrap:wrap;">
    <?= $this->Html->link('Back',['action'=>'index'],['class'=>'btn2']) ?>
    <?= $this->Html->link('Edit',['action'=>'edit',$event->id],['class'=>'btn2 primary']) ?>
    <?= $this->Form->postLink('Delete',['action'=>'delete',$event->id],['class'=>'btn2 danger','confirm'=>'Delete this event?']) ?>
    <?= $this->Html->link('Export PDF',['action'=>'exportPdf',$event->id],['class'=>'btn2']) ?>
  </div>
</div>

<div class="panel">
  <h3 style="margin:0;font-size:16px;">Event Information</h3>

  <div class="grid">
    <div class="item"><b>Start Date</b><span><?= h((string)($event->start_date ?? '-')) ?></span></div>
    <div class="item"><b>End Date</b><span><?= h((string)($event->end_date ?? '-')) ?></span></div>
    <div class="item"><b>Time</b><span><?= h((string)($event->time_start ?? '-')) ?> - <?= h((string)($event->time_end ?? '-')) ?></span></div>
    <div class="item"><b>Venue</b><span><?= h((string)($event->venue?->venue_name ?? '-')) ?></span></div>
    <div class="item"><b>Content Type</b><span><?= h((string)($event->content_type ?? '-')) ?></span></div>
    <div class="item"><b>Scope</b><span><?= h((string)($event->scope ?? '-')) ?></span></div>
  </div>

  <div class="item" style="margin-top:14px;">
    <b>Objectives</b>
    <span style="white-space:pre-wrap;"><?= h((string)($event->objectives ?? '-')) ?></span>
  </div>

  <div class="item" style="margin-top:14px;">
      <b>Requested By</b>
      <span><?= h((string)($req?->requested_by ?? '-')) ?></span>
  </div>

  <div class="grid">
      <div class="item">
          <b>Position</b>
          <span><?= h((string)($req?->position ?? '-')) ?></span>
      </div>

      <div class="item">
          <b>Phone Number</b>
          <span><?= h((string)($req?->phone_number ?? '-')) ?></span>
      </div>
  </div>

  <div class="grid" style="margin-top:14px;">
      <?php foreach(($event->guests ?? []) as $g): ?>
          <div class="item">
              <b>GUEST (<?= h((string)($g->guest_type?->type_name ?? '-')) ?>)</b>
              <span>
                  <b style="display:inline; font-size:11px;">NAME:</b> <?= h((string)($g->guest_name ?? '-')) ?><br>
                  <b style="display:inline; font-size:11px;">DESIGNATION:</b> <?= h((string)($g->designation ?? '-')) ?><br>
                  <b style="display:inline; font-size:11px;">ORGANIZATION:</b> <?= h((string)($g->organization ?? '-')) ?>
              </span>
          </div>
      <?php endforeach; ?>

      <?php foreach(($event->documents ?? []) as $d): ?>
          <div class="item">
              <b>DOCUMENT (<?= h((string)($d->document_type?->type_name ?? '-')) ?>)</b>
              <span>
                  <?= h((string)($d->company_info ?? '-')) ?><br>
                  <?php if (!empty($d->file_path)): ?>
                      <?= $this->Html->link(
                          'View File',
                          '/' . ltrim((string)$d->file_path, '/'),
                          ['target' => '_blank', 'class' => 'small-link']
                      ) ?>
                  <?php endif; ?>
              </span>
          </div>
      <?php endforeach; ?>
  </div>

  <div class="note">
      <b>Admin Comments</b>
      <div class="txt"><?= $adminComments !== '' ? h($adminComments) : 'No comments yet.' ?></div>
  </div>
</div>
