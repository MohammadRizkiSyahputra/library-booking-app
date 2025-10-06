<?php
use App\Core\Form\Form;
use App\Core\App;
/** @var \App\Models\ResetPasswordModel $model */
?>

<div class="max-w-md mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10">
  <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Reset Password</h1>
  <p class="text-gray-600 text-sm text-center mb-6">
    Enter the verification code and your new password.
  </p>

  <?php if ($m = App::$app->session->getFlash('error')): ?>
    <div class="mb-4 bg-red-100 text-red-700 border border-red-200 rounded-lg p-3 text-sm"><?= $m ?></div>
  <?php elseif ($m = App::$app->session->getFlash('success')): ?>
    <div class="mb-4 bg-green-100 text-green-700 border border-green-200 rounded-lg p-3 text-sm"><?= $m ?></div>
  <?php endif; ?>

  <?php $form = Form::begin('/reset', 'post'); ?>
    <?= $form->field($model, 'code')->label('Code')->placeholder('Enter verification code'); ?>
    <?= $form->field($model, 'password')->label('Password')->placeholder('New password'); ?>
    <?= $form->field($model, 'confirm_password')->label('Konfirm Password')->placeholder('Confirm new password'); ?>

    <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg mt-3 transition">
      Reset Password
    </button>
  <?php Form::end(); ?>

  <div class="text-center mt-4 text-sm">
    <a href="/login" class="text-indigo-600 hover:underline">Back to login</a>
  </div>
</div>
