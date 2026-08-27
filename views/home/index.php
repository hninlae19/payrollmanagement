<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Home' ?> — Employee Workforce and Payroll Management System</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --primary-soft: #eef2ff;
            --secondary: #0284c7;
            --secondary-light: #38bdf8;
            --secondary-soft: #e0f2fe;
            --accent: #f59e0b;
            --accent-soft: #fef3c7;
            --emerald: #10b981;
            --emerald-soft: #ecfdf5;
            --rose: #f43f5e;
            --rose-soft: #fff1f2;
            --violet: #8b5cf6;
            
            --bg-page: #f8fafc;
            --bg-white: #ffffff;
            --bg-card: rgba(255, 255, 255, 0.85);
            
            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --text-subtle: #94a3b8;
            
            --border-light: rgba(226, 232, 240, 0.9);
            --border-highlight: rgba(99, 102, 241, 0.25);
            
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.06), 0 2px 4px -1px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 10px 25px -5px rgba(79, 70, 229, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            --shadow-xl: 0 20px 35px -8px rgba(79, 70, 229, 0.12), 0 12px 18px -8px rgba(0, 0, 0, 0.04);
            --shadow-glow: 0 0 35px rgba(99, 102, 241, 0.18);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-body);
            line-height: 1.6;
            overflow-x: hidden;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(56, 189, 248, 0.1) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(245, 158, 11, 0.04) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.06) 0px, transparent 50%);
            background-attachment: fixed;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            color: var(--text-heading);
            font-weight: 700;
        }

        /* Gradient & Glow Helpers */
        .gradient-text {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 40%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-amber {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #ef4444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-emerald {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Glassmorphic White Cards */
        .card-white {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-light);
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-white:hover {
            border-color: var(--border-highlight);
            box-shadow: var(--shadow-xl);
            transform: translateY(-4px);
        }

        /* Header / Navbar */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.25rem 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        nav.scrolled {
            padding: 0.85rem 6%;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .brand-logo-container {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
            border: 2px solid #ffffff;
            background: linear-gradient(135deg, #6366f1, #0284c7);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-heading);
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .brand-title span {
            color: var(--primary-light);
        }

        .brand-subtitle {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            font-weight: 700;
        }

        .nav-menu {
            display: flex;
            gap: 2.2rem;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--text-body);
            font-weight: 600;
            font-size: 0.92rem;
            transition: all 0.25s ease;
            position: relative;
            padding: 0.4rem 0;
        }

        .nav-menu a:hover {
            color: var(--primary);
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.25s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 0.75rem 1.6rem;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.92rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: none;
            outline: none;
            letter-spacing: 0.2px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 60%, #0ea5e9 100%);
            color: #ffffff;
            box-shadow: 0 4px 18px rgba(79, 70, 229, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.45);
            color: #ffffff;
        }

        .btn-outline {
            background: #ffffff;
            color: var(--text-heading);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-sm);
        }

        .btn-outline:hover {
            border-color: var(--primary-light);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-lg {
            padding: 0.95rem 2.2rem;
            font-size: 1rem;
            border-radius: 16px;
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            padding: 8rem 6% 5rem;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 4rem;
            align-items: center;
            width: 100%;
            max-width: 1320px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 1rem;
            background: rgba(99, 102, 241, 0.08);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 50px;
            color: var(--primary);
            font-size: 0.82rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            animation: fadeInDown 0.8s ease-out;
        }

        .hero-badge i {
            color: var(--accent);
        }

        .hero-title {
            font-size: 3.8rem;
            line-height: 1.12;
            letter-spacing: -1.5px;
            margin-bottom: 1.5rem;
            color: var(--text-heading);
            animation: fadeInUp 0.8s ease-out 0.1s both;
        }

        .hero-description {
            font-size: 1.15rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            max-width: 580px;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .hero-actions {
            display: flex;
            gap: 1.2rem;
            align-items: center;
            margin-bottom: 3.5rem;
            animation: fadeInUp 0.8s ease-out 0.3s both;
        }

        /* Hero Quick Stats Strip */
        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-light);
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .stat-item h4 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-heading);
            margin-bottom: 0.2rem;
        }

        .stat-item p {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Hero Visual Preview Card */
        .hero-visual {
            position: relative;
            animation: fadeInRight 1s ease-out 0.2s both;
        }

        .preview-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 2rem;
            box-shadow: 0 25px 60px -15px rgba(79, 70, 229, 0.18), 0 10px 20px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.2rem;
            border-bottom: 1px solid var(--border-light);
        }

        .preview-dots {
            display: flex;
            gap: 6px;
        }

        .preview-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dot-red { background: #f87171; }
        .dot-yellow { background: #fbbf24; }
        .dot-green { background: #34d399; }

        .live-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--emerald-soft);
            color: var(--emerald);
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--emerald);
            animation: pulse 1.8s infinite;
        }

        .preview-content {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .preview-metric-box {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            border: 1px solid rgba(99, 102, 241, 0.15);
            border-radius: 18px;
            padding: 1.2rem 1.4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-metric-box .label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .preview-metric-box .val {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            font-family: 'Outfit', sans-serif;
        }

        .preview-list {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .preview-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border: 1px solid var(--border-light);
            padding: 0.85rem 1.1rem;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
        }

        .preview-row-user {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar-mini {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-light), var(--secondary-light));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .user-meta h5 {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-heading);
        }

        .user-meta span {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        .status-tag {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.25rem 0.65rem;
            border-radius: 8px;
        }

        .status-success { background: var(--emerald-soft); color: var(--emerald); }
        .status-info { background: var(--secondary-soft); color: var(--secondary); }

        /* Floating Accent Badges */
        .float-badge {
            position: absolute;
            background: #ffffff;
            padding: 0.9rem 1.3rem;
            border-radius: 18px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.9);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            animation: float 4s ease-in-out infinite;
        }

        .float-badge-top {
            top: -20px;
            right: -20px;
        }

        .float-badge-bottom {
            bottom: -20px;
            left: -20px;
            animation-delay: 2s;
        }

        .float-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .bg-indigo-icon { background: var(--primary-soft); color: var(--primary); }
        .bg-amber-icon { background: var(--accent-soft); color: var(--accent); }

        /* Common Section Layout */
        section {
            padding: 7rem 6%;
            position: relative;
        }

        .section-header {
            text-align: center;
            max-width: 720px;
            margin: 0 auto 4.5rem;
        }

        .section-tag {
            display: inline-block;
            padding: 0.35rem 1rem;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 2.8rem;
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 1rem;
            color: var(--text-heading);
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        /* About Us Section */
        .about-section {
            background: #ffffff;
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4.5rem;
            align-items: center;
            max-width: 1280px;
            margin: 0 auto;
        }

        .about-image-card {
            background: linear-gradient(135deg, #eef2ff 0%, #e0f2fe 100%);
            border-radius: 28px;
            padding: 2.5rem;
            border: 1px solid var(--border-light);
            position: relative;
            box-shadow: var(--shadow-lg);
        }

        .about-image-inner {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .about-image-inner img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .about-image-card:hover .about-image-inner img {
            transform: scale(1.03);
        }

        .about-content h3 {
            font-size: 2.2rem;
            line-height: 1.25;
            margin-bottom: 1.2rem;
            letter-spacing: -0.5px;
        }

        .about-content p {
            color: var(--text-body);
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 1.2rem;
        }

        .features-list {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .feature-icon-box {
            width: 44px;
            height: 44px;
            min-width: 44px;
            border-radius: 12px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: var(--shadow-sm);
        }

        .feature-text h5 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-heading);
            margin-bottom: 0.2rem;
        }

        .feature-text p {
            font-size: 0.92rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin: 0;
        }

        /* Rules & Policies Section */
        .rules-section {
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .rules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
            gap: 2rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        .rule-card {
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 24px;
            padding: 2.2rem;
            position: relative;
            box-shadow: var(--shadow-md);
            transition: all 0.35s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .rule-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 35px -5px rgba(79, 70, 229, 0.12);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .rule-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .rule-icon-wrap {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .icon-indigo { background: var(--primary-soft); color: var(--primary); }
        .icon-sky { background: var(--secondary-soft); color: var(--secondary); }
        .icon-amber { background: var(--accent-soft); color: var(--accent); }
        .icon-emerald { background: var(--emerald-soft); color: var(--emerald); }
        .icon-rose { background: var(--rose-soft); color: var(--rose); }
        .icon-violet { background: #f3e8ff; color: var(--violet); }

        .rule-num {
            font-size: 1.5rem;
            font-weight: 900;
            color: #cbd5e1;
            font-family: 'Outfit', sans-serif;
        }

        .rule-category {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .rule-card h3 {
            font-size: 1.35rem;
            margin-bottom: 0.8rem;
            color: var(--text-heading);
        }

        .rule-card p {
            color: var(--text-muted);
            font-size: 0.94rem;
            line-height: 1.6;
        }

        .rule-footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-body);
        }

        .rule-footer i {
            color: var(--emerald);
        }

        /* Contact Section */
        .contact-section {
            background: #ffffff;
            border-top: 1px solid var(--border-light);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.3fr;
            gap: 3.5rem;
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 28px;
            box-shadow: var(--shadow-xl);
            padding: 3.5rem;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .contact-info h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .contact-info p {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 2.5rem;
        }

        .info-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            padding: 1.2rem;
            background: var(--bg-page);
            border: 1px solid var(--border-light);
            border-radius: 18px;
            transition: all 0.25s ease;
        }

        .info-card:hover {
            border-color: var(--primary-light);
            transform: translateX(4px);
            background: #ffffff;
            box-shadow: var(--shadow-md);
        }

        .info-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .info-detail h5 {
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            margin-bottom: 0.2rem;
        }

        .info-detail p {
            font-size: 0.98rem;
            font-weight: 700;
            color: var(--text-heading);
            margin: 0;
        }

        /* Contact Form */
        .contact-form-container {
            background: #f8fafc;
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 2.5rem;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.4rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-heading);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            padding: 0.9rem 1.1rem;
            border-radius: 12px;
            color: var(--text-heading);
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            box-shadow: var(--shadow-sm);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            background: #ffffff;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* Toast notification */
        #toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #ffffff;
            border-left: 5px solid var(--emerald);
            padding: 1rem 1.5rem;
            border-radius: 14px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 0.8rem;
            z-index: 2000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Footer */
        footer {
            background: #ffffff;
            border-top: 1px solid var(--border-light);
            padding: 4rem 6% 2.5rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            max-width: 1280px;
            margin: 0 auto 3rem;
        }

        .footer-brand p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 1rem;
            max-width: 320px;
            line-height: 1.6;
        }

        .footer-col h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-heading);
            margin-bottom: 1.2rem;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            max-width: 1280px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: var(--text-body);
            font-weight: 600;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 3.5rem;
            }
            .hero-title {
                font-size: 3.2rem;
            }
            .hero-description {
                margin-inline: auto;
            }
            .hero-actions {
                justify-content: center;
            }
            .hero-stats {
                max-width: 500px;
                margin: 0 auto;
            }
            .about-grid {
                grid-template-columns: 1fr;
            }
            .contact-grid {
                grid-template-columns: 1fr;
                padding: 2.5rem;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            .rules-grid {
                grid-template-columns: 1fr;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .footer-bottom {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Header -->
    <nav id="navbar">
        <a href="/payrollsystem/" class="brand">
            <div class="brand-logo-container">
                <img src="/payrollsystem/assets/img/system_brand_badge.jpg" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=HR&background=4f46e5&color=fff'">
            </div>
            <div>
                <div class="brand-title">HR<span>Portal</span></div>
                <div class="brand-subtitle">Workforce & Payroll</div>
            </div>
        </a>

        <ul class="nav-menu">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About System</a></li>
            <li><a href="#rules">Company Rules</a></li>
            <li><a href="#contact">Contact Support</a></li>
        </ul>

        <div class="nav-actions">
            <a href="/payrollsystem/auth/employee" class="btn btn-primary">
                <i class="fa-solid fa-user-check"></i>
                <span>Employee Login</span>
            </a>
            <a href="/payrollsystem/auth/admin" class="btn btn-outline" style="border-color: rgba(99, 102, 241, 0.4); font-size: 0.88rem; padding: 0.7rem 1.2rem;">
                <i class="fa-solid fa-user-shield text-indigo-600"></i>
                <span>Admin Portal</span>
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-grid">
            <div class="hero-text-content">
                <div class="hero-badge">
                    <i class="fa-solid fa-sparkles"></i>
                    <span>Smart Workplace & Payroll Ecosystem</span>
                </div>
                
                <h1 class="hero-title">
                    Empowering Your Workforce With <span class="gradient-text">Intelligent Payroll</span>
                </h1>
                
                <p class="hero-description">
                    An intuitive, high-precision management platform designed to automate time tracking, compute accurate salaries, manage leave workflows, and give employees transparent self-service access.
                </p>
                
                <div class="hero-actions" style="flex-wrap: wrap;">
                    <a href="/payrollsystem/auth/employee" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Employee Sign In</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="/payrollsystem/auth/admin" class="btn btn-outline btn-lg" style="border-color: rgba(99, 102, 241, 0.4);">
                        <i class="fa-solid fa-shield-halved text-indigo-600"></i>
                        <span>Admin Portal</span>
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <h4>100%</h4>
                        <p>Automated Calculations</p>
                    </div>
                    <div class="stat-item">
                        <h4>Real-Time</h4>
                        <p>Attendance Checks</p>
                    </div>
                    <div class="stat-item">
                        <h4>Instant</h4>
                        <p>Pay Slip Access</p>
                    </div>
                </div>
            </div>

            <!-- Hero Interactive Preview Visual -->
            <div class="hero-visual">
                <div class="preview-card">
                    <div class="preview-header">
                        <div class="preview-dots">
                            <div class="preview-dot dot-red"></div>
                            <div class="preview-dot dot-yellow"></div>
                            <div class="preview-dot dot-green"></div>
                        </div>
                        <div class="live-pill">
                            <div class="pulse-dot"></div>
                            <span>System Active</span>
                        </div>
                    </div>

                    <div class="preview-content">
                        <div class="preview-metric-box">
                            <div>
                                <div class="label">Monthly Payroll Status</div>
                                <div style="font-size: 0.95rem; font-weight: 700; color: var(--text-heading); margin-top: 4px;">Processed & Verified</div>
                            </div>
                            <div class="val">99.9%</div>
                        </div>

                        <div class="preview-list">
                            <div class="preview-row">
                                <div class="preview-row-user">
                                    <div class="user-avatar-mini"><i class="fa-solid fa-user-check"></i></div>
                                    <div class="user-meta">
                                        <h5>Daily Attendance Tracking</h5>
                                        <span>Automated In/Out & Overtime</span>
                                    </div>
                                </div>
                                <span class="status-tag status-success"><i class="fa-solid fa-check mr-1"></i> Recorded</span>
                            </div>

                            <div class="preview-row">
                                <div class="preview-row-user">
                                    <div class="user-avatar-mini" style="background: linear-gradient(135deg, #0ea5e9, #06b6d4);"><i class="fa-solid fa-calculator"></i></div>
                                    <div class="user-meta">
                                        <h5>Leave & Bonus Deductions</h5>
                                        <span>Real-time formula calculation</span>
                                    </div>
                                </div>
                                <span class="status-tag status-info"><i class="fa-solid fa-bolt mr-1"></i> Synced</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Accent Badges -->
                <div class="float-badge float-badge-top">
                    <div class="float-icon bg-indigo-icon">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <h6 style="font-size: 0.88rem; font-weight: 700; color: var(--text-heading);">Role-Based Security</h6>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Admin & Employee Isolation</span>
                    </div>
                </div>

                <div class="float-badge float-badge-bottom">
                    <div class="float-icon bg-amber-icon">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <h6 style="font-size: 0.88rem; font-weight: 700; color: var(--text-heading);">One-Click Pay Slips</h6>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Download PDF anytime</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="section-header">
            <div class="section-tag">About Our System</div>
            <h2 class="section-title">Built For Precision, Clarity & Productivity</h2>
            <p class="section-subtitle">A modern solution eliminating paperwork and repetitive HR computations.</p>
        </div>

        <div class="about-grid">
            <div class="about-image-card">
                <div class="about-image-inner">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1000&q=80" alt="Team Collaboration">
                </div>
            </div>

            <div class="about-content">
                <h3>Transforming Traditional HR into a Digital Experience</h3>
                <p>
                    Our Employee Workforce and Payroll Management System replaces tedious spreadsheets with a unified, transparent digital environment. From the moment employees sign in, their working hours, overtime, leave approvals, and allowances are computed automatically according to organizational rules.
                </p>
                <p>
                    Management gains crystal-clear visibility into staff presence, department expenditure, and monthly salary disbursement with zero margin for manual calculation errors.
                </p>

                <div class="features-list">
                    <div class="feature-item">
                        <div class="feature-icon-box"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <div class="feature-text">
                            <h5>Automated Attendance & Overtime</h5>
                            <p>Tracks punctual check-ins, auto-calculates approved overtime hours, and logs absences effortlessly.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon-box" style="background: var(--secondary-soft); color: var(--secondary);"><i class="fa-solid fa-receipt"></i></div>
                        <div class="feature-text">
                            <h5>Dynamic Payroll Generation</h5>
                            <p>Computes gross pay, allowances, tax deductions, bonuses, and net pay automatically with instant print-ready slips.</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon-box" style="background: var(--emerald-soft); color: var(--emerald);"><i class="fa-solid fa-calendar-check"></i></div>
                        <div class="feature-text">
                            <h5>Self-Service Leave Approvals</h5>
                            <p>Employees request leaves in seconds; managers review and approve with instant balance adjustments.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Rules & Policies Section -->
    <section id="rules" class="rules-section">
        <div class="section-header">
            <div class="section-tag">Workplace Guidelines</div>
            <h2 class="section-title">Company Rules & Operational Policies</h2>
            <p class="section-subtitle">Clear standards designed to support accountability, fairness, and a healthy work environment.</p>
        </div>

        <div class="rules-grid">
            <!-- Rule 1: Attendance -->
            <div class="rule-card">
                <div>
                    <div class="rule-top">
                        <div class="rule-icon-wrap icon-indigo">
                            <i class="fa-solid fa-fingerprint"></i>
                        </div>
                        <div class="rule-num">01</div>
                    </div>
                    <div class="rule-category">Daily Schedule</div>
                    <h3>Attendance & Check-in</h3>
                    <p>Standard business hours begin at 9:00 AM. Employees are required to record check-in via the portal daily. A 15-minute grace period is provided before late marks apply.</p>
                </div>
                <div class="rule-footer">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Log in by 9:00 AM daily</span>
                </div>
            </div>

            <!-- Rule 2: Leaves -->
            <div class="rule-card">
                <div>
                    <div class="rule-top">
                        <div class="rule-icon-wrap icon-sky">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="rule-num">02</div>
                    </div>
                    <div class="rule-category">Time Off</div>
                    <h3>Leave Application Policy</h3>
                    <p>Planned leaves (annual, casual, or medical) must be submitted at least 48 hours prior. Emergency leaves must be reported to the direct supervisor before 10:00 AM.</p>
                </div>
                <div class="rule-footer">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Submit 48h in advance</span>
                </div>
            </div>

            <!-- Rule 3: Overtime -->
            <div class="rule-card">
                <div>
                    <div class="rule-top">
                        <div class="rule-icon-wrap icon-amber">
                            <i class="fa-solid fa-stopwatch"></i>
                        </div>
                        <div class="rule-num">03</div>
                    </div>
                    <div class="rule-category">Compensation</div>
                    <h3>Overtime & Extra Hours</h3>
                    <p>Overtime work requires prior departmental manager endorsement. Overtime rates apply for hours completed beyond official shift schedules upon verified checkout.</p>
                </div>
                <div class="rule-footer">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Manager approval required</span>
                </div>
            </div>

            <!-- Rule 4: Payroll & Slips -->
            <div class="rule-card">
                <div>
                    <div class="rule-top">
                        <div class="rule-icon-wrap icon-emerald">
                            <i class="fa-solid fa-money-check-dollar"></i>
                        </div>
                        <div class="rule-num">04</div>
                    </div>
                    <div class="rule-category">Disbursement</div>
                    <h3>Salary & Payslip Release</h3>
                    <p>Salaries are disbursed to bank accounts on the final business day of every month. Digital pay slips are available for download under the employee portal immediately.</p>
                </div>
                <div class="rule-footer">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Disbursed monthly end</span>
                </div>
            </div>

            <!-- Rule 5: Professional Conduct -->
            <div class="rule-card">
                <div>
                    <div class="rule-top">
                        <div class="rule-icon-wrap icon-rose">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <div class="rule-num">05</div>
                    </div>
                    <div class="rule-category">Ethics</div>
                    <h3>Professional Code of Conduct</h3>
                    <p>Maintain respect, integrity, and non-discrimination. System credentials must remain confidential; sharing user accounts or clocking for others is strictly prohibited.</p>
                </div>
                <div class="rule-footer">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Zero tolerance for fraud</span>
                </div>
            </div>

            <!-- Rule 6: Remote Work -->
            <div class="rule-card">
                <div>
                    <div class="rule-top">
                        <div class="rule-icon-wrap icon-violet">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <div class="rule-num">06</div>
                    </div>
                    <div class="rule-category">Flexibility</div>
                    <h3>Remote Work & Connectivity</h3>
                    <p>Eligible remote staff must remain reachable during core shift hours on company communication channels and maintain regular task progression updates.</p>
                </div>
                <div class="rule-footer">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Active status on shift</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Support Section -->
    <section id="contact" class="contact-section">
        <div class="section-header">
            <div class="section-tag">Help & Support</div>
            <h2 class="section-title">Need Assistance? We're Here To Help</h2>
            <p class="section-subtitle">Reach out to HR administration for inquiries regarding payroll, attendance discrepancies, or portal assistance.</p>
        </div>

        <div class="contact-grid">
            <div class="contact-info">
                <div>
                    <h3>Contact Information</h3>
                    <p>Feel free to reach out via email, phone, or submit the direct message form. Our support team responds promptly during office hours.</p>
                </div>

                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="info-detail">
                            <h5>HR Support Email</h5>
                            <p>hr.support@company.com</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon" style="background: var(--secondary-soft); color: var(--secondary);"><i class="fa-solid fa-phone"></i></div>
                        <div class="info-detail">
                            <h5>Direct Helpdesk Phone</h5>
                            <p>+95 (09) 123-456-789</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon" style="background: var(--emerald-soft); color: var(--emerald);"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="info-detail">
                            <h5>Corporate Office</h5>
                            <p>Building 4B, Central Business District</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form-container">
                <form class="contact-form" id="supportForm" onsubmit="handleSupportSubmit(event)">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contactName">Full Name</label>
                            <input type="text" id="contactName" class="form-control" placeholder="e.g. Alex Morgan" required>
                        </div>
                        <div class="form-group">
                            <label for="contactEmail">Work Email</label>
                            <input type="email" id="contactEmail" class="form-control" placeholder="alex@company.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contactSubject">Subject / Category</label>
                        <input type="text" id="contactSubject" class="form-control" placeholder="e.g. Payroll inquiry or Attendance correction" required>
                    </div>

                    <div class="form-group">
                        <label for="contactMessage">Message</label>
                        <textarea id="contactMessage" class="form-control" placeholder="Please describe your question or issue in detail..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; margin-top: 0.5rem;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Send Message to HR</span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Toast Notification -->
    <div id="toast">
        <i class="fa-solid fa-circle-check" style="color: var(--emerald); font-size: 1.25rem;"></i>
        <div>
            <h6 style="font-weight: 700; font-size: 0.9rem; color: var(--text-heading);">Message Delivered</h6>
            <p style="font-size: 0.8rem; color: var(--text-muted);">Thank you! HR administration has received your message.</p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="/payrollsystem/" class="brand">
                    <div class="brand-logo-container" style="width: 38px; height: 38px;">
                        <img src="/payrollsystem/assets/img/system_brand_badge.jpg" alt="Logo" onerror="this.src='https://ui-avatars.com/api/?name=HR&background=4f46e5&color=fff'">
                    </div>
                    <div>
                        <div class="brand-title">HR<span>Portal</span></div>
                    </div>
                </a>
                <p>Enterprise Employee Workforce & Automated Payroll Management System. Engineered for reliability, transparency, and operational efficiency.</p>
            </div>

            <div class="footer-col">
                <h5>Navigation</h5>
                <ul class="footer-links">
                    <li><a href="#home">Home Overview</a></li>
                    <li><a href="#about">About System</a></li>
                    <li><a href="#rules">Company Rules</a></li>
                    <li><a href="#contact">Contact Support</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Portals</h5>
                <ul class="footer-links">
                    <li><a href="/payrollsystem/auth/admin">Admin Portal</a></li>
                    <li><a href="/payrollsystem/auth/employee">Employee Workspace</a></li>
                    <li><a href="/payrollsystem/auth/forgot_password">Password Recovery</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Compliance</h5>
                <ul class="footer-links">
                    <li><a href="#rules">Attendance Policies</a></li>
                    <li><a href="#rules">Overtime Regulations</a></li>
                    <li><a href="#rules">Tax & Allowance Rules</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Employee Workforce and Payroll Management System. All rights reserved.</p>
            <div class="status-indicator">
                <span class="pulse-dot" style="display: inline-block;"></span>
                <span>Operational Status: Healthy</span>
            </div>
        </div>
    </footer>

    <!-- Interactive Script -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 40) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Contact form toast notification
        function handleSupportSubmit(e) {
            e.preventDefault();
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            document.getElementById('supportForm').reset();

            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }
    </script>
</body>
</html>
