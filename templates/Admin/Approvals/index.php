<?php
$this->assign('title', 'Event Approvals');

$events = $events ?? [];
$q = (string)($q ?? '');
$status = (string)($status ?? 'Pending');

$tabs = ['Pending','Approved','Rejected','All'];

$this->Paginator->setTemplates([
  'number'       => '<a class="pg-link" href="{{url}}">{{text}}</a>',
  'current'      => '<span class="pg-link is-active">{{text}}</span>',
  'prevActive'   => '<a class="pg-btn" rel="prev" href="{{url}}">‹ Prev</a>',
  'prevDisabled' => '<span class="pg-btn is-disabled">‹ Prev</span>',
  'nextActive'   => '<a class="pg-btn" rel="next" href="{{url}}">Next ›</a>',
  'nextDisabled' => '<span class="pg-btn is-disabled">Next ›</span>',
]);

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

.pager{
  display:flex;
  align-items:center;
  justify-content:flex-end;
  gap:10px;
  margin-top:12px;
}

.pg-nums{ display:flex; gap:6px; flex-wrap:wrap; }

.pg-link, .pg-btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  min-width:36px;
  height:34px;
  padding:0 12px;
  border-radius:12px;
  border:1px solid #e5e7eb;
  background:#fff;
  color:#0f172a;
  font-weight:800;
  font-size:13px;
  text-decoration:none;
  transition:.15s;
}

.pg-link:hover, .pg-btn:hover{
  transform:translateY(-1px);
  background:#f8fafc;
}

.pg-link.is-active{
  border:none;
  color:#fff;
  background:linear-gradient(135deg,#2563eb,#0ea5e9);
  box-shadow:0 10px 22px rgba(37,99,235,.18);
}

.pg-btn.is-disabled{
  opacity:.5;
  cursor:not-allowed;
  transform:none;
}
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

  <div class="pager">
  <?= $this->Paginator->prev() ?>
  <div class="pg-nums">
    <?= $this->Paginator->numbers(['modulus' => 5]) ?>
  </div>
  <?= $this->Paginator->next() ?>
</div>
<?php endif; ?>
</div>
