<?php
$this->assign('title', 'Edit User');
$user = $user ?? null;
$roles = $roles ?? [];
?>

<style>
/* same CSS as add.php */
.page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;margin-bottom:14px;}
.page-head h2{margin:0;font-size:20px;font-weight:750;letter-spacing:-.2px;}
.page-head p{margin:6px 0 0;color:#64748b;font-size:13px;}
.toolbar{display:flex;gap:10px;align-items:center;flex-wrap:wrap;}
.btn2{display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-weight:700;font-size:13px;padding:10px 14px;border-radius:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;transition:.15s;white-space:nowrap;cursor:pointer;}
.btn2:hover{transform:translateY(-1px);background:#f8fafc;}
.btn2.primary{border:none;color:#fff;background:linear-gradient(135deg,#2563eb,#0ea5e9);box-shadow:0 10px 22px rgba(37,99,235,.18);}
.panel{border:1px solid #e5e7eb;border-radius:16px;padding:16px;background:#fff;box-shadow:0 6px 16px rgba(15,23,42,0.05);}
.row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.field{margin-bottom:12px;}
label{display:block;font-size:12px;font-weight:700;letter-spacing:.4px;color:#475569;text-transform:uppercase;margin-bottom:6px;}
input,select{width:100%;padding:12px;border-radius:12px;border:1px solid #cbd5e1;background:#f8fafc;outline:none;font-size:14px;color:#0f172a;}
.help{font-size:12px;color:#64748b;margin-top:6px;}
.actions{display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;margin-top:12px;}
@media(max-width:980px){.page-head{flex-direction:column;}.row{grid-template-columns:1fr;}.actions{justify-content:flex-start;}}
</style>

<div class="page-head">
  <div>
    <h2>Edit User</h2>
    <p>Update user info and role.</p>
  </div>
  <div class="toolbar">
    <?= $this->Html->link('Back', ['action'=>'view', $user->id], ['class'=>'btn2']) ?>
  </div>
</div>

<div class="panel">
  <?= $this->Form->create($user, ['autocomplete'=>'off']) ?>

  <div class="row">
    <div class="field">
      <?= $this->Form->control('name', ['label'=>'Name', 'required'=>true]) ?>
    </div>
    <div class="field">
      <?= $this->Form->control('email', ['label'=>'Email', 'required'=>true]) ?>
    </div>
  </div>

  <div class="row">
    <div class="field">
      <?= $this->Form->control('role_id', [
          'label'=>'Role',
          'type'=>'select',
          'options'=>$roles,
          'empty'=>'-- Select Role --',
          'required'=>true
      ]) ?>
    </div>

    <div class="field">
      <?= $this->Form->control('password', [
          'label'=>'New Password (leave blank to keep)',
          'type'=>'password',
          'required'=>false
      ]) ?>
    </div>
  </div>

  <div class="actions">
    <?= $this->Html->link('Cancel', ['action'=>'view', $user->id], ['class'=>'btn2']) ?>
    <button class="btn2 primary" type="submit">Save Changes</button>
  </div>

  <?= $this->Form->end() ?>
</div>
