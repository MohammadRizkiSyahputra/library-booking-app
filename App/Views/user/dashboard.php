<?php
/** @var array $stats */
/** @var array $bookings */
/** @var \App\Models\User $user */
use App\Core\App;
?>

<!-- Disini za buat edit2 - styling css sama atur2 margin lah -->

<?php if ($m = App::$app->session->getFlash('warning')): ?>
  <p style="color: orange;"><?= htmlspecialchars($m) ?></p>
<?php endif; ?>

<h2>Welcome, <?= htmlspecialchars($user->nama) ?>!</h2>

<!-- Disini za buat edit2 - Statistics section -->
<div>
    <h3>Your Statistics</h3>
    <p>Total Bookings: <?= $stats['total'] ?? 0 ?></p>
    <p>Completed Bookings: <?= $stats['completed'] ?? 0 ?></p>
    <p>Upcoming Bookings: <?= $stats['upcoming'] ?? 0 ?></p>
</div>

<!-- Disini za buat edit2 - Recent bookings table -->
<div>
    <h3>Recent Bookings</h3>
    <?php if (empty($bookings)): ?>
        <p>No bookings yet. <a href="/rooms">Browse rooms</a> to make a booking.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Room</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
            <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?= htmlspecialchars($booking['room_title']) ?></td>
                <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                <td><?= htmlspecialchars($booking['start_time']) ?> - <?= htmlspecialchars($booking['end_time']) ?></td>
                <td><?= htmlspecialchars($booking['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="/my-bookings">View all bookings</a></p>
    <?php endif; ?>
</div>

<!-- Disini za buat edit2 - Navigation menu -->
<nav>
    <ul>
        <li><a href="/rooms">Browse Rooms</a></li>
        <li><a href="/my-bookings">My Bookings</a></li>
        <li><a href="/profile">Profile</a></li>
    </ul>
</nav>
