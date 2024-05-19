CREATE TABLE watch_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    video_id INT,
    watched_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
