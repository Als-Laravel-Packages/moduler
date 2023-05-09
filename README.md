# Mo(Jolar)

- Creating sub package.


#### Installation

```bash
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
**1.0.0** | This supports laravel 7 and below only, this will cause FlySystem error on higher version
**1.1.0** | Can this use for Laravel 8 and up. Fixed issue regarding local adapter


