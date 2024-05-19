<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This website is built with the LMAP stack, runs on Docker, and is hosted on RunCloud, AWS, and DigitalOcean.">
    <meta name="author" content="Jehovah Yii Zui Hon">
    <meta name="keywords" content="LMAP stack, Docker, RunCloud, AWS, DigitalOcean, web development">
    <meta property="og:title" content="Hovah Webpage">
    <meta property="og:description" content="This website is built with the LMAP stack, runs on Docker, and is hosted on RunCloud, AWS, and DigitalOcean.">
    <meta property="og:image" content="images/photo.png">
    <meta property="og:url" content="https://hovahyii.vercel.app">
    <meta property="og:type" content="website">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <title>Hovah Webpage</title>
    <style>
        @media (max-width: 640px) {
            .banner-image {
                object-fit: contain;
                height: auto;
            }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="images/banner.png" alt="Banner Image" class="w-screen h-64 object-fill md:object-cover banner-image">
            <div class="p-6 flex flex-col sm:flex-row items-center">
                <div class="flex items-center sm:w-1/3">
                    <img src="images/photo.png" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-white">
                    <h1 class="text-2xl font-bold ml-4">Jehovah Yii Zui Hon</h1>

                </div>
                <div class="flex sm:ml-auto mt-4 sm:mt-0 text-center sm:text-right sm:w-2/3 space-x-4 justify-end">
                    <button id="like-button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="incrementLike()">
                        Like <span id="like-count"><?php echo $like_count; ?></span>
                    </button>
                    <a href="https://hovahyii.vercel.app" target="_blank" class="bg-blue-500 text-white px-4 py-2 rounded">Visit My Website</a>
                </div>
            </div>
        </div>

            <!-- Thank You Section -->
        <div class="bg-blue-500 text-center py-4 mt-4 rounded-lg mb-4 flex flex-col items-center">
            <img class="w-16 h-16 mb-2" src="images/rc-logo-white-icon.svg" alt="runcloud.svg">
            <h2 class="text-xl text-white font-bold">Thank you, Run Cloud for teaching...</h2>
        </div>

        <!-- About Section -->
        <div class="bg-gray-100 text-center py-4 mt-4 rounded-lg mb-4">
            <h2 class="text-xl font-bold mb-2">About This Website</h2>
            <p class="text-gray-700">This website is built with the LAMP stack, runs on Docker, and is hosted on RunCloud, AWS, and Digital Ocean.</p>
        </div>

        <div class="bg-white  p-6 mt-4">
            <h2 class="text-2xl text-center font-bold mb-4">Say Something Nice Here 🤗</h2>
            <div id="memoryWall" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Add plus button as the first card -->
                <div class="flex items-center justify-center bg-white p-4 rounded-lg shadow-md">
                    <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="openForm()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
                <?php
                $servername = "db";
                $username = "root";
                $password = "password";
                $dbname = "mywall";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch like count
                $like_sql = "SELECT count FROM likes WHERE id = 1";
                $like_result = $conn->query($like_sql);
                $like_count = 0;
                if ($like_result->num_rows > 0) {
                    $like_row = $like_result->fetch_assoc();
                    $like_count = $like_row['count'];
                }

                // Fetch messages
                $sql = "SELECT name, message, avatar FROM messages";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="bg-white p-4 rounded-lg shadow-md flex items-center">';
                        echo '<img src="' . $row["avatar"] . '" alt="' . $row["name"] . '" class="w-12 h-12 rounded-full mr-4">';
                        echo '<div>';
                        echo '<h3 class="text-lg font-bold">' . $row["name"] . '</h3>';
                        echo '<p class="text-gray-700">' . $row["message"] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No messages yet.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <div id="formModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="process_form.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="avatar" class="block text-gray-700">Avatar</label>
                    <input type="file" id="avatar" name="avatar" class="w-full px-4 py-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700">Message</label>
                    <textarea id="message" name="message" class="w-full px-4 py-2 border rounded"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-4 mt-8">
        <p class="text-sm">&copy; 2024 Jehovah Yii Zui Hon. All rights reserved.</p>
        <p class="text-sm">Powered by RunCloud, AWS, and Digital Ocean.</p>
    </footer>


    <script>
            let likeCount = <?php echo $like_count; ?>;

            function openForm() {
                document.getElementById('formModal').classList.remove('hidden');
            }

            function incrementLike() {
                likeCount++;
                document.getElementById('like-count').innerText = likeCount;
                document.getElementById('like-button').innerText = `Liked ${likeCount}`;

                // Send AJAX request to update the like count in the database
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "like.php", true);
                xhr.send();
            }
        </script>
</body>
</html>
