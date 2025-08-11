<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-search me-3"></i>
        Add Book by ISBN
    </h1>
    <p class="page-subtitle">Search for books using their ISBN number and add them to your library</p>
</div>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Search Error:</strong> <?= session()->getFlashdata('error') ?>
        <hr class="my-2">
        <small class="mb-0">
            <i class="fas fa-lightbulb me-1"></i>
            <strong>Tips:</strong> Try entering the ISBN without hyphens (e.g., 0743273567 instead of 0-7432-7356-7), 
            or check if the ISBN is correct. You can also test the API at <a href="/books/test-api" class="alert-link">/books/test-api</a>
        </small>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-barcode fa-3x text-primary mb-3"></i>
                    <h4>Enter ISBN Number</h4>
                    <p class="text-muted">Enter the 10 or 13 digit ISBN number from the back of the book</p>
                </div>

                <form action="/books/search-isbn" method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>
                    
                    <div class="mb-4">
                        <label for="isbn" class="form-label">
                            <i class="fas fa-barcode me-2"></i>ISBN Number
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg text-center" 
                               id="isbn" 
                               name="isbn" 
                               placeholder="e.g., 978-0-7475-3269-9 or 0747532699"
                               value="<?= old('isbn') ?>"
                               maxlength="20"
                               required>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            You can enter ISBN with or without hyphens. The system will automatically clean the format.
                        </div>
                        <div class="invalid-feedback">
                            Please enter a valid ISBN number.
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>
                            Search for Book
                        </button>
                        <a href="/books" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Books
                        </a>
                    </div>
                </form>

                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="mb-2">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>
                        How to find ISBN:
                    </h6>
                    <ul class="mb-0 small text-muted">
                        <li>Look on the back cover of the book</li>
                        <li>Check the copyright page inside the book</li>
                        <li>ISBN is usually 10 or 13 digits long</li>
                        <li>May include hyphens or spaces</li>
                    </ul>
                </div>

                <div class="mt-3 p-3 bg-info rounded">
                    <h6 class="mb-2">
                        <i class="fas fa-shield-alt me-2 text-white"></i>
                        Duplicate Protection:
                    </h6>
                    <p class="mb-0 small text-white">
                        The system automatically checks if a book already exists in your library. 
                        You cannot add the same book twice, preventing duplicates and keeping your 
                        collection organized.
                    </p>
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

.form-control-lg {
    font-size: 1.1rem;
    letter-spacing: 1px;
}

.bg-light {
    background: rgba(99, 102, 241, 0.05) !important;
}

.bg-info {
    background: rgba(6, 182, 212, 0.1) !important;
    border: 1px solid rgba(6, 182, 212, 0.2);
}

html[data-bs-theme="dark"] .bg-light {
    background: rgba(99, 102, 241, 0.1) !important;
}

html[data-bs-theme="dark"] .bg-info {
    background: rgba(6, 182, 212, 0.15) !important;
    border: 1px solid rgba(6, 182, 212, 0.3);
}

html[data-bs-theme="dark"] .card {
    background: rgba(31, 41, 55, 0.9);
    border: 1px solid rgba(75, 85, 99, 0.3);
}

html[data-bs-theme="dark"] .text-muted {
    color: #9ca3af !important;
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

// Auto-format ISBN input
document.getElementById('isbn').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^0-9X]/g, '');
    
    // Format as ISBN-13 if 13 digits, otherwise as ISBN-10
    if (value.length >= 13) {
        value = value.substring(0, 13);
        if (value.length === 13) {
            value = value.replace(/(\d{3})(\d{1})(\d{4})(\d{4})(\d{1})/, '$1-$2-$3-$4-$5');
        }
    } else if (value.length >= 10) {
        value = value.substring(0, 10);
        if (value.length === 10) {
            value = value.replace(/(\d{1})(\d{4})(\d{4})(\d{1})/, '$1-$2-$3-$4');
        }
    }
    
    e.target.value = value;
});

// Also handle paste events
document.getElementById('isbn').addEventListener('paste', function(e) {
    setTimeout(() => {
        let value = e.target.value.replace(/[^0-9X]/g, '');
        
        if (value.length >= 13) {
            value = value.substring(0, 13);
            if (value.length === 13) {
                value = value.replace(/(\d{3})(\d{1})(\d{4})(\d{4})(\d{1})/, '$1-$2-$3-$4-$5');
            }
        } else if (value.length >= 10) {
            value = value.substring(0, 10);
            if (value.length === 10) {
                value = value.replace(/(\d{1})(\d{4})(\d{4})(\d{1})/, '$1-$2-$3-$4');
            }
        }
        
        e.target.value = value;
    }, 10);
});
</script>

<?= $this->endSection() ?>
