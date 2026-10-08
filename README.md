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
