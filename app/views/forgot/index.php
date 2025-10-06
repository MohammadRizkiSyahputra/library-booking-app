<?php
use App\Core\Form\Form;
use App\Core\App;
/** @var \App\Models\ForgotPasswordModel $model */
?>

<div class="max-w-md mx-auto bg-white shadow-xl rounded-2xl p-8 mt-10">
  <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Forgot Password</h1>
  <p class="text-gray-600 text-sm text-center mb-6">
    Enter your email, and we'll send a reset code.
  </p>

  <?php if ($m = App::$app->session->getFlash('error')): ?>
    <div class="mb-4 bg-red-100 text-red-700 border border-red-200 rounded-lg p-3 text-sm"><?= $m ?></div>
  <?php elseif ($m = App::$app->session->getFlash('success')): ?>
    <div class="mb-4 bg-green-100 text-green-700 border border-green-200 rounded-lg p-3 text-sm"><?= $m ?></div>
  <?php endif; ?>

  <?php $form = Form::begin('/forgot', 'post'); ?>
    <?= $form->field($model, 'email')->label('Email')->placeholder('Enter your email address'); ?>
    <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg mt-3 transition">
      Send Reset Code
    </button>
  <?php Form::end(); ?>

  <div class="text-center mt-4 text-sm">
    <a href="/login" class="text-indigo-600 hover:underline">Back to login</a>
  </div>
</div>
