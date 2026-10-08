# GETinn — Restaurant Web Application

GETinn is a web application developed as a team project for managing common restaurant activities such as browsing food items, placing orders, booking tables, and managing restaurant operations.

The project includes both customer-facing features and an admin side for managing the application.

## What the application does

Customers can:

- Browse food items and categories
- Add items to the cart
- Place orders
- Book restaurant tables
- Choose between standard and VIP booking options
- Manage their account
- Receive order and account-related notifications
- Get a PDF bill after an order

The application also includes an admin section for managing users, orders, menu-related information, and website settings.

## Main Features

### Customer

- User registration and login
- Email verification
- Password recovery
- Food menu
- Shopping cart
- Checkout
- Order management
- Table booking
- VIP membership
- VIP booking
- PDF bill generation
- Feedback and contact features

### Admin

- Admin login
- User management
- Order management
- Menu management
- Booking management
- Website page controls
- Notification management

## Technology Used

**Frontend**

- HTML
- CSS
- JavaScript

**Backend**

- PHP

**Database**

- MySQL

**Other Tools / Libraries**

- PHPMailer
- FPDF
- phpMyAdmin

## Database

The project uses MySQL for storing application data.

Some of the main data areas include:

- Registered users
- Menu items
- Orders
- Table bookings
- VIP bookings
- Admin configuration

The SQL database file is included in this repository.

## Project Structure

```text
GETinn-Restaurant/
│
├── admin/
├── assets/
├── dashboard/
├── event-booking/
├── fpdf/
├── includes/
├── payment/
├── PHPMailer/
├── vip/
│
├── .gitignore
├── GETINN DB.sql
├── index.php
├── login.php
├── menu.php
├── checkout.php
├── table-booking.php
├── vip-booking.php
└── ...
