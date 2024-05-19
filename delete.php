<?php
session_start();
require 'db.php';

// Pastikan pengguna yang masuk
if (!isset($_SESSION['user_id'])) {
    // Redirect atau kembalikan ke halaman login jika pengguna tidak masuk
    header('Location: login.php');
    exit;
}

// Ambil id video dari URL
$video_id = $_GET['id'];

// Ambil informasi video dari database
$stmt = $pdo->prepare('SELECT * FROM videos WHERE id = ?');
$stmt->execute([$video_id]);
$video = $stmt->fetch();

// Periksa apakah pengguna yang masuk adalah pemilik video yang ingin dihapus
if ($_SESSION['user_id'] == $video['user_id']) {
    // Jika pengguna mengonfirmasi penghapusan
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        // Hapus video dari database dan sistem penyimpanan file
        $stmt = $pdo->prepare('DELETE FROM videos WHERE id = ?');
        $stmt->execute([$video_id]);

        // Redirect atau kembalikan ke halaman yang sesuai setelah penghapusan
        header('Location: index.php');
        exit;
    }

    // Jika pengguna membatalkan penghapusan
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
        // Redirect atau kembali ke halaman tampilan video
        header('Location: view.php?id=' . $video_id);
        exit;
    }

    // Tampilkan halaman konfirmasi penghapusan
    else {
        include 'delete_confirm.php'; // Sertakan file HTML untuk konfirmasi penghapusan
        exit;
    }
} else {
    // Redirect atau kembalikan ke halaman yang sesuai jika pengguna tidak memiliki izin
    header('Location: verifikasi.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploaded Videos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>My Uploaded Videos</h1>
    <a href="upload.php">Upload New Video</a>
    <div class="video-list">
        <?php foreach ($videos as $video): ?>
            <div class="video-item">
                <h2><?php echo htmlspecialchars($video['title']); ?></h2>
                <video controls>
                    <source src="uploads/videos/<?php echo htmlspecialchars($video['filename']); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p><?php echo nl2br(htmlspecialchars($video['description'])); ?></p>
                <small>Uploaded on <?php echo $video['upload_date']; ?></small>
                <form action="delete.php" method="post">
                    <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">
                    <input type="submit" value="Delete">
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
