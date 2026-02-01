<?php
$this->assign('title', 'Venues');

$q = (string)($q ?? '');
$venues = $venues ?? [];
?>

<style>
/* Admin Venues - clean + not too bold */
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

.panel{border:1px solid #e5e7eb;border-radius:16px;padding:16px;background:#fff;box-shadow:0 6px 16px rgba(15,23,42,0.05);}
.searchbox{
  display:flex;align-items:center;gap:10px;
  padding:10px 12px;border-radius:12px;border:1px solid #e5e7eb;background:#f8fafc;
  max-width:420px;
}
.searchbox input{width:100%;border:none;outline:none;background:transparent;font-size:13px;color:#0f172a;}
.searchbox .svg{width:18px;height:18px;opacity:.7;}

.table{width:100%;border-collapse:separate;border-spacing:0 10px;margin-top:12px;}
.table th{ text-align:left;font-size:12px;letter-spacing:.5px;color:#64748b;padding:0 10px 6px;font-weight:700; }
.rowitem{ background:#f8fafc;border:1px solid #e5e7eb; }
.rowitem td{ padding:14px 12px;font-size:14px;vertical-align:middle;color:#0f172a; }
.rowitem td:first-child{border-top-left-radius:14px;border-bottom-left-radius:14px;}
.rowitem td:last-child{border-top-right-radius:14px;border-bottom-right-radius:14px;text-align:right;}

.muted{color:#64748b;font-size:13px;margin:0;}
.badge{
  display:inline-block;padding:6px 10px;border-radius:999px;
  font-weight:700;font-size:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;
}
.b-type{background:#eef2ff;border-color:#c7d2fe;color:#3730a3;}
.b-cap{background:#ecfeff;border-color:#a5f3fc;color:#155e75;}

.link{font-weight:700;color:#2563eb;text-decoration:none;}
.link:hover{text-decoration:underline;}

.empty{
  border:1px dashed #cbd5e1;background:linear-gradient(#ffffff,#f8fafc);
  border-radius:16px;padding:24px;color:#64748b;font-size:14px;text-align:center;
}

@media (max-width: 980px){
  .page-head{flex-direction:column;}
  .searchbox{max-width:100%;}
}
</style>

<div class="page-head">
  <div>
    <h2>Venues</h2>
    <p>Manage venue records for event submissions.</p>
  </div>

  <div class="toolbar">
    <?= $this->Html->link('+ Add Venue', ['action'=>'add'], ['class'=>'btn2 primary']) ?>
  </div>
</div>

<div class="panel">
  <form class="searchbox" method="get" action="<?= $this->Url->build(['action'=>'index']) ?>" style="margin-bottom:10px;">
    <svg class="svg" viewBox="0 0 24 24" fill="none">
      <circle cx="11" cy="11" r="7" stroke="#64748b" stroke-width="2"/>
      <path d="M20 20l-3.5-3.5" stroke="#64748b" stroke-width="2" stroke-linecap="round"/>
    </svg>
    <input type="text" name="q" placeholder="Search venue name / type / address..." value="<?= h($q) ?>">
  </form>

  <?php if ($venues->isEmpty()): ?>
    <div class="empty">No venues found.</div>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>VENUE</th>
          <th>TYPE</th>
          <th>CAPACITY</th>
          <th>ADDRESS</th>
          <th style="text-align:right;">ACTION</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($venues as $v): ?>
        <tr class="rowitem">
          <td style="font-weight:750;"><?= h((string)$v->venue_name) ?></td>
          <td>
            <?php if (!empty($v->type)): ?>
              <span class="badge b-type"><?= h((string)$v->type) ?></span>
            <?php else: ?>
              <span class="muted">-</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($v->capacity !== null && $v->capacity !== ''): ?>
              <span class="badge b-cap"><?= h((string)$v->capacity) ?></span>
            <?php else: ?>
              <span class="muted">-</span>
            <?php endif; ?>
          </td>
          <td>
            <span class="muted"><?= h((string)($v->address ?? '-')) ?></span>
          </td>
          <td>
            <?= $this->Html->link('View', ['action'=>'view', $v->id], ['class'=>'link']) ?>
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
