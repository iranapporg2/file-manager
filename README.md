# Laravel File Manager

Laravel File Manager is a flexible and pluggable file management package for Laravel. It allows you to easily upload and manage files across different storage drivers such as local disk, FTP, S3, or ArvanCloud. This package provides ready-to-use controllers, AJAX-based JavaScript support, and blade view examples to get started quickly.

### Attention!
The package, override public and private and s3 disk on your filesystems.php.

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

### Needing env config:
**Public Disk**:    
FILE_MANAGER_PUBLIC_ROOT=/root/

**Arvan Disk:**     
ARVAN_ACCESS_KEY=   
ARVAN_SECRET_KEY=   
ARVAN_BUCKET=   
ARVAN_API_KEY=  
ARVAN_URL=

**FTP Disk:**   
FTP_HOST=   
FTP_USERNAME=       
FTP_PASSWORD=   
FTP_URL=    
FTP_ROOT_FOLDER=

**S3 Disk:**    
AWS_ACCESS_KEY_ID=  
AWS_SECRET_ACCESS_KEY=  
AWS_DEFAULT_REGION=us-east-1    
AWS_BUCKET= 
AWS_USE_PATH_STYLE_ENDPOINT=false   
---

## 📂 Publishing Resources

Publish migrations, config, and public assets:

```bash
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
@include('file-manager::example_file_upload')
```

Or check the JS helper file:

```html
<script src="{{ asset('assets/filemanager.js') }}"></script>
```

Use this JavaScript to send your form data via AJAX.

---

## 📎 Example

See the included `example_file_upload.blade.php` for how to create an AJAX-based file upload form.

You can modify this view to match your front-end design or integrate it into your admin panel.

---

## 📃 License

This project is open-source and released under a permissive license.

---

## 👨‍💻 Author

Developed by [itsunn](https://github.com/itsunn)
