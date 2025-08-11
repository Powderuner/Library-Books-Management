<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-check-circle me-3"></i>
        Confirm Book Information
    </h1>
    <p class="page-subtitle">Review the book details before adding to your library</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-book me-2"></i>
                    Book Found Successfully!
                </h5>
            </div>
            <div class="card-body p-4">
                
                <!-- Book Cover Image -->
                <?php if (!empty($book['image_url'])): ?>
                <div class="text-center mb-4">
                    <img src="<?= esc($book['image_url']) ?>" 
                         alt="Book Cover" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 200px;">
                </div>
                <?php endif; ?>

                <!-- Book Information -->
                <div class="book-details">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Title:</strong>
                        </div>
                        <div class="col-sm-9">
                            <h5 class="mb-0"><?= esc($book['title']) ?></h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Author:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fs-6"><?= esc($book['author']) ?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Genre:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge bg-primary"><?= esc($book['genre']) ?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Published:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fs-6"><?= esc($book['publication_year']) ?></span>
                        </div>
                    </div>

                    <?php if (!empty($book['publisher'])): ?>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Publisher:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fs-6"><?= esc($book['publisher']) ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($book['page_count'])): ?>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Pages:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fs-6"><?= esc($book['page_count']) ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($book['description'])): ?>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Description:</strong>
                        </div>
                        <div class="col-sm-9">
                            <p class="fs-6 text-muted mb-0">
                                <?= esc(substr($book['description'], 0, 200)) ?>
                                <?= strlen($book['description']) > 200 ? '...' : '' ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">ISBN:</strong>
                        </div>
                        <div class="col-sm-9">
                            <code class="fs-6"><?= esc($book['isbn']) ?></code>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2 mt-4">
                    <form action="/books/add-from-isbn" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="title" value="<?= esc($book['title']) ?>">
                        <input type="hidden" name="author" value="<?= esc($book['author']) ?>">
                        <input type="hidden" name="genre" value="<?= esc($book['genre']) ?>">
                        <input type="hidden" name="publication_year" value="<?= esc($book['publication_year']) ?>">
                        <input type="hidden" name="description" value="<?= esc($book['description'] ?? '') ?>">
                        
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-plus me-2"></i>
                            Add to Library
                        </button>
                    </form>
                    
                    <div class="d-flex gap-2">
                        <a href="/books/lookup-isbn" class="btn btn-outline-secondary flex-fill">
                            <i class="fas fa-search me-2"></i>
                            Search Another ISBN
                        </a>
                        <a href="/books" class="btn btn-outline-secondary flex-fill">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Books
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-radius: 16px;
}

.book-details .row {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 0.5rem 0;
}

.book-details .row:last-child {
    border-bottom: none;
}

.badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

code {
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary-color);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

html[data-bs-theme="dark"] .card {
    background: rgba(31, 41, 55, 0.9);
    border: 1px solid rgba(75, 85, 99, 0.3);
}

html[data-bs-theme="dark"] .book-details .row {
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

html[data-bs-theme="dark"] .text-muted {
    color: #9ca3af !important;
}

html[data-bs-theme="dark"] code {
    background: rgba(99, 102, 241, 0.2);
    color: #a5b4fc;
}
</style>

<?= $this->endSection() ?>
