# RoRo Ferry Management System

A comprehensive web-based management system designed to streamline operations for Roll-On/Roll-Off (RoRo) ferry services. This system handles booking, payment processing, vehicle management, and service administration.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Project Structure](#project-structure)
- [Usage](#usage)
- [API Integration](#api-integration)
- [Security](#security)
- [Contributing](#contributing)
- [License](#license)

---

## 🎯 Overview

The RoRo Ferry Management System is a full-featured web application that enables ferry service operators to:
- Manage vehicle bookings and reservations
- Process secure online payments
- Track vehicle operations
- Manage customer information
- Generate reports and analytics
- Handle administrative tasks

This system is built with PHP backend, MySQL database, and responsive frontend technologies.

---

## ✨ Features

### 🚗 Vehicle Management
- Add and manage vehicle fleet
- Track vehicle status and availability
- Maintenance scheduling
- Vehicle registration details

### 📅 Booking Management
- Real-time booking system
- Schedule management
- Availability tracking
- Automated confirmation system

### 💳 Payment Processing
- Secure payment gateway integration
- Multiple payment method support
- Transaction history and receipts
- Refund management
- Integration with Cashfree Payment Gateway

### 👤 Customer Management
- User registration and profiles
- Booking history
- Customer support ticketing
- Email notifications

### 📊 Analytics & Reports
- Booking statistics
- Revenue reports
- Vehicle utilization reports
- Customer analytics

### 🔐 Security
- User authentication and authorization
- Role-based access control
- Secure data encryption
- Payment security compliance

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | HTML5, CSS3, JavaScript, Bootstrap |
| **Backend** | PHP 7.x / 8.x |
| **Database** | MySQL 5.7+ |
| **Server** | Apache / Nginx |
| **Payment Gateway** | Cashfree |
| **APIs** | RESTful APIs |

---

## 📦 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (optional, for dependency management)
- Git

### Step 1: Clone the Repository

```bash
git clone https://github.com/PriyanshiBharodiya/Roro-Ferry-Management-System.git
cd Roro-Ferry-Management-System
```

### Step 2: Set Up Web Server

**For Apache:**
```bash
# Place project in Apache root directory
cp -r Roro-Ferry-Management-System /var/www/html/
cd /var/www/html/Roro-Ferry-Management-System
```

**For Nginx:**
```bash
cp -r Roro-Ferry-Management-System /var/www/
cd /var/www/Roro-Ferry-Management-System
```

### Step 3: Install Dependencies

```bash
# If using Composer
composer install

# Or manually ensure all required PHP extensions are enabled
```

### Step 4: Create Configuration File

```bash
cp config.example.php config.php
```

Edit `config.php` with your database credentials and settings.

### Step 5: Set File Permissions

```bash
chmod -R 755 .
chmod -R 777 uploads/
chmod -R 777 logs/
```

---

## ⚙️ Configuration

### Database Configuration

Edit `config.php`:

```php
<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
define('DB_NAME', 'roro_ferry_db');

// Payment Gateway Configuration
define('CASHFREE_APP_ID', 'YOUR_CASHFREE_APP_ID');
define('CASHFREE_SECRET_KEY', 'YOUR_CASHFREE_SECRET_KEY');
define('PAYMENT_MODE', 'PROD'); // or 'TEST'

// App Configuration
define('APP_URL', 'http://localhost/Roro-Ferry-Management-System');
define('APP_NAME', 'RoRo Ferry Management System');
?>
```

**⚠️ Security Warning:** Never commit actual API keys. Use environment variables or `.env` files for production.

### Environment Variables (Recommended)

Create a `.env` file in the root directory:

```
DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=roro_ferry_db
CASHFREE_APP_ID=your_app_id
CASHFREE_SECRET_KEY=your_secret_key
PAYMENT_MODE=TEST
```

---

## 🗄️ Database Setup

### Create Database

```sql
CREATE DATABASE roro_ferry_db;
USE roro_ferry_db;
```

### Run Migration Script

```bash
# If using migration file
mysql -u root -p roro_ferry_db < database/schema.sql
```

Or import using phpMyAdmin:
1. Open phpMyAdmin
2. Select the `roro_ferry_db` database
3. Click "Import"
4. Select `database/schema.sql`
5. Click "Go"

### Database Tables

- `users` - User accounts and profiles
- `vehicles` - Fleet management
- `bookings` - Reservation records
- `payments` - Transaction records
- `routes` - Ferry routes
- `schedules` - Booking schedules
- `customers` - Customer information
- `support_tickets` - Customer support

---

## 📁 Project Structure

```
Roro-Ferry-Management-System/
├── config.php                 # Configuration file
├── index.php                  # Entry point
├── dashboard.php              # Admin dashboard
├── 
├── css/
│   ├── style.css             # Main stylesheet
│   ├── bootstrap.min.css     # Bootstrap framework
│   └── responsive.css        # Responsive design
├── 
├── js/
│   ├── main.js               # Main JavaScript
│   ├── validation.js         # Form validation
│   └── ajax.js               # AJAX utilities
├── 
├── includes/
│   ├── header.php            # Header template
│   ├── footer.php            # Footer template
│   ├── db_connect.php        # Database connection
│   └── functions.php         # Helper functions
├── 
├── api/
│   ├── bookings.php          # Booking API
│   ├── payments.php          # Payment API
│   ├── vehicles.php          # Vehicle API
│   └── users.php             # User API
├── 
├── payment/
│   ├── payment.php           # Payment processing
│   ├── request.php           # Payment request handler
│   └── response.php          # Payment response handler
├── 
├── admin/
│   ├── users.php             # User management
│   ├── vehicles.php          # Vehicle management
│   ├── bookings.php          # Booking management
│   └── reports.php           # Reports & Analytics
├── 
├── uploads/                  # User uploads directory
├── logs/                      # Application logs
├── database/
│   └── schema.sql            # Database schema
├── 
└── README.md                 # This file
```

---

## 🚀 Usage

### Access the Application

```
http://localhost/Roro-Ferry-Management-System
```

### Admin Panel

```
http://localhost/Roro-Ferry-Management-System/admin
```

**Default Credentials** (Change after first login):
- Username: `admin`
- Password: `admin123`

### User Registration

1. Click "Register" on the login page
2. Fill in user details
3. Verify email address
4. Login with credentials

### Making a Booking

1. Login to user account
2. Click "New Booking"
3. Select route and date
4. Choose vehicle type
5. Enter vehicle details
6. Proceed to payment
7. Complete payment via Cashfree gateway

---

## 💳 API Integration

### Payment Gateway (Cashfree)

#### Payment Request

```php
// payment/request.php
$_POST['orderId'] = 'ORDER123';
$_POST['orderAmount'] = '1000';
$_POST['customerName'] = 'John Doe';
$_POST['customerEmail'] = 'john@example.com';
$_POST['customerPhone'] = '9876543210';
```

#### Payment Response

```php
// payment/response.php
if ($status == 'OK') {
    // Payment successful
    updateBookingStatus('confirmed');
} else {
    // Payment failed
    updateBookingStatus('pending');
}
```

### REST API Endpoints

| Method | Endpoint | Description |
|--------|----------|------------|
| GET | `/api/bookings.php` | List all bookings |
| POST | `/api/bookings.php` | Create new booking |
| GET | `/api/bookings.php?id=1` | Get booking details |
| PUT | `/api/bookings.php?id=1` | Update booking |
| DELETE | `/api/bookings.php?id=1` | Cancel booking |

---

## 🔒 Security

### Best Practices Implemented

- **SQL Injection Prevention:** Parameterized queries
- **XSS Protection:** Input validation and sanitization
- **CSRF Protection:** Token-based verification
- **Password Security:** Hashed passwords (bcrypt/argon2)
- **Secure Payment:** SSL/TLS encryption
- **Session Management:** Secure session handling
- **Access Control:** Role-based permissions

### Security Checklist

- [ ] Change default admin credentials
- [ ] Configure HTTPS/SSL certificate
- [ ] Set proper file permissions (755 for files, 777 for writable dirs)
- [ ] Keep dependencies updated
- [ ] Regular security audits
- [ ] Enable error logging (disable display_errors in production)
- [ ] Use environment variables for sensitive data
- [ ] Regular database backups

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Code Standards

- Follow PSR-12 PHP coding standards
- Write clear, descriptive commit messages
- Add comments for complex logic
- Test changes before submitting PR

---

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 📞 Support & Contact

For support, issues, or questions:

- **Issues:** Create an issue on GitHub
- **Email:** priyanshibharodiya@gmail.com
- **Documentation:** Check the `/docs` folder

---

## 🙏 Acknowledgments

- Cashfree for payment gateway
- Bootstrap for UI framework
- PHP community for excellent documentation

---

## 📌 Version History

| Version | Date | Changes |
|---------|------|---------|
| 1.0.0 | June 2026 | Initial release |

---

**Last Updated:** June 5, 2026

**Status:** ✅ Active Development

---

## 🎓 Educational Note

This project is built for educational and learning purposes. It demonstrates modern web development practices including database design, API integration, payment processing, and secure coding practices.

**Happy coding! 🚀**
