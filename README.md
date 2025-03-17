# Thao_Blog Module for Magento 2

## Introduction
`Thao_Blog` is a module for Magento 2 that allows you to easily create and manage a blog on your website. This module provides features such as:
- Managing blog posts (create, edit, delete)
- Displaying blog posts on the frontend
- SEO-friendly URLs

## System Requirements
- Magento 2.4+
- PHP 7.4 or higher

## Installation
You can install the `Thao_Blog` module in two ways: using Composer or manually via the `app/code` directory.

### Method 1: Install via Composer
```sh
composer config repositories.thao-blog git https://github.com/Tothao/Thao_Blog.git
composer require thao/module-blog:dev-master
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```

### Method 2: Manual Installation
1. Download or clone the repository:
   ```sh
   git clone https://github.com/Tothao/Thao_Blog.git app/code/Thao/Blog
   ```
2. Run the following commands to enable the module:
   ```sh
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento cache:flush
   ```

## Configuration
After installation, you can access the Magento admin panel and navigate to **Stores > Configuration > Thaott > Blog** to configure the module settings.

## Support
If you encounter any issues, please open an issue on GitHub or contact us.
