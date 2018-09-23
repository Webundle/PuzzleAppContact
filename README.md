# Puzzle App Contact Bundle
**=========================**

Puzzle app contact

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

`composer require webundle/puzzle-app-contact`

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
{
    $bundles = array(
    // ...

    new Puzzle\App\ContactBundle\PuzzleAppContactBundle(),
                    );

 // ...
}

 // ...
}
```

### Step 3: Register the Routes

Load the bundle's routing definition in the application (usually in the `app/config/routing.yml` file):

# app/config/routing.yml
```yaml
puzzle_app:
        resource: "@PuzzleAppContactBundle/Resources/config/routing.yml"
```

### Step 4: Configure Bundle

Then, configure bundle by adding it to the list of registered bundles in the `app/config/config.yml` file of your project under:

```yaml
# Puzzle App Blog
puzzle_app_contact:
    title: contact.title
    description: contact.description
    icon: contact.icon
    templates:
        contact:
            create: 'AppBundle:Contact:create_contact.html.twig'
            show: 'AppBundle:Contact:contact.html.twig'
```