<?php
    use App\Core\App;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(App::$app->getTitle()) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h1 class="text-2xl font-bold text-gray-800">Library Booking</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-600 hover:text-indigo-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </button>
                    <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-semibold">
                        U
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <ul class="flex space-x-1">
                    <li>
                        <a href="/dashboard" class="block px-6 py-4 hover:bg-indigo-700 transition">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/books" class="block px-6 py-4 hover:bg-indigo-700 transition">
                            Books
                        </a>
                    </li>
                    <li>
                        <a href="/bookings" class="block px-6 py-4 hover:bg-indigo-700 transition">
                            My Bookings
                        </a>
                    </li>
                    <li>
                        <a href="/about" class="block px-6 py-4 hover:bg-indigo-700 transition">
                            About
                        </a>
                    </li>
                </ul>
                <div class="flex space-x-2">
                    <?php if (App::isGuest()): ?>
                    <a href="/login" class="px-6 py-2 border border-white rounded-lg hover:bg-indigo-700 transition">
                        Login
                    </a>
                    <a href="/register" class="px-6 py-2 bg-white text-indigo-600 rounded-lg hover:bg-gray-100 transition font-semibold">
                        Register
                    </a>
                    <?php else: ?>
                    <form action="/logout" method="post">
                        <button type="submit" class="px-6 py-2 bg-white text-indigo-600 rounded-lg hover:bg-gray-100 transition font-semibold">Logout</button>
                    </form>
                    <a href="/profile" class="px-6 py-2 bg-white text-indigo-600 rounded-lg hover:bg-gray-100 transition font-semibold">
                        Profile
                    </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <?php if (App::$app->session->getFlash('success')): ?>
    <div id="alert-success" class="relative mb-6 flex items-start rounded-lg border border-green-300 bg-green-50 p-4 text-green-800 shadow-sm">
        <svg class="h-5 w-5 flex-shrink-0 text-green-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
        </svg>
        <div class="ml-3 text-sm font-medium leading-5">
            <?= htmlspecialchars(App::$app->session->getFlash('success')) ?>
        </div>
        <button onclick="document.getElementById('alert-success').remove()" 
                class="absolute top-2 right-2 text-green-600 hover:text-green-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <?php endif; ?>

        {{content}}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About Section -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">About Us</h3>
                    <p class="text-gray-400 text-sm">
                        Your trusted library booking platform. Find and reserve your favorite books with ease.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/books" class="text-gray-400 hover:text-white transition">Browse Books</a></li>
                        <li><a href="/bookings" class="text-gray-400 hover:text-white transition">My Bookings</a></li>
                        <li><a href="/faq" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                        <li><a href="/terms" class="text-gray-400 hover:text-white transition">Terms of Service</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📧 info@librarybooking.com</li>
                        <li>📞 +1 (555) 123-4567</li>
                        <li>📍 123 Library St, Book City</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
                <p>&copy; <?= date('Y') ?> Library Booking App. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>