<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= h($this->fetch('title')) ?></title>
    <?= $this->Html->css('auth') ?>
</head>
<body>

<div class="flash-wrap">
    <?= $this->Flash->render() ?>
</div>

<div class="auth-wrapper">
    <?= $this->fetch('content') ?>
</div>

</body>
</html>
