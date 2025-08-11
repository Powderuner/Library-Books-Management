<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = ['title', 'author', 'genre', 'publication_year', 'description'];

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

    /**
     * Get books with filtering and sorting
     */
    public function getFilteredBooks($genre = null, $sortBy = 'title', $sortOrder = 'asc')
    {
        $builder = $this->builder();
        
        // Apply genre filter if specified
        if ($genre && $genre !== 'all') {
            $builder->where('genre', $genre);
        }
        
        // Apply sorting
        switch ($sortBy) {
            case 'publication_year':
                $builder->orderBy('publication_year', $sortOrder);
                break;
            case 'date_added':
                $builder->orderBy('created_at', $sortOrder);
                break;
            case 'title':
            default:
                $builder->orderBy('title', $sortOrder);
                break;
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get all unique genres for filter dropdown
     */
    public function getGenres()
    {
        return $this->distinct()->select('genre')->where('genre IS NOT NULL')->where('genre !=', '')->findAll();
    }

    /**
     * Check if a book already exists in the inventory
     */
    public function bookExists($title, $author)
    {
        // Clean and normalize the title and author for comparison
        $cleanTitle = trim(strtolower($title));
        $cleanAuthor = trim(strtolower($author));
        
        // Check for exact matches first
        $existingBook = $this->where('LOWER(title)', $cleanTitle)
                            ->where('LOWER(author)', $cleanAuthor)
                            ->first();
        
        if ($existingBook) {
            return $existingBook;
        }
        
        // Check for similar titles (fuzzy matching)
        $similarBooks = $this->where('LOWER(title) LIKE', "%{$cleanTitle}%")
                            ->where('LOWER(author)', $cleanAuthor)
                            ->findAll();
        
        if (!empty($similarBooks)) {
            return $similarBooks[0]; // Return first similar book
        }
        
        return null;
    }

    /**
     * Check if a book exists by ISBN
     */
    public function bookExistsByISBN($isbn)
    {
        // Clean ISBN for comparison
        $cleanIsbn = preg_replace('/[^0-9X]/', '', $isbn);
        
        // Check if ISBN already exists in the database
        // Note: This would require adding an ISBN field to the books table
        // For now, we'll use title + author as the primary duplicate check
        
        return null;
    }

    /**
     * Fetch book information from Google Books API using ISBN
     */
    public function fetchBookByISBN($isbn)
    {
        // Clean ISBN (remove hyphens, spaces, and X for validation)
        $cleanIsbn = preg_replace('/[^0-9X]/', '', $isbn);
        
        // Log the original and cleaned ISBN for debugging
        log_message('info', "ISBN Lookup - Original: {$isbn}, Cleaned: {$cleanIsbn}");
        
        $apiKey = 'AIzaSyDz1l8t5ns08jci9GcunMFxAi1TGuDdjCI';
        
        // Try both with and without hyphens for better API results
        $urls = [
            "https://www.googleapis.com/books/v1/volumes?q=isbn:{$cleanIsbn}&key={$apiKey}",
            "https://www.googleapis.com/books/v1/volumes?q=isbn:{$isbn}&key={$apiKey}"
        ];
        
        foreach ($urls as $url) {
            log_message('info', "Trying URL: {$url}");
            
            // Use cURL for better error handling
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'LibraryManager/1.0');
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            log_message('info', "HTTP Code: {$httpCode}, Error: {$error}");
            
            if ($error) {
                log_message('error', "cURL Error: {$error}");
                continue;
            }
            
            if ($httpCode !== 200 || !$response) {
                log_message('warning', "HTTP Error: {$httpCode}, Response: " . substr($response, 0, 100));
                continue;
            }
            
            $data = json_decode($response, true);
            
            if (!$data) {
                log_message('warning', "JSON decode failed for URL: {$url}");
                continue;
            }
            
            log_message('info', "API Response: " . json_encode(array_keys($data)));
            
            if (!isset($data['items']) || empty($data['items'])) {
                log_message('info', "No items found in API response");
                continue;
            }
            
            $book = $data['items'][0]['volumeInfo'];
            log_message('info', "Book found: " . ($book['title'] ?? 'No title'));
            
            // Extract publication year from publishedDate
            $publishedYear = null;
            if (isset($book['publishedDate'])) {
                $publishedYear = substr($book['publishedDate'], 0, 4);
            }
            
            // Determine genre based on categories
            $genre = 'Other';
            if (isset($book['categories']) && !empty($book['categories'])) {
                $categories = $book['categories'];
                $genre = $categories[0]; // Use first category as genre
            }
            
            // Clean up description (remove HTML tags and limit length)
            $description = '';
            if (isset($book['description'])) {
                $description = strip_tags($book['description']);
                if (strlen($description) > 500) {
                    $description = substr($description, 0, 500) . '...';
                }
            }
            
            return [
                'title' => $book['title'] ?? 'Unknown Title',
                'author' => isset($book['authors']) ? implode(', ', $book['authors']) : 'Unknown Author',
                'genre' => $genre,
                'publication_year' => $publishedYear ?? date('Y'),
                'description' => $description,
                'isbn' => $cleanIsbn,
                'page_count' => $book['pageCount'] ?? null,
                'language' => $book['language'] ?? 'en',
                'publisher' => $book['publisher'] ?? '',
                'image_url' => isset($book['imageLinks']['thumbnail']) ? $book['imageLinks']['thumbnail'] : null
            ];
        }
        
        log_message('error', "No book found for ISBN: {$isbn} after trying all URLs");
        return null;
    }
}
