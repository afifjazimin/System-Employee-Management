<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home - Employee Management System</title>
    <meta name="description" content="Employee Management System for Foundation Polytechnic, Ikot Ekpene." />
    <meta name="keywords" content="employee management system, foundation polytechnic, staff portal" />
    <meta name="author" content="Employee Management System" />

    <link rel="icon" type="image/png" sizes="16x16" href="image/logo.jpeg">
    <link rel="stylesheet" type="text/css" href="css/pe-icon-7.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/owl.theme.default.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/toastr.css">

    <style>
        :root {
            --brand-navy: #0f172a;
            --brand-deep: #12243d;
            --brand-blue: #1d4ed8;
            --brand-cyan: #0f9db5;
            --brand-soft: #e8f1ff;
            --brand-border: rgba(15, 23, 42, 0.08);
            --brand-text: #d9e7ff;
            --surface: #ffffff;
            --surface-soft: #f7faff;
            --shadow-soft: 0 20px 60px rgba(15, 23, 42, 0.12);
            --shadow-card: 0 16px 40px rgba(15, 23, 42, 0.1);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(15, 157, 181, 0.2), transparent 28%),
                radial-gradient(circle at top right, rgba(29, 78, 216, 0.18), transparent 32%),
                linear-gradient(180deg, #f9fcff 0%, #eef5ff 100%);
            color: #213047;
        }

        .navbar-custom {
            padding: 16px 0;
            background: rgba(15, 23, 42, 0.18);
            backdrop-filter: blur(14px);
        }

        .nav-sticky.navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
        }

        .navbar-custom .navbar-nav li a {
            margin: 0 0 0 22px;
            font-size: 14px;
            letter-spacing: 0.02em;
        }

        .hero-shell {
            position: relative;
            overflow: hidden;
            padding: 170px 0 110px;
            background:
                linear-gradient(135deg, rgba(15, 23, 42, 0.94), rgba(18, 36, 61, 0.9)),
                linear-gradient(45deg, #1d4ed8, #0f9db5);
        }

        .hero-shell::before,
        .hero-shell::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
        }

        .hero-shell::before {
            width: 420px;
            height: 420px;
            top: -150px;
            right: -80px;
            background: rgba(96, 165, 250, 0.16);
        }

        .hero-shell::after {
            width: 300px;
            height: 300px;
            left: -100px;
            bottom: -110px;
            background: rgba(45, 212, 191, 0.14);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            color: #f8fbff;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .hero-headline {
            font-size: clamp(2.6rem, 5vw, 4.6rem);
            line-height: 1.08;
            font-weight: 800;
            color: #ffffff;
            margin: 24px 0 20px;
        }

        .hero-copy {
            max-width: 600px;
            font-size: 1.05rem;
            line-height: 1.9;
            color: rgba(255, 255, 255, 0.78);
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 34px;
        }

        .hero-actions .btn {
            border-radius: 999px;
            padding: 14px 28px;
        }

        .hero-actions .btn-outline-light {
            border-width: 2px;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 38px;
        }

        .hero-stat {
            padding: 18px 20px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
        }

        .hero-stat strong {
            display: block;
            margin-bottom: 4px;
            font-size: 1.35rem;
            color: #ffffff;
        }

        .hero-stat span {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.93rem;
        }

        .hero-panel {
            position: relative;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 28px;
            padding: 28px;
            box-shadow: var(--shadow-soft);
        }

        .hero-panel-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }

        .hero-panel h5 {
            font-size: 1.35rem;
            margin-bottom: 8px;
            color: var(--brand-navy);
        }

        .hero-panel p {
            margin-bottom: 0;
            color: #5a6d87;
        }

        .hero-panel-tag {
            padding: 10px 14px;
            border-radius: 14px;
            background: var(--brand-soft);
            color: var(--brand-blue);
            font-weight: 700;
            white-space: nowrap;
        }

        .hero-panel img {
            border-radius: 22px;
            width: 100%;
            height: 260px;
            object-fit: cover;
            box-shadow: var(--shadow-card);
        }

        .feature-section {
            position: relative;
            margin-top: -54px;
            z-index: 2;
        }

        .section-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.75);
            border-radius: 30px;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(10px);
        }

        .quick-link-card {
            height: 100%;
            padding: 28px;
            border: 1px solid var(--brand-border);
            border-radius: 24px;
            background: var(--surface);
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .quick-link-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
            border-color: rgba(29, 78, 216, 0.2);
        }

        .quick-link-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, #dbeafe, #e0f7fa);
            color: var(--brand-blue);
            font-size: 26px;
            margin-bottom: 18px;
        }

        .quick-link-card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--brand-navy);
        }

        .quick-link-card p {
            color: #61748d;
            margin-bottom: 22px;
        }

        .info-section {
            padding: 90px 0 70px;
        }

        .section-intro {
            max-width: 620px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .section-intro .eyebrow {
            display: inline-block;
            margin-bottom: 14px;
            color: var(--brand-blue);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .section-intro h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            color: var(--brand-navy);
            margin-bottom: 14px;
        }

        .section-intro p {
            color: #5f738d;
            margin-bottom: 0;
        }

        .info-card {
            height: 100%;
            padding: 28px;
            border-radius: 26px;
            background: linear-gradient(180deg, #ffffff 0%, #f9fbff 100%);
            border: 1px solid var(--brand-border);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
        }

        .info-card i {
            font-size: 34px;
            color: var(--brand-cyan);
        }

        .info-card h4 {
            margin: 18px 0 12px;
            color: var(--brand-navy);
        }

        .info-card p {
            margin-bottom: 0;
            color: #62758d;
        }

        .cta-strip {
            padding: 36px;
            border-radius: 28px;
            background: linear-gradient(135deg, #11233a, #0f7f98);
            color: #ffffff;
            box-shadow: var(--shadow-soft);
        }

        .cta-strip h3 {
            color: #ffffff;
            margin-bottom: 10px;
        }

        .cta-strip p {
            margin-bottom: 0;
            color: rgba(255, 255, 255, 0.78);
        }

        .cta-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .footer {
            background: #0f172a;
            padding-top: 24px;
        }

        @media (max-width: 991.98px) {
            .hero-shell {
                padding: 145px 0 90px;
            }

            .hero-panel {
                margin-top: 34px;
            }

            .feature-section {
                margin-top: -24px;
            }
        }

        @media (max-width: 767.98px) {
            .navbar-custom {
                background: rgba(255, 255, 255, 0.96) !important;
            }

            .hero-headline {
                font-size: 2.4rem;
            }

            .hero-stats {
                grid-template-columns: 1fr;
            }

            .hero-actions {
                flex-direction: column;
            }

            .hero-actions .btn {
                width: 100%;
                text-align: center;
            }

            .hero-panel {
                padding: 22px;
            }

            .hero-panel-top {
                flex-direction: column;
            }

            .section-card,
            .cta-strip {
                border-radius: 22px;
            }

            .quick-link-card,
            .info-card {
                padding: 24px;
            }

            .cta-actions {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body class="d-flex flex-column">
    <div id="preloader">
        <div id="status">
            <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark nav-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto navbar-center" id="mySidenav">
                    <li class="nav-item active">
                        <a href="#home" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#access" class="nav-link">Access</a>
                    </li>
                    <li class="nav-item">
                        <a href="#overview" class="nav-link">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a href="Account/registration.php" class="nav-link">Register</a>
                    </li>
                    <li class="nav-item">
                        <a href="Employee/index.php" class="nav-link">Employee Portal</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admin/index.php" class="nav-link">Admin Portal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-shell position-relative" id="home">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="hero-badge">
                        <i class="mdi mdi-shield-account-outline"></i>
                        Smart Staff Administration
                    </span>
                    <h1 class="hero-headline">A cleaner, faster way to manage staff records and daily operations.</h1>
                    <p class="hero-copy">
                        This Employee Management System helps Foundation Polytechnic, Ikot Ekpene organize registration, monitor employee activity, and provide a clear route into both staff and admin workspaces.
                    </p>

                    <div class="hero-actions">
                        <a href="Account/registration.php" class="btn btn-light">Register Employee</a>
                        <a href="Employee/index.php" class="btn btn-outline-light">Open Employee Dashboard</a>
                    </div>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <strong>One Portal</strong>
                            <span>Central access for registration and management.</span>
                        </div>
                        <div class="hero-stat">
                            <strong>Secure Flow</strong>
                            <span>Separate routes for employees and administrators.</span>
                        </div>
                        <div class="hero-stat">
                            <strong>Clear UI</strong>
                            <span>Focused navigation for faster daily tasks.</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="hero-panel">
                        <div class="hero-panel-top">
                            <div>
                                <h5>Foundation Polytechnic Case Study</h5>
                                <p>Built to support a more organized approach to employee record handling and institutional workflow.</p>
                            </div>
                            <span class="hero-panel-tag">AKPOLY</span>
                        </div>
                        <img src="images/img1.jpg" alt="Foundation Polytechnic campus preview">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="feature-section" id="access">
        <div class="container">
            <div class="section-card p-4 p-lg-5">
                <div class="row">
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="quick-link-card">
                            <div class="quick-link-icon">
                                <i class="mdi mdi-account-plus-outline"></i>
                            </div>
                            <h3>Employee Registration</h3>
                            <p>Create a staff profile and capture the information needed to begin using the system.</p>
                            <a href="Account/registration.php" class="btn btn-primary btn-sm">Start Registration</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="quick-link-card">
                            <div class="quick-link-icon">
                                <i class="mdi mdi-account-circle-outline"></i>
                            </div>
                            <h3>Employee Dashboard</h3>
                            <p>Enter the employee area to review records, profile details, and personal workflow tools.</p>
                            <a href="Employee/index.php" class="btn btn-primary btn-sm">Open Employee Area</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="quick-link-card">
                            <div class="quick-link-icon">
                                <i class="mdi mdi-monitor-dashboard"></i>
                            </div>
                            <h3>Admin Dashboard</h3>
                            <p>Manage users, monitor activity, and oversee the wider employee administration process.</p>
                            <a href="Admin/index.php" class="btn btn-primary btn-sm">Open Admin Area</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="info-section" id="overview">
        <div class="container">
            <div class="section-intro">
                <span class="eyebrow">Why This Interface Works Better</span>
                <h2>Designed to make the first step obvious for every user.</h2>
                <p>The landing page now highlights the main actions immediately, improves readability, and gives the system a more modern institutional presentation.</p>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="info-card">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <h4>Focused Navigation</h4>
                        <p>Users can move directly to registration, employee access, or admin control without searching around the page.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="info-card">
                        <i class="mdi mdi-layers-outline"></i>
                        <h4>Stronger Visual Hierarchy</h4>
                        <p>The updated spacing, typography, and cards make important actions stand out much more clearly.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="info-card">
                        <i class="mdi mdi-cellphone-link"></i>
                        <h4>Better Mobile Experience</h4>
                        <p>The layout adapts for small screens so the main entry points remain usable on phones and tablets.</p>
                    </div>
                </div>
            </div>

            <div class="cta-strip mt-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <h3>Ready to continue?</h3>
                        <p>Choose the route that matches your role and move straight into the system.</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="cta-actions">
                        <a href="Admin/index.php" class="btn btn-light">Admin Login</a>
                        <a href="Employee/index.php" class="btn btn-outline-light">Employee Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="footer pt-0 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center footer-alt my-1">
                        <p class="f-15 mb-0">
                            <?php include('inc/footer2.php'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/anime.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/site.js"></script>
    <script src="js/general.js"></script>
    <script src="app-assets/vendors/js/toastr.min.js" type="text/javascript"></script>
    <script src="lib/jquery-validation/dist/jquery.validate.js"></script>
</body>
</html>
