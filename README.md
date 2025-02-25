# PHP:ONE - Open Source ONE RECORD Server

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-8%2B-blue)](https://www.php.net/)
[![Database Support](https://img.shields.io/badge/Database-MySQL-green)](https://www.mysql.com/)
[![API Support](https://img.shields.io/badge/API-ONE%20RECORD-orange)](https://www.iata.org/en/programs/cargo/one-record/)

## 🚀 Overview

**PHP:ONE** is an **Open Source ONE RECORD Server** built with PHP, powered by **MySQL**, and fully compliant with **ONE RECORD Ontology and API specifications**.  
It can also function as a **Universal Cargo Hub**, allowing seamless data exchange between logistics stakeholders using **One Record API** and traditional **Cargo-IMP messaging (C-IMP/C-XML formats)**.

## 🌍 Key Features

✅ **Full ONE RECORD API & Ontology Support** – Implements all One Record data models and API endpoints.  
✅ **Multi-Channel Data Ingestion** – Supports data exchange via **ONE RECORD API, Email, and SITA**.  
✅ **Universal Cargo Hub** – Connects both **modern and legacy systems**, allowing seamless transition to One Record.  
✅ **Cargo-IMP (C-IMP / C-XML) Compatibility** – Works with older messaging and data-sharing standards.  
✅ **Access Delegation & Subscriptions** – Supports access control, event subscriptions, and change notifications.  
✅ **Industry-Standard Open Source Solution** – Accelerates One Record adoption for logistics companies.  

## 🔧 Installation

### 1️⃣ Clone Repository
```sh
git clone https://github.com/Awery-Open-Source/onerecordback
cd php-one
```

### 2️⃣ Install Dependencies
Ensure you have **PHP 8+, Composer, and MySQL** installed.
```sh
composer install
```

### 3️⃣ Configure Database
Update `.env` with database credentials:
```ini
DATABASE_URL="mysql://user:password@127.0.0.1:3306/php_one_db"
```

### 4️⃣ Run Database Migrations
```sh
php bin/console doctrine:schema:update --force
```

### 5️⃣ Start PHP:ONE Server
```sh
php bin/console server:start
```


## 🌐 Supported Integrations

- 📡 **ONE RECORD API (RESTful API)**
- 📩 **Email / SITA Message Parsing**
- 🔄 **Cargo-IMP (C-IMP / C-XML) Interoperability**

## 🤝 Contributing

We welcome contributions! To contribute:
1. Fork the repository.
2. Create a new branch (`feature-branch-name`).
3. Submit a pull request.

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

---

🚀 **Join us in building the future of digital logistics!**  
🔗 **GitHub:** [https://github.com/Awery-Open-Source/onerecordback](https://github.com/Awery-Open-Source/onerecordback)

🔗 **Using:** [https://github.com/zabidok/php-onerecord-entities](https://github.com/zabidok/php-onerecord-entities)
