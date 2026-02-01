<?php
$this->assign('title', 'Sign In');
$this->setLayout('auth');
?>

<style>
   * {
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
    }
    body {
        margin: 0;
        background: #eef2f7;
    }
    .auth-wrapper {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .auth-card {
        width: 900px;
        height: 520px;
        background: white;
        display: flex;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        animation: fadeUp 0.6s ease;
    }
    .auth-left {
        width: 45%;
        background: linear-gradient(135deg, #1e5eff, #4f9bff);
        color: white;
        padding: 50px;
        display: flex;
        align-items: center;
        background-size: 200% 200%;
        animation: gradientMove 6s ease infinite;
    }
    .auth-left-content h1 {
        margin: 0;
        font-weight: 400;
    }
    .auth-left-content h2 {
        margin: 5px 0 20px;
        font-size: 28px;
    }
    .auth-left-content p {
        font-size: 14px;
        opacity: 0.9;
    }
    .logo {
        width: 60px;
        margin-bottom: 20px;
    }
    .auth-right {
        width: 55%;
        padding: 50px;
    }
    .auth-right h3 {
        margin: 0;
        font-size: 26px;
    }
    .subtitle {
        color: #777;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .auth-right label {
        display: block;
        font-size: 13px;
        margin-bottom: 5px;
        color: #444;
    }
    .auth-right input {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        transition: all 0.2s ease;
    }
    .auth-right input:focus {
        border-color: #1e5eff;
        box-shadow: 0 0 0 3px rgba(30,94,255,0.15);
        outline: none;
    }
    .auth-right small {
        font-size: 12px;
        color: #888;
    }
    .btn-primary {
        width: 100%;
        margin-top: 10px;
        padding: 14px;
        border: none;
        border-radius: 8px;
        background: #1e5eff;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(30,94,255,0.35);
    }
    .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 5px 15px rgba(30,94,255,0.25);
    }
    .auth-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
    }
    .auth-footer a {
        color: #1e5eff;
        text-decoration: none;
        font-weight: 600;
    }
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<div class="auth-card">

    <div class="auth-left">
        <div class="auth-left-content">
            <h1>Welcome back to</h1>
            <h2>UKM Event System</h2>
            <p>
                Sign in to manage your event submissions,
                approvals, and reports.
            </p>
        </div>
    </div>

    <div class="auth-right">
        <h3>Sign In</h3>
        <p class="subtitle">Access your dashboard</p>

        <?= $this->Form->create() ?>

        <div class="form-group">
            <?= $this->Form->control('email', [
                'label' => 'Email Address',
                'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->control('password', [
                'label' => 'Password',
                'required' => true
            ]) ?>
        </div>

        <?= $this->Form->button('Sign In', ['class' => 'btn-primary']) ?>
        <?= $this->Form->end() ?>

        <p class="auth-footer">
            Don’t have an account?
            <?= $this->Html->link('Create one', ['action' => 'register']) ?>
        </p>
    </div>

</div>
