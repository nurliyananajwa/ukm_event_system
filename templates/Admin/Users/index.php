<?php
$this->assign('title', 'Users');

$q = (string)($q ?? '');
$role = (string)($role ?? '');
$roles = $roles ?? [];
$users = $users ?? [];
?>

<style>
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

.filters{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-bottom:10px;}
.searchbox{
  display:flex;align-items:center;gap:10px;
  padding:10px 12px;border-radius:12px;border:1px solid #e5e7eb;background:#f8fafc;
  max-width:420px; flex:1;
}
.searchbox input{width:100%;border:none;outline:none;background:transparent;font-size:13px;color:#0f172a;}
.searchbox .svg{width:18px;height:18px;opacity:.7;}

.selectbox{
  display:flex;align-items:center;gap:10px;
  padding:10px 12px;border-radius:12px;border:1px solid #e5e7eb;background:#f8fafc;
}
.selectbox select{border:none;outline:none;background:transparent;font-size:13px;color:#0f172a;}

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
.b-admin{background:#eef2ff;border-color:#c7d2fe;color:#3730a3;}
.b-org{background:#ecfdf5;border-color:#bbf7d0;color:#166534;}
.b-staff{background:#fff7ed;border-color:#fed7aa;color:#9a3412;}

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
    <h2>Users</h2>
    <p>Manage admin, staff, and organizers.</p>
  </div>

  <div class="toolbar">
    <?= $this->Html->link('+ Add User', ['action'=>'add'], ['class'=>'btn2 primary']) ?>
  </div>
</div>

<div class="panel">

  <form class="filters" method="get" action="<?= $this->Url->build(['action'=>'index']) ?>">
    <div class="searchbox">
      <svg class="svg" viewBox="0 0 24 24" fill="none">
        <circle cx="11" cy="11" r="7" stroke="#64748b" stroke-width="2"/>
        <path d="M20 20l-3.5-3.5" stroke="#64748b" stroke-width="2" stroke-linecap="round"/>
      </svg>
      <input type="text" name="q" placeholder="Search name / email / role..." value="<?= h($q) ?>">
    </div>

    <div class="selectbox">
      <select name="role">
        <option value="">All Roles</option>
        <?php foreach ($roles as $rid => $rname): ?>
          <option value="<?= h((string)$rid) ?>" <?= ((string)$rid === (string)$role) ? 'selected' : '' ?>>
            <?= h((string)$rname) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button class="btn2" type="submit">Filter</button>

    <?php if ($q !== '' || $role !== ''): ?>
      <?= $this->Html->link('Reset', ['action'=>'index'], ['class'=>'btn2']) ?>
    <?php endif; ?>
  </form>

  <?php if ($users->isEmpty()): ?>
    <div class="empty">No users found.</div>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>NAME</th>
          <th>EMAIL</th>
          <th>ROLE</th>
          <th>CREATED</th>
          <th style="text-align:right;">ACTION</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($users as $u): ?>
        <?php
          $roleName = (string)($u->role?->role_name ?? '-');
          $low = strtolower($roleName);
          $badge = 'badge ';
          if ($low === 'admin') $badge .= 'b-admin';
          elseif ($low === 'organizer') $badge .= 'b-org';
          else $badge .= 'b-staff';
        ?>
        <tr class="rowitem">
          <td style="font-weight:750;"><?= h((string)$u->name) ?></td>
          <td><span class="muted"><?= h((string)$u->email) ?></span></td>
          <td><span class="<?= $badge ?>"><?= h($roleName) ?></span></td>
          <td><span class="muted"><?= h((string)($u->created ?? '-')) ?></span></td>
          <td>
            <?= $this->Html->link('View', ['action'=>'view', $u->id], ['class'=>'link']) ?>
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
