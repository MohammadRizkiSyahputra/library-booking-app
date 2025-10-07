<?php
use App\Core\App;
use App\Models\RegisterModel;
/** @var \App\Models\RegisterModel|null $me */
$me = App::$app->user;
?>

<?php if ($me && $me->status === RegisterModel::STATUS_ACTIVE): ?>
  <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-lg flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <p class="font-semibold">Account Pending Verification</p>
      <p class="text-sm">Upload your KuBacaPNJ screenshot to complete verification.</p>
    </div>
    <form action="/upload-kubaca" method="post" enctype="multipart/form-data" class="flex items-center gap-2">
      <input type="file" name="kubaca_image" accept="image/png,image/jpeg,image/webp" required class="text-sm">
      <button type="submit"
              class="px-3 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Upload</button>
    </form>
  </div>
<?php elseif ($me && $me->status === RegisterModel::STATUS_VERIFIED): ?>
  <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-lg">
    <p class="font-semibold">Your account has been verified.</p>
  </div>
<?php endif; ?>
