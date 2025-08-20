<!-- mobile_sidebar.php -->
<aside class="w-64 h-full bg-white text-gray-800 flex flex-col py-4 px-3 border-r border-gray-200">
  <!-- Close button for mobile -->
  <button id="closeSidebarBtn" class="lg:hidden self-end mb-4 p-2 hover:bg-gray-100 rounded-lg">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
  </button>

  <div class="flex-1">
    <!-- Logo -->
    <div class="flex justify-center mb-8">
      <div class="w-16 h-16 lg:w-20 lg:h-20 bg-blue-100 rounded-full flex items-center justify-center">
        <svg class="w-8 h-8 lg:w-10 lg:h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
      </div>
    </div>

    <!-- Menu Navigation -->
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <nav class="space-y-2">
      
      <!-- Dashboard -->
      <a href="dashboard.php" 
         class="mobile-menu-item group flex items-center px-3 py-3 rounded-lg transition-all duration-200 <?= $current == 'dashboard.php' ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'hover:bg-gray-50 text-gray-700' ?>">
        <div class="flex items-center space-x-3 w-full">
          <div class="p-2 rounded-lg <?= $current == 'dashboard.php' ? 'bg-blue-100' : 'bg-gray-100 group-hover:bg-gray-200' ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 13 2.165 2.165a1 1 0 001.521-.126L16 9"></path>
            </svg>
          </div>
          <span class="font-medium text-sm">Dashboard</span>
        </div>
      </a>

      <!-- Data Siswa -->
      <a href="data_siswa.php" 
         class="mobile-menu-item group flex items-center px-3 py-3 rounded-lg transition-all duration-200 <?= $current == 'data_siswa.php' ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'hover:bg-gray-50 text-gray-700' ?>">
        <div class="flex items-center space-x-3 w-full">
          <div class="p-2 rounded-lg <?= $current == 'data_siswa.php' ? 'bg-blue-100' : 'bg-gray-100 group-hover:bg-gray-200' ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
          </div>
          <span class="font-medium text-sm">Data Siswa</span>
        </div>
      </a>

      <!-- Kelas & Jurusan -->
      <a href="kelas_jurusan.php" 
         class="mobile-menu-item group flex items-center px-3 py-3 rounded-lg transition-all duration-200 <?= $current == 'kelas_jurusan.php' ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'hover:bg-gray-50 text-gray-700' ?>">
        <div class="flex items-center space-x-3 w-full">
          <div class="p-2 rounded-lg <?= $current == 'kelas_jurusan.php' ? 'bg-blue-100' : 'bg-gray-100 group-hover:bg-gray-200' ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
          <span class="font-medium text-sm">Kelas</span>
        </div>
      </a>

      <!-- Laporan -->
      <a href="laporan.php" 
         class="mobile-menu-item group flex items-center px-3 py-3 rounded-lg transition-all duration-200 <?= $current == 'laporan.php' ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'hover:bg-gray-50 text-gray-700' ?>">
        <div class="flex items-center space-x-3 w-full">
          <div class="p-2 rounded-lg <?= $current == 'laporan.php' ? 'bg-blue-100' : 'bg-gray-100 group-hover:bg-gray-200' ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <span class="font-medium text-sm">Laporan</span>
        </div>
      </a>

      <!-- Import Data -->
      <a href="import_siswa.php" 
         class="mobile-menu-item group flex items-center px-3 py-3 rounded-lg transition-all duration-200 <?= $current == 'import_siswa.php' ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'hover:bg-gray-50 text-gray-700' ?>">
        <div class="flex items-center space-x-3 w-full">
          <div class="p-2 rounded-lg <?= $current == 'import_siswa.php' ? 'bg-blue-100' : 'bg-gray-100 group-hover:bg-gray-200' ?>">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
          </div>
          <span class="font-medium text-sm">Import Data</span>
        </div>
      </a>

    </nav>
  </div>

  <!-- User Info & Logout -->
  <div class="border-t border-gray-200 pt-4 mt-4">
    <div class="px-3 py-2 mb-3">
      <div class="flex items-center space-x-3">
        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
          <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>
        <div>
          <p class="text-sm font-medium text-gray-800"><?php echo $_SESSION['username'] ?? 'Admin'; ?></p>
          <p class="text-xs text-gray-500">Administrator</p>
        </div>
      </div>
    </div>
    
    <button onclick="toggleLogoutModal()" 
            class="w-full flex items-center px-3 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors group">
      <div class="p-2 rounded-lg bg-red-100 group-hover:bg-red-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
      </div>
      <span class="ml-3 font-medium text-sm">Logout</span>
    </button>
  </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const closeSidebarBtn = document.getElementById('closeSidebarBtn');
  const mobileMenuItems = document.querySelectorAll('.mobile-menu-item');
  
  // Close sidebar button functionality
  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener('click', function() {
      const sidebar = document.getElementById('sidebar');
      const mobileOverlay = document.getElementById('mobileOverlay');
      
      if (sidebar && mobileOverlay) {
        sidebar.classList.add('-translate-x-full');
        mobileOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      }
    });
  }

  // Auto close sidebar when menu item clicked on mobile
  mobileMenuItems.forEach(item => {
    item.addEventListener('click', function(e) {
      // Only auto-close on mobile/tablet
      if (window.innerWidth < 1024) {
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        
        if (sidebar && mobileOverlay) {
          // Small delay for better UX
          setTimeout(() => {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
          }, 150);
        }
      }
    });
  });

  // Handle window resize
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) {
      const sidebar = document.getElementById('sidebar');
      const mobileOverlay = document.getElementById('mobileOverlay');
      
      if (sidebar) {
        sidebar.classList.remove('-translate-x-full');
      }
      if (mobileOverlay) {
        mobileOverlay.classList.add('hidden');
      }
      document.body.classList.remove('overflow-hidden');
    }
  });
});
</script>