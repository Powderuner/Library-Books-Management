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
        // Get filter and sort parameters
        $genre = $this->request->getGet('genre') ?? 'all';
        $sortBy = $this->request->getGet('sort_by') ?? 'title';
        $sortOrder = $this->request->getGet('sort_order') ?? 'asc';
        
        // Validate sort parameters
        if (!in_array($sortBy, ['title', 'publication_year', 'date_added'])) {
            $sortBy = 'title';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }
        
        // Get filtered and sorted books
        $data['books'] = $this->bookModel->getFilteredBooks($genre, $sortBy, $sortOrder);
        
        // Get all genres for filter dropdown
        $data['genres'] = $this->bookModel->getGenres();
        
        // Pass current filter and sort state
        $data['currentGenre'] = $genre;
        $data['currentSortBy'] = $sortBy;
        $data['currentSortOrder'] = $sortOrder;
        
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
            'description' => $this->request->getPost('description'),
        ];

        // Check if book already exists
        $existingBook = $this->bookModel->bookExists($data['title'], $data['author']);
        
        if ($existingBook) {
            return redirect()->back()->withInput()->with('error', 'This book already exists in your library! Book: "' . $existingBook['title'] . '" by ' . $existingBook['author'] . ' (Added on ' . date('M j, Y', strtotime($existingBook['created_at'])) . ')');
        }

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
            'description' => $this->request->getPost('description'),
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

    public function lookupISBN()
    {
        return view('books/isbn/lookup_isbn');
    }

    public function searchISBN()
    {
        $isbn = $this->request->getPost('isbn');
        
        if (empty($isbn)) {
            return redirect()->back()->with('error', 'Please enter an ISBN number.');
        }
        
        // Clean ISBN (remove hyphens and spaces)
        $cleanIsbn = preg_replace('/[^0-9X]/', '', $isbn);
        
        // Log the search attempt
        log_message('info', "ISBN Search - Original: {$isbn}, Cleaned: {$cleanIsbn}");
        
        if (strlen($cleanIsbn) !== 10 && strlen($cleanIsbn) !== 13) {
            return redirect()->back()->with('error', 'Please enter a valid 10 or 13 digit ISBN number. You entered: ' . strlen($cleanIsbn) . ' digits.');
        }
        
        $bookData = $this->bookModel->fetchBookByISBN($isbn);
        
        if (!$bookData) {
            log_message('warning', "No book found for ISBN: {$isbn} (cleaned: {$cleanIsbn})");
            return redirect()->back()->with('error', 'No book found with this ISBN: ' . $isbn . '. Please check the number and try again. You can also try entering the ISBN without hyphens.');
        }
        
        // Check if book already exists in the library
        $existingBook = $this->bookModel->bookExists($bookData['title'], $bookData['author']);
        
        if ($existingBook) {
            return redirect()->back()->with('error', 'This book is already in your library! "' . $existingBook['title'] . '" by ' . $existingBook['author'] . ' (Added on ' . date('M j, Y', strtotime($existingBook['created_at'])) . '). You cannot add the same book twice.');
        }
        
        log_message('info', "Book found successfully for ISBN: {$isbn}");
        return view('books/isbn/confirm_book', ['book' => $bookData]);
    }

    public function addFromISBN()
    {
        $bookData = [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'genre' => $this->request->getPost('genre'),
            'publication_year' => $this->request->getPost('publication_year'),
            'description' => $this->request->getPost('description'),
        ];

        // Check if book already exists
        $existingBook = $this->bookModel->bookExists($bookData['title'], $bookData['author']);
        
        if ($existingBook) {
            return redirect()->back()->withInput()->with('error', 'This book already exists in your library! Book: "' . $existingBook['title'] . '" by ' . $existingBook['author'] . ' (Added on ' . date('M j, Y', strtotime($existingBook['created_at'])) . ')');
        }

        if (!$this->bookModel->insert($bookData)) {
            return redirect()->back()->withInput()->with('validation', $this->bookModel->errors());
        }

        return redirect()->to('/books')->with('success', 'Book added successfully from ISBN lookup!');
    }

    public function testAPI()
    {
        // Test with a known ISBN to verify API is working
        $testIsbn = '9780747532699'; // Harry Potter and the Philosopher's Stone
        $bookData = $this->bookModel->fetchBookByISBN($testIsbn);
        
        if ($bookData) {
            echo "API Test Successful!<br>";
            echo "Book: " . $bookData['title'] . " by " . $bookData['author'] . "<br>";
            echo "Genre: " . $bookData['genre'] . "<br>";
            echo "Year: " . $bookData['publication_year'] . "<br>";
        } else {
            echo "API Test Failed!<br>";
            echo "Check the logs for more details.<br>";
        }
        
        // Also test the specific ISBN you're trying
        $yourIsbn = '0743273567';
        $yourBookData = $this->bookModel->fetchBookByISBN($yourIsbn);
        
        if ($yourBookData) {
            echo "<br>Your ISBN Test Successful!<br>";
            echo "Book: " . $yourBookData['title'] . " by " . $yourBookData['author'] . "<br>";
        } else {
            echo "<br>Your ISBN Test Failed!<br>";
            echo "ISBN: {$yourIsbn}<br>";
        }
        
        exit;
    }
}
