<?php 
use App\Core\Form\Form;
use App\Core\App;
/** @var \App\Models\VerifyModel $model */
?>

<div class="max-w-md mx-auto bg-white shadow-xl rounded-xl p-8 mt-12 text-center">
  <?php if ($m = App::$app->session->getFlash('success')): ?>
    <div class="mb-4 rounded bg-green-100 border border-green-200 text-green-800 p-3"><?= $m ?></div>
  <?php endif; ?>
  <?php if ($m = App::$app->session->getFlash('error')): ?>
    <div class="mb-4 rounded bg-red-100 border border-red-200 text-red-800 p-3"><?= $m ?></div>
  <?php endif; ?>

  <h1 class="text-2xl font-semibold mb-2 text-gray-800">Verify Your Account</h1>
  <p class="text-gray-600 mb-6">Enter the 6-character code we emailed to you.</p>

  <?php $form = Form::begin('/verify', 'post'); ?>
    <?= $form->field($model, 'code')->otpStyle(); ?>
    <button type="submit"
            class="w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 transition">
      Verify
    </button>

    <p class="text-sm text-gray-500 text-center mt-4">
      Didn't receive a code?
      <a href="/resend"
         id="resendLink"
         class="text-indigo-600 hover:underline disabled:opacity-50 disabled:pointer-events-none">Resend Code</a>
      <span id="cooldownTimer" class="text-gray-400 ml-1 hidden">(60s)</span>
    </p>
  <?php Form::end(); ?>
</div>

<script src="/js/verify.js"></script>
