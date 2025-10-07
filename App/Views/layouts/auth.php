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
                        <a href="/" class="block px-6 py-4 hover:bg-indigo-700 transition">
                            Home
                        </a>
                    </li>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
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