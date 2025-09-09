# Laravel File Manager

Laravel File Manager is a flexible and pluggable file management package for Laravel. It allows you to easily upload and manage files across different storage drivers such as local disk, FTP, S3, or ArvanCloud. This package provides ready-to-use controllers, AJAX-based JavaScript support, and blade view examples to get started quickly.

---

## 📚 Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Available Storage Drivers](#available-storage-drivers)
- [Publishing Resources](#publishing-resources)
- [Example](#example)
- [License](#license)

---

## 🚀 Features

- Upload files via AJAX
- Built-in controllers for file and folder management
- Supports multiple storage drivers (FTP, S3, Arvan, etc.)
- Laravel-style service structure (Controllers, Requests, Services, Models)
- Database support for file & folder metadata
- Example blade view and JavaScript helper

---

## 🛠 Installation

Install via Composer:

```bash
composer require itsunn/file-manager
```

---

## ⚙️ Configuration

You need to merge the package’s `filesystems.php` configuration into your app’s filesystem config.  
To publish the configuration file:

```bash
php artisan vendor:publish --tag=file-manager
```

Update your `config/filesystems.php` with your custom drivers and credentials as needed.

---

## 📂 Publishing Resources

Publish migrations, config, and public assets:

```bash
php artisan vendor:publish --tag=file-manager
php artisan vendor:publish --tag=file-manager
php artisan vendor:publish --tag=file-manager
```

---

## 📦 Available Storage Drivers

The package currently supports the following drivers:

- Local
- FTP
- S3
- ArvanCloud

You can configure these in your app’s `config/filesystems.php` by merging the settings from the package config.

---

## 📤 Usage

To upload files or manage folders, make AJAX requests to the following controllers:

- `FileManagerController`
- `FolderManagerController`

These controllers are already defined and handle file uploads, deletions, folder creation, etc.

Refer to the included Blade example view for implementation:

```blade
@include('file-manager::example')
```

Or check the JS helper file:

```html
<script src="{{ asset('vendor/file-manager/filemanager.js') }}"></script>
```

Use this JavaScript to send your form data via AJAX.

---

## 📎 Example

See the included `example.blade.php` for how to create an AJAX-based file upload form.

You can modify this view to match your front-end design or integrate it into your admin panel.

---

## 📃 License

This project is open-source and released under a permissive license.

---

## 👨‍💻 Author

Developed by [itsunn](https://github.com/itsunn)
