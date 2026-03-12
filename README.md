# GETINN Restaurant 🍴

**GETINN Restaurant** is a sophisticated, end-to-end web solution designed for the modern dining industry. It offers a seamless, responsive user experience combined with a powerful administrative backend to manage daily restaurant operations.

---

## 🌟 Key Capabilities

### 🍽️ Customer Experience

* **Interactive Menu:** Browse dishes by category with real-time pricing and descriptions.
* **Smart Ordering:** Integrated shopping cart system with quantity management and checkout flow.
* **Table Reservations:** Dual-tier booking system supporting both **Standard** and **VIP** seating.
* **Membership Program:** Exclusive VIP status for registered users to unlock special discounts.
* **Digital Receipts:** Automatic PDF bill generation with dynamic discount calculations.

### ⚙️ Backend & Admin Control

* **User Management:** Secure authentication with email verification and password recovery tools.
* **Command Center:** Admins can toggle page visibility (Menu/Booking), manage orders, and broadcast messages.
* **Automated Notifications:** SMTP integration for registration, order updates, and administrative alerts.
* **Data Analytics:** Track customer feedback and manage community "Lend a Hand" initiatives.

---

## 📸 Interface Preview

---

## 🛠️ Tech Stack

**Frontend & Logic:**

**Backend & Database:**

---

## 🚀 Installation & Database Setup

To get **GETINN Restaurant** running locally, follow these steps to configure your **phpMyAdmin** environment:

### 1. Initialize Database

```sql
CREATE DATABASE taaza_db;

```

### 2. Core Tables

The system relies on several interconnected tables. Below is a summary of the required architecture:

| Table | Purpose |
| --- | --- |
| `registered_users` | Profiles, VIP status, and credentials. |
| `menu_items` | Food inventory and pricing. |
| `orders` | Transaction history and delivery details. |
| `table_booking_ground` | Standard reservation records. |
| `table_booking_vip` | Premium seating with decor preferences. |
| `admin` | System configuration and page toggles. |

### 3. Essential SQL Schemas

```sql
-- Admin Configuration Table
CREATE TABLE admin (
    id INT NOT NULL PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(190) NOT NULL,
    resettoken VARCHAR(190) NOT NULL,
    resettokenexpire DATE DEFAULT NULL,
    enable_table_booking TINYINT NOT NULL,
    enable_menu_page TINYINT NOT NULL
);

-- Menu Items Table
CREATE TABLE menu_items (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    available TINYINT(1) DEFAULT 1,
    image_path VARCHAR(255)
);

-- Orders Table
CREATE TABLE orders (
    order_id INT NOT NULL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address VARCHAR(200) NOT NULL,
    item VARCHAR(30) NOT NULL,
    quantity VARCHAR(30) NOT NULL,
    total_price VARCHAR(30) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

```

> **Note:** Ensure you create all 10 tables as specified in the database structure to enable full functionality.

---

## 📜 Licensing

This project is licensed under the **Creative Commons Attribution-NonCommercial 4.0 International (CC BY-NC 4.0)**.

* **Personal Use:** Encouraged for learning and testing.
* **Commercial Use:** Prohibited without explicit consent from the author.
* **Adaptations:** Must be shared under the same license terms.

---

## 🤝 Contact & Support

Developed with ❤️ by **Kundan Naik**.

* **GitHub:** [Kundan8126](https://github.com/Kundan8126)
* **LinkedIn:** [Kundan Naik](https://www.google.com/search?q=https://www.linkedin.com/in/kundan-naik-b3a117294)
* **Instagram:** [@kundan_naik_07_](https://www.google.com/search?q=https://www.instagram.com/kundan_naik_07_/)

**Don't forget to hit the Star ⭐ if you find this project useful!**

