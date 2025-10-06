<div class="max-w-6xl mx-auto">
  <div class="text-center mb-10">
    <h2 class="text-4xl font-bold text-gray-800">My Bookings</h2>
    <p class="text-gray-600 mt-2">Track your active and past reservations.</p>
  </div>

  <!-- Actions (UI only) -->
  <div class="bg-white rounded-2xl shadow p-5 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-2">
      <span class="text-sm text-gray-600">Showing</span>
      <select class="px-3 py-2 rounded-lg border border-gray-200">
        <option>All</option>
        <option>Active</option>
        <option>Completed</option>
        <option>Cancelled</option>
      </select>
    </div>
    <div class="flex gap-3">
      <button class="px-4 py-2 rounded-lg border border-gray-200 bg-white hover:bg-gray-50">Export</button>
      <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">New Booking</button>
    </div>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full text-left">
        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
          <tr>
            <th class="px-6 py-4">#</th>
            <th class="px-6 py-4">Title</th>
            <th class="px-6 py-4">Pickup Date</th>
            <th class="px-6 py-4">Due Date</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
          <tr>
            <td class="px-6 py-4">BK-00123</td>
            <td class="px-6 py-4">
              <div class="font-medium text-gray-800">Clean Architecture</div>
              <div class="text-gray-500">Robert C. Martin</div>
            </td>
            <td class="px-6 py-4">29 Sep 2025</td>
            <td class="px-6 py-4">06 Oct 2025</td>
            <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">Active</span></td>
            <td class="px-6 py-4">
              <div class="flex justify-end gap-2">
                <button class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">View</button>
                <button class="px-3 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Cancel</button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="px-6 py-4">BK-00110</td>
            <td class="px-6 py-4">
              <div class="font-medium text-gray-800">Deep Work</div>
              <div class="text-gray-500">Cal Newport</div>
            </td>
            <td class="px-6 py-4">10 Sep 2025</td>
            <td class="px-6 py-4">17 Sep 2025</td>
            <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs">Completed</span></td>
            <td class="px-6 py-4">
              <div class="flex justify-end gap-2">
                <button class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">View</button>
                <button class="px-3 py-2 rounded-lg bg-gray-200 text-gray-600 cursor-not-allowed">Cancel</button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="px-6 py-4">BK-00098</td>
            <td class="px-6 py-4">
              <div class="font-medium text-gray-800">Atomic Habits</div>
              <div class="text-gray-500">James Clear</div>
            </td>
            <td class="px-6 py-4">01 Sep 2025</td>
            <td class="px-6 py-4">08 Sep 2025</td>
            <td class="px-6 py-4"><span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs">Cancelled</span></td>
            <td class="px-6 py-4">
              <div class="flex justify-end gap-2">
                <button class="px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">View</button>
                <button class="px-3 py-2 rounded-lg bg-gray-200 text-gray-600 cursor-not-allowed">Cancel</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
