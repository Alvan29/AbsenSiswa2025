<div id="loginModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-96 relative">
        <button onclick="closeModal()" 
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">&times;</button>
        
        <h2 class="text-xl font-bold mb-4 text-center">Login</h2>
        
        <!-- Form Login -->
        <form action="login.php" method="POST" class="flex flex-col gap-4">
            <input type="text" name="username" placeholder="Username" 
                class="border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black">
            
            <input type="password" name="password" placeholder="Password" 
                class="border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black">
            
            <button type="submit" class="bg-black text-white py-2 rounded-full hover:bg-gray-800">Login</button>
        </form>
    </div>
</div>
