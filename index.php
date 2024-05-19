<?php
require 'db.php';

$stmt = $pdo->query('SELECT * FROM videos ORDER BY upload_date DESC');
$videos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video</title>
    <link rel="shortcut icon" href="./assets/images/logoYoutube.svg" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/loading.css">
    <script src="./assets/js/loading.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    /* Masukkan gaya sidebar di sini */
    /* Tambahkan gaya CSS untuk sidebar */


    /* Styling untuk konten lainnya */
    body {
        font-family: Arial, sans-serif;
        background-color: #0f0f0f;
        margin: 0;
        padding: 0;
        color: #fff;
    }

    .navbar {
        margin-bottom: 20px;
    }

    .video-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .video-item {
        border: 1px solid #ddd;
        border-radius: 12px;
        overflow: hidden;
    }

    .video-item img {
        width: 100%;
        height: auto;
        cursor: pointer;
    }

    .video-item h2 {
        font-size: 18px;
        margin: 10px 0;
    }

    .video-item p {
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Jumlah baris sebelum ditampilkan ellipsis */
        -webkit-box-orient: vertical;
        white-space: nowrap; /* Menyediakan ruang tambahan untuk menampilkan elipsis */
    }

    .video-item small {
        color: #888;
        font-size: 12px;
    }
</style>
<body>

        <!-- Elemen loading -->
    <div class="loading">
        <img class="loading-img" src="./assets/images/Loading.gif" alt="Loading...">
    </div>

    <!-- Tambahkan tombol untuk membuka sidebar -->
    <div class="container-fluid">
        <span style="font-size:30px;cursor:pointer;color:white" onclick="openNav()">&#9776;</span>
    </div>

    <!-- Sertakan sidebar.php di sini -->
    <?php include './sideBar/sidebar.php'; ?>

    <!-- Konten utama -->
    <div id="main">
        <div class="container">
            <div class="video-list">
                <?php foreach ($videos as $video): ?>
                    <div class="container mt-3">
                        <div class="video-item">
                            <a href="view.php?id=<?php echo $video['id']; ?>">
                                <img src="uploads/videos/<?php echo htmlspecialchars($video['thumbnail']); ?>" alt="<?php echo htmlspecialchars($video['title']); ?>">
                            </a>
                            <h2><?php echo htmlspecialchars($video['title']); ?></h2>
                            <p><?php echo nl2br(htmlspecialchars($video['description'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>

