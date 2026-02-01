<?php
$this->assign('title', 'View Venue');

$venue  = $venue ?? null;
$events = $events ?? [];

$eventCount = is_object($events) && method_exists($events, 'count') ? $events->count() : (is_countable($events) ? count($events) : 0);
?>

<style>
/* follow SAME style language as index */
.page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;margin-bottom:14px;}
.page-head h2{margin:0;font-size:20px;font-weight:750;letter-spacing:-.2px;}
.page-head p{margin:6px 0 0;color:#64748b;font-size:13px;}
.toolbar{display:flex;gap:10px;align-items:center;flex-wrap:wrap;}

.btn2{
  display:inline-flex;align-items:center;gap:8px;
  text-decoration:none;font-weight:700;font-size:13px;
  padding:10px 14px;border-radius:12px;border:1px solid #e5e7eb;
  background:#fff;color:#0f172a;transition:.15s;white-space:nowrap;cursor:pointer;
}
.btn2:hover{transform:translateY(-1px);background:#f8fafc;}
.btn2.primary{
  border:none;color:#fff;
  background:linear-gradient(135deg,#2563eb,#0ea5e9);
  box-shadow:0 10px 22px rgba(37,99,235,.18);
}
.btn2.danger{
  border:1px solid rgba(239,68,68,0.35);
  color:#b91c1c;
  background:rgba(239,68,68,0.06);
}
.btn2.danger:hover{ background:rgba(239,68,68,0.10); }

.panel{border:1px solid #e5e7eb;border-radius:16px;padding:16px;background:#fff;box-shadow:0 6px 16px rgba(15,23,42,0.05);}

.grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;}
.item{padding:12px;border-radius:14px;background:#f8fafc;border:1px solid #e5e7eb;}
.item b{display:block;font-size:12px;letter-spacing:.5px;color:#64748b;font-weight:700;text-transform:uppercase;}
.item span{display:block;margin-top:6px;color:#0f172a;font-weight:650;}

.muted{color:#64748b;font-size:13px;margin:0;}
.badge{
  display:inline-block;padding:6px 10px;border-radius:999px;
  font-weight:700;font-size:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;
}
.b-type{background:#eef2ff;border-color:#c7d2fe;color:#3730a3;}
.b-cap{background:#ecfeff;border-color:#a5f3fc;color:#155e75;}

.table{width:100%;border-collapse:separate;border-spacing:0 10px;margin-top:12px;}
.table th{ text-align:left;font-size:12px;letter-spacing:.5px;color:#64748b;padding:0 10px 6px;font-weight:700; }
.rowitem{ background:#f8fafc;border:1px solid #e5e7eb; }
.rowitem td{ padding:14px 12px;font-size:14px;vertical-align:middle;color:#0f172a; }
.rowitem td:first-child{border-top-left-radius:14px;border-bottom-left-radius:14px;}
.rowitem td:last-child{border-top-right-radius:14px;border-bottom-right-radius:14px;text-align:right;}

.badgeStatus{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:700;font-size:12px;border:1px solid #e5e7eb;background:#fff;}
.s-pending{background:#fff7ed;border-color:#fed7aa;color:#9a3412;}
.s-approved{background:#ecfdf5;border-color:#bbf7d0;color:#166534;}
.s-rejected{background:#fef2f2;border-color:#fecaca;color:#991b1b;}

.link{font-weight:700;color:#2563eb;text-decoration:none;}
.link:hover{text-decoration:underline;}

.empty{
  border:1px dashed #cbd5e1;background:linear-gradient(#ffffff,#f8fafc);
  border-radius:16px;padding:24px;color:#64748b;font-size:14px;text-align:center;
}

hr.sep{border:none;border-top:1px solid #e5e7eb;margin:14px 0;}

@media (max-width: 980px){
  .page-head{flex-direction:column;}
  .grid{grid-template-columns:1fr;}
}
</style>

<div class="page-head">
  <div>
    <h2><?= h((string)($venue->venue_name ?? 'Venue')) ?></h2>
    <p>View venue details and events that use this venue.</p>
  </div>

  <div class="toolbar">
    <?= $this->Html->link('Back', ['action'=>'index'], ['class'=>'btn2']) ?>
    <?= $this->Html->link('Edit', ['action'=>'edit', $venue->id], ['class'=>'btn2 primary']) ?>
    <?= $this->Form->postLink(
      'Delete',
      ['action'=>'delete', $venue->id],
      ['class'=>'btn2 danger', 'confirm'=>'Delete this venue? (Events using this venue will become venue = NULL)']
    ) ?>
  </div>
</div>

<div class="panel">
  <div class="grid">
    <div class="item">
      <b>Type</b>
      <?php if (!empty($venue->type)): ?>
        <span><span class="badge b-type"><?= h((string)$venue->type) ?></span></span>
      <?php else: ?>
        <span class="muted">-</span>
      <?php endif; ?>
    </div>

    <div class="item">
      <b>Capacity</b>
      <?php if ($venue->capacity !== null && $venue->capacity !== ''): ?>
        <span><span class="badge b-cap"><?= h((string)$venue->capacity) ?></span></span>
      <?php else: ?>
        <span class="muted">-</span>
      <?php endif; ?>
    </div>

    <div class="item" style="grid-column:1 / -1;">
      <b>Address</b>
      <span><?= h((string)($venue->address ?? '-')) ?></span>
    </div>

    <div class="item" style="grid-column:1 / -1;">
      <b>Events Using This Venue</b>
      <span><?= (int)$eventCount ?> event(s)</span>
    </div>
  </div>

  <hr class="sep">

  <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:12px;flex-wrap:wrap;">
    <div>
      <div style="font-weight:750;letter-spacing:-.2px;">Events Using This Venue</div>
    </div>
  </div>

  <?php if ($eventCount <= 0): ?>
    <div class="empty" style="margin-top:12px;">No events are currently using this venue.</div>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>EVENT</th>
          <th>DATE</th>
          <th>TIME</th>
          <th>ORGANIZER</th>
          <th>STATUS</th>
          <th style="text-align:right;">ACTION</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($events as $e): ?>
        <?php
          $st = (string)($e->approval?->approval_status ?? 'Pending');
          $low = strtolower($st);
          $statusCls = 'badgeStatus ' . (
            $low === 'approved' ? 's-approved' : ($low === 'rejected' ? 's-rejected' : 's-pending')
          );

          $t1 = trim((string)($e->time_start ?? ''));
          $t2 = trim((string)($e->time_end ?? ''));
          $timeTxt = ($t1 !== '' && $t2 !== '') ? ($t1 . ' - ' . $t2) : '-';
        ?>
        <tr class="rowitem">
          <td style="font-weight:750;"><?= h((string)($e->event_name ?? '-')) ?></td>
          <td><?= h((string)($e->start_date ?? '-')) ?></td>
          <td><?= h($timeTxt) ?></td>
          <td><?= h((string)($e->organizer?->name ?? '-')) ?></td>
          <td><span class="<?= h($statusCls) ?>"><?= h($st) ?></span></td>
          <td>
            <?= $this->Html->link(
              'Open',
              ['prefix'=>'Admin','controller'=>'Approvals','action'=>'view', $e->id],
              ['class'=>'link']
            ) ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <div style="margin-top:10px;">
      <?= $this->Paginator->numbers() ?>
    </div>
  <?php endif; ?>
</div>
