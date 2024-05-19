<?php
session_start();

// Pastikan pengguna yang masuk
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

// Ambil ID pengguna yang masuk dari sesi
$user_id = $_SESSION['user_id'];

// Query untuk mengambil riwayat tontonan pengguna
$sql = "SELECT videos.id AS video_id, videos.title, videos.description, videos.filename, videos.thumbnail, watch_history.watched_at
        FROM watch_history
        JOIN videos ON watch_history.video_id = videos.id
        WHERE watch_history.user_id = ?
        ORDER BY watch_history.watched_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$watch_history = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch History</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <h1>Watch History</h1>
    <?php if (empty($watch_history)): ?>
        <p>No videos watched yet.</p>
    <?php else: ?>
        <div class="video-list">
            <?php foreach ($watch_history as $history): ?>
                <div class="video-item">
                    <a href="view.php?id=<?php echo $history['video_id']; ?>">
                        <img src="uploads/thumbnails/<?php echo htmlspecialchars($history['thumbnail']); ?>" alt="<?php echo htmlspecialchars($history['title']); ?>">
                    </a>
                    <h2><?php echo htmlspecialchars($history['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($history['description'])); ?></p>
                    <p>Watched at: <?php echo htmlspecialchars($history['watched_at']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
