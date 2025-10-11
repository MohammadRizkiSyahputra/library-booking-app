<?php
/** @var \App\Models\Booking $booking */
/** @var \App\Models\Room $room */
use App\Core\App;
use App\Core\Csrf;
use App\Core\Form\Form;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>Book Room: <?= htmlspecialchars($room->title) ?></h2>

<?php if ($m = App::$app->session->getFlash('success')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php if ($m = App::$app->session->getFlash('error')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<div>
  <p><strong>Room Capacity:</strong> <?= htmlspecialchars($room->capacity_min) ?> - <?= htmlspecialchars($room->capacity_max) ?> people</p>
  <?php if ($room->description): ?>
    <p><strong>Room Info:</strong> <?= htmlspecialchars($room->description) ?></p>
  <?php endif; ?>
</div>

<?php $form = Form::begin('/book?room_id=' . $room->id, 'post'); ?>
  <?= Csrf::field() ?>
  
  <input type="hidden" name="room_id" value="<?= $room->id ?>">

  <?= $form->field($booking, 'booking_date')->type('date')->label('Booking Date') ?>
  <?= $form->field($booking, 'start_time')->type('time')->label('Start Time') ?>
  <?= $form->field($booking, 'end_time')->type('time')->label('End Time') ?>
  <?= $form->field($booking, 'participants')->type('number')->label('Number of Participants') ?>
  <small>Min: <?= $room->capacity_min ?>, Max: <?= $room->capacity_max ?></small>
  
  <?= $form->field($booking, 'purpose')->type('textarea')->label('Purpose of Booking')->rows(4) ?>

  <button type="submit">Submit Booking</button>
<?php Form::end(); ?>

<p><a href="/rooms">Back to Room List</a></p>
