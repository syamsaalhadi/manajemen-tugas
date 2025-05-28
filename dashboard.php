<?php
session_start();
include('config/db.php');

// Cek session lengkap
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id']; // ✅ ambil user_id

// ✅ Ambil tugas milik user ini aja
$query = "SELECT * FROM tugas WHERE user_id = '$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$task_count = mysqli_num_rows($result);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyberpunk Task Dashboard</title>
    <meta name="description" content="Advanced Task Management System">
    

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@300;400;500;700;900&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    
   
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    

    <style>

        .welcome-section {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .user-greeting {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #00ffff, #ff00ff, #00ff41);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: colorShift 3s ease-in-out infinite;
        }
        
        @keyframes colorShift {
            0%, 100% { filter: hue-rotate(0deg); }
            50% { filter: hue-rotate(180deg); }
        }
        
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 2rem 0;
            flex-wrap: wrap;
        }
        
        .stat-item {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 1rem 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 255, 255, 0.1);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 900;
            color: var(--neon-cyan);
            display: block;
            text-shadow: 0 0 10px currentColor;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem 0 1rem 0;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .section-title {
            font-size: 1.8rem;
            color: var(--neon-cyan);
            margin: 0;
        }
        
        /* Enhanced empty state */
        .empty-state {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 2px dashed var(--glass-border);
            border-radius: 20px;
            padding: 4rem 2rem;
            text-align: center;
            margin: 2rem 0;
        }
        
        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        /* Floating action button */
        .fab {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--neon-pink), var(--neon-purple));
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(255, 0, 255, 0.4);
            transition: var(--transition);
            z-index: 1000;
        }
        
        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(255, 0, 255, 0.6);
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .stats-bar {
                gap: 1rem;
            }
            
            .stat-item {
                padding: 0.8rem 1.5rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .section-header {
                flex-direction: column;
                text-align: center;
            }
            
            .fab {
                bottom: 1rem;
                right: 1rem;
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1>CYBERPUNK TASK MANAGER</h1>
            <div class="user-greeting">
                Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            </div>
            <p style="color: rgba(255,255,255,0.7); font-family: 'Share Tech Mono', monospace;">
                System Online • All functions operational
            </p>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-number"><?php echo $task_count; ?></span>
                <span class="stat-label">Total Tasks</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">⚡</span>
                <span class="stat-label">Active</span>
            </div>
        </div>

        <!-- Action Links -->
        <div class="action-links">
            <a href="tugas/tambah.php" class="btn">
                ➕ Tambah Tugas Baru
            </a>
            <a href="auth/logout.php" class="btn" style="background: linear-gradient(45deg, #ff3333, #cc0000);">
                🚪 Logout
            </a>
        </div>

        <!-- Section Header -->
        <div class="section-header">
            <h2 class="section-title">📋 Daftar Tugas</h2>
        </div>

        <?php if ($task_count > 0): ?>
            <!-- Tasks Grid Layout -->
            <div class="tasks-grid">
                <?php 
                $no = 1; 
                while ($tugas = mysqli_fetch_assoc($result)): 
                ?>
                <div class="task-card">
                    <div class="task-number"><?php echo $no++; ?></div>
                    
                    <div class="task-title">
                        <?php echo htmlspecialchars($tugas['nama_tugas']); ?>
                    </div>
                    
                    <div class="task-description">
                        <?php 
                        $desc = htmlspecialchars($tugas['deskripsi']);
                        echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc;
                        ?>
                    </div>
                    
                    <div class="task-actions">
                        <a href="tugas/edit.php?id=<?php echo $tugas['id']; ?>" class="edit-btn">
                            ✏️ Edit
                        </a>
                        <a href="tugas/hapus.php?id=<?php echo $tugas['id']; ?>" 
                           class="delete-btn"
                           onclick="return confirm('⚠️ Yakin ingin menghapus tugas ini?\n\nTugas: <?php echo htmlspecialchars($tugas['nama_tugas']); ?>')">
                            🗑️ Hapus
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">📝</div>
                <h3>Belum Ada Tugas</h3>
                <p>Mulai produktivitas cyberpunk Anda dengan menambahkan tugas pertama!</p>
                <br>
                <a href="tugas/tambah.php" class="btn">
                    🚀 Buat Tugas Pertama
                </a>
            </div>
        <?php endif; ?>

        <!-- Fallback Table for Accessibility -->
        <details style="margin-top: 2rem;">
            <summary style="cursor: pointer; color: var(--neon-cyan); font-weight: bold;">
                📊 Tampilan Tabel (Alternatif)
            </summary>
            <table style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tugas</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Reset result pointer
                    mysqli_data_seek($result, 0);
                    $no = 1; 
                    while ($tugas = mysqli_fetch_assoc($result)): 
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($tugas['nama_tugas']); ?></td>
                        <td><?php echo htmlspecialchars($tugas['deskripsi']); ?></td>
                        <td>
                            <a href="tugas/edit.php?id=<?php echo $tugas['id']; ?>">Edit</a> | 
                            <a href="tugas/hapus.php?id=<?php echo $tugas['id']; ?>" 
                               onclick="return confirm('Yakin ingin menghapus tugas ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </details>
    </div>

    <!-- Floating Action Button -->
    <button class="fab" onclick="window.location.href='tugas/tambah.php'" title="Tambah Tugas">
        ➕
    </button>

    <!-- Add some JavaScript for enhanced interactions -->
    <script>
        // Enhanced hover effects
        document.querySelectorAll('.task-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Smooth scroll for better UX
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add loading states
        document.querySelectorAll('.btn, .task-actions a').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('delete-btn')) {
                    this.innerHTML = '<span class="loading"></span> Loading...';
                }
            });
        });

        // Welcome animation
        window.addEventListener('load', function() {
            document.querySelector('.welcome-section').style.animation = 'fadeInUp 1s ease-out';
            document.querySelector('.container').style.opacity = '1';
        });
    </script>
</body>
</html>