<?php
/** @var \App\Models\LoginModel $model */
/** @var \App\Core\Form\Form $form */
/** @var $model \app\models\User */
use App\Core\Form\Form;/media/windows/Users/takofaru/linux/Data/library-booking-app/migrations
?>

<?php use App\Core\App; ?>
<div class="max-w-md mx-auto bg-white shadow-xl rounded-xl p-8 mt-12 text-center">
  <?php if ($m = App::$app->session->getFlash('success')): ?>
    <div class="mb-4 rounded bg-green-100 border border-green-200 text-green-800 p-3"><?= $m ?></div>
  <?php endif; ?>

<div class="max-w-md mx-auto">
  <div class="text-center mb-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang Kembali</h2>
    <p class="text-gray-600">Login ke akun Library Booking Anda</p>
  </div>
  <?php $form = Form::begin('/login', 'post'); ?>
    <?= $form->field($model, 'identifier')->label('Email atau NIM')->placeholder('Email atau NIM')->type('text'); ?>
    <?= $form->field($model, 'password')->label('Password')->placeholder('Masukkan password')->type('password'); ?>
    <div class="flex items-center justify-between mb-4 mt-2">
      <label class="flex items-center">
        <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
      </label>
      <a href="/forgot" class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold">Lupa password?</a>
    </div>
    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition">Login</button>
  <?php Form::end(); ?>
  <p class="text-center text-sm text-gray-600 mt-4">Belum punya akun? <a href="/register" class="text-indigo-600 hover:text-indigo-700 font-semibold">Daftar sekarang</a></p>
</div>
