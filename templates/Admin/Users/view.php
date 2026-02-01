<?php
$this->assign('title', 'View User');

$user = $user ?? null;
$events = $events ?? [];
$roleName = (string)($user->role?->role_name ?? '-');
$low = strtolower($roleName);
$badge = 'badge ' . ($low === 'admin' ? 'b-admin' : ($low === 'organizer' ? 'b-org' : 'b-staff'));
?>

<style>
.page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;margin-bottom:14px;}
.page-head h2{margin:0;font-size:20px;font-weight:750;letter-spacing:-.2px;}
.page-head p{margin:6px 0 0;color:#64748b;font-size:13px;}
.toolbar{display:flex;gap:10px;align-items:center;flex-wrap:wrap;}

.btn2{display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-weight:700;font-size:13px;padding:10px 14px;border-radius:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;transition:.15s;white-space:nowrap;cursor:pointer;}
.btn2:hover{transform:translateY(-1px);background:#f8fafc;}
.btn2.primary{border:none;color:#fff;background:linear-gradient(135deg,#2563eb,#0ea5e9);box-shadow:0 10px 22px rgba(37,99,235,.18);}
.btn2.danger{border:1px solid #fecaca;color:#ef4444;background:#fff;}

.panel{border:1px solid #e5e7eb;border-radius:16px;padding:16px;background:#fff;box-shadow:0 6px 16px rgba(15,23,42,0.05);}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:12px;}
.item{padding:12px;border-radius:14px;background:#f8fafc;border:1px solid #e5e7eb;}
.item b{display:block;font-size:12px;letter-spacing:.5px;color:#64748b;text-transform:uppercase;font-weight:700;}
.item span{display:block;margin-top:6px;font-weight:650;color:#0f172a;}
.muted{color:#64748b;font-size:13px;margin:0;}

.badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:700;font-size:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;}
.b-admin{background:#eef2ff;border-color:#c7d2fe;color:#3730a3;}
.b-org{background:#ecfdf5;border-color:#bbf7d0;color:#166534;}
.b-staff{background:#fff7ed;border-color:#fed7aa;color:#9a3412;}

.table{width:100%;border-collapse:separate;border-spacing:0 10px;margin-top:12px;}
.table th{ text-align:left;font-size:12px;letter-spacing:.5px;color:#64748b;padding:0 10px 6px;font-weight:700; }
.rowitem{ background:#f8fafc;border:1px solid #e5e7eb; }
.rowitem td{ padding:14px 12px;font-size:14px;vertical-align:middle;color:#0f172a; }
.rowitem td:first-child{border-top-left-radius:14px;border-bottom-left-radius:14px;}
.rowitem td:last-child{border-top-right-radius:14px;border-bottom-right-radius:14px;text-align:right;}
.link{font-weight:700;color:#2563eb;text-decoration:none;}
.link:hover{text-decoration:underline;}

@media (max-width: 980px){ .page-head{flex-direction:column;} .grid{grid-template-columns:1fr;} }
</style>

<div class="page-head">
  <div>
    <h2><?= h((string)$user->name) ?></h2>
    <p>
      <span class="<?= $badge ?>"><?= h($roleName) ?></span>
      <span class="muted"> • <?= h((string)$user->email) ?></span>
    </p>
  </div>

  <div class="toolbar">
    <?= $this->Html->link('Back', ['action'=>'index'], ['class'=>'btn2']) ?>
    <?= $this->Html->link('Edit', ['action'=>'edit', $user->id], ['class'=>'btn2 primary']) ?>
    <?= $this->Form->postLink('Delete', ['action'=>'delete', $user->id], [
        'class'=>'btn2 danger',
        'confirm'=>'Delete this user?'
    ]) ?>
  </div>
</div>

<div class="panel">
  <div class="grid">
    <div class="item"><b>User ID</b><span><?= h((string)$user->id) ?></span></div>
    <div class="item"><b>Created</b><span><?= h((string)($user->created ?? '-')) ?></span></div>
    <div class="item"><b>Modified</b><span><?= h((string)($user->modified ?? '-')) ?></span></div>
    <div class="item"><b>Role</b><span><?= h($roleName) ?></span></div>
  </div>

  <?php if (!empty($events) && method_exists($events, 'count') && $events->count()): ?>
    <div style="margin-top:16px;">
      <b style="display:block;font-size:12px;letter-spacing:.5px;color:#64748b;text-transform:uppercase;font-weight:700;">
        Latest Events by this Organizer
      </b>

      <table class="table">
        <thead>
          <tr>
            <th>EVENT</th>
            <th>DATE</th>
            <th>VENUE</th>
            <th>STATUS</th>
            <th style="text-align:right;">ACTION</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $e): ?>
          <?php
            $st = (string)($e->approval?->approval_status ?? 'Pending');
            $low2 = strtolower($st);
            $b2 = 'badge ' . ($low2 === 'approved' ? 'b-org' : ($low2 === 'rejected' ? 'b-staff' : 'b-admin'));
          ?>
          <tr class="rowitem">
            <td style="font-weight:750;"><?= h((string)$e->event_name) ?></td>
            <td><span class="muted"><?= h((string)$e->start_date) ?></span></td>
            <td><span class="muted"><?= h((string)($e->venue?->venue_name ?? '-')) ?></span></td>
            <td><span class="<?= $b2 ?>"><?= h($st) ?></span></td>
            <td>
              <?= $this->Html->link('Open', ['prefix'=>'Admin','controller'=>'Approvals','action'=>'view', $e->id], ['class'=>'link']) ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
