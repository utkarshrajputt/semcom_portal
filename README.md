
# 📚 SEMCOM Portal

A complete web-based College Management System designed for SEMCOM College. This portal allows **Admins**, **Staff**, and **Students** to interact via role-based dashboards, perform academic operations, and manage evaluations, feedback, and announcements efficiently.

---

## 🚀 Features

🔐 **Role-Based Access**
- Admin: Full control — manage staff, students, and announcements.
- Staff: Add evaluations, view student details, and provide feedback.
- Student: View results, submit feedback, and access notices.

📝 **Modules**
- Feedback system
- Evaluation management
- Notice board
- Staff and student directory
- Result generation
- Session-based login/logout system

📊 **Admin Utilities**
- Logs (access/error)
- User management
- Role & permission control (hardcoded for now)

---

## 🛠️ Tech Stack

| Layer         | Technology            |
|---------------|------------------------|
| Backend       | PHP                    |
| Frontend      | HTML, CSS, JavaScript  |
| Database      | MySQL                  |
| Styling       | Bootstrap (optional)   |
| Hosting Ready | XAMPP / LAMP Stack     |

---

## 📂 Folder Structure

```

semcom\_portal/
├── admin/             # Admin-specific pages and controls
├── staff/             # Staff dashboard and features
├── student/           # Student-side portal and views
├── assets/            # Images, JS, CSS
├── includes/          # Shared components (header, footer, sidebar)
├── config/            # DB connection and constants
├── logs/              # Access and error logs
├── database/          # SQL schema & setup scripts (add yours here!)
├── index.php          # Landing/login page
└── README.md          # You're reading this!

````

---

## 🧪 Local Setup

1. **Clone this Repository**
   ```bash
   git clone https://github.com/utkarshrajputt/semcom_portal.git


2. **Set Up XAMPP or LAMP**

   * Place the project folder in the `htdocs/` directory (for XAMPP).
   * Start Apache and MySQL from your control panel.

3. **Configure the Database**

   * Create a MySQL database named `semcom_portal` (or edit `config/config.php` to match).
   * Import the SQL file (if available) using phpMyAdmin or MySQL CLI.

4. **Edit Configuration**

   * Go to `config/config.php` and update your DB credentials accordingly.

5. **Run the App**
   Open your browser and go to:

   ```
   http://localhost/semcom_portal/
   ```

---

## 🔐 Default Credentials (for Testing)

> Change these in production!

| Role    | Username    | Password  |
| ------- | ----------- | --------- |
| Admin   | `admin`     | `admin`   |
| Staff   | `staff01`   | `staff`   |
| Student | `student01` | `student` |

---

## ✍️ Contributing

1. Fork the repo
2. Create a new branch (`git checkout -b feature-name`)
3. Commit your changes (`git commit -m 'Add new feature'`)
4. Push to the branch (`git push origin feature-name`)
5. Open a Pull Request ✅

---

## 📌 TODO (Optional Enhancements)

* [ ] Switch to OOP / MVC architecture
* [ ] Add email notifications
* [ ] Implement password hashing (`password_hash`)
* [ ] Add CSRF tokens for better security
* [ ] Add REST APIs for mobile app integration
* [ ] Dockerize the project

---


---

## 📄 License

MIT License – free to use and modify. Attribution appreciated but not required.

---
