# Mo(Jolar)

- Creating sub package.


#### Installation

```bash
composer require aldev/moduler
```

#### Manual Installation

```bash
# Create packages/aldev folder on your root project
# Copy package to packages/aldev
# Add below line to composer.json
"repositories": {
    "aldev/moduler": {
        "type": "path",
        "url": "packages/aldev/moduler"
    }
}
# Then run installation command
composer require aldev/moduler
```


### Commands

**Command** | **Parameters** | **Description**
------------|----------------|----------------
`moduler:create` | `name` | Vendor/module/submodule. i.e `php artisan moduler:create parent/child/grandchild`.
_ | `-A\|--author=John Doe` | Author name.
_ | `-E\|--email=johndoe@moduler.com` | Author email address.
_ | `-D\|--description=` | Module description/
`moduler:list` | _ | List modules.


### Usage

```bash
php artisan moduler:create my/fatastic -A="John Doe" -E="johndoe@example.com" -D="My Fantastic module"
```


### Requirements

**Tech** | **Version**
---------|------------
**PHP** | [7 and above](https://www.php.net/)
**Node** | [14 and above](https://nodejs.org/en/)
**xstate** | [any](https://xstate.js.org/docs/)
**xstate/react** | [any](https://xstate.js.org/docs/packages/xstate-react/#quick-start)
**React** | [any](https://reactjs.org/)


### Change logs

**Version** | **Description**
------------|----------------
**1.2.0** | Laravel 10 support
**1.1.2** | Fix issue on author having equal (=) sign [#5](https://github.com/Als-Laravel-Packages/moduler/issues/5)
**1.1.0** | Can this use for Laravel 8 and up. Fixed issue regarding local adapter
**1.0.0** | This supports laravel 7 and below only, this will cause FlySystem error on higher version

