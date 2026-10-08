# 🍽️ GETinn Restaurant

> A full-stack restaurant management and online ordering web application built to provide a smooth digital dining experience for customers and an efficient management system for restaurant administrators.

[![PHP](https://img.shields.io/badge/PHP-8+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=apachefriends&logoColor=white)](https://www.apachefriends.org/)

---

## 📌 Project Overview

GETinn Restaurant is a web-based restaurant management and ordering platform that connects customers with restaurant services through a centralized digital system.

The application allows customers to:

- 🍴 Explore restaurant menu items
- 🛒 Add food items to a shopping cart
- 📦 Place and manage orders
- 🪑 Book restaurant tables
- ⭐ Access VIP booking functionality
- 👤 Create and manage user accounts
- 📧 Receive account and application notifications
- 🧾 Generate digital bills/receipts

The project also includes an administrative interface for managing restaurant operations, users, orders, menu items, bookings and website functionality.

---

## ✨ Key Features

### 👨‍🍳 Customer Features

- Responsive restaurant website
- User registration and login
- Email verification
- Password recovery
- Dynamic food menu
- Category-based menu browsing
- Shopping cart
- Order placement
- Checkout workflow
- Table reservation
- VIP table booking
- Membership/VIP functionality
- Digital bill generation
- Contact and feedback system

### 🛠️ Admin Features

- Admin authentication
- User management
- Menu item management
- Order management
- Table booking management
- VIP booking management
- Customer feedback management
- Website/page visibility controls
- Admin messaging
- Restaurant operation dashboard

---

## 🧑‍💻 My Contribution

This repository represents my work with the GETinn Restaurant project.

### My focus areas include:

- Understanding and working with the existing PHP application architecture
- Configuring the project to run locally using XAMPP
- Setting up and connecting the MySQL database
- Testing customer-facing workflows
- Testing authentication and ordering functionality
- Debugging application and database issues
- Improving project documentation and developer setup instructions
- Working with Git and GitHub for project version control

> **Note:** This project was originally developed as a collaborative/open-source base and has been customized and worked on as part of my development practice.

---

## 🏗️ System Architecture

```text
                    ┌─────────────────────┐
                    │       Customer      │
                    └──────────┬──────────┘
                               │
                               ▼
                    ┌─────────────────────┐
                    │   GETinn Web App    │
                    │   PHP + HTML/CSS/JS │
                    └──────────┬──────────┘
                               │
                    ┌──────────▼──────────┐
                    │    PHP Backend      │
                    │ Authentication      │
                    │ Orders              │
                    │ Bookings            │
                    │ Payments            │
                    └──────────┬──────────┘
                               │
                               ▼
                    ┌─────────────────────┐
                    │       MySQL         │
                    │     taaza_db        │
                    └─────────────────────┘
                               ▲
                               │
                    ┌──────────┴──────────┐
                    │       Admin         │
                    │ Management Panel    │
                    └─────────────────────┘

```
## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP 8+ |
| Database | MySQL 8+ |
| Local Server | Apache |
| Development Environment | XAMPP |
| Version Control | Git & GitHub |

---

## 📂 Project Structure

```text
GETinn-Restaurant/
│
├── admin/              # Admin management functionality
├── assets/             # Website assets
├── css/                # Stylesheets
├── js/                 # JavaScript functionality
├── images/             # Images and media
├── includes/           # Reusable PHP components
├── database/           # Database / SQL files
├── *.php               # Application pages
└── README.md
```

> The exact structure may vary depending on the current project implementation.

---

## ⚙️ Local Setup

### Prerequisites

Make sure the following are installed:

- XAMPP
- PHP 8+
- MySQL 8+
- Git
- A modern web browser

### 1. Clone the Repository

```bash
git clone https://github.com/mansizate/GETinn-Restaurant.git
```

### 2. Move the Project to XAMPP

Copy the project folder into:

```text
C:\xampp\htdocs\
```

The final path should look like:

```text
C:\xampp\htdocs\GETinn-Restaurant
```

### 3. Start XAMPP

Open XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 4. Create the Database

Open:

```text
http://localhost/phpmyadmin
```

Create the required database and import the SQL file included in the project.

### 5. Configure Database Connection

Check the project's PHP database configuration file and make sure the following values match your local MySQL setup:

```text
Host: localhost
Username: root
Password: your-local-password
Database: taaza_db
```

> Do not commit real passwords, API keys, or other credentials to GitHub.

### 6. Run the Application

Open:

```text
http://localhost/GETinn-Restaurant/
```

---

## 🧪 Testing & Verification

The application has been tested in a local XAMPP environment.

### Verified areas include:

- Application startup through Apache
- MySQL database connection
- Customer registration and login flow
- Menu browsing
- Cart functionality
- Ordering workflow
- Table booking workflow
- VIP booking functionality
- Administrative functionality
- PHP/MySQL integration

Testing is performed locally using:

```text
Apache + PHP + MySQL + XAMPP
```

---

## 🎯 Project Highlights

GETinn demonstrates practical experience with:

- Full-stack web application development
- Server-side PHP programming
- Relational database design with MySQL
- CRUD operations
- Authentication and session handling
- Form processing and validation
- Customer and admin workflows
- Database-driven web applications
- Local server configuration using XAMPP
- Git-based version control
- Debugging and troubleshooting

---

## 🔐 Security Considerations

The project includes authentication and user-management functionality.

For production deployment, additional security hardening should be considered, including:

- Secure password hashing
- Input validation and sanitization
- SQL injection protection
- CSRF protection
- Secure session configuration
- Environment-based configuration for credentials
- HTTPS deployment


---

## 📚 Learning Outcomes

Working with this project provided practical experience in:

- PHP web development
- MySQL database integration
- Frontend development
- Backend logic
- Authentication workflows
- CRUD operations
- Debugging
- Local server configuration
- Git and GitHub
- Understanding an existing codebase

---

## 👩‍💻 Developer

**Mansi Zate**

Computer Science / Information Technology Graduate

GitHub:  
https://github.com/mansizate

Portfolio:  
https://manseez-portfolio.netlify.app/

---


---

## 📄 License

This repository is intended for educational, learning, and portfolio purposes.
