<?php
session_start();
require 'db.php';

// Mengatur batas unggahan file secara dinamis
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '110M');
ini_set('max_execution_time', '300');
ini_set('max_input_time', '300');

// Pastikan pengguna yang masuk
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_FILES['thumbnail'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $user_id = $_SESSION['user_id'];

        $thumbnail = $_FILES['thumbnail'];
        $thumbnail_filename = $thumbnail['name'];
        $temp_thumbnail = $thumbnail['tmp_name'];

        $target_dir = "uploads/videos/";
        $thumbnail_target_file = $target_dir . $thumbnail_filename;

        if (move_uploaded_file($temp_thumbnail, $thumbnail_target_file)) {
            if (!empty($_FILES['video']['name'])) {
                $video = $_FILES['video'];
                $video_filename = $video['name'];
                $temp_video = $video['tmp_name'];
                $video_target_file = $target_dir . $video_filename;

                if (move_uploaded_file($temp_video, $video_target_file)) {
                    $stmt = $pdo->prepare('INSERT INTO videos (title, description, filename, thumbnail, user_id) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute([$title, $description, $video_filename, $thumbnail_filename, $user_id]);
                    echo "The video has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your video.";
                }
            } elseif (!empty($_POST['video_link'])) {
                $video_link = $_POST['video_link'];
                $filename = basename($video_link);
                $target_file = $target_dir . $filename;

                if (file_put_contents($target_file, file_get_contents($video_link))) {
                    $stmt = $pdo->prepare('INSERT INTO videos (title, description, filename, thumbnail, user_id) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute([$title, $description, $filename, $thumbnail_filename, $user_id]);
                    echo "The video has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your video from link.";
                }
            } else {
                echo "Please provide both a video file or link and a thumbnail.";
            }
        } else {
            echo "Sorry, there was an error uploading your thumbnail.";
        }
    } else {
        echo "Please provide a title, description, and a thumbnail.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <!-- Tambahkan tombol untuk membuka sidebar -->
    <div class="container-fluid">
        <span style="font-size:30px;cursor:pointer;color:white" onclick="openNav()">&#9776;</span>
    </div>

    <!-- Sertakan sidebar.php di sini -->
    <?php include './sideBar/sidebar.php'; ?>
    
    <h1>Upload Video</h1>
    <form id="uploadForm" enctype="multipart/form-data" method="post" action="upload.php">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required><br>
        <label for="description">Description</label>
        <textarea name="description" id="description" required></textarea><br>
        <label for="video">Upload Video</label>
        <input type="file" name="video" id="video"><br>
        <label for="video_link">or Video Link</label>
        <input type="url" name="video_link" id="video_link"><br>
        <label for="thumbnail">Thumbnail</label>
        <input type="file" name="thumbnail" id="thumbnail" required><br>
        <input type="submit" value="Upload Video" name="submit">
    </form>
    <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
    <div id="status"></div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            var formData = new FormData(this);
            var progressBar = document.getElementById('progressBar');
            var status = document.getElementById('status');

            // AJAX request to upload.php
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                var percent = Math.round((e.loaded / e.total) * 100);
                progressBar.value = percent; // Update progress bar value
                status.innerHTML = percent + '% uploaded'; // Update status message
            });
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Upload completed, display response message
                    status.innerHTML = xhr.responseText;
                }
            };
            xhr.open('POST', 'upload.php', true);
            xhr.send(formData);
        });
    </script>
</body>
</html>
