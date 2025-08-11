<?php

namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\Controller;

class Books extends Controller
{
    protected $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        $data['books'] = $this->bookModel->findAll();
        return view('books/index', $data);
    }

    public function create()
    {
        return view('books/create');
    }

    public function store()
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'genre' => $this->request->getPost('genre'),
            'publication_year' => $this->request->getPost('year'),
        ];

        if (!$this->bookModel->insert($data)) {
            return redirect()->back()->withInput()->with('validation', $this->bookModel->errors());
        }

        return redirect()->to('/books')->with('success', 'Book added successfully.');
    }

    public function edit($id)
    {
        $book = $this->bookModel->find($id);
        if (!$book) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Book not found');
        }

        return view('books/edit', ['book' => $book]);
    }

    public function update($id)
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'genre' => $this->request->getPost('genre'),
            'publication_year' => $this->request->getPost('year'),
        ];

        if (!$this->bookModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('validation', $this->bookModel->errors());
        }

        return redirect()->to('/books')->with('success', 'Book updated successfully.');
    }

    public function delete($id)
    {
        $this->bookModel->delete($id);
        return redirect()->to('/books')->with('success', 'Book deleted successfully.');
    }
}
