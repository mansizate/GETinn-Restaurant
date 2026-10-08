
# 🍽️ GETinn -Tech That Feeds and Fules

> A multi-module software platform combining restaurant management, online food ordering, AI-based food-waste prediction, and sustainability-focused food-waste management.

<p align="center">

[![PHP](https://img.shields.io/badge/PHP-8+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Java](https://img.shields.io/badge/Java-17+-ED8B00?style=for-the-badge&logo=openjdk&logoColor=white)](https://www.java.com/)
[![Spring Boot](https://img.shields.io/badge/Spring%20Boot-3.x-6DB33F?style=for-the-badge&logo=springboot&logoColor=white)](https://spring.io/projects/spring-boot)
[![Python](https://img.shields.io/badge/Python-3.x-3776AB?style=for-the-badge&logo=python&logoColor=white)](https://www.python.org/)
[![MySQL](https://img.shields.io/badge/MySQL-8+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=apachefriends&logoColor=white)](https://www.apachefriends.org/)

</p>

---

## 📌 Overview

**GETinn** is a multi-module project that brings together three related areas:

- 🍽️ **Restaurant Management & Online Ordering**
- 🤖 **AI-Based Food Waste Prediction**
- 🌱 **Food Waste Management & Sustainability**

The project explores how software engineering, databases, backend development, and machine learning can be applied across the food lifecycle.

### Food Lifecycle

```text
🍽️ Restaurant Operations
          ↓
🍲 Food Consumption
          ↓
♻️ Food Waste
          ↓
🤖 Prediction & Analysis
          ↓
📊 Better Planning
          ↓
🌱 Sustainable Management
          ↓
🔥 Resource / Fuel Potential
```

> The project demonstrates the software and sustainability concept. It does not claim that the current system physically produces fuel.

---

# 🚀 Project Modules

## 🍽️ 1. GETinn Restaurant

The main restaurant management and online ordering application.

### Customer Features

- 👤 User registration and login
- 📧 Email verification
- 🔐 Password recovery
- 🍴 Restaurant menu browsing
- 🏷️ Category-based menu
- 🛒 Shopping cart
- 📦 Food ordering
- 💳 Checkout workflow
- 🪑 Table reservation
- ⭐ VIP table booking
- 🎫 Membership/VIP functionality
- 🧾 Digital bill generation
- 📩 Contact and feedback

### Admin Features

- 🔐 Admin authentication
- 👥 User management
- 🍔 Menu management
- 📦 Order management
- 🪑 Table booking management
- ⭐ VIP booking management
- 💬 Customer feedback management
- 📄 Website/page management
- 📊 Restaurant operation management
- 📩 Admin messaging

### Technologies

```text
PHP
HTML5
CSS3
JavaScript
MySQL
Apache
XAMPP
```

---

## 🌱 2. EcoRegen

**EcoRegen** is the sustainability-focused module of the project.

It explores digital management of food waste and its potential use as a sustainable resource.

### Main Features

- 🌱 Food-waste management
- ♻️ Sustainable resource utilization
- 🔥 Food-waste-to-resource/fuel concept
- 👥 User and role management
- 🔐 Authentication
- 🌐 Backend APIs
- 🗄️ Database integration
- 💻 Sustainability-focused frontend

### Technologies

```text
Java
Spring Boot
Maven
MySQL
HTML
CSS
JavaScript
```

### Location

```text
modules/ecoregen/
```

---

## 🤖 3. Food Waste Predictor

The **Food Waste Predictor** is the AI/ML module.

It uses food-related data, trained models, and prediction pipelines to support food-waste prediction.

### Features

- 🤖 Machine-learning prediction
- 📊 Food-waste dataset
- 🧠 Trained ML models
- 🔄 Prediction pipelines
- 🐍 Python application
- 🌐 Flask web interface
- 📓 Jupyter notebooks
- 📈 Data-processing workflow

### Technologies

```text
Python
Flask
Machine Learning
Pandas
Jupyter Notebook
HTML
CSV
Pickle-based ML models
```

### Location

```text
modules/food-waste-predictor/
```

---

# 🌍 How the Project Fits Together

The project follows a broader food-management and sustainability workflow:

```text
┌─────────────────────────────┐
│     🍽️ GETinn Restaurant    │
│                             │
│ • Restaurant Management     │
│ • Food Ordering             │
│ • Table Booking             │
│ • Customer Management       │
└──────────────┬──────────────┘
               │
               ▼
        🍲 Food Consumption
               │
               ▼
          ♻️ Food Waste
               │
       ┌───────┴────────┐
       │                │
       ▼                ▼
┌──────────────┐  ┌───────────────┐
│ 🤖 Food Waste│  │ 🌱 EcoRegen   │
│   Predictor  │  │               │
│              │  │ Waste         │
│ ML Prediction│  │ Management    │
│ Data Analysis│  │ Sustainability│
└──────────────┘  └───────────────┘
```

### Core Goals

- ♻️ Reduce unnecessary food waste
- 🤖 Predict food-waste patterns
- 📊 Improve food and resource planning
- 🌱 Digitally manage food waste
- 🔄 Explore sustainable utilization
- 🔥 Explore food waste as a potential resource/fuel input

---

# 🏗️ System Architecture

```text
                         ┌─────────────────┐
                         │    Customer     │
                         └────────┬────────┘
                                  │
                                  ▼
                    ┌─────────────────────────┐
                    │   GETinn Restaurant     │
                    │                         │
                    │ PHP + HTML/CSS/JS       │
                    └────────────┬────────────┘
                                 │
                                 ▼
                    ┌─────────────────────────┐
                    │         MySQL           │
                    │   Restaurant Database   │
                    └────────────┬────────────┘
                                 │
                                 ▼
                           🍲 Food Data
                                 │
                                 ▼
                           ♻️ Food Waste
                                 │
                    ┌────────────┴────────────┐
                    │                         │
                    ▼                         ▼
          ┌──────────────────┐      ┌──────────────────┐
          │ 🤖 Food Waste    │      │ 🌱 EcoRegen      │
          │    Predictor     │      │                  │
          │                  │      │ Java / Spring    │
          │ Python / Flask   │      │ Boot / MySQL     │
          │ ML Models        │      │ Sustainability   │
          └──────────────────┘      └──────────────────┘
```

---

# 🛠️ Technology Stack

| Area | Technologies |
|---|---|
| Restaurant Frontend | HTML5, CSS3, JavaScript |
| Restaurant Backend | PHP 8+ |
| Restaurant Database | MySQL 8+ |
| Sustainability Backend | Java, Spring Boot |
| Sustainability Database | MySQL |
| AI/ML Application | Python, Flask |
| Machine Learning | Trained ML Models, Prediction Pipelines |
| Data Processing | Pandas, CSV |
| Experimentation | Jupyter Notebook |
| Local Server | Apache / XAMPP |
| Build Tool | Maven |
| Version Control | Git & GitHub |

---

# 📂 Repository Structure

```text
GETinn-Restaurant/
│
├── admin/
│   └── Restaurant administration
│
├── assets/
│   └── Website assets
│
├── css/
│   └── Stylesheets
│
├── js/
│   └── JavaScript files
│
├── images/
│   └── Website images and media
│
├── includes/
│   └── Reusable PHP components
│
├── database/
│   └── Database / SQL files
│
├── modules/
│   │
│   ├── ATTRIBUTION.md
│   │
│   ├── ecoregen/
│   │   │
│   │   ├── Project-Backend/
│   │   │   └── Spring Boot backend
│   │   │
│   │   ├── Project-Frontend/
│   │   │   └── EcoRegen frontend
│   │   │
│   │   └── Project_Images/
│   │       └── EcoRegen assets
│   │
│   └── food-waste-predictor/
│       │
│       ├── app.py
│       ├── templates/
│       ├── *.pkl
│       ├── *.csv
│       └── *.ipynb
│
├── *.php
│
└── README.md
```

---

# 👩‍💻 My Contribution

My contribution focuses on **development, configuration, testing, debugging, integration, and documentation** across the project components.

## GETinn Restaurant

- Worked with the existing PHP application architecture
- Configured the application using XAMPP
- Connected the application with MySQL
- Tested customer workflows
- Tested authentication
- Tested menu and cart functionality
- Tested ordering workflows
- Tested table booking
- Debugged PHP and database-related issues
- Worked with Git and GitHub
- Improved project documentation

## EcoRegen

- Worked with the frontend and backend structure
- Worked with the Spring Boot project
- Worked with frontend pages and assets
- Assisted with configuration and testing
- Worked with database-related functionality
- Integrated the module into the combined repository

## Food Waste Predictor

- Worked with the Python application
- Worked with the Flask interface
- Worked with machine-learning model files
- Worked with prediction pipelines
- Worked with food-waste datasets
- Worked with Jupyter notebooks
- Integrated the predictor into the combined repository

---

# 🧠 Technical Skills Demonstrated

## Frontend Development

- HTML5
- CSS3
- JavaScript
- Responsive interfaces
- Forms and user interfaces

## Backend Development

- PHP
- Java
- Spring Boot
- Python
- Flask
- Backend/API concepts

## Database

- MySQL
- Database connectivity
- CRUD operations
- Relational data management

## AI / Machine Learning

- Python
- Data processing
- Machine-learning models
- Prediction pipelines
- Dataset handling
- Jupyter Notebook

## Development Tools

- Git
- GitHub
- XAMPP
- Apache
- Maven
- VS Code
- GitHub Codespaces

---

# ⚙️ Installation & Setup

## Prerequisites

Make sure the following are installed:

- XAMPP
- PHP 8+
- MySQL 8+
- Git
- Python 3.x
- Java 17+
- Maven
- Modern web browser

---

# 🍽️ GETinn Setup

### 1. Clone the Repository

```bash
git clone https://github.com/mansizate/GETinn-Restaurant.git
```

```bash
cd GETinn-Restaurant
```

### 2. Move to XAMPP

Copy the project into:

```text
C:\xampp\htdocs\
```

Final path:

```text
C:\xampp\htdocs\GETinn-Restaurant
```

### 3. Start XAMPP

Open XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 4. Configure MySQL

Open:

```text
http://localhost/phpmyadmin
```

Create the required database and import the SQL/database files included in the project.

### 5. Configure Database Connection

Check the PHP database configuration.

Typical local configuration:

```text
Host: localhost
Username: root
Password: your-local-password
Database: taaza_db
```

> Never commit real passwords, API keys, tokens, or other credentials to GitHub.

### 6. Run GETinn

Open:

```text
http://localhost/GETinn-Restaurant/
```

---

# 🤖 Food Waste Predictor Setup

Navigate to:

```bash
cd modules/food-waste-predictor
```

Install the required Python dependencies according to the project configuration.

Run:

```bash
python app.py
```

The Flask application will display its local URL in the terminal.

---

# 🌱 EcoRegen Setup

## Backend

Location:

```text
modules/ecoregen/Project-Backend/
```

The backend is a Spring Boot application using Maven.

## Frontend

Location:

```text
modules/ecoregen/Project-Frontend/
```

The frontend contains the EcoRegen interface and related assets.

> GETinn, EcoRegen, and Food Waste Predictor are maintained as separate application components inside the same repository. They are organized as a combined project/monorepo and are not presented as one single runtime application.

---

# 🧪 Testing & Verification

## GETinn

Verified areas include:

- Application startup
- Apache configuration
- MySQL connectivity
- User registration
- User login
- Menu browsing
- Shopping cart
- Ordering workflow
- Table reservation
- VIP booking
- Administrative functionality
- PHP/MySQL integration

## EcoRegen

Testing includes:

- Frontend pages
- Backend application
- Spring Boot configuration
- Application functionality
- Database-related functionality

## Food Waste Predictor

Testing includes:

- Python application
- Flask interface
- Model loading
- Prediction workflow
- Dataset handling
- Prediction pipeline

---

# 🎯 Project Highlights

### 🍽️ Restaurant Management

Customer and admin workflows for restaurant operations, ordering, bookings, and menu management.

### 🤖 AI-Based Food Waste Prediction

Uses trained machine-learning models and data pipelines to support food-waste prediction.

### 🌱 Sustainability

Explores digital approaches to food-waste management and sustainable utilization.

### 🔥 Food Waste → Resource/Fuel Concept

Explores the potential of food waste as an input for sustainable resource and fuel-related applications.

### 🔗 Multi-Technology Project

```text
PHP
   +
Java / Spring Boot
   +
Python / Flask
   +
Machine Learning
   +
MySQL
   +
HTML / CSS / JavaScript
```

---

# 📚 Learning Outcomes

This project provided practical experience in:

- Full-stack web development
- PHP development
- Java Spring Boot development
- Python development
- Flask applications
- Machine-learning workflows
- MySQL database integration
- CRUD operations
- Authentication workflows
- Backend/API concepts
- Debugging existing codebases
- Testing web applications
- Dataset handling
- Trained ML models
- Git and GitHub
- Multi-module project organization
- Sustainability-focused software development

---

# 🔐 Security Considerations

For production deployment, additional security hardening should be applied.

Recommended improvements include:

- Secure password hashing
- Input validation
- Output sanitization
- SQL injection protection
- CSRF protection
- Secure session management
- API authentication
- Environment variables for secrets
- HTTPS
- Secure database configuration
- Proper access control

> Never store passwords, API keys, JWT secrets, database credentials, or other private information in the repository.


---

# 🌟 Why This Project?

This project combines software engineering with a real-world sustainability problem.

Rather than treating restaurant management and food waste as completely separate areas, the project explores a broader workflow:

```text
🍽️ Restaurant
      ↓
🍲 Food Consumption
      ↓
♻️ Food Waste
      ↓
🤖 Prediction
      ↓
📊 Better Planning
      ↓
🌱 Sustainable Management
      ↓
🔥 Resource / Fuel Potential
```

The project demonstrates the application of:

**Web Development + Backend Engineering + Databases + AI/ML + Sustainability**

---



# 📂 Attribution

Some components included in the sustainability modules are based on existing projects and are included with attribution.

## EcoRegen

Original repository:

https://github.com/Kundan8126/EcoRegen

Integrated location:

```text
modules/ecoregen/
```

## Food Waste Predictor

Original repository:

https://github.com/Kundan8126/Food-Waste-Predictor

Integrated location:

```text
modules/food-waste-predictor/
```

For additional details, see:

```text
modules/ATTRIBUTION.md
```

---

# 👩‍💻 Developer

## Mansi Zate

**Computer Science / Information Technology Graduate**

### GitHub

https://github.com/mansizate

### Portfolio

https://manseez-portfolio.netlify.app/

---

# 📄 License

This repository is maintained for educational, learning, development, and portfolio purposes.

Please refer to the original project repositories and applicable licensing/attribution requirements for the components included under:

```text
modules/ecoregen/
modules/food-waste-predictor/
```

---

<p align="center">

 three-module concept and attribution, so this version mainly makes the presentation much cleaner and more recruiter-friendly. Pasted text
