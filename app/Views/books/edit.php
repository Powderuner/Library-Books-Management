<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">✏️ Edit Book</h2>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<form action="/books/update/<?= esc($book['id']) ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?= esc($book['title']) ?>">
    </div>

    <div class="mb-3">
        <label for="author" class="form-label">Author</label>
        <input type="text" name="author" class="form-control" value="<?= esc($book['author']) ?>">
    </div>

    <div class="mb-3">
        <label for="genre" class="form-label">Genre</label>
        <input type="text" name="genre" class="form-control" value="<?= esc($book['genre']) ?>">
    </div>

    <div class="mb-3">
        <label for="year" class="form-label">Publication Year</label>
        <input type="text" name="year" class="form-control" value="<?= esc($book['publication_year']) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="/books" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>
