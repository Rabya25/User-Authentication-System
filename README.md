# User Authentication System

A simple, secure user authentication system built with pure PHP and MySQL.

## Features

- **Registration** : create account with email and password validation
- **Login** : verify credentials with hashed password comparison
- **Session Management** : stay logged in across pages
- **Profile Page** : view user info from the database
- **Logout** : securely destroy the session
- **Protected Pages** : dashboard and profile require login

## Security

- Passwords hashed with `password_hash()` (bcrypt)
- PDO prepared statements (SQL injection prevention)
- CSRF protection with tokens
- Input validation on registration
- `htmlspecialchars()` on all output (XSS prevention)
- Session regeneration after login (session fixation prevention)
- Generic login errors (no username enumeration)

## Technologies

- **PHP 8+**
- **MySQL** for user storage
- **PDO** for database access

## Project Structure
```text
├── register.php       # Registration form + handler
├── login.php          # Login form + handler
├── dashboard.php      # Protected dashboard
├── profile.php        # Protected profile page
├── logout.php         # Destroys session
└── README.md          # This file
```
