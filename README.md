# Introduction

Simple PHP project for my Diploma of Software Development.

This project is based on the teacher template.

Several customizations are being made for applying the best practice in software development and also achieve the demand of the course.

# Project Set Up

1. Clone the project: `git clone https://github.com/alanlima/lpaecomms-web.git`
2. Run `npm install` to install all the dependencies.

# Database Set Up

1. Rename the file `config.template.php` to `config.php`.
2. Open the renamed file and change the content with the database connection details.

File Sample:

```php
<?php
    return array(
        'db_host' => 'localhost',
        'db_name' => 'phpmyadmin',
        'db_user' => 'user',
        'db_pwd' => 'pwd'
    );
```

# FTP Upload Set Up

1. Rename the file `ftp-deploy.template.json` to `ftp-deploy.json`.
2. Open the renamed file and change the content with the FTP Server details.

File Sample:

```json
{
    "host": "host",
    "user": "user",
    "pwd": "pwd"
}
```

## FTP Deploy

Run `gulp deploy`