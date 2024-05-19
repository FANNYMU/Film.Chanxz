<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Video</title>
</head>
<body>
    <h1>Delete Video</h1>
    <p>Apakah Anda yakin ingin menghapus video ini?</p>
    <form action="delete.php?id=<?php echo $video_id; ?>" method="POST">
        <button type="submit" name="delete">Ya, Hapus</button>
        <button type="submit" name="cancel">Batal</button>
    </form>
</body>
</html>
