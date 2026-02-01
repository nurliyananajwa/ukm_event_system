<?php
$this->assign('title', 'Edit Venue');
$venue = $venue ?? null;
?>

<style>
/* reuse same styling as add */
.form-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;margin-bottom:14px;}
.form-head h2{margin:0;font-size:20px;font-weight:750;}
.form-head p{margin:6px 0 0;color:#64748b;font-size:13px;}
.btn2{display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-weight:700;font-size:13px;padding:10px 14px;border-radius:12px;border:1px solid #e5e7eb;background:#fff;color:#0f172a;transition:.15s;white-space:nowrap;cursor:pointer;}
.btn2:hover{transform:translateY(-1px);background:#f8fafc;}
.btn2.primary{border:none;color:#fff;background:linear-gradient(135deg,#2563eb,#0ea5e9);box-shadow:0 10px 22px rgba(37,99,235,.18);}
.btn2.danger{border:1px solid #fecaca;color:#ef4444;background:#fff;}
.card{border:1px solid #e5e7eb;border-radius:16px;padding:16px;background:#fff;box-shadow:0 6px 16px rgba(15,23,42,0.05);}
.row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.field label{display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:6px;}
.field input,.field textarea,.field select{width:100%;padding:12px;border-radius:12px;border:1px solid #cbd5e1;background:#f8fafc;font-size:14px;outline:none;}
.field textarea{min-height:90px;resize:vertical;}
.actions{display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;margin-top:12px;}
@media (max-width:900px){.form-head{flex-direction:column;}.row{grid-template-columns:1fr;}.actions{justify-content:flex-start;}}
</style>

<div class="form-head">
  <div>
    <h2>Edit Venue</h2>
    <p>Update venue details.</p>
  </div>
  <div style="display:flex;gap:10px;flex-wrap:wrap;">
    <?= $this->Html->link('Back', ['action'=>'view', $venue->id], ['class'=>'btn2']) ?>
  </div>
</div>

<div class="card">
  <?= $this->Form->create($venue, ['autocomplete'=>'off']) ?>

  <div class="field">
    <?= $this->Form->control('venue_name', [
      'label' => 'Venue Name',
      'required' => true,
    ]) ?>
  </div>

  <div class="row">
    <div class="field">
      <?= $this->Form->control('type', [
        'label' => 'Type (Optional)',
        'required' => false,
      ]) ?>
    </div>

    <div class="field">
      <?= $this->Form->control('capacity', [
        'label' => 'Capacity (Optional)',
        'type' => 'number',
        'min' => 0,
        'required' => false,
      ]) ?>
    </div>
  </div>

  <div class="field">
    <?= $this->Form->control('address', [
      'label' => 'Address (Optional)',
      'type' => 'textarea',
      'required' => false,
    ]) ?>
  </div>

  <div class="actions">
    <?= $this->Html->link('Cancel', ['action'=>'view', $venue->id], ['class'=>'btn2']) ?>
    <button class="btn2 primary" type="submit">Save Changes</button>
  </div>

  <?= $this->Form->end() ?>
</div>
