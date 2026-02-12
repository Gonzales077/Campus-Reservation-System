<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holy Cross College - Facilities Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --hcc-blue: #1a3a52;
            --hcc-blue-dark: #0f2432;
            --hcc-blue-light: #2d5a7b;
            --hcc-gold: #d4af37;
            --hcc-gold-dark: #b8941f;
            --hcc-red: #ef4444;
            --hcc-red-dark: #dc2626;
            --hcc-gray: #f8fafc;
            --hcc-text: #1e293b;
            --shadow-sm: 0 2px 4px rgba(26, 58, 82, 0.1);
            --shadow-md: 0 4px 12px rgba(26, 58, 82, 0.15);
            --shadow-lg: 0 8px 24px rgba(26, 58, 82, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--hcc-gray);
            color: var(--hcc-text);
            padding-top: 70px;
            line-height: 1.6;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
            box-shadow: var(--shadow-lg);
            padding: 1rem 2rem;
            backdrop-filter: blur(10px);
            border-bottom: 3px solid var(--hcc-gold);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: translateY(-2px);
        }
        
        .navbar-brand i {
            color: var(--hcc-gold);
            font-size: 1.8rem;
            filter: drop-shadow(0 2px 4px rgba(212, 175, 55, 0.3));
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 600;
            padding: 8px 16px !important;
            transition: all 0.3s ease;
            border-radius: 6px;
            margin: 0 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-link:hover {
            color: var(--hcc-gold) !important;
            background-color: rgba(212, 175, 55, 0.2);
            transform: translateY(-2px);
        }
        
        .btn-logout {
            background: linear-gradient(135deg, var(--hcc-red) 0%, var(--hcc-red-dark) 100%) !important;
            color: white !important;
            font-weight: 600 !important;
            padding: 8px 16px !important;
            border-radius: 8px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
            font-size: 0.9rem;
            white-space: nowrap;
        }
        
        .btn-logout:hover {
            background: linear-gradient(135deg, var(--hcc-red-dark) 0%, #b91c1c 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            border-color: rgba(255, 255, 255, 0.4);
        }
        
        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
            color: white;
            font-weight: 600;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--hcc-blue-dark) 0%, var(--hcc-blue) 100%);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: #6C757D;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-danger {
            background-color: #DC3545;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background-color: #C82333;
            transform: translateY(-2px);
        }
        
        .btn-warning {
            background-color: var(--hcc-gold);
            color: var(--hcc-text);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-warning:hover {
            background-color: var(--hcc-gold-dark);
            transform: translateY(-2px);
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }
        
        .alert-success {
            background-color: #D4EDDA;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #F8D7DA;
            color: #721C24;
        }
        
        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            margin-right: 6px;
        }
        
        .table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .table thead {
            background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
            color: white;
        }
        
        .table thead th {
            font-weight: 600;
            border: none;
            padding: 1rem;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--hcc-blue);
            font-weight: 700;
        }

        /* Custom Logout Modal */
        .logout-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 36, 50, 0.85);
            backdrop-filter: blur(8px);
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        .logout-modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-modal {
            background: white;
            border-radius: 20px;
            padding: 0;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(26, 58, 82, 0.4);
            animation: slideUp 0.3s ease;
            overflow: hidden;
        }

        .logout-modal-header {
            background: linear-gradient(135deg, var(--hcc-red) 0%, var(--hcc-red-dark) 100%);
            color: white;
            padding: 24px 32px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logout-modal-header i {
            font-size: 32px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .logout-modal-header h3 {
            margin: 0;
            font-size: 1.5rem;
            color: white;
        }

        .logout-modal-body {
            padding: 32px;
            text-align: center;
        }

        .logout-modal-body p {
            font-size: 1.1rem;
            color: var(--hcc-text);
            margin-bottom: 0;
            line-height: 1.6;
        }

        .logout-modal-footer {
            padding: 24px 32px;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .logout-modal-btn {
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .logout-modal-btn-cancel {
            background: #e2e8f0;
            color: var(--hcc-text);
        }

        .logout-modal-btn-cancel:hover {
            background: #cbd5e1;
            transform: translateY(-1px);
        }

        .logout-modal-btn-confirm {
            background: linear-gradient(135deg, var(--hcc-red) 0%, var(--hcc-red-dark) 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.25);
        }

        .logout-modal-btn-confirm:hover {
            background: linear-gradient(135deg, var(--hcc-red-dark) 0%, #b91c1c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-graduation-cap"></i>
                Holy Cross College
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php if(auth()->user()->isAdmin()): ?> <?php echo e(route('admin.dashboard')); ?> <?php else: ?> <?php echo e(route('user.dashboard')); ?> <?php endif; ?>">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <button class="btn-logout" type="button" onclick="showLogoutModal()">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Logout Confirmation Modal -->
    <div class="logout-modal-overlay" id="logoutModal">
        <div class="logout-modal">
            <div class="logout-modal-header">
                <i class="fas fa-exclamation-circle"></i>
                <h3>Confirm Logout</h3>
            </div>
            <div class="logout-modal-body">
                <p>Are you sure you want to logout from your account?</p>
            </div>
            <div class="logout-modal-footer">
                <button class="logout-modal-btn logout-modal-btn-cancel" onclick="hideLogoutModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form id="logoutForm" action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline; margin:0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="logout-modal-btn logout-modal-btn-confirm">
                        <i class="fas fa-sign-out-alt"></i> Yes, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLogoutModal() {
            document.getElementById('logoutModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function hideLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('logoutModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                hideLogoutModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideLogoutModal();
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\my-project\resources\views/layouts/app.blade.php ENDPATH**/ ?>