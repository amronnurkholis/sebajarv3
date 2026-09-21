
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sebajar.id — Daftar</title>

    <meta
        name="description"
        content="Daftar akun Sebajar.id — Sewa Baju Fajar"
    >

    <link
        rel="stylesheet"
        href="<?php echo e(asset('assets/modern-saas/style.css')); ?>"
    >
</head>


<body>

<div class="page">


    <!-- =========================
         LEFT SIDE
    ========================== -->

    <div class="left">

        <div class="brand">

            <a href="/" class="logo">
                Sebajar<span>.</span>
            </a>

        </div>


        <div class="content">

            <h1>
                Bergabung dengan
                <span>Sebajar.id</span>
            </h1>


            <p class="subtitle">

                Buat akun untuk menemukan dan menyewa
                kostum tari yang kamu butuhkan.

            </p>


            <div class="features">


                <div class="feature">

                    <div class="icon">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Koleksi Kostum
                        </strong>

                        <p>
                            Temukan berbagai pilihan kostum tari.
                        </p>

                    </div>

                </div>


                <div class="feature">

                    <div class="icon">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Akun Pribadi
                        </strong>

                        <p>
                            Kelola kebutuhan penyewaan kamu dengan mudah.
                        </p>

                    </div>

                </div>


                <div class="feature">

                    <div class="icon">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Mudah Digunakan
                        </strong>

                        <p>
                            Daftar dan mulai menjelajahi Sebajar.id.
                        </p>

                    </div>

                </div>


            </div>

        </div>

    </div>



    <!-- =========================
         RIGHT SIDE
    ========================== -->

    <div class="right">

        <div class="form-container">


            <!-- HEADER -->

            <div class="form-header">

                <h2>
                    Buat Akun
                </h2>

                <p>
                    Daftar sebagai pengguna Sebajar.id.
                </p>

            </div>



            <!-- VALIDATION ERROR -->

            <?php if($errors->any()): ?>

                <div class="alert alert-error">

                    <ul>

                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <li>
                                <?php echo e($error); ?>

                            </li>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>

                </div>

            <?php endif; ?>



            <!-- REGISTER FORM -->

            <form
                method="POST"
                action="<?php echo e(route('register.store')); ?>"
                class="login-form"
            >

                <?php echo csrf_field(); ?>


                <!-- NAME -->

                <div class="form-group">

                    <label for="name">
                        Nama
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?php echo e(old('name')); ?>"
                        placeholder="Masukkan nama kamu"
                        autocomplete="name"
                        required
                        autofocus
                    >

                </div>



                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 6 karakter"
                        autocomplete="new-password"
                        required
                    >

                </div>



                <!-- CONFIRM PASSWORD -->

                <div class="form-group">

                    <label for="password_confirmation">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Masukkan password kembali"
                        autocomplete="new-password"
                        required
                    >

                </div>



                <!-- REGISTER BUTTON -->

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Daftar
                </button>

            </form>



            <!-- DIVIDER -->

            <div class="divider">

                <span>
                    atau
                </span>

            </div>



            <!-- GOOGLE -->

            <a
                href="#"
                class="btn btn-google"
                onclick="return false;"
            >

                <svg
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >

                    <path
                        fill="#4285F4"
                        d="M21.35 12.27c0-.78-.07-1.53-.22-2.25H12v4.26h5.22a4.46 4.46 0 0 1-1.94 2.93v2.44h3.14c1.84-1.69 2.93-4.18 2.93-7.38z"
                    />

                    <path
                        fill="#34A853"
                        d="M12 21.75c2.63 0 4.84-.87 6.45-2.36l-3.14-2.44c-.87.58-1.98.93-3.31.93-2.54 0-4.69-1.72-5.46-4.03H3.3v2.52A9.75 9.75 0 0 0 12 21.75z"
                    />

                    <path
                        fill="#FBBC05"
                        d="M6.54 13.85a5.86 5.86 0 0 1 0-3.7V7.63H3.3a9.75 9.75 0 0 0 0 8.74l3.24-2.52z"
                    />

                    <path
                        fill="#EA4335"
                        d="M12 6.12c1.43 0 2.71.49 3.72 1.45l2.79-2.79C16.84 3.15 14.63 2.25 12 2.25a9.75 9.75 0 0 0-8.7 5.38l3.24 2.52C6.54 7.84 8.69 6.12 12 6.12z"
                    />

                </svg>


                <span>
                    Daftar dengan Google
                </span>

            </a>



            <!-- LOGIN LINK -->

            <div class="register-link">

                <p>

                    Sudah punya akun?

                    <a href="<?php echo e(route('login')); ?>">
                        Masuk sekarang
                    </a>

                </p>

            </div>


        </div>

    </div>

</div>


<script
    src="<?php echo e(asset('assets/modern-saas/script.js')); ?>"
></script>

<?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html>

<?php /**PATH /home/ophelia/Publik/sebajarv3/resources/views/register.blade.php ENDPATH**/ ?>