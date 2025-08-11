<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            min-height: calc(100vh - 76px);
        }
        .sidebar .nav-link {
            color: #6c757d;
            border-radius: 10px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #667eea;
            color: white;
        }
        .main-content {
            padding: 2rem;
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        .stats-users { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stats-books { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stats-students { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stats-admins { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .recent-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }
        .btn-action {
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-book-reader me-2"></i>
                Library Management System
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        <?= esc(session()->get('full_name')) ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('auth/profile') ?>">
                            <i class="fas fa-user me-2"></i>Profile
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="<?= base_url('admin/dashboard') ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link" href="<?= base_url('admin/users') ?>">
                            <i class="fas fa-users me-2"></i>Users Management
                        </a>
                        <a class="nav-link" href="<?= base_url('books') ?>">
                            <i class="fas fa-book me-2"></i>Books Management
                        </a>
                        <a class="nav-link" href="<?= base_url('auth/register') ?>">
                            <i class="fas fa-user-plus me-2"></i>Create User
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">Admin Dashboard</h1>
                        <div>
                            <a href="<?= base_url('auth/register') ?>" class="btn btn-primary btn-action">
                                <i class="fas fa-user-plus me-2"></i>Create User
                            </a>
                            <a href="<?= base_url('books/create') ?>" class="btn btn-success btn-action">
                                <i class="fas fa-plus me-2"></i>Add Book
                            </a>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon stats-users me-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= $totalUsers ?></h3>
                                        <p class="text-muted mb-0">Total Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon stats-students me-3">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= $totalStudents ?></h3>
                                        <p class="text-muted mb-0">Students</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon stats-admins me-3">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= $totalAdmins ?></h3>
                                        <p class="text-muted mb-0">Administrators</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon stats-books me-3">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= $totalBooks ?></h3>
                                        <p class="text-muted mb-0">Total Books</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="recent-card">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-users me-2 text-primary"></i>
                                    Recent Users
                                </h5>
                                <?php if (!empty($recentUsers)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recentUsers as $user): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                <div>
                                                    <h6 class="mb-1"><?= esc($user['full_name']) ?></h6>
                                                    <small class="text-muted">
                                                        @<?= esc($user['username']) ?> • 
                                                        <span class="badge bg-<?= $user['role'] === 'admin' ? 'primary' : 'success' ?>">
                                                            <?= ucfirst($user['role']) ?>
                                                        </span>
                                                    </small>
                                                </div>
                                                <small class="text-muted">
                                                    <?= date('M d', strtotime($user['created_at'])) ?>
                                                </small>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No users found.</p>
                                <?php endif; ?>
                                <div class="mt-3">
                                    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-primary btn-sm">
                                        View All Users
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="recent-card">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-book me-2 text-success"></i>
                                    Recent Books
                                </h5>
                                <?php if (!empty($recentBooks)): ?>
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($recentBooks as $book): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                <div>
                                                    <h6 class="mb-1"><?= esc($book['title']) ?></h6>
                                                    <small class="text-muted">
                                                        By <?= esc($book['author']) ?> • 
                                                        <span class="badge bg-info"><?= esc($book['isbn']) ?></span>
                                                    </small>
                                                </div>
                                                <small class="text-muted">
                                                    <?= date('M d', strtotime($book['created_at'])) ?>
                                                </small>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No books found.</p>
                                <?php endif; ?>
                                <div class="mt-3">
                                    <a href="<?= base_url('books') ?>" class="btn btn-outline-success btn-sm">
                                        View All Books
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
