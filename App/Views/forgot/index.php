<?php
/** @var \App\Models\PasswordResetModel $model */
use App\Core\App;
use App\Core\Form\Form;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>Forgot Password</h2>

<?php if ($m = App::$app->session->getFlash('success')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php if ($m = App::$app->session->getFlash('error')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<p>Enter your email to receive a reset code.</p>

<?php $form = Form::begin('/forgot', 'post'); ?>
  <?= $form->field($model, 'email')->label('Email') ?>
  <?= Form::button('Send Reset Code') ?>
<?php Form::end(); ?>

<p><a href="/login">Back to login</a></p>
