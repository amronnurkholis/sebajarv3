<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Sebajar.id — Sewa Baju Fajar</title>


    <!-- =====================================================
         FAVICON
    ====================================================== -->

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/sebajar-logo.png') }}"
    >

    <link
        rel="shortcut icon"
        type="image/png"
        href="{{ asset('images/sebajar-logo.png') }}"
    >


    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        /* =====================================================
           SEBAJAR COLOR PALETTE
        ===================================================== */

        :root {

            --sebajar-black: #111111;

            --sebajar-red: #c9252d;

            --sebajar-red-dark: #a91e25;

            --sebajar-gray: #777777;

            --sebajar-light-gray: #eeeeee;

            --sebajar-border: #dddddd;

            --sebajar-white: #ffffff;

        }


        /* =====================================================
           HTML & BODY
        ===================================================== */

        html,
        body {

            width: 100%;
            min-height: 100%;

        }


        body {

            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                "Helvetica Neue",
                Arial,
                sans-serif;

            min-height: 100vh;
            min-height: 100dvh;

            line-height: 1.5;

            color:
                var(--sebajar-black);

            overflow-x: hidden;

        }


        /* =====================================================
           MAIN BACKGROUND
        ===================================================== */

        .sebajar-login {

            position: relative;

            width: 100%;

            min-height: 100vh;
            min-height: 100dvh;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding:
                50px 6vw;

            background-image:

                linear-gradient(
                    90deg,
                    rgba(0, 0, 0, 0.72) 0%,
                    rgba(0, 0, 0, 0.50) 42%,
                    rgba(0, 0, 0, 0.30) 70%,
                    rgba(0, 0, 0, 0.38) 100%
                ),
                url("{{ asset('images/hero/tari-saman.jpg') }}");

background-size:
                cover;

            background-position:
                center;

            background-repeat:
                no-repeat;

        }


        /* =====================================================
           LEFT BRANDING
        ===================================================== */

        .login-copy {

            position: relative;

            z-index: 2;

            width: 52%;

            max-width: 680px;

            padding-left:
                2vw;

            color:
                var(--sebajar-white);

        }


        .eyebrow {

            margin-bottom:
                16px;

            font-size:
                14px;

            font-weight:
                600;

            letter-spacing:
                0.12em;

            text-transform:
                uppercase;

            color:
                rgba(255, 255, 255, 0.86);

        }


        .login-copy h1 {

            margin-bottom:
                12px;

            font-size:
                clamp(4rem, 7vw, 7rem);

            line-height:
                0.9;

            font-weight:
                700;

            letter-spacing:
                -0.065em;

            text-shadow:
                0 4px 22px rgba(0, 0, 0, 0.30);

        }


        .login-copy h1 span {

            color:
                var(--sebajar-red);

        }


        .login-copy h2 {

            margin-bottom:
                24px;

            font-size:
                clamp(1.5rem, 2.8vw, 2.5rem);

            line-height:
                1.2;

            font-weight:
                500;

            letter-spacing:
                -0.025em;

            color:
                rgba(255, 255, 255, 0.96);

            text-shadow:
                0 3px 15px rgba(0, 0, 0, 0.30);

        }


        .copy-line {

            width:
                65px;

            height:
                4px;

            margin-bottom:
                25px;

            border-radius:
                10px;

            background:
                var(--sebajar-red);

            box-shadow:
                0 4px 15px
                rgba(201, 37, 45, 0.45);

        }


        .login-copy .description {

            max-width:
                500px;

            font-size:
                18px;

            line-height:
                1.7;

            color:
                rgba(255, 255, 255, 0.88);

            text-shadow:
                0 2px 10px rgba(0, 0, 0, 0.35);

        }


        /* =====================================================
           RIGHT LOGIN AREA
        ===================================================== */

        .login-right {

            position: relative;

            z-index: 5;

            width:
                43%;

            display:
                flex;

            justify-content:
                center;

            align-items:
                center;

        }


        /* =====================================================
           AUTH CARD
        ===================================================== */

        .login-card {

            position: relative;

            width:
                100%;

            max-width:
                430px;

            padding:
                38px 40px 34px;

            background:
                rgba(255, 255, 255, 0.93);

            border:
                1px solid
                rgba(255, 255, 255, 0.72);

            border-radius:
                18px;

            box-shadow:

                0 25px 70px
                rgba(0, 0, 0, 0.28),

                0 8px 25px
                rgba(0, 0, 0, 0.15);

            backdrop-filter:
                blur(16px);

            -webkit-backdrop-filter:
                blur(16px);

            overflow:
                hidden;

        }


        /* =====================================================
           AUTH MODE TRANSITION
        ===================================================== */

        .auth-panel {

            width:
                100%;

            opacity:
                1;

            transform:
                translateX(0);

            transition:
                opacity 0.25s ease,
                transform 0.25s ease;

        }


        .auth-panel.switching {

            opacity:
                0;

            transform:
                translateX(18px);

        }


        .auth-panel.register-panel {

            display:
                none;

        }


        /* =====================================================
           HEADER
        ===================================================== */

        .login-header {

            text-align:
                center;

            margin-bottom:
                25px;

        }


        /* =====================================================
           LOGO
        ===================================================== */

        .logo {

            width:
                150px;

            height:
                62px;

            margin:
                0 auto 7px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                transparent;

        }


        .logo img {

            width:
                100%;

            height:
                100%;

            object-fit:
                contain;

            display:
                block;

        }


        /* =====================================================
           HEADER TITLE
        ===================================================== */

        .login-header h2 {

            margin-bottom:
                7px;

            color:
                var(--sebajar-black);

            font-size:
                1.55rem;

            font-weight:
                650;

            line-height:
                1.3;

            letter-spacing:
                -0.025em;

        }


        .login-header p {

            color:
                var(--sebajar-gray);

            font-size:
                14px;

            line-height:
                1.6;

        }


        /* =====================================================
           ALERT
        ===================================================== */

        .alert {

            padding:
                12px 14px;

            margin-bottom:
                20px;

            border-radius:
                8px;

            font-size:
                13px;

            line-height:
                1.5;

        }


        .alert-error {

            color:
                #9d2027;

            background:
                #fff1f1;

            border:
                1px solid #f0c4c7;

        }


        .alert ul {

            padding-left:
                18px;

        }


        /* =====================================================
           INPUT GROUP
        ===================================================== */

        .input-group {

            position:
                relative;

            margin-bottom:
                19px;

        }


        .input-group input {

            width:
                100%;

            height:
                54px;

            padding:
                17px 46px 7px 15px;

            border:
                1px solid #dcdcdc;

            border-radius:
                8px;

            outline:
                none;

            background:
                rgba(255, 255, 255, 0.88);

            color:
                var(--sebajar-black);

            font-size:
                15px;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;

        }


        .input-group input:hover {

            border-color:
                #bcbcbc;

        }


        .input-group input:focus {

            border-color:
                var(--sebajar-red);

            box-shadow:

                0 0 0 3px
                rgba(201, 37, 45, 0.10);

        }


        .input-group input::placeholder {

            color:
                transparent;

        }


        /* =====================================================
           FLOATING LABEL
        ===================================================== */

        .input-group label {

            position:
                absolute;

            left:
                15px;

            top:
                50%;

            transform:
                translateY(-50%);

            color:
                #888888;

            font-size:
                15px;

            pointer-events:
                none;

            transition:
                all 0.2s ease;

            background:
                rgba(255, 255, 255, 0.93);

            padding:
                0 3px;

        }


        .input-group input:focus + label,

        .input-group
        input:not(:placeholder-shown)
        + label {

            top:
                0;

            transform:
                translateY(-50%);

            font-size:
                11px;

            font-weight:
                600;

            color:
                var(--sebajar-red);

        }


        /* =====================================================
           INPUT BORDER
        ===================================================== */

        .input-border {

            position:
                absolute;

            left:
                0;

            bottom:
                0;

            width:
                0;

            height:
                2px;

            border-radius:
                10px;

            background:
                var(--sebajar-red);

            transition:
                width 0.25s ease;

        }


        .input-group
        input:focus
        ~ .input-border {

            width:
                100%;

        }


        /* =====================================================
           PASSWORD TOGGLE
        ===================================================== */

        .password-toggle {

            position:
                absolute;

            right:
                9px;

            top:
                50%;

            transform:
                translateY(-50%);

            width:
                34px;

            height:
                34px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            border:
                none;

            border-radius:
                6px;

            background:
                transparent;

            color:
                #888888;

            cursor:
                pointer;

            font-size:
                16px;

            transition:
                color 0.2s ease,
                background 0.2s ease;

        }


        .password-toggle:hover {

            color:
                var(--sebajar-red);

            background:
                rgba(201, 37, 45, 0.06);

        }


        /* =====================================================
           FORM OPTIONS
        ===================================================== */

        .form-options {

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            margin-bottom:
                21px;

        }


        .checkbox-container {

            display:
                flex;

            align-items:
                center;

            gap:
                8px;

            color:
                #707070;

            font-size:
                13px;

            cursor:
                pointer;

        }


        .checkbox-container input {

            width:
                16px;

            height:
                16px;

            margin:
                0;

            accent-color:
                var(--sebajar-red);

            cursor:
                pointer;

        }


        /* =====================================================
           SUBMIT BUTTON
        ===================================================== */

        .submit-btn {

            width:
                100%;

            min-height:
                50px;

            padding:
                13px 20px;

            border:
                none;

            border-radius:
                8px;

            background:
                var(--sebajar-red);

            color:
                var(--sebajar-white);

            font-size:
                15px;

            font-weight:
                600;

            cursor:
                pointer;

            transition:
                background 0.2s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease;

        }


        .submit-btn:hover {

            background:
                var(--sebajar-red-dark);

            transform:
                translateY(-1px);

            box-shadow:

                0 7px 18px
                rgba(201, 37, 45, 0.30);

        }


        .submit-btn:active {

            transform:
                translateY(0);

        }


        /* =====================================================
           SWITCH AUTH LINK
        ===================================================== */

        .signup-link {

            margin-top:
                19px;

            text-align:
                center;

            color:
                #888888;

            font-size:
                13px;

        }


        .signup-link button {

            padding:
                0;

            border:
                none;

            background:
                transparent;

            color:
                var(--sebajar-red);

            font-family:
                inherit;

            font-size:
                inherit;

            font-weight:
                600;

            cursor:
                pointer;

        }


        .signup-link button:hover {

            text-decoration:
                underline;

        }


        /* =====================================================
           BRAND WATERMARK
        ===================================================== */

        .brand-watermark {

            position:
                absolute;

            left:
                0;

            bottom:
                20px;

            width:
                100%;

            text-align:
                center;

            color:
                rgba(255, 255, 255, 0.45);

            font-size:
                10px;

            letter-spacing:
                0.1em;

            z-index:
                2;

            pointer-events:
                none;

        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 1000px) {

            .sebajar-login {

                padding:
                    40px 4vw;

            }


            .login-copy {

                width:
                    50%;

                padding-left:
                    1vw;

            }


            .login-right {

                width:
                    48%;

            }


            .login-card {

                max-width:
                    410px;

                padding:
                    34px 32px 30px;

            }


            .login-copy h1 {

                font-size:
                    clamp(3.5rem, 7vw, 5rem);

            }

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 768px) {

            .sebajar-login {

                min-height:
                    100dvh;

                padding:
                    30px 18px;

                align-items:
                    flex-end;

                justify-content:
                    center;

                background-position:
                    center center;

                background-image:

                    linear-gradient(
                        rgba(0, 0, 0, 0.48),
                        rgba(0, 0, 0, 0.68)
                    ),

                    url("{{ asset('images/hero/tari-saman.jpg') }}");

            }


            /* =================================================
               MOBILE BRANDING
            ================================================== */

            .login-copy {

                position:
                    absolute;

                top:
                    35px;

                left:
                    0;

                width:
                    100%;

                padding:
                    0 24px;

                text-align:
                    center;

            }


            .eyebrow {

                margin-bottom:
                    8px;

                font-size:
                    10px;

                letter-spacing:
                    0.12em;

            }


            .login-copy h1 {

                margin-bottom:
                    5px;

                font-size:
                    clamp(2.7rem, 13vw, 4.2rem);

            }


            .login-copy h2 {

                margin-bottom:
                    0;

                font-size:
                    1.15rem;

            }


            .copy-line,
            .login-copy .description {

                display:
                    none;

            }


            /* =================================================
               MOBILE CARD
            ================================================== */

            .login-right {

                width:
                    100%;

                padding:
                    0;

                align-items:
                    flex-end;

            }


            .login-card {

                width:
                    100%;

                max-width:
                    500px;

                padding:
                    28px 24px 24px;

                border-radius:
                    18px;

                background:
                    rgba(255, 255, 255, 0.96);

                box-shadow:
                    0 15px 50px
                    rgba(0, 0, 0, 0.30);

            }


            .logo {

                width:
                    125px;

                height:
                    55px;

                margin-bottom:
                    5px;

            }


            .login-header {

                margin-bottom:
                    22px;

            }


            .login-header h2 {

                font-size:
                    1.35rem;

            }


            .login-header p {

                font-size:
                    12px;

            }


            .input-group {

                margin-bottom:
                    17px;

            }


            .input-group input {

                height:
                    52px;

            }


            .form-options {

                margin-bottom:
                    18px;

            }


            .signup-link {

                margin-top:
                    18px;

            }

        }


        /* =====================================================
           VERY SMALL PHONES
        ===================================================== */

        @media (max-width: 380px) {

            .sebajar-login {

                padding:
                    20px 14px;

            }


            .login-copy {

                top:
                    22px;

                padding:
                    0 15px;

            }


            .login-copy h1 {

                font-size:
                    2.5rem;

            }


            .login-copy h2 {

                font-size:
                    1rem;

            }


            .login-card {

                padding:
                    24px 20px 20px;

            }


            .login-header {

                margin-bottom:
                    18px;

            }


            .login-header h2 {

                font-size:
                    1.25rem;

            }

        }

    </style>

</head>


<body>


<div class="sebajar-login">


    <!-- =====================================================
         BRANDING
    ====================================================== -->

    <div class="login-copy">

        <p class="eyebrow">
            Koleksi Busana Tari
        </p>


        <h1>
            Sebajar<span>.id</span>
        </h1>


        <h2>
            Sewa Baju Fajar
        </h2>


        <div class="copy-line"></div>


        <p class="description">

            Sewa baju tari yang kamu butuhkan.
            Temukan koleksi kostum untuk kebutuhan
            pertunjukanmu.

        </p>

    </div>



    <!-- =====================================================
         AUTHENTICATION AREA
    ====================================================== -->

    <section class="login-right">


        <div class="login-card">


            <!-- =================================================
                 LOGIN PANEL
            ================================================== -->

            <div
                class="auth-panel login-panel"
                id="loginPanel"
            >


                <!-- =============================================
                     LOGIN HEADER
                ============================================== -->

                <div class="login-header">


                    <div class="logo">

                        <img
                            src="{{ asset('images/sebajar-logo.png') }}"
                            alt="Sebajar.id"
                        >

                    </div>


                    <h2>
                        Masuk ke Sebajar
                    </h2>


                    <p>
                        Selamat datang kembali.
                        Silakan masuk untuk melanjutkan.
                    </p>


                </div>



                <!-- =============================================
                     SESSION ERROR
                ============================================== -->

                @if(session('error'))

                    <div class="alert alert-error">

                        {{ session('error') }}

                    </div>

                @endif



                <!-- =============================================
                     VALIDATION ERROR
                ============================================== -->

                @if($errors->any())

                    <div class="alert alert-error">

                        <ul>

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                <!-- =============================================
                     LOGIN FORM
                ============================================== -->

                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="login-form"
                >

                    @csrf


                    <!-- NAME -->

                    <div class="input-group">


                        <input
                            type="text"
                            id="login_name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder=" "
                            autocomplete="username"
                            required
                            autofocus
                        >


                        <label for="login_name">
                            Nama
                        </label>


                        <span class="input-border"></span>


                    </div>



                    <!-- PASSWORD -->

                    <div class="input-group">


                        <input
                            type="password"
                            id="login_password"
                            name="password"
                            placeholder=" "
                            autocomplete="current-password"
                            required
                        >


                        <label for="login_password">
                            Password
                        </label>


                        <button
                            type="button"
                            class="password-toggle"
                            data-password-target="login_password"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>


                        <span class="input-border"></span>


                    </div>



                    <!-- REMEMBER -->

                    <div class="form-options">


                        <label class="checkbox-container">


                            <input
                                type="checkbox"
                                name="remember"
                            >


                            <span>
                                Ingat saya
                            </span>


                        </label>


                    </div>



                    <!-- SUBMIT -->

                    <button
                        type="submit"
                        class="submit-btn"
                    >

                        Masuk

                    </button>


                </form>




                <!-- =============================================
                     SWITCH TO REGISTER
                ============================================== -->

                <div class="signup-link">

                    Belum punya akun?

                    <button
                        type="button"
                        id="showRegister"
                    >
                        Daftar sekarang
                    </button>

                </div>


            </div>



            <!-- =================================================
                 REGISTER PANEL
            ================================================== -->

            <div
                class="auth-panel register-panel"
                id="registerPanel"
            >


                <!-- =============================================
                     REGISTER HEADER
                ============================================== -->

                <div class="login-header">


                    <div class="logo">

                        <img
                            src="{{ asset('images/sebajar-logo.png') }}"
                            alt="Sebajar.id"
                        >

                    </div>


                    <h2>
                        Buat Akun Sebajar
                    </h2>


                    <p>
                        Daftar untuk mulai menyewa
                        kostum di Sebajar.
                    </p>


                </div>



                <!-- =============================================
                     REGISTER VALIDATION ERRORS
                ============================================== -->

                @if($errors->any())

                    <div class="alert alert-error">

                        <ul>

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                <!-- =============================================
                     REGISTER FORM
                ============================================== -->

                <form
                    method="POST"
                    action="{{ route('register') }}"
                    class="register-form"
                >

                    @csrf


                    <!-- NAME -->

                    <div class="input-group">


                        <input
                            type="text"
                            id="register_name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder=" "
                            autocomplete="name"
                            required
                        >


                        <label for="register_name">
                            Nama
                        </label>


                        <span class="input-border"></span>


                    </div>



                    <!-- PASSWORD -->

                    <div class="input-group">


                        <input
                            type="password"
                            id="register_password"
                            name="password"
                            placeholder=" "
                            autocomplete="new-password"
                            required
                        >


                        <label for="register_password">
                            Password
                        </label>


                        <button
                            type="button"
                            class="password-toggle"
                            data-password-target="register_password"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>


                        <span class="input-border"></span>


                    </div>



                    <!-- CONFIRM PASSWORD -->

                    <div class="input-group">


                        <input
                            type="password"
                            id="register_password_confirmation"
                            name="password_confirmation"
                            placeholder=" "
                            autocomplete="new-password"
                            required
                        >


                        <label for="register_password_confirmation">
                            Konfirmasi Password
                        </label>


                        <button
                            type="button"
                            class="password-toggle"
                            data-password-target="register_password_confirmation"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>


                        <span class="input-border"></span>


                    </div>



                    <!-- SUBMIT -->

                    <button
                        type="submit"
                        class="submit-btn"
                    >

                        Daftar

                    </button>


                </form>






                <!-- =============================================
                     SWITCH TO LOGIN
                ============================================== -->

                <div class="signup-link">

                    Sudah punya akun?

                    <button
                        type="button"
                        id="showLogin"
                    >
                        Masuk sekarang
                    </button>

                </div>


            </div>


        </div>


    </section>



    <!-- =====================================================
         WATERMARK
    ====================================================== -->

    <div class="brand-watermark">

        SEBAJAR.ID • SEWA BAJU FAJAR

    </div>


</div>



<!-- =========================================================
     JAVASCRIPT
========================================================== -->

<script>


    /* =========================================================
       PASSWORD TOGGLE
    ========================================================= */

    const passwordToggleButtons =
        document.querySelectorAll(
            '.password-toggle'
        );


    passwordToggleButtons.forEach(
        function(button) {


            button.addEventListener(
                'click',
                function() {


                    const targetId =
                        button.getAttribute(
                            'data-password-target'
                        );


                    const passwordInput =
                        document.getElementById(
                            targetId
                        );


                    if (!passwordInput) {
                        return;
                    }


                    if (
                        passwordInput.type ===
                        'password'
                    ) {

                        passwordInput.type =
                            'text';

                        button.textContent =
                            '🙈';

                        button.setAttribute(
                            'aria-label',
                            'Sembunyikan password'
                        );


                    } else {

                        passwordInput.type =
                            'password';

                        button.textContent =
                            '👁';

                        button.setAttribute(
                            'aria-label',
                            'Tampilkan password'
                        );

                    }

                }
            );

        }
    );



    /* =========================================================
       LOGIN <-> REGISTER
    ========================================================= */

    const loginPanel =
        document.getElementById(
            'loginPanel'
        );


    const registerPanel =
        document.getElementById(
            'registerPanel'
        );


    const showRegister =
        document.getElementById(
            'showRegister'
        );


    const showLogin =
        document.getElementById(
            'showLogin'
        );



    function switchToRegister() {

        if (!loginPanel || !registerPanel) {
            return;
        }


        loginPanel.classList.add(
            'switching'
        );


        setTimeout(
            function() {


                loginPanel.style.display =
                    'none';


                registerPanel.style.display =
                    'block';


                registerPanel.classList.add(
                    'switching'
                );


                void registerPanel.offsetWidth;


                registerPanel.classList.remove(
                    'switching'
                );


            },
            250
        );

    }



    function switchToLogin() {

        if (!loginPanel || !registerPanel) {
            return;
        }


        registerPanel.classList.add(
            'switching'
        );


        setTimeout(
            function() {


                registerPanel.style.display =
                    'none';


                loginPanel.style.display =
                    'block';


                loginPanel.classList.add(
                    'switching'
                );


                void loginPanel.offsetWidth;


                loginPanel.classList.remove(
                    'switching'
                );


            },
            250
        );

    }



    if (showRegister) {

        showRegister.addEventListener(
            'click',
            switchToRegister
        );

    }


    if (showLogin) {

        showLogin.addEventListener(
            'click',
            switchToLogin
        );

    }


</script>


@include('partials.toast')
</body>

</html>
