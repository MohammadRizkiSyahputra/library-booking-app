<?php
/** @var array $rooms */
use App\Core\App;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>Available Rooms</h2>

<?php if ($m = App::$app->session->getFlash('success')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php if ($m = App::$app->session->getFlash('error')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php if (empty($rooms)): ?>
  <p>No rooms available at the moment.</p>
<?php else: ?>
  <table border="1">
    <tr>
      <th>Room Name</th>
      <th>Capacity</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
    <?php foreach ($rooms as $room): ?>
    <tr>
      <td><?= htmlspecialchars($room->title) ?></td>
      <td><?= htmlspecialchars($room->capacity_min) ?> - <?= htmlspecialchars($room->capacity_max) ?> people</td>
      <td><?= htmlspecialchars($room->status) ?></td>
      <td>
        <a href="/room?id=<?= $room->id ?>">View Details</a> |
        <a href="/book?room_id=<?= $room->id ?>">Book Now</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<p><a href="/dashboard">Back to Dashboard</a></p>
