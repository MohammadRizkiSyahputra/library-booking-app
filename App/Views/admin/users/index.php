<?php
/** @var array $users */
use App\Core\App;
use App\Core\Form\Form;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>Manage Users</h2>

<?php if ($m = App::$app->session->getFlash('success')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php if ($m = App::$app->session->getFlash('error')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<table border="1">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>NIM/NIP</th>
      <th>Status</th>
      <th>KuBaca</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
      <tr>
        <td><?= htmlspecialchars($user->id) ?></td>
        <td><?= htmlspecialchars($user->nama) ?></td>
        <td><?= htmlspecialchars($user->email) ?></td>
        <td><?= htmlspecialchars($user->role) ?></td>
        <td><?= htmlspecialchars($user->nim ?? $user->nip ?? '-') ?></td>
        <td><?= htmlspecialchars($user->status) ?></td>
        <td>
          <?php if ($user->kubaca_img): ?>
            <a href="/uploads/kubaca/<?= htmlspecialchars($user->kubaca_img) ?>" target="_blank">View Image</a>
          <?php else: ?>
            -
          <?php endif; ?>
        </td>
        <td>
          <?php if ($user->kubaca_img && $user->status === 'active'): ?>
            <?php $f = Form::begin('/admin/users/status', 'post'); ?>
              <?= Form::hiddenField('user_id', $user->id) ?>
              <?= Form::hiddenField('action', 'verify_kubaca') ?>
              <?= Form::button('Verify KuBaca') ?>
            <?php Form::end(); ?>
            <?php $f = Form::begin('/admin/users/status', 'post'); ?>
              <?= Form::hiddenField('user_id', $user->id) ?>
              <?= Form::hiddenField('action', 'reject_kubaca') ?>
              <?= Form::button('Reject KuBaca') ?>
            <?php Form::end(); ?>
          <?php endif; ?>
          
          <?php if ($user->status !== 'suspended'): ?>
            <?php $f = Form::begin('/admin/users/status', 'post'); ?>
              <?= Form::hiddenField('user_id', $user->id) ?>
              <?= Form::hiddenField('action', 'suspend') ?>
              <?= Form::button('Suspend') ?>
            <?php Form::end(); ?>
          <?php endif; ?>
          
          <?php if ($user->status === 'suspended'): ?>
            <?php $f = Form::begin('/admin/users/status', 'post'); ?>
              <?= Form::hiddenField('user_id', $user->id) ?>
              <?= Form::hiddenField('action', 'activate') ?>
              <?= Form::button('Activate') ?>
            <?php Form::end(); ?>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<p><a href="/admin">Back to Admin Dashboard</a></p>
