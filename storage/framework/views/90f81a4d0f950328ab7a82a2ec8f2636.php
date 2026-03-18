<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holy Cross College - Facilities Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --hcc-blue: #1a3a52;
            --hcc-blue-dark: #0f2432;
            --hcc-blue-light: #2d5a7b;
            --hcc-blue-lighter: #3a6b91;
            --hcc-gold: #d4af37;
            --hcc-gold-dark: #b8941f;
            --hcc-gold-light: #e6c56e;
            --hcc-gold-xlight: #f3e0b5;
            --hcc-red: #ef4444;
            --hcc-red-dark: #dc2626;
            --hcc-success: #10b981;
            --hcc-warning: #f59e0b;
            --hcc-danger: #ef4444;
            --hcc-gray: #f8fafc;
            --hcc-text: #1e293b;
            
            --background-primary: #ffffff;
            --background-secondary: #f8fafc;
            --background-tertiary: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #334155;
            --text-tertiary: #64748b;
            --border-light: #e2e8f0;
            --border-medium: #cbd5e1;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--hcc-blue) 0%, #0f2432 100%);
            color: var(--hcc-text);
            /* Match this to the actual height of the navbar (approx 50px now) */
            padding-top: 50px; 
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
       /* Navbar - Enhanced Profile */
.navbar {
    background: linear-gradient(90deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%);
    padding: 0.8rem 1.5rem !important; /* Increased padding for height */
    min-height: 70px; /* Comfortable height */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    animation: slideDown 0.8s ease;
    border-bottom: 3px solid var(--hcc-gold);
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.4rem; /* Larger brand text */
    color: white !important;
    display: flex;
    align-items: center;
    gap: 12px;
}

.navbar-brand img {
    width: 40px; /* Enlarged logo */
    height: 40px;
    object-fit: contain;
    background: white;
    border-radius: 6px;
    padding: 3px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

.nav-link {
    color: rgba(255, 255, 255, 0.95) !important;
    font-weight: 600; /* Bolder text */
    font-size: 1rem; /* Standard readable size */
    padding: 8px 15px !important;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-link:hover {
    color: var(--hcc-gold-light) !important;
    transform: translateY(-1px);
}

.btn-logout {
    background: linear-gradient(135deg, var(--hcc-red) 0%, var(--hcc-red-dark) 100%) !important;
    color: white !important;
    font-weight: 700 !important;
    padding: 8px 18px !important; /* Larger button */
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-size: 0.9rem;
    white-space: nowrap;
    margin-left: 10px;
    transition: all 0.3s ease;
}

.btn-logout:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Adjust body padding so content doesn't hide under the taller navbar */
body {
    padding-top: 85px; 
}

        /* Rest of the styles... */
        .container-fluid { max-width: 1400px; margin: 0 auto; padding: 1.5rem; }
        .card { border: none; border-radius: 12px; box-shadow: var(--shadow-sm); margin-bottom: 24px; background: white; }
        .card-header { background: linear-gradient(135deg, var(--hcc-blue) 0%, var(--hcc-blue-light) 100%); color: white; font-weight: 600; border-radius: 12px 12px 0 0 !important; padding: 0.8rem 1.2rem; }
        .logout-modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 36, 50, 0.85); backdrop-filter: blur(8px); z-index: 9999; }
        .logout-modal-overlay.active { display: flex; align-items: center; justify-content: center; }
        .logout-modal { background: white; border-radius: 15px; max-width: 400px; width: 90%; overflow: hidden; animation: slideUp 0.3s ease; }
        .logout-modal-header { background: var(--hcc-red); color: white; padding: 1.2rem; display: flex; align-items: center; gap: 12px; }
        .logout-modal-body { padding: 2rem; text-align: center; }
        .logout-modal-footer { padding: 1rem; display: flex; gap: 10px; justify-content: flex-end; background: #f8fafc; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 991.98px) { .navbar { padding: 0.2rem 1rem !important; } .nav-link { justify-content: flex-start; margin: 2px 0; } .btn-logout { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img src="https://amyfoundationph.com/home/wp-content/uploads/2022/07/hcc.gif" alt="HCC Logo">
                Holy Cross College
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard')); ?>">
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
                            <a class="nav-link" href="<?php echo e(route('login')); ?>"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>"><i class="fas fa-user-plus"></i> Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="logout-modal-overlay" id="logoutModal">
        <div class="logout-modal">
            <div class="logout-modal-header">
                <i class="fas fa-exclamation-circle"></i>
                <h5 class="mb-0">Confirm Logout</h5>
            </div>
            <div class="logout-modal-body">
                <p class="mb-0">Are you sure you want to logout?</p>
            </div>
            <div class="logout-modal-footer">
                <button class="btn btn-sm btn-light" onclick="hideLogoutModal()">Cancel</button>
                <form id="logoutForm" action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-danger">Yes, Logout</button>
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
        document.getElementById('logoutModal')?.addEventListener('click', function(e) { if (e.target === this) hideLogoutModal(); });
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') hideLogoutModal(); });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\my-project\resources\views/layouts/app.blade.php ENDPATH**/ ?>