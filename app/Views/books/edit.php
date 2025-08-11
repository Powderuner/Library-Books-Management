<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-edit me-3"></i>
        Edit Book
    </h1>
    <p class="page-subtitle">Update the information for "<?= esc($book['title']) ?>"</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-white">
                    <i class="fas fa-book me-2"></i>
                    Edit Book Information
                </h5>
            </div>
            <div class="card-body p-4">
                <?php if (isset($validation)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($validation->getErrors() as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="/books/update/<?= esc($book['id']) ?>" method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">
                                <i class="fas fa-book me-1 text-primary"></i>
                                Book Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title"
                                   class="form-control form-control-lg <?= (isset($validation) && $validation->hasError('title')) ? 'is-invalid' : '' ?>" 
                                   value="<?= esc($book['title']) ?>" 
                                   placeholder="Enter book title"
                                   required>
                            <?php if (isset($validation) && $validation->hasError('title')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('title') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="author" class="form-label">
                                <i class="fas fa-user me-1 text-success"></i>
                                Author <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="author" 
                                   id="author"
                                   class="form-control form-control-lg <?= (isset($validation) && $validation->hasError('author')) ? 'is-invalid' : '' ?>" 
                                   value="<?= esc($book['author']) ?>" 
                                   placeholder="Enter author name"
                                   required>
                            <?php if (isset($validation) && $validation->hasError('author')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('author') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="genre" class="form-label">
                                <i class="fas fa-tag me-1 text-info"></i>
                                Genre <span class="text-danger">*</span>
                            </label>
                            <select name="genre" 
                                    id="genre"
                                    class="form-select form-select-lg <?= (isset($validation) && $validation->hasError('genre')) ? 'is-invalid' : '' ?>" 
                                    required>
                                <option value="">Select a genre</option>
                                <option value="Fiction" <?= esc($book['genre']) === 'Fiction' ? 'selected' : '' ?>>Fiction</option>
                                <option value="Non-Fiction" <?= esc($book['genre']) === 'Non-Fiction' ? 'selected' : '' ?>>Non-Fiction</option>
                                <option value="Mystery" <?= esc($book['genre']) === 'Mystery' ? 'selected' : '' ?>>Mystery</option>
                                <option value="Romance" <?= esc($book['genre']) === 'Romance' ? 'selected' : '' ?>>Romance</option>
                                <option value="Science Fiction" <?= esc($book['genre']) === 'Science Fiction' ? 'selected' : '' ?>>Science Fiction</option>
                                <option value="Fantasy" <?= esc($book['genre']) === 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
                                <option value="Thriller" <?= esc($book['genre']) === 'Thriller' ? 'selected' : '' ?>>Thriller</option>
                                <option value="Biography" <?= esc($book['genre']) === 'Biography' ? 'selected' : '' ?>>Biography</option>
                                <option value="History" <?= esc($book['genre']) === 'History' ? 'selected' : '' ?>>History</option>
                                <option value="Self-Help" <?= esc($book['genre']) === 'Self-Help' ? 'selected' : '' ?>>Self-Help</option>
                                <option value="Action" <?= esc($book['genre']) === 'Action' ? 'selected' : '' ?>>Action</option>
                                <option value="Other" <?= esc($book['genre']) === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                            <?php if (isset($validation) && $validation->hasError('genre')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('genre') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="year" class="form-label">
                                <i class="fas fa-calendar me-1 text-warning"></i>
                                Publication Year <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   name="year" 
                                   id="year"
                                   class="form-control form-control-lg <?= (isset($validation) && $validation->hasError('year')) ? 'is-invalid' : '' ?>" 
                                   value="<?= esc($book['publication_year']) ?>" 
                                   placeholder="e.g., 2024"
                                   min="1000" 
                                   max="<?= date('Y') + 1 ?>"
                                   required>
                            <?php if (isset($validation) && $validation->hasError('year')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('year') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1 text-info"></i>
                            Book Description
                        </label>
                        <textarea name="description" 
                                  id="description"
                                  class="form-control form-control-lg <?= (isset($validation) && $validation->hasError('description')) ? 'is-invalid' : '' ?>" 
                                  rows="4"
                                  placeholder="Enter a brief description of the book (optional)"><?= esc($book['description'] ?? '') ?></textarea>
                        <?php if (isset($validation) && $validation->hasError('description')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('description') ?></div>
                        <?php endif; ?>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Provide a brief overview of the book's content, plot, or purpose
                        </div>
                    </div>

                    <div class="form-actions mt-4 pt-3 border-top">
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="/books" class="btn btn-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                Update Book
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    transform: translateY(-1px);
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: var(--danger-color);
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

body[data-bs-theme="dark"] .form-label {
    color: #d1d5db;
}

.form-actions {
    background: rgba(0, 0, 0, 0.02);
    margin: 0 -1.5rem -1.5rem -1.5rem;
    padding: 1.5rem;
}

body[data-bs-theme="dark"] .form-actions {
    background: rgba(255, 255, 255, 0.02);
}

@media (max-width: 768px) {
    .form-actions .d-flex {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>

<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Auto-focus on first input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('title').focus();
});
</script>

<?= $this->endSection() ?>
