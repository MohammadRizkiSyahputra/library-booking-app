<?php
use App\Core\App;
use App\Core\Form\Form;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(App::$app->getTitle()) ?></title>
    <!-- Disini za buat styling css sama atur2 margin lah -->
</head>
<body>
    <header>
        <h1>Library Booking App</h1>
        <nav>
            <?php if (App::isGuest()): ?>
                <a href="/">Home</a> |
                <a href="/login">Login</a> |
                <a href="/register">Register</a>
            <?php else: ?>
                <?php $user = App::$app->user; ?>
                <?php if ($user->role === 'admin'): ?>
                    <a href="/admin">Admin Dashboard</a> |
                    <a href="/admin/rooms">Manage Rooms</a> |
                    <a href="/admin/users">Manage Users</a> |
                    <a href="/admin/reports">Reports</a> |
                    <a href="/rooms">Book Room</a> |
                <?php else: ?>
                    <a href="/dashboard">Dashboard</a> |
                    <a href="/rooms">Rooms</a> |
                    <a href="/my-bookings">My Bookings</a> |
                <?php endif; ?>
                <a href="/profile">Profile</a> |
                <?php $f = Form::begin('/logout', 'post'); ?>
                    <?= Form::button('Logout') ?>
                <?php Form::end(); ?>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php if ($m = App::$app->session->getFlash('success')): ?>
            <p><?= htmlspecialchars($m) ?></p>
        <?php endif; ?>

        {{content}}
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Library Booking App PNJ</p>
    </footer>
</body>
</html>