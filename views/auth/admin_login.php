<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Admin Login' ?> — Employee Workforce and Payroll Management System</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4338ca;
            --primary-light: #6366f1;
            --primary-soft: #eef2ff;
            --accent: #f59e0b;
            --accent-soft: #fef3c7;
            --emerald: #10b981;
            --emerald-soft: #ecfdf5;
            --rose: #ef4444;
            --rose-soft: #fef2f2;
            
            --bg-body: #090d16;
            --bg-card: #ffffff;
            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --border-focus: #4f46e5;
            
            --shadow-card: 0 25px 60px -15px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.08);
            --shadow-input-focus: 0 0 0 4px rgba(99, 102, 241, 0.18);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow-x: hidden;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.25) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.2) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(15, 23, 42, 0.9) 0px, transparent 70%);
            background-attachment: fixed;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Ambient Glow Orbs */
        .glow-orb-1 {
            position: absolute;
            top: -120px;
            left: -120px;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            filter: blur(40px);
        }

        .glow-orb-2 {
            position: absolute;
            bottom: -120px;
            right: -120px;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, rgba(139, 92, 246, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            filter: blur(40px);
        }

        /* Main Container */
        .auth-container {
            width: 100%;
            max-width: 1060px;
            background: var(--bg-card);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: var(--shadow-card);
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            position: relative;
            z-index: 10;
            animation: fadeInScale 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        /* Left Side: Showcase Banner */
        .auth-showcase {
            background: linear-gradient(145deg, #1e1b4b 0%, #0f172a 60%, #1e1b4b 100%);
            padding: 3.5rem;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .auth-showcase::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.35) 0%, transparent 60%),
                radial-gradient(circle at 80% 80%, rgba(168, 85, 247, 0.25) 0%, transparent 60%);
            pointer-events: none;
        }

        .showcase-top {
            position: relative;
            z-index: 2;
        }

        .brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            margin-bottom: 2.5rem;
        }

        .brand-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: linear-gradient(135deg, #6366f1, #4338ca);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .brand-icon-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-text-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
        }

        .brand-text-title span {
            color: #818cf8;
        }

        .brand-text-sub {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #94a3b8;
            font-weight: 700;
        }

        .showcase-heading {
            font-size: 2.4rem;
            line-height: 1.18;
            font-weight: 800;
            margin-bottom: 1.2rem;
            letter-spacing: -0.5px;
        }

        .showcase-heading span {
            background: linear-gradient(135deg, #a5b4fc 0%, #e0e7ff 50%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .showcase-desc {
            font-size: 0.98rem;
            color: #cbd5e1;
            line-height: 1.65;
            margin-bottom: 2.5rem;
        }

        /* Feature Cards */
        .feature-bullets {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            position: relative;
            z-index: 2;
        }

        .bullet-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 0.9rem 1.2rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .bullet-item:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(99, 102, 241, 0.4);
            transform: translateX(4px);
        }

        .bullet-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(99, 102, 241, 0.25);
            color: #a5b4fc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .bullet-text h5 {
            font-size: 0.92rem;
            font-weight: 700;
            color: #ffffff;
        }

        .bullet-text p {
            font-size: 0.76rem;
            color: #94a3b8;
        }

        .showcase-bottom {
            position: relative;
            z-index: 2;
            padding-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .live-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            color: #cbd5e1;
            font-weight: 600;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--emerald);
            box-shadow: 0 0 10px var(--emerald);
        }

        /* Right Side: Login Form */
        .auth-form-side {
            padding: 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.9rem;
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 50px;
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 1rem;
        }

        .form-title {
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--text-heading);
            letter-spacing: -0.5px;
            margin-bottom: 0.4rem;
        }

        .form-subtitle {
            font-size: 0.92rem;
            color: var(--text-muted);
        }

        /* Alerts */
        .alert-error {
            background: var(--rose-soft);
            border: 1px solid #fecdd3;
            color: #9f1239;
            padding: 0.85rem 1.1rem;
            border-radius: 14px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            animation: shake 0.5s ease-in-out;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 1.35rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-heading);
            margin-bottom: 0.5rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1.1rem;
            color: #94a3b8;
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.95rem 1.1rem 0.95rem 2.9rem;
            border: 1.5px solid var(--border-light);
            border-radius: 14px;
            background: #f8fafc;
            color: var(--text-heading);
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input:focus {
            outline: none;
            background: #ffffff;
            border-color: var(--border-focus);
            box-shadow: var(--shadow-input-focus);
        }

        .form-input:focus + .input-icon,
        .input-wrap:focus-within .input-icon {
            color: var(--primary);
        }

        .toggle-pwd {
            position: absolute;
            right: 1.1rem;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .toggle-pwd:hover {
            color: var(--primary);
        }

        /* Row options */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.8rem;
            font-size: 0.85rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: var(--text-body);
            font-weight: 500;
            user-select: none;
        }

        .checkbox-label input {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .security-note {
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1rem 1.5rem;
            background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #7c3aed 100%);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(79, 70, 229, 0.45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Footer switchers */
        .auth-footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            text-align: center;
            font-size: 0.85rem;
        }

        .switch-link {
            color: var(--text-body);
            font-weight: 500;
        }

        .switch-link a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            margin-left: 0.3rem;
            transition: color 0.2s ease;
        }

        .switch-link a:hover {
            color: #3730a3;
            text-decoration: underline;
        }

        .home-link {
            color: #94a3b8;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: color 0.2s ease;
        }

        .home-link:hover {
            color: var(--text-heading);
        }

        /* Animations */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.96) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 520px;
            }
            .auth-showcase {
                display: none; /* Mobile view prioritizes clean login */
            }
            .auth-form-side {
                padding: 2.8rem 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="glow-orb-1"></div>
    <div class="glow-orb-2"></div>

    <div class="auth-container">
        
        <!-- Left Side: System Showcase -->
        <div class="auth-showcase">
            <div class="showcase-top">
                <a href="/payrollsystem/" class="brand-pill">
                    <div class="brand-icon-box">
                        <img src="/payrollsystem/assets/img/system_brand_badge.jpg" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=HR&background=4f46e5&color=fff'">
                    </div>
                    <div>
                        <div class="brand-text-title">HR<span>Portal</span></div>
                        <div class="brand-text-sub">Administration</div>
                    </div>
                </a>

                <h2 class="showcase-heading">
                    Executive Control & <span>Payroll Oversight</span>
                </h2>
                
                <p class="showcase-desc">
                    Comprehensive administration dashboard to verify daily attendance logs, execute monthly salary runs, and manage organizational rules with precision.
                </p>

                <div class="feature-bullets">
                    <div class="bullet-item">
                        <div class="bullet-icon"><i class="fa-solid fa-user-shield"></i></div>
                        <div class="bullet-text">
                            <h5>High-Security Access</h5>
                            <p>Encrypted session control and role authorization</p>
                        </div>
                    </div>

                    <div class="bullet-item">
                        <div class="bullet-icon"><i class="fa-solid fa-calculator"></i></div>
                        <div class="bullet-text">
                            <h5>Automated Payroll Processing</h5>
                            <p>One-click bulk salary calculation and slip generation</p>
                        </div>
                    </div>

                    <div class="bullet-item">
                        <div class="bullet-icon"><i class="fa-solid fa-calendar-check"></i></div>
                        <div class="bullet-text">
                            <h5>Leave & Overtime Approvals</h5>
                            <p>Review staff attendance exceptions in real time</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="showcase-bottom">
                <div class="live-status">
                    <div class="pulse-dot"></div>
                    <span>Administrator Console Active</span>
                </div>
                <span style="font-size: 0.75rem; color: #64748b; font-weight: 600;">TLS 1.3 Encrypted</span>
            </div>
        </div>

        <!-- Right Side: Administrator Sign In Form -->
        <div class="auth-form-side">
            <div class="form-header">
                <div class="security-badge">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Restricted Access</span>
                </div>
                <h1 class="form-title">Admin Sign In</h1>
                <p class="form-subtitle">Enter your administrative credentials to access portal control.</p>
            </div>

            <?php if(isset($data['error'])): ?>
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem;"></i>
                    <span><?= htmlspecialchars($data['error']) ?></span>
                </div>
            <?php endif; ?>

            <form action="/payrollsystem/auth/admin_login" method="POST" id="adminForm">
                <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">

                <div class="form-group">
                    <label for="adminEmail" class="form-label">Administrator Email</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input type="email" name="email" id="adminEmail" class="form-input" placeholder="admin@company.com" required autofocus autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="adminPassword" class="form-label">Security Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" name="password" id="adminPassword" class="form-input" placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" id="togglePassword" class="toggle-pwd" aria-label="Toggle password visibility">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" id="rememberMe">
                        <span>Keep session active</span>
                    </label>
                    
                    <!-- Notice: Strictly NO Forgot Password Link for Admin -->
                    <span class="security-note">
                        <i class="fa-solid fa-lock-keyhole"></i>
                        <span>System Audited</span>
                    </span>
                </div>

                <button type="submit" id="submitBtn" class="btn-submit">
                    <span>AUTHENTICATE & ENTER</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="auth-footer">
                <div class="switch-link">
                    Staff member?
                    <a href="/payrollsystem/auth/employee">Switch to Employee Workspace &rarr;</a>
                </div>
                <div>
                    <a href="/payrollsystem/" class="home-link">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Back to Home Overview</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Password toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('adminPassword');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('fa-eye', !isPassword);
            eyeIcon.classList.toggle('fa-eye-slash', isPassword);
        });

        // Form submit loading
        document.getElementById('adminForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i><span>Authorizing Access...</span>';
            btn.style.opacity = '0.85';
            btn.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>
