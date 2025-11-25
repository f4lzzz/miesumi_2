<?php
include "connection.php";

$success = "";
$error = "";

// Ketika admin submit
if (isset($_POST['konfirmasi'])) {
    $input = strtolower(trim($_POST['konfirmasi']));

    if ($input === "reset") {
        // Hapus semua tabel
        mysqli_query($conn, "DELETE FROM riwayat_pemesanan");
        mysqli_query($conn, "DELETE FROM detail_pendapatan");
        mysqli_query($conn, "DELETE FROM rekap_pendapatan");

        // Notifikasi sukses
        $success = "Semua data berhasil direset!";
    } else {
        $error = "Kata kunci salah! Ketik 'reset' untuk menghapus.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Pendapatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #FEA116;
            --primary-dark: #e55c00;
            --secondary: #0F172B;
            --accent: #4CAF50;
            --danger: #f44336;
            --warning: #ff9800;
            --info: #2196F3;
            --light: #F1F8FF;
            --dark: #0F172B;
            --gray: #6c757d;
            --gray-light: #e9ecef;
            --border-radius: 10px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, var(--light) 0%, #ffffff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            background: white;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-danger {
            background: linear-gradient(45deg, var(--danger), #d32f2f);
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 30px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-danger:hover {
            background: linear-gradient(45deg, #d32f2f, var(--danger));
            transform: scale(1.05);
        }

        .btn-secondary {
            background: linear-gradient(45deg, var(--gray), #5a6268);
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 30px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: linear-gradient(45deg, #5a6268, var(--gray));
            transform: scale(1.05);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 30px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary));
            transform: scale(1.05);
        }

        .form-control {
            border: 2px solid var(--gray-light);
            border-radius: var(--border-radius);
            padding: 12px 15px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(254, 161, 22, 0.25);
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(45deg, var(--accent), #45a049);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(45deg, var(--danger), #d32f2f);
            color: white;
        }

        .warning-icon {
            font-size: 3rem;
            color: var(--warning);
            margin-bottom: 1rem;
        }

        .list-group-item {
            border: none;
            padding: 10px 15px;
            background: var(--gray-light);
            margin: 5px 0;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .list-group-item:hover {
            background: var(--primary);
            color: white;
            transform: translateX(5px);
        }

        /* Animasi kustom */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.6s ease-out;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .card {
                margin: 10px;
                padding: 20px;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .btn-group {
                display: flex;
                flex-direction: column;
            }
            
            h3 {
                font-size: 1.5rem;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .card {
                padding: 15px;
            }
            
            .warning-icon {
                font-size: 2.5rem;
            }
            
            .list-group-item {
                font-size: 0.9rem;
            }
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-4 mt-md-5">
    <div class="card shadow p-3 p-md-4 animate__animated animate__fadeInUp">
        <div class="text-center warning-icon animate__animated animate__pulse animate__infinite">
            ⚠️
        </div>
        <h3 class="text-danger text-center fw-bold animate-slide-in">Konfirmasi Reset Pendapatan</h3>

        <?php if ($success): ?>
            <div class="alert alert-success mt-3 animate__animated animate__bounceIn">
                <div class="d-flex align-items-center">
                    <span class="me-2">✅</span>
                    <span><?= $success ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger mt-3 animate__animated animate__shakeX">
                <div class="d-flex align-items-center">
                    <span class="me-2">❌</span>
                    <span><?= $error ?></span>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-4 animate-slide-in">
            <p class="fw-semibold">
                ❗ <strong>Peringatan:</strong> Aksi ini akan menghapus:
            </p>
            <div class="list-group">
                <div class="list-group-item">
                    📊 Seluruh data <strong>Riwayat Pemesanan</strong>
                </div>
                <div class="list-group-item">
                    💰 Seluruh data <strong>Detail Pendapatan</strong>
                </div>
                <div class="list-group-item">
                    📈 Seluruh data <strong>Rekap Pendapatan</strong>
                </div>
            </div>
        </div>

        <p class="text-danger fw-bold mt-3 animate__animated animate__pulse">🚨 Tindakan ini tidak dapat dibatalkan!</p>

        <?php if (!$success): ?>
        <form method="POST" id="resetForm" class="animate-slide-in">
            <div class="mb-3">
                <label class="form-label fw-semibold">Ketik <strong class="text-danger">"reset"</strong> untuk melanjutkan:</label>
                <input type="text" name="konfirmasi" class="form-control" id="confirmInput" required 
                       placeholder="Ketik reset disini...">
                <div class="form-text text-muted">Pastikan Anda benar-benar yakin dengan tindakan ini.</div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end btn-group">
                <button class="btn btn-secondary flex-fill" type="button" onclick="goBack()">
                    <span class="me-2">←</span>Batal
                </button>
                <button class="btn btn-danger flex-fill" type="button" id="submitBtn" onclick="confirmReset()">
                    <span class="me-2">🗑️</span>Hapus Semua Data
                </button>
            </div>
        </form>
        <?php else: ?>
            <!-- Jika berhasil reset, tombol kembali saja -->
            <div class="text-center mt-4 animate__animated animate__fadeIn">
                <a href="rekap_pendapatan.php" class="btn btn-primary px-5">
                    <span class="me-2">←</span>Kembali ke Rekap Pendapatan
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function goBack() {
        window.history.back();
    }

    function confirmReset() {
        const input = document.getElementById('confirmInput');
        const submitBtn = document.getElementById('submitBtn');
        
        if (input.value.toLowerCase().trim() === 'reset') {
            if (confirm('🚨 KONFIRMASI AKHIR!\n\nApakah Anda YAKIN ingin menghapus SEMUA data pendapatan?\n\nTindakan ini TIDAK DAPAT DIBATALKAN!')) {
                // Tampilkan loading
                submitBtn.innerHTML = '<div class="loading"></div> Memproses...';
                submitBtn.disabled = true;
                
                // Submit form setelah konfirmasi
                setTimeout(() => {
                    document.getElementById('resetForm').submit();
                }, 1000);
            }
        } else {
            // Animasi shake untuk input yang salah
            input.classList.add('animate__animated', 'animate__shakeX');
            setTimeout(() => {
                input.classList.remove('animate__animated', 'animate__shakeX');
            }, 1000);
            
            input.focus();
        }
    }

    // Animasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });

    // Real-time validation
    document.getElementById('confirmInput').addEventListener('input', function(e) {
        const value = e.target.value.toLowerCase().trim();
        const submitBtn = document.getElementById('submitBtn');
        
        if (value === 'reset') {
            e.target.style.borderColor = 'var(--accent)';
            e.target.style.background = 'rgba(76, 175, 80, 0.1)';
        } else {
            e.target.style.borderColor = 'var(--danger)';
            e.target.style.background = 'rgba(244, 67, 54, 0.1)';
        }
    });
</script>

</body>
</html>