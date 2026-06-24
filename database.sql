-- ============================================================
--  Student Management System — Database Schema
--  Created by: Aftab Murtaza
-- ============================================================

CREATE DATABASE IF NOT EXISTS student_management;
USE student_management;

-- ── Users (Admin Login) ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    full_name   VARCHAR(100) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin: username = admin | password = admin123
INSERT INTO users (username, password, full_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');

-- ── Students ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS students (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    student_id   VARCHAR(20)  NOT NULL UNIQUE,
    full_name    VARCHAR(100) NOT NULL,
    email        VARCHAR(100) NOT NULL UNIQUE,
    phone        VARCHAR(20),
    department   VARCHAR(100),
    semester     INT DEFAULT 1,
    status       ENUM('Active','Inactive','Graduated') DEFAULT 'Active',
    enrolled_at  DATE,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── Courses ─────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS courses (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    course_code  VARCHAR(20)  NOT NULL UNIQUE,
    course_name  VARCHAR(150) NOT NULL,
    credit_hours INT DEFAULT 3,
    department   VARCHAR(100),
    instructor   VARCHAR(100),
    semester     INT,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── Grades ──────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS grades (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    student_id   INT NOT NULL,
    course_id    INT NOT NULL,
    marks        DECIMAL(5,2),
    grade        VARCHAR(5),
    semester     INT,
    academic_year VARCHAR(10),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id)  REFERENCES courses(id)  ON DELETE CASCADE,
    UNIQUE KEY unique_grade (student_id, course_id, semester)
);

-- ── Sample Data ─────────────────────────────────────────────
INSERT INTO students (student_id, full_name, email, phone, department, semester, status, enrolled_at) VALUES
('BSSE-2024-001', 'Ali Hassan',    'ali.hassan@email.com',    '0300-1234567', 'Software Engineering', 1, 'Active',   '2024-01-15'),
('BSSE-2024-002', 'Sara Khan',     'sara.khan@email.com',     '0301-2345678', 'Software Engineering', 1, 'Active',   '2024-01-15'),
('BSSE-2023-001', 'Usman Ahmed',   'usman.ahmed@email.com',   '0302-3456789', 'Computer Science',     3, 'Active',   '2023-01-10'),
('BSSE-2023-002', 'Fatima Malik',  'fatima.malik@email.com',  '0303-4567890', 'Software Engineering', 3, 'Active',   '2023-01-10'),
('BSSE-2022-001', 'Bilal Raza',    'bilal.raza@email.com',    '0304-5678901', 'Computer Science',     5, 'Active',   '2022-01-12');

INSERT INTO courses (course_code, course_name, credit_hours, department, instructor, semester) VALUES
('CS101',  'Programming Fundamentals',       3, 'Computer Science',     'Dr. Ahmed Ali',     1),
('CS201',  'Data Structures & Algorithms',   3, 'Computer Science',     'Dr. Sara Malik',    2),
('CS301',  'Database Management Systems',    3, 'Computer Science',     'Prof. Usman Khan',  3),
('SE201',  'Object Oriented Programming',    3, 'Software Engineering', 'Dr. Fatima Raza',   2),
('SE301',  'Web Technologies',               3, 'Software Engineering', 'Prof. Bilal Ahmed', 3),
('CS401',  'Computer Networks',              3, 'Computer Science',     'Dr. Imran Shah',    4);

INSERT INTO grades (student_id, course_id, marks, grade, semester, academic_year) VALUES
(1, 1, 85.00, 'A',  1, '2024'),
(1, 2, 78.50, 'B+', 2, '2024'),
(2, 1, 92.00, 'A+', 1, '2024'),
(3, 3, 88.00, 'A',  3, '2023'),
(3, 4, 75.00, 'B',  2, '2023'),
(4, 5, 95.00, 'A+', 3, '2023');
