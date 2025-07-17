# Student Information Management System

## 👥 Group Members and Roles

| Name            | Role                                    |
|-----------------|-----------------------------------------|
| Turaya Haide    | CSS Design & Theme for the System       |
| Prince Balighot | Handles View, Add, Edit, and Delete PHP |
| Defeo Basil     | Remaining Backend & Functional Logic    |

---

## 📄 Project Overview

This Student Information Management System is a web-based application built with **PHP**, **MySQL**, **HTML/CSS**, and **Bootstrap**. It allows administrators to:

- Register and log in securely
- View, add, edit, and delete student records
- Manage access using role-based authentication
- Provide a user-friendly interface with a space-themed design

Students can log in to view limited profile data such as:
- Name
- Course
- Birthdate

---

## ⚙️ Setup Instructions

1. **Install XAMPP or any local server**
   - Make sure Apache and MySQL are running

2. **Clone or copy this project into your `htdocs` folder**
   ```
   C:\xampp\htdocs\student_system1\
   ```

3. **Create the database**
   - Open `phpMyAdmin`
   - Run the following SQL commands:

   ```sql
   CREATE DATABASE IF NOT EXISTS student_db;
   USE student_db;

   CREATE TABLE IF NOT EXISTS users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(100) NOT NULL UNIQUE,
       email VARCHAR(100) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       role ENUM('admin', 'user') DEFAULT 'user',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE IF NOT EXISTS students (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       course VARCHAR(100) NOT NULL,
       birthdate DATE NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```

4. **Run the system**
   - Go to your browser and type:
     ```
     http://localhost/student_system1/
     ```

5. **Register a new user**
   - Start by registering an account
   - Default users are assigned the `user` role unless otherwise set manually

---

## 🌌 Design Notes

- The UI uses Bootstrap 5 and a custom outer space theme.
- Responsive design is applied.
- Buttons have a transparent, modern look.
