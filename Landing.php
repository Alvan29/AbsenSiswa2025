<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>

        .hover-dissolve:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transition: background-color 0.3s ease-in-out;
        }
    </style>
</head>
<body class="h-screen w-screen overflow-hidden relative">
    <video id="bgVideo"
           class="absolute inset-0 w-full h-full object-cover"
           autoplay
           muted
           loop
           playsinline
           poster="images/poster.jpg">
    </video>
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="absolute top-6 left-1/2 transform -translate-x-1/2
                bg-white/20 backdrop-blur-md shadow-lg 
                rounded-[10px] flex space-x-10 px-8 py-3">
        <a href="index.php" class="px-4 py-2 rounded-md text-black font-medium hover-dissolve">Absen</a>
        <a href="login.php" class="px-4 py-2 rounded-md text-black font-medium hover-dissolve">Login</a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const video = document.getElementById("bgVideo");
            setTimeout(() => {
                const source = document.createElement("source");
                // source.src = "images/video.mp4"; 
                source.type = "video/mp4";
                video.appendChild(source);
                video.load();
                video.play().catch(err => console.log("Autoplay blocked:", err));
            }, 500);
        });
    </script>

</body>
</html>
