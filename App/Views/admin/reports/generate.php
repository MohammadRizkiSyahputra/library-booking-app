<?php
/** @var array $bookings */
/** @var string $startDate */
/** @var string $endDate */
use App\Core\App;
?>

<!-- Disini za buat styling css sama atur2 margin lah -->

<h2>Booking Report</h2>
<p>Period: <?= htmlspecialchars($startDate) ?> to <?= htmlspecialchars($endDate) ?></p>

<button onclick="window.print()">Print Report</button>

<?php if (empty($bookings)): ?>
  <p>No bookings found for this period.</p>
<?php else: ?>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Email</th>
      <th>Room</th>
      <th>Date</th>
      <th>Time</th>
      <th>Participants</th>
      <th>Purpose</th>
      <th>Status</th>
      <th>Created</th>
    </tr>
    <?php foreach ($bookings as $booking): ?>
    <tr>
      <td><?= $booking['id'] ?></td>
      <td><?= htmlspecialchars($booking['user_name']) ?></td>
      <td><?= htmlspecialchars($booking['user_email']) ?></td>
      <td><?= htmlspecialchars($booking['room_title']) ?></td>
      <td><?= htmlspecialchars($booking['booking_date']) ?></td>
      <td><?= htmlspecialchars($booking['start_time']) ?> - <?= htmlspecialchars($booking['end_time']) ?></td>
      <td><?= $booking['participants'] ?></td>
      <td><?= htmlspecialchars($booking['purpose']) ?></td>
      <td><?= htmlspecialchars($booking['status']) ?></td>
      <td><?= htmlspecialchars($booking['created_at']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  
  <p><strong>Total Bookings:</strong> <?= count($bookings) ?></p>
<?php endif; ?>

<p><a href="/admin/reports">Back to Reports</a> | <a href="/admin">Admin Dashboard</a></p>
