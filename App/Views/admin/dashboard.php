<?php
/** @var array $stats */
/** @var array $roomUsage */
/** @var array $bookings */
use App\Core\App;
?>

<!-- Disini za buat edit2 - styling css sama atur2 margin lah -->

<h2>Admin Dashboard</h2>

<!-- Disini za buat edit2 - Statistics section -->
<div>
  <h3>Statistics</h3>
  <p>Total Bookings: <?= $stats['total_bookings'] ?? 0 ?></p>
  <p>Pending Bookings: <?= $stats['pending_bookings'] ?? 0 ?></p>
  <p>Active Users: <?= $stats['active_users'] ?? 0 ?></p>
  <p>Pending Verifications: <?= $stats['pending_verifications'] ?? 0 ?></p>
</div>

<!-- Disini za buat edit2 - Room usage table -->
<div>
  <h3>Room Usage</h3>
  <?php if (empty($roomUsage)): ?>
    <p>No room usage data available.</p>
  <?php else: ?>
    <table border="1">
      <tr>
        <th>Room</th>
        <th>Total Bookings</th>
        <th>Usage %</th>
      </tr>
      <?php 
      $totalBookings = array_sum(array_column($roomUsage, 'booking_count'));
      foreach ($roomUsage as $usage): 
        $percentage = $totalBookings > 0 ? round(($usage['booking_count'] / $totalBookings) * 100, 2) : 0;
      ?>
      <tr>
        <td><?= htmlspecialchars($usage['title']) ?></td>
        <td><?= $usage['booking_count'] ?></td>
        <td><?= $percentage ?>%</td>
      </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</div>

<!-- Disini za buat edit2 - Recent bookings table -->
<div>
  <h3>Recent Bookings</h3>
  <?php if (empty($bookings)): ?>
    <p>No recent bookings.</p>
  <?php else: ?>
    <table border="1">
      <tr>
        <th>User</th>
        <th>Room</th>
        <th>Date</th>
        <th>Status</th>
      </tr>
      <?php foreach ($bookings as $booking): ?>
      <tr>
        <td><?= htmlspecialchars($booking['user_name']) ?></td>
        <td><?= htmlspecialchars($booking['room_title']) ?></td>
        <td><?= htmlspecialchars($booking['booking_date']) ?></td>
        <td><?= htmlspecialchars($booking['status']) ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</div>

<!-- Disini za buat edit2 - Admin navigation menu -->
<nav>
  <h3>Admin Menu</h3>
  <ul>
    <li><a href="/admin/rooms">Manage Rooms</a></li>
    <li><a href="/admin/users">Manage Users</a></li>
    <li><a href="/admin/reports">Generate Reports</a></li>
    <li><a href="/rooms">Book a Room</a></li>
  </ul>
</nav>
