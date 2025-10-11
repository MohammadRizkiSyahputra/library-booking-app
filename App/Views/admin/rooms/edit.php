<?php
/** @var \App\Models\Room $room */
use App\Core\App;
use App\Core\Csrf;
use App\Core\Form\Form;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>Edit Room</h2>

<?php if ($m = App::$app->session->getFlash('error')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php $form = Form::begin('/admin/rooms/edit?id=' . $room->id, 'post'); ?>
  <?= Csrf::field() ?>

  <?= $form->field($room, 'title')->label('Room Title') ?>
  <?= $form->field($room, 'capacity_min')->type('number')->label('Minimum Capacity') ?>
  <?= $form->field($room, 'capacity_max')->type('number')->label('Maximum Capacity') ?>
  <?= $form->field($room, 'description')->type('textarea')->rows(4) ?>

  <div>
    <label for="status">Status</label>
    <select id="status" name="status" required>
      <option value="available" <?= $room->status === 'available' ? 'selected' : '' ?>>Available</option>
      <option value="maintenance" <?= $room->status === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
    </select>
  </div>

  <button type="submit">Update Room</button>
<?php Form::end(); ?>

<p><a href="/admin/rooms">Back to Room List</a></p>
