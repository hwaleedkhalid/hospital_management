# Hospital Management System

This is a simple Hospital Management System built with PHP and MySQL.

## Project Structure

- `config/` - Database configuration file
- `public/` - Publicly accessible directory for assets and the entry point
- `src/` - Source files including controllers, models, views, and helpers
- `.htaccess` - Apache configuration for URL rewriting
- `README.md` - Project documentation

## Setup Instructions

1. Clone the repository.
2. Set up a MySQL database and update `config/database.php` with your database credentials.
3. Configure your web server to point to the `public` directory.
4. Import the SQL schema to your database.
5. Access the application through the browser.

## Usage

- Access the home page at `/`
- Login at `/login`
- Admin, Doctor, and Patient dashboards are accessible after logging in.
