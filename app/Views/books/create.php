<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">📖 Add New Book</h2>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<form action="/books/store" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= old('title') ?>">
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Author</label>
        <input type="text" name="author" class="form-control" value="<?= old('author') ?>">
    </div>

    <div class="mb-3">
        <label for="genre" class="form-label">Genre</label>
        <input type="text" name="genre" class="form-control" value="<?= old('genre') ?>">
    </div>

    <div class="mb-3">
        <label for="year" class="form-label">Publication Year</label>
        <input type="text" name="year" class="form-control" value="<?= old('year') ?>">
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="/books" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>
