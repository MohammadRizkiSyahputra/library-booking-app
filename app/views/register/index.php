<?php
/** @var \App\Models\RegisterModel $model */
/** @var \App\Core\Form\Form $form */

use App\Core\App;
use App\Core\Form\Form;
?>

<div class="max-w-md mx-auto bg-white shadow-xl rounded-xl p-8 mt-12 text-center">
  <?php if ($m = App::$app->session->getFlash('success')): ?>
    <div class="mb-4 rounded bg-green-100 border border-green-200 text-green-800 p-3"><?= $m ?></div>
  <?php endif; ?>
  <?php if ($m = App::$app->session->getFlash('error')): ?>
    <div class="mb-4 rounded bg-red-100 border border-red-200 text-red-800 p-3"><?= $m ?></div>
  <?php endif; ?>

<div class="max-w-md mx-auto">
  <div class="text-center mb-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Daftar Akun Baru</h2>
    <p class="text-gray-600">Bergabung dengan Library Booking sekarang</p>
  </div>

  <?php $form = Form::begin('/register', 'post'); ?>
    <?= $form->field($model, 'name')->label('Nama Panjang')->placeholder('Nama Lengkap'); ?>
    <?= $form->field($model, 'nim')->label('NIM')->placeholder('NIM (10 digit)')->type('text'); ?>
    <?= $form->field($model, 'email')->label('Email (Wajib Email PNJ)')->placeholder('nama@stu.pnj.ac.id atau nama@tik.pnj.ac.id'); ?>
    <?= $form->field($model, 'password')->label('Password')->placeholder('Minimal 6 karakter'); ?>
    <?= $form->field($model, 'confirm_password')->label('Konfirmasi Ulang Password')->placeholder('Ketik ulang password'); ?>

    <button type="submit"
      class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition">
      Daftar Sekarang
    </button>
  <?php Form::end(); ?>

  <p class="text-center text-sm text-gray-600 mt-4">
    Sudah punya akun?
    <a href="/login" class="text-indigo-600 hover:text-indigo-700 font-semibold">Login disini</a>
  </p>
</div>
