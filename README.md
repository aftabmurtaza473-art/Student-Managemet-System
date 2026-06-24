# 🎓 Student Management System

A full-featured web-based Student Management System built with **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**. Developed as a personal project to demonstrate full-stack web development skills.

---

## 📋 Features

- 🔐 **Admin Authentication** — Secure login/logout system with password hashing
- 👨‍🎓 **Student Management** — Add, Edit, Delete, and View student records (CRUD)
- 📚 **Course Management** — Manage courses with instructor and department info
- ⭐ **Grades Management** — Assign and track student grades with auto grade calculation
- 📊 **Dashboard** — Overview with stats: total students, courses, grade records, and top performers
- 🔍 **Live Search** — Instant filter across all tables without page reload
- 📱 **Responsive Design** — Works on desktop, tablet, and mobile
- ✅ **Sample Data** — Pre-loaded with demo students, courses, and grades

---

## 🛠️ Tech Stack

| Technology | Usage |
|------------|-------|
| PHP 7.4+   | Backend logic, routing, database queries |
| MySQL      | Relational database storage |
| HTML5      | Page structure and templates |
| CSS3       | Custom styling, responsive layout |
| JavaScript | Live search, grade auto-calc, sidebar toggle |
| Font Awesome | Icons |

---

## 📁 Project Structure

```
student-management-system/
│
├── index.php                  # Dashboard
├── database.sql               # Database schema + sample data
│
├── auth/
│   ├── login.php              # Admin login page
│   └── logout.php             # Session destroy & redirect
│
├── students/
│   ├── index.php              # List all students
│   ├── add.php                # Add new student
│   ├── edit.php               # Edit student record
│   └── delete.php             # Delete student
│
├── courses/
│   ├── index.php              # List all courses
│   ├── add.php                # Add new course
│   ├── edit.php               # Edit course
│   └── delete.php             # Delete course
│
├── grades/
│   ├── index.php              # List all grades
│   ├── add.php                # Add grade record
│   ├── edit.php               # Edit grade
│   └── delete.php             # Delete grade
│
├── includes/
│   ├── config.php             # Database connection
│   ├── auth_check.php         # Session protection
│   ├── header.php             # Sidebar + topbar layout
│   └── footer.php             # Page closing tags
│
├── css/
│   └── style.css              # All styles
│
└── js/
    └── main.js                # Interactive features
```

---

## ⚙️ Installation & Setup

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP / WAMP / LAMP (local) or any web hosting

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/YourUsername/student-management-system.git
```

**2. Move to your server's root folder**
- For XAMPP: `C:/xampp/htdocs/student-management-system/`
- For WAMP:  `C:/wamp64/www/student-management-system/`

**3. Import the database**
- Open **phpMyAdmin** → `http://localhost/phpmyadmin`
- Create a new database named `student_management`
- Click **Import** → select `database.sql` → click **Go**

**4. Configure database connection**

Open `includes/config.php` and update:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // your MySQL username
define('DB_PASS', '');          // your MySQL password
define('DB_NAME', 'student_management');
```

**5. Run the project**

Open your browser and go to:
```
http://localhost/student-management-system/
```

**6. Login**
```
Username: admin
Password: admin123
```

---

## 📸 Screenshots

> _Screenshots will be added after deployment._

---

## 👨‍💻 Author

**Aftab Murtaza**
- 📧 Aftabmurtaza473@gmail.com
- 🔗 [LinkedIn](https://linkedin.com/in/aftab-murtaza)
- 🐙 [GitHub](https://github.com/AftabMurtaza)

---

## 📄 License

This project is open source and available for educational purposes.
