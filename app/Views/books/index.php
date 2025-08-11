<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">📚 List of Books</h2>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<a class="btn btn-primary mb-3" href="/books/create">Add New Book</a>

<table class="table table-bordered table-dark table-hover">
    <thead>
        <tr>
            <th>Title</th><th>Author</th><th>Genre</th><th>Publication Year</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
        <tr>
            <td><?= esc($book['title']) ?></td>
            <td><?= esc($book['author']) ?></td>
            <td><?= esc($book['genre']) ?></td>
            <td><?= esc($book['publication_year']) ?></td>
            <td>
                <a href="/books/edit/<?= $book['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                <form action="/books/delete/<?= $book['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this book?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
