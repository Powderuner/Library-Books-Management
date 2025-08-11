<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .profile-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        .profile-header {
            text-align: center;
            padding: 2rem 0;
            border-bottom: 2px solid #f8f9fa;
        }
        .profile-header i {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .form-control.with-icon {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        .profile-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
        }
        .nav-tabs .nav-link {
            border: none;
            border-radius: 10px 10px 0 0;
            margin-right: 0.5rem;
            color: #6c757d;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            background: #667eea;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="profile-container p-4">
                    <div class="profile-header">
                        <i class="fas fa-user-circle"></i>
                        <h2 class="text-dark mb-2"><?= esc($user['full_name']) ?></h2>
                        <p class="text-muted mb-0">
                            <span class="badge bg-primary me-2"><?= ucfirst($user['role']) ?></span>
                            <span class="badge bg-<?= $user['is_active'] ? 'success' : 'danger' ?>">
                                <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="profile-info">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-user me-2"></i>Username:</strong> <?= esc($user['username']) ?></p>
                                <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> <?= esc($user['email']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-calendar me-2"></i>Member Since:</strong> <?= date('M d, Y', strtotime($user['created_at'])) ?></p>
                                <?php if ($user['last_login']): ?>
                                    <p><strong><i class="fas fa-clock me-2"></i>Last Login:</strong> <?= date('M d, Y H:i', strtotime($user['last_login'])) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mt-4" id="profileTabsContent">
                        <!-- Edit Profile Tab -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            <form action="<?= base_url('auth/updateProfile') ?>" method="post">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <input type="text" class="form-control with-icon" id="full_name" name="full_name" 
                                               value="<?= esc($user['full_name']) ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control with-icon" id="email" name="email" 
                                               value="<?= esc($user['email']) ?>" required>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <form action="<?= base_url('auth/changePassword') ?>" method="post">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control with-icon" id="current_password" name="current_password" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-key"></i>
                                        </span>
                                        <input type="password" class="form-control with-icon" id="new_password" name="new_password" 
                                               minlength="6" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                        <input type="password" class="form-control with-icon" id="confirm_password" name="confirm_password" 
                                               minlength="6" required>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key me-2"></i>
                                        Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="<?= base_url(session()->get('role') === 'admin' ? 'admin/dashboard' : 'dashboard') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
