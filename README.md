pakai database mysql
-- Tabel Pengguna
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Tugas
CREATE TABLE tugas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_tugas VARCHAR(200),
    deskripsi TEXT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
