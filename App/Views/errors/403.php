<?php
    use App\Core\App;
?>

<?php App::$app->controller?->setTitle('403 Forbidden | Library Booking App'); ?>

<div class="flex flex-col items-center justify-center min-h-[70vh] text-center">
  <h1 class="text-6xl font-extrabold text-gray-800 mb-4">403</h1>
  <h2 class="text-2xl font-semibold text-gray-700 mb-2">Forbidden</h2>
  <p class="text-gray-500 mb-6">You are not authorized to access this page.</p>
  <a href="/login"
     class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
    Go to Login
  </a>
</div>
