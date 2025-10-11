<?php
/** @var array $bookings */
use App\Core\App;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>My Bookings</h2>

<?php if ($m = App::$app->session->getFlash('success')): ?>
  <p><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<?php if (empty($bookings)): ?>
  <p>You haven't made any bookings yet.</p>
  <p><a href="/rooms">Browse available rooms</a></p>
<?php else: ?>
  <table border="1">
    <tr>
      <th>Room</th>
      <th>Date</th>
      <th>Time</th>
      <th>Participants</th>
      <th>Purpose</th>
      <th>Status</th>
    </tr>
    <?php foreach ($bookings as $booking): ?>
    <tr>
      <td><?= htmlspecialchars($booking['room_title']) ?></td>
      <td><?= htmlspecialchars($booking['booking_date']) ?></td>
      <td><?= htmlspecialchars($booking['start_time']) ?> - <?= htmlspecialchars($booking['end_time']) ?></td>
      <td><?= htmlspecialchars($booking['participants']) ?></td>
      <td><?= htmlspecialchars($booking['purpose']) ?></td>
      <td><?= htmlspecialchars($booking['status']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<p><a href="/dashboard">Back to Dashboard</a> | <a href="/rooms">Book Another Room</a></p>
