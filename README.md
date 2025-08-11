# Library Books Management System

A modern web application for managing library book collections. Built with CodeIgniter 4, it features a clean interface for adding, organizing, and tracking books with support for ISBN lookup via Google Books API.

## ✨ Key Features

- **Book Management**: Add, edit, delete, and organize books
- **ISBN Integration**: Look up books automatically using Google Books API
- **Smart Filtering**: Filter by genre, sort by title, publication year, or date added
- **Duplicate Prevention**: Prevents adding the same book twice
- **Responsive Design**: Works perfectly on desktop and mobile devices
- **Dark Mode**: Beautiful dark/light theme switching

## 🚀 Quick Setup

### Prerequisites
- PHP 7.4+ 
- MySQL 5.7+ or MariaDB 10.2+
- Composer
- Web server (Apache/Nginx) or use built-in server

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Powderuner/Library-Books-Management.git
   cd Library-Books-Management
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Database setup**
   ```bash
   # Option 1: Import SQL file (Recommended)
   # Open phpMyAdmin and import database_setup.sql
   # OR use MySQL command line:
   mysql -u root -p < database_setup.sql
   
   # Option 2: Manual setup
   mysql -u root -p
   CREATE DATABASE library_db;
   EXIT;
   
   # Run migrations
   php spark migrate
   ```

4. **Configure environment**
   ```bash
   # Copy environment file
   cp env .env
   
   # Edit .env with your database details
   database.default.hostname = 127.0.0.1
   database.default.database = library_db
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   ```

5. **Start the application**
   ```bash
   # Development server
   php spark serve
   
   # Or access via your web server
   # http://localhost/Library-Books-Management/public
   ```

## 🎯 Usage

- **Add Books**: Manual entry or ISBN lookup
- **Organize**: Filter by genre, sort by various criteria
- **View Details**: Click any book row to see full information
- **Manage**: Edit or delete books as needed

## 🛠️ Project Structure

```
Library-Books-Management/
├── app/
│   ├── Controllers/     # Book management logic
│   ├── Models/         # Database interactions
│   ├── Views/          # User interface templates
│   └── Database/       # Database migrations
├── public/             # Web-accessible files
├── system/             # CodeIgniter framework
└── database_setup.sql  # Complete database setup file
```

## 🔧 Configuration

- **Google Books API**: Add your API key in `BookModel.php` for ISBN lookup
- **Database**: Configure in `.env` file
- **Theme**: Dark/light mode toggle in the interface

## 📱 Access

- **Local Development**: http://localhost:8080
- **Production**: Configure your web server to point to the `public/` directory


