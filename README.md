# Library Books Management System

A modern and efficient Library Books Management System built with CodeIgniter 4 and MySQL. This application provides a complete solution for managing library books, including CRUD operations, form validation, and a responsive user interface.

## 🚀 Features

- **Book Management**
  - Create, Read, Update, and Delete book records
  - Detailed book information management
  - Form validation for data integrity
  - Responsive design for all devices

- **Technical Features**
  - Built with CodeIgniter 4 framework
  - MySQL database for reliable data storage
  - Clean and intuitive user interface

## 📋 Prerequisites

Before you begin, ensure you have the following installed:
- PHP 7.4 or higher
- XAMPP (includes Apache and MySQL)
- Composer (PHP package manager)
- Git

## 🛠️ Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/Powderuner/Library-Books-Management.git
   cd Library-Books-Management
   ```

2. Install dependencies using Composer:
   ```bash
   composer install
   ```

3. Configure your database:
   - Open XAMPP Control Panel and start Apache and MySQL services
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `library_management`
   - Import the database schema (if provided)

4. Configure the application:
   - Copy `env` file to `.env`
   - Update the database configuration in `.env`:
     ```
     database.default.hostname = localhost
     database.default.database = library_management
     database.default.username = root
     database.default.password = 
     database.default.DBDriver = MySQLi
     ```

5. Access the application:
   - Place the project in your XAMPP's htdocs directory
   - Access via: http://localhost/Library-Books-Management/public

## 🗄️ Database Setup

The application uses MySQL database. Make sure to:
1. Create the database in phpMyAdmin
2. Configure the database connection in `.env` file
3. The application will automatically create the required tables on first run

## 🏗️ Project Structure

```
Library-Books-Management/
├── app/
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── public/
└── .env
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📝 License

This project is open-source and available under the MIT License.

## 👥 Author

- GitHub: [@Powderuner](https://github.com/Powderuner)

## 🙏 Acknowledgments

- CodeIgniter 4 Framework
- XAMPP Development Environment
- MySQL Team
