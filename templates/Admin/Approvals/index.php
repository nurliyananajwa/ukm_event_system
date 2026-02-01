<?php
$this->assign('title', 'Event Approvals');

$events = $events ?? [];
$q = (string)($q ?? '');
$status = (string)($status ?? 'Pending');

$tabs = ['Pending','Approved','Rejected','All'];
?>

<style>
.page-head{ display:flex; align-items:flex-start; justify-content:space-between; gap:14px; margin-bottom: 14px; }
.page-head h2{ margin:0; font-size:22px; font-weight:800; }
.page-head p{ margin:6px 0 0; color:#64748b; font-size:13px; }

.tabs{ display:flex; gap:8px; flex-wrap:wrap; margin-top:10px; }
.tab{
    display:inline-block; padding:8px 12px; border-radius:999px;
    border:1px solid #e5e7eb; background:#fff; color:#0f172a;
    text-decoration:none; font-weight:800; font-size:12px;
}
.tab.active{ background:#2563eb; border-color:#2563eb; color:#fff; }

.panel{ border:1px solid #e5e7eb; border-radius:16px; padding:16px; background:#fff; }
.table{ width:100%; border-collapse:separate; border-spacing:0 10px; margin-top:12px; }
.table th{ text-align:left; font-size:12px; letter-spacing:.5px; color:#64748b; padding:0 10px 6px; font-weight:700; }
.rowitem{ background:#f8fafc; border:1px solid #e5e7eb; }
.rowitem td{ padding:14px 12px; font-size:14px; vertical-align:middle; color:#0f172a; }
.rowitem td:first-child{ border-top-left-radius:14px; border-bottom-left-radius:14px; }
.rowitem td:last-child{ border-top-right-radius:14px; border-bottom-right-radius:14px; text-align:right; }

.badge{ display:inline-block; padding:6px 10px; border-radius:999px; font-weight:800; font-size:12px; border:1px solid #e5e7eb; background:#fff; color:#0f172a; }
.b-pending{ background:#fff7ed; border-color:#fed7aa; color:#9a3412; }
.b-approved{ background:#ecfdf5; border-color:#bbf7d0; color:#166534; }
.b-rejected{ background:#fef2f2; border-color:#fecaca; color:#991b1b; }

.link{ font-weight:800; color:#2563eb; text-decoration:none; }
.link:hover{ text-decoration:underline; }

.empty{ border:1px dashed #cbd5e1; background: linear-gradient(#ffffff, #f8fafc); border-radius:16px; padding:24px; color:#64748b; font-size:14px; text-align:center; margin-top:12px; }
</style>

<div class="page-head">
  <div>
    <h2>Event Approvals</h2>
    <p>Review event submissions and record approval decisions.</p>

    <div class="tabs">
      <?php foreach ($tabs as $t): ?>
        <?php $isActive = (strtolower($t) === strtolower($status)); ?>
        <a class="tab <?= $isActive ? 'active' : '' ?>"
           href="<?= $this->Url->build(['?' => ['status' => $t, 'q' => $q]]) ?>">
           <?= h($t) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<div class="panel">
<?php
$hasAny = false;
foreach ($events as $tmp) { $hasAny = true; break; }
unset($tmp);
?>

<?php if (!$hasAny): ?>
  <div class="empty">No records found.</div>
<?php else: ?>
  <table class="table">
    <thead>
      <tr>
        <th>EVENT</th>
        <th>DATE</th>
        <th>VENUE</th>
        <th>ORGANIZER</th>
        <th>STATUS</th>
        <th style="text-align:right;">ACTION</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($events as $e): ?>
      <?php
        $st = 'Pending';
        if (isset($e->approval) && $e->approval) {
            $st = (string)($e->approval->approval_status ?? 'Pending');
        } elseif (!empty($e->approvals) && isset($e->approvals[0])) {
            $st = (string)($e->approvals[0]->approval_status ?? 'Pending');
        }

        $low = strtolower($st);
        $badgeCls = 'badge ' . ($low === 'approved' ? 'b-approved' : ($low === 'rejected' ? 'b-rejected' : 'b-pending'));
      ?>
      <tr class="rowitem">
        <td><?= h((string)($e->event_name ?? '-')) ?></td>
        <td><?= h((string)($e->start_date ?? '-')) ?></td>
        <td><?= h((string)($e->venue?->venue_name ?? '-')) ?></td>
        <td><?= h((string)($e->organizer?->name ?? '-')) ?></td>
        <td><span class="<?= h($badgeCls) ?>"><?= h($st) ?></span></td>
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
