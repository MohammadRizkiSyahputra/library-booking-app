<?php
/** @var \App\Models\VerificationModel $model */
use App\Core\App;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>Verify Your Account</h2>

<?php if ($m = App::$app->session->getFlash('success')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php if ($m = App::$app->session->getFlash('error')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php if ($devOtp = App::$app->session->get('dev_otp_display')): ?>
  <div style="border: 2px solid orange; padding: 20px; margin: 20px 0; background: #fff3cd;">
    <h3 style="color: #856404;">DEVELOPMENT MODE - OTP Code</h3>
    <p><strong>User:</strong> <?= htmlspecialchars($devOtp['user']) ?> (<?= htmlspecialchars($devOtp['email']) ?>)</p>
    <p><strong>OTP Code:</strong> <span style="font-size: 32px; color: #d63384; font-weight: bold; letter-spacing: 5px;"><?= htmlspecialchars($devOtp['otp']) ?></span></p>
    <p><strong>Purpose:</strong> <?= $devOtp['purpose'] === 'reset_password' ? 'Password Reset' : 'Account Verification' ?></p>
    <p style="color: #856404;"><em>In production mode, this will be sent via email.</em></p>
  </div>
  <?php App::$app->session->remove('dev_otp_display'); ?>
<?php endif; ?>

<p>Enter the 6-digit code sent to your email.</p>

<?php
use App\Core\Form\Form;
$form = Form::begin('/verify', 'post');
?>
  <?= $form->field($model, 'code')->label('Verification Code')->type('text') ?>
  <?= Form::button('Verify') ?>
<?php Form::end(); ?>

<p>Didn't receive code? <a href="/resend">Resend</a></p>
