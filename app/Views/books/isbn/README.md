# ISBN Functionality Views

This folder contains the view files for the ISBN lookup and book addition functionality.

## Files

### `lookup_isbn.php`
- **Purpose**: Form for users to enter ISBN numbers to search for books
- **Features**: 
  - ISBN input with auto-formatting
  - Input validation
  - Helpful instructions for finding ISBNs
  - Duplicate protection information
  - Dark mode support

### `confirm_book.php`
- **Purpose**: Confirmation page showing book details fetched from Google Books API
- **Features**:
  - Displays book information (title, author, genre, publication year, etc.)
  - Shows book cover image if available
  - Confirmation buttons to add book or search another ISBN
  - Dark mode support
  - Responsive design

## Functionality

These views work together to provide a seamless ISBN-based book addition experience:

1. **ISBN Input** → User enters ISBN in `lookup_isbn.php`
2. **API Search** → System searches Google Books API
3. **Book Confirmation** → User reviews book details in `confirm_book.php`
4. **Library Addition** → Book is added to the library (if not duplicate)

## Integration

- **Controller**: `app/Controllers/Books.php` handles the logic
- **Model**: `app/Models/BookModel.php` manages API calls and data
- **Routes**: Defined in `app/Config/Routes.php`
- **Main Interface**: Integrated into `app/Views/books/index.php`

## Features

- ✅ Google Books API integration
- ✅ Duplicate book prevention
- ✅ ISBN auto-formatting
- ✅ Dark mode support
- ✅ Responsive design
- ✅ Input validation
- ✅ Error handling
- ✅ User guidance
