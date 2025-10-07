<?php
use App\Core\App;
use App\Models\RegisterModel;
/** @var \App\Models\RegisterModel|null $user */
$user = App::$app->user;

if ($user && $user->status === RegisterModel::STATUS_ACTIVE): ?>
  <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-3 rounded-lg mb-4">
    <b>Account Pending Verification:</b> please upload your KuBacaPNJ screenshot in your Profile page.
  </div>
<?php endif; ?>

<div class="text-center">
    <div class="bg-white rounded-2xl shadow-2xl p-12 max-w-2xl mx-4">
        <div class="mb-8">
            <svg class="w-20 h-20 mx-auto text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>

        <?php if (App::isGuest()): ?>
            <h1 class="text-5xl font-bold text-gray-800 mb-4">
                Welcome
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Welcome to your Library Booking App
            </p>
            <div class="flex gap-4 justify-center">
                <a href="/login"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                    Get Started
                </a>
                <a href="/about"
                   class="bg-white hover:bg-gray-50 text-indigo-600 font-semibold py-3 px-8 rounded-lg border-2 border-indigo-600 transition duration-300 ease-in-out transform hover:scale-105">
                    Learn More
                </a>
            </div>
        <?php else: ?>
            <h1 class="text-5xl font-bold text-gray-800 mb-4">
                Welcome, <?= htmlspecialchars(App::$app->user->getDisplayName()) ?> 👋
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Glad to see you back in the Library Booking App!
            </p>
            <div class="flex gap-4 justify-center">
                <a href="/books"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                    Browse Books
                </a>
                <a href="/bookings"
                   class="bg-white hover:bg-gray-50 text-indigo-600 font-semibold py-3 px-8 rounded-lg border-2 border-indigo-600 transition duration-300 ease-in-out transform hover:scale-105">
                    My Bookings
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
