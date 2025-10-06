<div class="max-w-6xl mx-auto">
  <!-- Heading -->
  <div class="text-center mb-10">
    <h2 class="text-4xl font-bold text-gray-800">Browse Books</h2>
    <p class="text-gray-600 mt-2">Find your next read and reserve it in seconds.</p>
  </div>

  <!-- Filters / Search (UI only) -->
  <div class="bg-white rounded-2xl shadow p-6 mb-8">
    <form action="#" method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="md:col-span-2">
        <label class="block text-sm text-gray-700 mb-2">Search</label>
        <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Title, author, or keyword">
      </div>
      <div>
        <label class="block text-sm text-gray-700 mb-2">Category</label>
        <select class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500">
          <option>All Categories</option>
          <option>Fiction</option>
          <option>Non-Fiction</option>
          <option>Science</option>
          <option>History</option>
        </select>
      </div>
      <div>
        <label class="block text-sm text-gray-700 mb-2">Availability</label>
        <select class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500">
          <option>Any</option>
          <option>Available</option>
          <option>Checked Out</option>
        </select>
      </div>
      <div class="md:col-span-4 flex gap-3 justify-end">
        <button type="reset" class="px-5 py-3 rounded-lg border border-gray-200 bg-white hover:bg-gray-50">Reset</button>
        <button class="px-6 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 shadow">Search</button>
      </div>
    </form>
  </div>

  <!-- Book Grid (placeholders) -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow p-5 flex flex-col">
      <div class="aspect-[3/4] bg-gray-100 rounded-xl mb-4"></div>
      <h3 class="text-lg font-semibold text-gray-800">The Great Library</h3>
      <p class="text-sm text-gray-500 mt-1">John Reader • 2023</p>
      <div class="mt-4 flex items-center justify-between">
        <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700">Available</span>
        <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm hover:bg-indigo-700">Reserve</button>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 flex flex-col">
      <div class="aspect-[3/4] bg-gray-100 rounded-xl mb-4"></div>
      <h3 class="text-lg font-semibold text-gray-800">Design Patterns</h3>
      <p class="text-sm text-gray-500 mt-1">E. Gamma • 1994</p>
      <div class="mt-4 flex items-center justify-between">
        <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">Limited</span>
        <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm hover:bg-indigo-700">Reserve</button>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 flex flex-col">
      <div class="aspect-[3/4] bg-gray-100 rounded-xl mb-4"></div>
      <h3 class="text-lg font-semibold text-gray-800">Clean Code</h3>
      <p class="text-sm text-gray-500 mt-1">Robert C. Martin • 2008</p>
      <div class="mt-4 flex items-center justify-between">
        <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-700">Checked Out</span>
        <button class="px-4 py-2 rounded-lg bg-gray-200 text-gray-600 text-sm cursor-not-allowed">Reserve</button>
      </div>
    </div>
  </div>
</div>
