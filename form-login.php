<?php
session_start();
include "koneksi.php";
?>

<h2 class="text-2xl font-bold mb-4">Login</h2>
<form action="login.php" method="post" class="space-y-4">
    <div>
        <label class="block mb-1 font-medium">Username</label>
        <input type="text" name="username" required class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block mb-1 font-medium">Password</label>
        <input type="password" name="password" required class="w-full border rounded-lg px-3 py-2">
    </div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg w-full">
        Login
    </button>
</form>

