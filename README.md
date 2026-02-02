# 🎓 UKM Event Management System

**IMS566 – Group Project**

## 📌 Project Overview

The **UKM Event Management System** is a web-based application developed to manage event submissions, approvals, and administration workflows within a university environment.
This system is designed to streamline interactions between **Organizers** and **Administrators**, ensuring an efficient, structured, and auditable approval process.

## 📐 Academic Alignment

This project fulfills the IMS566 Group Project requirements by implementing:

- MVC-based web application architecture
- Role-based access control
- Relational database design with normalization
- CRUD operations for core entities
- Approval workflow with audit trail
- Report generation (PDF export)

All features were developed and tested according to the provided project guideline.

---

## 👥 User Roles & Access

### 1️⃣ Organizer

Organizers are responsible for submitting and managing event applications.

**Key Functions:**

* Register & login
* Create event submissions
* Add guests (mandatory)
* Upload supporting documents (optional)
* View approval status (Pending / Approved / Rejected)
* View admin comments
* Export event details to PDF (submission copy)

---

### 2️⃣ Admin

Admins manage approvals and system data.

**Key Functions:**

* Review and approve / reject event submissions
* Add comments during approval
* View all events and organizers
* Manage venues (CRUD)
* Manage users (Admin & Organizer)
* Export event approval details to PDF
* Dashboard with statistics & quick actions

---

## 🧩 System Modules

### 📋 Event Management

* Event creation with date, time, venue, objectives, scope, and type
* One-to-one relationship with approvals
* One-to-many relationship with guests and documents

### ✅ Event Approval

* Approval status tracking:

  * Pending
  * Approved
  * Rejected
* Admin comments recorded
* Approval timestamp stored
* Organizer can view final decision

### 🏢 Venue Management (Admin)

* Add, view, edit, delete venues
* Venue capacity and type tracking
* View events associated with a venue

### 👤 User Management (Admin)

* Create Admin and Organizer accounts
* Role-based access control
* Secure authentication using CakePHP Authentication plugin

### 📄 Export to PDF

Available at:

* Organizer: Event view page (submission copy)
* Admin: Approval view page (official approval copy)

PDF includes:

* Event details
* Organizer information
* Guest list
* Documents list (if any)
* Approval status

---

## 🛠️ Tech Stack

* **Framework:** CakePHP 5
* **Language:** PHP 8+
* **Database:** MySQL
* **Frontend:** HTML, CSS (custom UI)
* **PDF Generation:** DOMPDF
* **Architecture:** MVC (Model-View-Controller)

---

## 🗂️ Database Structure (Summary)

Main tables:

* `users`
* `roles`
* `events`
* `approvals`
* `venues`
* `requests`
* `guests`
* `documents`
* `document_types`
* `guest_types`

Relational integrity is enforced using foreign keys.

---

## 🔐 Authentication & Security

* Role-based access control
* Protected routes using CakePHP Authentication
* Password hashing using bcrypt
* Admin-only access for approvals and system management

---

## 📊 Dashboard Features

### Organizer Dashboard

* Total events
* Pending / Approved / Rejected count
* Recent submissions
* Status breakdown
* Announcements

### Admin Dashboard

* Total events
* Pending approvals
* Total organizers
* Total venues
* Quick access to:

  * Event approvals
  * Venue management
  * User management
  * All events

---

## 📑 Project Status

✔ Core features completed
✔ CRUD operations implemented
✔ Approval workflow functional
✔ PDF export implemented
✔ UI polished for academic submission

---

## 🚀 Installation (Local)

1. Clone the repository

```bash
git clone https://github.com/yourusername/ukm-event-system.git
```

2. Install dependencies

```bash
composer install
```

3. Configure database

* Import provided SQL file
* Update `config/app_local.php`

4. Run server

```bash
bin/cake server
```
---

## ✨ Notes

This system is developed for academic purposes and demonstrates:

* MVC architecture
* Database design & relationships
* Role-based system design
* Approval workflow implementation
* PDF reporting
