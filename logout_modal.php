<!-- logout_modal.php -->
<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
    <h2 class="text-lg font-semibold mb-4 text-gray-800 text-center">Yakin ingin logout?</h2>
    <div class="flex justify-end gap-3">
      <button onclick="toggleLogoutModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Tidak</button>
      <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Iya</a>
    </div>
  </div>
</div>

<script>
  function toggleLogoutModal() {
    const modal = document.getElementById("logoutModal");
    modal.classList.toggle("hidden");
  }
</script>
