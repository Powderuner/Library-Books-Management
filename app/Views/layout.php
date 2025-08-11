<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Manage Library Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }

        .theme-toggle {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 1031;
        }
    </style>
</head>
<body>
    <div class="theme-toggle">
        <button id="toggleThemeBtn" class="btn btn-outline-secondary btn-sm">🌓 Toggle Theme</button>
    </div>

    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>

    <script>
        // Theme toggle logic with localStorage
        const html = document.documentElement;
        const toggleBtn = document.getElementById('toggleThemeBtn');
        const savedTheme = localStorage.getItem('theme');

        if (savedTheme) {
            html.setAttribute('data-bs-theme', savedTheme);
        }

        toggleBtn.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>
</html>
