

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; background: #ffffff;">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <span class="p-3 d-inline-block rounded-circle bg-light">
                                <i class="fas fa-user-shield fa-2x text-primary"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold text-dark">Check your email</h3>
                        <p class="text-muted px-3">
                            To protect your account, we've sent a 6-digit code to your registered Gmail address.
                        </p>
                    </div>

                    <form action="<?php echo e(route('login.otp.verify')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-4">
                            <label for="otp" class="form-label small text-uppercase fw-bold text-muted text-center d-block mb-3">
                                Enter Security Code
                            </label>
                            
                            <input type="text" 
                                   name="otp" 
                                   id="otp" 
                                   class="form-control form-control-lg text-center <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   placeholder="&middot;&middot;&middot;&middot;&middot;&middot;" 
                                   maxlength="6" 
                                   autocomplete="one-time-code"
                                   required 
                                   autofocus>
                            
                            <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback text-center mt-2">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="text-center mb-4">
                            <span class="badge rounded-pill bg-light text-dark py-2 px-3 border">
                                <i class="far fa-clock me-1 text-primary"></i> 
                               Code expires in: <span id="timer" class="fw-bold">01:00</span>
                            </span>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="border-radius: 8px;">
                            Confirm Identity
                        </button>
                    </form>

                    <div class="text-center mt-5">
                        <div id="resend-wait" class="small text-muted">
                            Didn't get the code? Wait <span id="resend-timer" class="fw-bold">30</span>s to resend.
                        </div>
                        <div id="resend-section" class="d-none">
                            <p class="small text-muted mb-1">Didn't receive the code?</p>
                            <a href="<?php echo e(route('login.otp.resend')); ?>" class="text-primary text-decoration-none small fw-bold">
                                <i class="fas fa-paper-plane me-1"></i> Resend code
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?php echo e(route('login')); ?>" class="text-muted text-decoration-none small mx-2">
                    <i class="fas fa-chevron-left me-1"></i> Use another account
                </a>
                <span class="text-muted small">|</span>
                <a href="/" class="text-muted text-decoration-none small mx-2">Help Center</a>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f0f2f5; /* Light gray background like Facebook */
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    #otp {
        letter-spacing: 15px;
        font-size: 2.2rem;
        font-weight: 700;
        border: 2px solid #e4e6eb;
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
    }

    #otp:focus {
        border-color: #1877f2;
        box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
        background-color: #ffffff;
    }

    .btn-primary {
        background-color: #1877f2; /* Professional Blue */
        border: none;
    }

    .btn-primary:hover {
        background-color: #166fe5;
    }

    .bg-light {
        background-color: #f0f2f5 !important;
    }
</style>

<script>
    // 1. Total expiration timer (Changed to 1 minute)
    let expirationTime = 1 * 60; 
    // 2. Resend button cooldown (Changed to 30 seconds)
    let resendCooldown = 30; 

    const timerDisplay = document.getElementById('timer');
    const resendTimerDisplay = document.getElementById('resend-timer');
    const resendSection = document.getElementById('resend-section');
    const resendWait = document.getElementById('resend-wait');

    const countdown = setInterval(function() {
        // Expiration Logic
        let minutes = Math.floor(expirationTime / 60);
        let seconds = expirationTime % 60;
        
        // Display formatting (e.g., 0:59)
        timerDisplay.innerHTML = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        
        // Resend Cooldown Logic
        if (resendCooldown > 0) {
            resendCooldown--;
            resendTimerDisplay.innerHTML = resendCooldown;
        } else {
            resendWait.classList.add('d-none');
            resendSection.classList.remove('d-none');
        }

        // Action when expired
        if (expirationTime <= 0) {
            clearInterval(countdown);
            alert("Security code expired. Please login again.");
            window.location.href = "<?php echo e(route('login')); ?>";
        }
        expirationTime--;
    }, 1000);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\my-project\resources\views/auth/verify-otp.blade.php ENDPATH**/ ?>