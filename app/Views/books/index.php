<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php
// Function to generate consistent colors for genres
function getGenreColor($genre) {
    // Predefined colors for common genres
    $genreColors = [
        'Fiction' => '#3B82F6',      // Blue
        'Non-Fiction' => '#10B981',  // Green
        'Mystery' => '#8B5CF6',      // Purple
        'Romance' => '#EC4899',      // Pink
        'Science Fiction' => '#06B6D4', // Cyan
        'Fantasy' => '#F59E0B',      // Amber
        'Thriller' => '#EF4444',     // Red
        'Biography' => '#84CC16',    // Lime
        'History' => '#F97316',      // Orange
        'Self-Help' => '#6366F1',    // Indigo
        'Action' => '#DC2626',       // Red-600
        'Other' => '#6B7280',        // Gray
    ];
    
    // If genre has a predefined color, use it
    if (isset($genreColors[$genre])) {
        return $genreColors[$genre];
    }
    
    // For new genres, generate a unique color based on the genre name
    $hash = crc32($genre);
    $hue = $hash % 360;
    $saturation = 70 + ($hash % 20); // 70-90%
    $lightness = 45 + ($hash % 15);  // 45-60%
    
    return "hsl({$hue}, {$saturation}%, {$lightness}%)";
}
?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-books me-3"></i>
        Library Collection
    </h1>
    <p class="page-subtitle">Manage and organize your book collection with ease</p>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="d-flex gap-2">
            <a href="/books/create" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>
                Add New Book
            </a>
            <a href="/books/lookup-isbn" class="btn btn-success btn-lg" title="Search Google Books API by ISBN number">
                <i class="fas fa-barcode me-2"></i>
                Add by ISBN
                <small class="d-block" style="font-size: 0.7rem; opacity: 0.8;">Google Books API</small>
            </a>
        </div>
    </div>
    <div class="col-md-6 text-md-end">
        <div class="d-flex align-items-center justify-content-md-end">
            <span class="text-muted me-3">
                <i class="fas fa-book me-1"></i>
                <?= count($books) ?> book<?= count($books) !== 1 ? 's' : '' ?>
            </span>
        </div>
    </div>
</div>

<!-- Filter and Sort Controls -->
<div class="card mb-4 filter-controls">
    <div class="card-body">
        <form method="get" action="/books" class="row g-3 align-items-end">
            <!-- Genre Filter -->
            <div class="col-md-3">
                <label for="genre" class="form-label">
                    <i class="fas fa-tag me-2"></i>Filter by Genre
                </label>
                <select name="genre" id="genre" class="form-select" onchange="this.form.submit()">
                    <option value="all" <?= $currentGenre === 'all' ? 'selected' : '' ?>>All Genres</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= esc($genre['genre']) ?>" <?= $currentGenre === $genre['genre'] ? 'selected' : '' ?>>
                            <?= esc($genre['genre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Sort By -->
            <div class="col-md-3">
                <label for="sort_by" class="form-label">
                    <i class="fas fa-sort me-2"></i>Sort By
                </label>
                <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                    <option value="title" <?= $currentSortBy === 'title' ? 'selected' : '' ?>>Book Title</option>
                    <option value="publication_year" <?= $currentSortBy === 'publication_year' ? 'selected' : '' ?>>Publication Year</option>
                    <option value="date_added" <?= $currentSortBy === 'date_added' ? 'selected' : '' ?>>Date Added</option>
                </select>
            </div>
            
            <!-- Sort Order -->
            <div class="col-md-3">
                <label for="sort_order" class="form-label">
                    <i class="fas fa-sort-amount-down me-2"></i>Sort Order
                </label>
                <select name="sort_order" id="sort_order" class="form-select" onchange="this.form.submit()">
                    <option value="asc" <?= $currentSortOrder === 'asc' ? 'selected' : '' ?>>Ascending</option>
                    <option value="desc" <?= $currentSortOrder === 'desc' ? 'selected' : '' ?>>Descending</option>
                </select>
            </div>
            
            <!-- Clear Filters -->
            <div class="col-md-3">
                <a href="/books" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times me-2"></i>Clear Filters
                </a>
            </div>
        </form>
    </div>
</div>



<?php if (empty($books)): ?>
    <div class="card">
        <div class="card-body empty-state">
            <i class="fas fa-books"></i>
            <h4 class="mb-3">No books found</h4>
            <p class="text-muted mb-4">
                <?php if ($currentGenre !== 'all'): ?>
                    No books found in the "<?= esc($currentGenre) ?>" genre.
                <?php else: ?>
                    Start building your library by adding your first book.
                <?php endif; ?>
            </p>
            <a href="/books/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Add Your First Book
            </a>
        </div>
    </div>
<?php else: ?>
    <!-- Results Summary -->
    <div class="mb-3 results-summary">
        <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Showing <?= count($books) ?> book<?= count($books) !== 1 ? 's' : '' ?>
            <?php if ($currentGenre !== 'all'): ?>
                in "<?= esc($currentGenre) ?>" genre
            <?php endif; ?>
            sorted by <?= 
                $currentSortBy === 'title' ? 'book title' : 
                ($currentSortBy === 'publication_year' ? 'publication year' : 'date added')
            ?> 
            (<?= $currentSortOrder === 'asc' ? 'A-Z' : 'Z-A' ?>)
        </small>
        <small class="text-muted d-block mt-1">
            <i class="fas fa-shield-alt me-1"></i>
            Duplicate protection is active - you cannot add the same book twice
        </small>
        <small class="text-muted d-block mt-1">
            <i class="fas fa-mouse-pointer me-1"></i>
            <strong>Tip:</strong> Click on any book row to view detailed information
        </small>
    </div>

    <!-- Books Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-3">
                                <i class="fas fa-book me-2 text-primary"></i>Title
                            </th>
                            <th scope="col">
                                <i class="fas fa-user me-2 text-success"></i>Author
                            </th>
                            <th scope="col">
                                <i class="fas fa-tag me-2 text-info"></i>Genre
                            </th>
                            <th scope="col">
                                <i class="fas fa-calendar me-2 text-warning"></i>Published
                            </th>
                            <th scope="col">
                                <i class="fas fa-clock me-2 text-info"></i>Date Added
                            </th>
                            <th scope="col" class="text-center">
                                <i class="fas fa-cogs me-2 text-secondary"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                        <tr class="book-row" onclick="showBookDetails(<?= htmlspecialchars(json_encode($book), ENT_QUOTES, 'UTF-8') ?>)" style="cursor: pointer;">
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="book-icon me-3">
                                        <i class="fas fa-book text-primary"></i>
                                    </div>
                                    <div>
                                        <strong class="book-title"><?= esc($book['title']) ?></strong>
                                        <div class="text-muted small">ID: <?= $book['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="author-name"><?= esc($book['author']) ?></span>
                            </td>
                            <td>
                                <span class="badge genre-badge" data-genre="<?= esc($book['genre']) ?>" style="background-color: <?= getGenreColor($book['genre']) ?>; color: white; border: none;">
                                    <?= esc($book['genre']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="publication-year"><?= esc($book['publication_year']) ?></span>
                            </td>
                            <td>
                                <span class="date-added" title="<?= date('F j, Y \a\t g:i A', strtotime($book['created_at'])) ?>">
                                    <?= date('M j, Y', strtotime($book['created_at'])) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="/books/edit/<?= $book['id'] ?>" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit Book">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmDelete('<?= esc($book['title']) ?>', <?= $book['id'] ?>)"
                                            title="Delete Book">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination Info -->
    <div class="mt-3 text-center">
        <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Showing all <?= count($books) ?> books. 
            <?php if (count($books) > 100): ?>
                Consider using filters to narrow down results for better performance.
            <?php endif; ?>
        </small>
    </div>
<?php endif; ?>

<!-- Book Details Modal -->
<div class="modal fade" id="bookDetailsModal" tabindex="-1" aria-labelledby="bookDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookDetailsModalLabel">
                    <i class="fas fa-book me-2"></i>
                    Book Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="bookDetailsContent">
                    <!-- Book details will be populated here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="editBookBtn" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Book
                </a>
            </div>
        </div>
    </div>
</div>

<style>




        /* Dark mode empty state styling */
        html[data-bs-theme="dark"] .empty-state {
            color: #e5e7eb;
        }

        html[data-bs-theme="dark"] .empty-state h4 {
            color: #f9fafb;
        }

        html[data-bs-theme="dark"] .empty-state p {
            color: #9ca3af;
        }

        /* Dark mode book count styling */
        html[data-bs-theme="dark"] .text-muted {
            color: #9ca3af !important;
        }

        /* Dark mode filter controls enhancement */
        html[data-bs-theme="dark"] .filter-controls {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        /* Table styling */
        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--primary-color);
            background: rgba(99, 102, 241, 0.05);
        }

        .book-row {
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
        }

        .book-row:hover {
            background: rgba(99, 102, 241, 0.05);
            transform: translateX(2px);
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
        }

        .book-row::after {
            content: '👁️';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.2s ease;
            font-size: 0.8rem;
        }

        .book-row:hover::after {
            opacity: 1;
        }

        /* Table row animations */
        .book-row {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hover effects for better interactivity */
        .book-row:hover {
            background: rgba(99, 102, 241, 0.08) !important;
            transform: translateX(4px) !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15) !important;
        }

        /* Active state for clicked rows */
        .book-row:active {
            transform: translateX(2px) scale(0.98) !important;
            transition: transform 0.1s ease;
        }

        .book-title {
            color: var(--primary-color);
            font-size: 1rem;
        }

        .author-name {
            font-weight: 500;
            color: #374151;
        }

        .publication-year {
            font-weight: 600;
            color: #059669;
        }

        .date-added {
            font-weight: 500;
            color: #6B7280;
            font-size: 0.9rem;
        }

        .genre-badge {
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .genre-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn-group .btn {
            border-radius: 6px;
            margin: 0 2px;
        }

        .book-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 8px;
        }

        /* Dark mode table styling */
        html[data-bs-theme="dark"] .table th {
            background: rgba(99, 102, 241, 0.1);
            color: #d1d5db;
        }

        html[data-bs-theme="dark"] .book-row:hover {
            background: rgba(99, 102, 241, 0.1);
        }

        html[data-bs-theme="dark"] .book-title {
            color: #f9fafb;
        }

        html[data-bs-theme="dark"] .author-name {
            color: #e5e7eb;
        }

        html[data-bs-theme="dark"] .publication-year {
            color: #10b981;
        }

        html[data-bs-theme="dark"] .date-added {
            color: #9ca3af;
        }

        html[data-bs-theme="dark"] .genre-badge {
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        html[data-bs-theme="dark"] .book-icon {
            background: rgba(99, 102, 241, 0.2);
        }

        .genre-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .genre-legend-item {
            transition: all 0.2s ease;
        }

        .genre-legend-item:hover {
            transform: translateY(-2px);
        }

        /* Modal and Book Details Styling */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border-bottom: none;
            border-radius: 16px 16px 0 0;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .book-details .row {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 0.75rem 0;
        }

        .book-details .row:last-child {
            border-bottom: none;
        }

        .book-cover-placeholder {
            padding: 2rem;
            background: rgba(99, 102, 241, 0.05);
            border-radius: 12px;
            border: 2px dashed rgba(99, 102, 241, 0.2);
        }

        .book-stats {
            background: rgba(99, 102, 241, 0.05);
            padding: 1rem;
            border-radius: 8px;
        }

        .stat-item {
            text-align: center;
        }

        /* Dark mode modal styling */
        html[data-bs-theme="dark"] .modal-content {
            background: rgba(31, 41, 55, 0.95);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }

        html[data-bs-theme="dark"] .book-details .row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        html[data-bs-theme="dark"] .book-cover-placeholder {
            background: rgba(99, 102, 241, 0.1);
            border-color: rgba(99, 102, 241, 0.3);
        }

        html[data-bs-theme="dark"] .book-stats {
            background: rgba(99, 102, 241, 0.1);
        }

        /* Dark mode loading overlay */
                html[data-bs-theme="dark"] .loading-overlay {
            background: rgba(31, 41, 55, 0.95);
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .book-card {
                margin-bottom: 1rem;
            }
            
            .info-row strong {
                min-width: 60px;
            }
            
            .d-flex.gap-2 {
                flex-direction: column;
            }
            
            .btn-lg {
                padding: 0.75rem 1rem;
                font-size: 1rem;
            }
        }
</style>

<script>
function confirmDelete(bookTitle, bookId) {
    if (confirm(`Are you sure you want to delete "${bookTitle}"? This action cannot be undone.`)) {
        window.location.href = `/books/delete/${bookId}`;
    }
}

function showBookDetails(book) {
    console.log('showBookDetails called with:', book); // Debug log
    
    // Format the date added
    const dateAdded = new Date(book.created_at);
    const formattedDate = dateAdded.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Generate genre color
    const genreColor = getGenreColor(book.genre);
    
    // Populate modal content
    const modalContent = `
        <div class="row">
            <div class="col-md-8">
                <div class="book-details">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Title:</strong>
                        </div>
                        <div class="col-sm-9">
                            <h4 class="mb-0 text-primary">${book.title}</h4>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Author:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fs-5">${book.author}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Genre:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge" style="background-color: ${genreColor}; color: white; border: none; padding: 0.5rem 1rem; font-size: 1rem;">
                                ${book.genre}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Published:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fs-5 text-success">${book.publication_year}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Date Added:</strong>
                        </div>
                        <div class="col-sm-9">
                            <span class="fs-5 text-info">${formattedDate}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Book ID:</strong>
                        </div>
                        <div class="col-sm-9">
                            <code class="fs-6">${book.id}</code>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong class="text-muted">Description:</strong>
                        </div>
                        <div class="col-sm-9">
                            <div class="book-description">
                                ${book.description ? book.description : '<em class="text-muted">No description available</em>'}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="text-center">
                    <div class="book-cover-placeholder mb-3">
                        <i class="fas fa-book fa-4x text-muted"></i>
                        <p class="text-muted mt-2">No cover image available</p>
                    </div>
                    
                    <div class="book-stats">
                        <div class="stat-item mb-2">
                            <small class="text-muted">Added to library</small><br>
                            <strong>${dateAdded.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Update modal content
    document.getElementById('bookDetailsContent').innerHTML = modalContent;
    
    // Update edit button href
    document.getElementById('editBookBtn').href = `/books/edit/${book.id}`;
    
    // Show the modal
    window.bookModal.show();
}

// Function to generate genre colors (same as PHP function)
function getGenreColor(genre) {
    const genreColors = {
        'Fiction': '#3B82F6',
        'Non-Fiction': '#10B981',
        'Mystery': '#8B5CF6',
        'Romance': '#EC4899',
        'Science Fiction': '#06B6D4',
        'Fantasy': '#F59E0B',
        'Thriller': '#EF4444',
        'Biography': '#84CC16',
        'History': '#F97316',
        'Self-Help': '#6366F1',
        'Action': '#DC2626',
        'Other': '#6B7280'
    };
    
    if (genreColors[genre]) {
        return genreColors[genre];
    }
    
    // Generate unique color for new genres
    let hash = 0;
    for (let i = 0; i < genre.length; i++) {
        const char = genre.charCodeAt(i);
        hash = ((hash << 5) - hash) + char;
        hash = hash & hash; // Convert to 32-bit integer
    }
    
    const hue = Math.abs(hash) % 360;
    const saturation = 70 + (Math.abs(hash) % 20);
    const lightness = 45 + (Math.abs(hash) % 15);
    
    return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
}

// Add table row animations
document.addEventListener('DOMContentLoaded', function() {
    const bookRows = document.querySelectorAll('.book-row');
    bookRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
        row.classList.add('fade-in');
    });

    // Initialize Bootstrap modal
    const bookModal = new bootstrap.Modal(document.getElementById('bookDetailsModal'));
    
    // Make modal globally accessible
    window.bookModal = bookModal;
    
    console.log('Modal initialized:', bookModal); // Debug log
    console.log('Modal element:', document.getElementById('bookDetailsModal')); // Debug log

    // Enhanced filter form handling
    const filterForm = document.querySelector('form[action="/books"]');
    if (filterForm) {
        const filterSelects = filterForm.querySelectorAll('select');
        
        // Add loading state to form
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Add loading class to the form
                filterForm.classList.add('loading');
                
                // Show loading indicator
                const loadingIndicator = document.createElement('div');
                loadingIndicator.className = 'loading-overlay';
                loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                filterForm.appendChild(loadingIndicator);
                
                // Submit form after a short delay to show loading state
                setTimeout(() => {
                    filterForm.submit();
                }, 300);
            });
        });

        // Add smooth scrolling to top when filters change
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                setTimeout(() => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 100);
            });
        });
    }
});
</script>

<style>
.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: var(--primary-color);
    font-weight: 600;
    border-radius: 8px;
    z-index: 10;
}

body[data-bs-theme="dark"] .loading-overlay {
    background: rgba(31, 41, 55, 0.95);
    color: var(--primary-color);
}

body[data-bs-theme="dark"] .empty-state {
    color: #e5e7eb;
}

body[data-bs-theme="dark"] .empty-state h4 {
    color: #f9fafb;
}

        body[data-bs-theme="dark"] .empty-state p {
            color: #9ca3af;
        }

        /* Dark mode book count styling */
        body[data-bs-theme="dark"] .text-muted {
            color: #9ca3af !important;
        }

        /* Dark mode filter controls enhancement */
        body[data-bs-theme="dark"] .filter-controls {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        /* Dark mode book card hover effect */
        body[data-bs-theme="dark"] .book-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            transform: translateY(-8px);
        }

        /* Book description styling */
        .book-description {
            background: rgba(99, 102, 241, 0.05);
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            line-height: 1.6;
            max-height: 200px;
            overflow-y: auto;
        }

        .book-description em {
            font-style: italic;
            color: #6b7280;
        }

        html[data-bs-theme="dark"] .book-description {
            background: rgba(99, 102, 241, 0.1);
            border-left-color: var(--primary-color);
        }

        html[data-bs-theme="dark"] .book-description em {
            color: #9ca3af;
        }

.loading {
    position: relative;
}

.loading .loading-overlay {
    animation: fadeIn 0.3s ease;
}
</style>

<?= $this->endSection() ?>
