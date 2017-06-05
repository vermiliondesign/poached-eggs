# Boilerplate Requirements:

-node v.7
-webpack
-composer

# Boilerplate Features:

1. Enables WP minor auto-updates by keeping WordPress out of version control by installing via Composer
2. Installs TacoWordPress and AddMany via Composer

# Getting Started

1. cd into html and run composer install (this installs WordPress, tacotheme, and any other theme dependencies as specified on the composer.json and /html/wp-content/themes/taco-theme/app/core/composer.json files)

3. add your salts and table prefix to the wp-config.php

4. add a db.php file at the root of the repo, with the below database constants:

```
<?php
define(CLIENT_DB_HOSTNAME, '');
define(CLIENT_DB_NAME, '');
define(CLIENT_DB_USER, '');
define(CLIENT_DB_PASSWORD, '');
?>
```
5. after installing WordPress, you'll have to make sure a copy of the .htaccess-wordpress-default exists in the /wordpress directory and is just named .htaccess per usual. You will also need to fix the WordPress Address URL and Site Address URL to remove /wordpress from the path, as it will by default on first install - want to add /wordpress to the URL. You can do this under Settings -> General, or running a find and replace in the database.

5. update .gitlab-ci.yml with staging and production paths

6. check the .htaccess and when setting up password protection on staging environments, comment out lines 5-14 on the .htaccess in the root of the html directory

7. plugins to install

-WP Yoast SEO
-iThemes Security
-Regenerate Thumbnails


# Git Workflow

git checkout -b develop. All pushes to develop should build and deploy automatically to staging. Switching to master, merging develop and pushing to master will setup the production server build and deployment. Pushing to master should always be set to manually deploy.


# Ignored files

This theme ignores WordPress core files. It also ignores the db.php so make sure this gets manually migrated when the site moves environments.

# Frontend tasks

Please review the README in the taco-theme for more information about using webpack.


# Changelog
### v1.0
* First version to be used with PHP 7