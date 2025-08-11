<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books Management</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --light-bg: #f8fafc;
            --dark-bg: #0f172a;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            
            /* Dark mode specific colors */
            --dark-card-bg: rgba(31, 41, 55, 0.9);
            --dark-card-header-bg: rgba(55, 65, 81, 0.9);
            --dark-border-color: rgba(75, 85, 99, 0.3);
            --dark-text-primary: #f9fafb;
            --dark-text-secondary: #e5e7eb;
            --dark-text-muted: #9ca3af;
            --dark-form-bg: rgba(55, 65, 81, 0.8);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            background: var(--light-bg);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Smooth transitions for all elements during theme changes */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        html[data-bs-theme="dark"] body {
            background: var(--dark-bg);
            color: #e5e7eb;
        }

        /* Dark mode text colors */
        html[data-bs-theme="dark"] body {
            color: #e5e7eb;
        }

        html[data-bs-theme="dark"] h1,
        html[data-bs-theme="dark"] h2,
        html[data-bs-theme="dark"] h3,
        html[data-bs-theme="dark"] h4,
        html[data-bs-theme="dark"] h5,
        html[data-bs-theme="dark"] h6 {
            color: #f9fafb;
        }

        html[data-bs-theme="dark"] .text-muted {
            color: #9ca3af !important;
        }

        /* Dark mode card styling */
        html[data-bs-theme="dark"] .card {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.3);
            color: #e5e7eb;
        }

        html[data-bs-theme="dark"] .card-header {
            background: rgba(55, 65, 81, 0.8);
            border-bottom: 1px solid rgba(75, 85, 99, 0.3);
            color: #f9fafb;
        }

        html[data-bs-theme="dark"] .card-body {
            background: rgba(31, 41, 55, 0.8);
            color: #e5e7eb;
        }

        html[data-bs-theme="dark"] .card-footer {
            background: rgba(55, 65, 81, 0.8);
            border-top: 1px solid rgba(75, 85, 99, 0.3);
        }

        /* Dark mode form controls */
        html[data-bs-theme="dark"] .form-control,
        html[data-bs-theme="dark"] .form-select {
            background: rgba(55, 65, 81, 0.8);
            border: 1px solid rgba(75, 85, 99, 0.5);
            color: #e5e7eb;
        }

        html[data-bs-theme="dark"] .form-control:focus,
        html[data-bs-theme="dark"] .form-select:focus {
            background: rgba(55, 65, 81, 0.9);
            border-color: var(--primary-color);
            color: #f9fafb;
        }

        html[data-bs-theme="dark"] .form-label {
            color: #d1d5db;
        }

        /* Dark mode button styling */
        html[data-bs-theme="dark"] .btn-outline-secondary {
            border-color: rgba(75, 85, 99, 0.5);
            color: #d1d5db;
        }

        html[data-bs-theme="dark"] .btn-outline-secondary:hover {
            background: rgba(75, 85, 99, 0.8);
            border-color: rgba(75, 85, 99, 0.8);
            color: #f9fafb;
        }

        /* Dark mode navbar brand */
        html[data-bs-theme="dark"] .navbar-brand {
            color: var(--primary-color) !important;
        }

        html[data-bs-theme="dark"] .navbar-brand:hover {
            color: var(--primary-hover) !important;
            background: rgba(99, 102, 241, 0.2);
        }

        html[data-bs-theme="dark"] .navbar-brand::before {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        }

        /* Dark mode page title shadow */
        html[data-bs-theme="dark"] .page-title {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Dark mode container background */
        html[data-bs-theme="dark"] .container {
            background: transparent;
        }

        /* Dark mode alert styling */
        html[data-bs-theme="dark"] .alert {
            background: rgba(31, 41, 55, 0.9);
            border: 1px solid rgba(75, 85, 99, 0.3);
            color: #e5e7eb;
        }

        html[data-bs-theme="dark"] .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
            color: #10b981;
        }

        html[data-bs-theme="dark"] .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        /* Dark mode theme toggle button */
        html[data-bs-theme="dark"] .theme-toggle .btn {
            background: rgba(55, 65, 81, 0.8);
            border: 2px solid rgba(75, 85, 99, 0.5);
            color: #d1d5db;
        }

        html[data-bs-theme="dark"] .theme-toggle .btn:hover {
            background: rgba(75, 85, 99, 0.9);
            border-color: rgba(75, 85, 99, 0.8);
            color: #f9fafb;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        html[data-bs-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .navbar-brand:hover {
            color: var(--primary-hover) !important;
            transform: translateY(-1px);
            background: rgba(99, 102, 241, 0.1);
        }

        .navbar-brand:active {
            transform: translateY(0);
        }

        .navbar-brand::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .navbar-brand:hover::before {
            left: 100%;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1031;
        }

        .theme-toggle .btn {
            border-radius: 50px;
            padding: 10px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .theme-toggle .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .main-container {
            min-height: 100vh;
            padding: 100px 20px 40px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #6b7280;
            font-weight: 400;
        }

        html[data-bs-theme="dark"] .page-subtitle {
            color: #9ca3af;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            animation: slideInDown 0.5s ease;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            color: white;
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-info {
            background: var(--info-color);
            color: white;
        }

        .btn-warning {
            background: var(--warning-color);
            color: white;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border: none;
            padding: 1.5rem;
            font-weight: 600;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            border: none;
            font-weight: 600;
            color: #374151;
            padding: 1rem;
            background: #f9fafb;
        }

        body[data-bs-theme="dark"] .table th {
            background: #1f2937;
            color: #d1d5db;
        }

        .table td {
            border: none;
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(99, 102, 241, 0.05);
        }

        html[data-bs-theme="dark"] .table tbody tr:hover {
            background: rgba(99, 102, 241, 0.1);
        }

        .badge {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        html[data-bs-theme="dark"] .empty-state {
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        /* Filter and Sort Controls Styling */
        .filter-controls {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        html[data-bs-theme="dark"] .filter-controls {
            background: rgba(31, 41, 55, 0.95);
            border: 1px solid rgba(75, 85, 99, 0.5);
            backdrop-filter: blur(20px);
        }

        html[data-bs-theme="dark"] .filter-controls .form-label {
            color: #d1d5db;
        }

        html[data-bs-theme="dark"] .filter-controls .form-select {
            background: rgba(55, 65, 81, 0.8);
            border: 2px solid rgba(75, 85, 99, 0.5);
            color: #e5e7eb;
        }

        html[data-bs-theme="dark"] .filter-controls .form-select:focus {
            background: rgba(55, 65, 81, 0.9);
            border-color: var(--primary-color);
            color: #f9fafb;
        }

        html[data-bs-theme="dark"] .filter-controls .btn-outline-secondary {
            background: rgba(55, 65, 81, 0.8);
            border: 2px solid rgba(75, 85, 99, 0.5);
            color: #d1d5db;
        }

        html[data-bs-theme="dark"] .filter-controls .btn-outline-secondary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .filter-controls .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .filter-controls .form-select {
            border: 2px solid rgba(99, 102, 241, 0.2);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .filter-controls .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .filter-controls .btn-outline-secondary {
            border: 2px solid rgba(99, 102, 241, 0.2);
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .filter-controls .btn-outline-secondary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .results-summary {
            background: rgba(99, 102, 241, 0.1);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border-left: 4px solid var(--primary-color);
        }

        html[data-bs-theme="dark"] .results-summary {
            background: rgba(99, 102, 241, 0.15);
            border-left: 4px solid var(--primary-color);
            color: #d1d5db;
        }

        html[data-bs-theme="dark"] .results-summary .text-muted {
            color: #9ca3af !important;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .main-container {
                padding: 80px 15px 30px;
            }
            
            .theme-toggle {
                top: 15px;
                right: 15px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/" title="Go to Library Homepage">
                <i class="fas fa-book-open me-2"></i>
                Library Manager
            </a>
        </div>
    </nav>

    <div class="theme-toggle">
        <button id="toggleThemeBtn" class="btn btn-outline-secondary">
            <i class="fas fa-moon"></i>
            <span class="theme-text">Dark</span>
        </button>
    </div>

    <div class="main-container">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced theme toggle logic
        const html = document.documentElement;
        const toggleBtn = document.getElementById('toggleThemeBtn');
        const themeIcon = toggleBtn.querySelector('i');
        const themeText = toggleBtn.querySelector('.theme-text');
        const savedTheme = localStorage.getItem('theme') || 'light';

        function setTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
            
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-sun';
                themeText.textContent = 'Light';
            } else {
                themeIcon.className = 'fas fa-moon';
                themeText.textContent = 'Dark';
            }
        }

        // Initialize theme
        setTheme(savedTheme);

        toggleBtn.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        });

        // Add fade-in animation to content
        document.addEventListener('DOMContentLoaded', function() {
            const content = document.querySelector('.main-container');
            content.classList.add('fade-in');

            // Add navbar brand interaction effects
            const navbarBrand = document.querySelector('.navbar-brand');
            
            // Add click feedback
            navbarBrand.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });

            // Add keyboard navigation support
            navbarBrand.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });

            // Make navbar brand focusable
            navbarBrand.setAttribute('tabindex', '0');
        });
    </script>
</body>
</html>
