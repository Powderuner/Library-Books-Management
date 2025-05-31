<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'author', 'genre', 'publication_year'];

    protected $validationRules = [
        'title' => 'required',
        'author' => 'required',
        'publication_year' => 'required|numeric|exact_length[4]',
    ];

    protected $validationMessages = [
        'publication_year' => [
            'required' => 'The publication year field is required.',
            'numeric' => 'Publication year must be a number.',
            'exact_length' => 'Publication year must be exactly 4 digits.',
        ],
    ];
}
