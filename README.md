# Docksal powered Drupal 9 With Composer Installation

## Developer notice:

This is a sample site running on Drupal9 that I used as a backbone to implement the knowledge I aquired while learning how to work with different parts of Drupal. I really didnt pay much attention to repo handling and commits/branches since the original puprose of the repo was to simply keep my work synced between my pcs as needed.

The content you may want to take a look at could be divided in two: Theme Development and Module development.

### Theme development

I built a little custom theme while learning theming and site building. The idea was to create something reesembling a streaming service page.

This can be found in: web\themes\mentoring.

Things I learned during this experienmce:
- How to install/create a theme and configure it.
- How the render API and themes work, defining regions, using base themes and asset libraries, overriding and creation of templates.
- How twig templating works, using preprocess functions and hooks to add/modify the availabe information or behaviour of a theme.
- Working with views, extending functionality with modules such as responsive images and configuring them.

### Module Development
I built some custom modules to better understand how drupals backend works, I worked more specifically with: Form API, Database API, Schema API, Plugin api. This is still a work in progress and some of it is missing due to technical problems with one of my pcs.

This can be found in web\modules\custom.

Things I learned so far:
- How to create and configure a custom module.
- How to create, alter and validate forms using the Form API.
- How to plugins and services work, how to create and configure an annotation based plugin and use dependency injection.
- How to the database and schema apis work, how to instantiate a connection, write querys and create a custom schema for a table


This is a sample Drupal 9 with Composer installation pre-configured for use with Docksal.

Features:

- Drupal 9 Composer Project
- `fin init` [example](.docksal/commands/init)
- Using the [default](.docksal/docksal.env#L9) Docksal LAMP stack with [image version pinning](.docksal/docksal.env#L13-L15)
- PHP and MySQL settings overrides [examples](.docksal/etc)

## Setup instructions

### Step #1: Docksal environment setup

**This is a one time setup - skip this if you already have a working Docksal environment.**

Follow [Docksal environment setup instructions](https://docs.docksal.io/getting-started/setup/)

### Step #2: Project setup

1. Clone this repo into your Projects directory

    ```
    git clone https://github.com/docksal/boilerplate-drupal9-composer.git drupal9
    cd drupal9
    ```

2. Initialize the site

    This will initialize local settings and install the site via drush

    ```
    fin init
    ```
   A `composer.lock` file will be generated. This file should be committed to your repository.

3. Point your browser to

    ```
    http://drupal9.docksal
    ```

When the automated install is complete the command line output will display the admin username and password.


## More automation with 'fin init'

Site provisioning can be automated using `fin init`, which calls the shell script in [.docksal/commands/init](.docksal/commands/init).
This script is meant to be modified per project. The one in this repo will give you a good starting example.

Some common tasks that can be handled by the init script (an other [custom commands](https://docs.docksal.io/fin/custom-commands/)):

- initialize local settings files for Docker Compose, Drupal, Behat, etc.
- import DB or perform a site install
- compile Sass
- run DB updates, revert features, clear caches, etc.
- enable/disable modules, update variables values


## Security notice

This repo is intended for quick start demos and includes a hardcoded value for `hash_salt` in `settings.php`.
If you are basing your project code base on this repo, make sure you regenerate and update the `hash_salt` value.
A new value can be generated with `drush ev '$hash = Drupal\Component\Utility\Crypt::randomBytesBase64(55); print $hash . "\n";'`
