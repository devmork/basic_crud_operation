# School Event Attendance Management (SEAM) - Basic CRUD Operation

## Description

This is a simple web-based application for managing school event attendance. It demonstrates basic CRUD (Create, Read, Update, Delete) operations using PHP and MySQL. Users can view, add, edit, and delete attendance records for events, including details like event ID, date, time, status, expected attendees, description, and venue.

The application is built as a learning activity for web development, focusing on database interactions, form handling, and basic security practices like prepared statements and input sanitization.

## Features

- **Read**: Display a list of all attendance records in a table format.
- **Create**: Add new attendance records via a form.
- **Update**: Edit existing records.
- **Delete**: Remove records with a confirmation prompt.
- Responsive HTML table with action links.
- Basic error handling for database operations.
- XSS protection using `htmlspecialchars()`.

## Technologies Used

- **Backend**: PHP (with MySQLi for database interaction)
- **Frontend**: HTML, CSS
- **Database**: MySQL
- **Server**: XAMPP (Apache and MySQL)

## Prerequisites

- Windows machine with XAMPP installed (includes Apache, MySQL, and PHP).
- Basic knowledge of PHP and MySQL.
- A web browser for testing.

## Setup Instructions

1. **Install XAMPP**:
   - Download and install XAMPP from the official website (https://www.apachefriends.org/).
   - Ensure Apache and MySQL modules are installed.

2. **Clone or Place the Project**:
   - Copy the project folder (`basic_crud_operation`) into `C:\xampp\htdocs\`.
   - The full path should be `C:\xampp\htdocs\basic_crud_operation`.

3. **Set Up the Database**:
   - Start XAMPP Control Panel and start Apache and MySQL.
   - Open phpMyAdmin (usually at http://localhost/phpmyadmin).
   - Create a new database named `seams_db` (or update `includes/db.php` if using a different name).
   - Import the `database.sql` file (includes table creation and sample records) by selecting the file in phpMyAdmin's import section.
   - Alternatively, copy the SQL statements from `database.sql` and paste them into phpMyAdmin's SQL tab.

4. **Configure Database Connection**:
   - Edit `includes/db.php` to match your MySQL credentials (default: host='localhost', user='root', password='', db='seams_db').
   - Example:
     ```php
     $conn = mysqli_connect('localhost', 'root', '', 'seams_db');
     ```

5. **Run the Application**:
   - Open a web browser and navigate to `http://localhost/basic_crud_operation/index.php`.
   - The main page should load, displaying the attendance table with sample records.

## Usage

- **View Records**: Visit `index.php` to see the list of attendance records.
- **Add Record**: Click "Add New Attendance" to go to `add.php` and submit a form.
- **Edit Record**: Click "Edit" on a row in the table to modify it via `edit.php`.
- **Delete Record**: Click "Delete" on a row and confirm to remove it via `delete.php`.
- Ensure XAMPP is running for the server to work.

## Folder Structure

```
basic_crud_operation/
├── includes/
│ └── db.php # Database connection file
├── styles/
│ └── index.css # CSS styles for the application
├── index.php # Main page (list records)
├── add.php # Add new record form
├── edit.php # Edit record form
├── delete.php # Delete record handler
├── README.md # This file
└── database.sql # SQL database setup
```

## Troubleshooting

- **Database Connection Errors**: Check MySQL is running in XAMPP and verify credentials in `db.php`.
- **Page Not Loading**: Ensure Apache is started and the URL is correct.
- **No Records**: Confirm the database and table exist, and insert sample data if needed.
- For issues, check XAMPP logs or browser console.

## License

This project is for educational purposes only. No specific license applied.
