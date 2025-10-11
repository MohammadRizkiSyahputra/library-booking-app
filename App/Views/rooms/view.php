<?php
/** @var \App\Models\Room $room */
use App\Core\App;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2><?= htmlspecialchars($room->title) ?></h2>

<div>
  <p><strong>Capacity:</strong> <?= htmlspecialchars($room->capacity_min) ?> - <?= htmlspecialchars($room->capacity_max) ?> people</p>
  <p><strong>Status:</strong> <?= htmlspecialchars($room->status) ?></p>
  <?php if ($room->description): ?>
    <p><strong>Description:</strong></p>
    <p><?= htmlspecialchars($room->description) ?></p>
  <?php endif; ?>
</div>

<div>
  <a href="/book?room_id=<?= $room->id ?>">Book This Room</a> |
  <a href="/rooms">Back to Room List</a>
</div>
