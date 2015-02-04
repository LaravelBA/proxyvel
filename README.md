# Proxyvel
An implementation of [ProxyManager](http://github.com/ocramius/proxy-manager) for Laravel.

## Why?
When you do intensive constructor injection, a lot of objects will be needed in order to create your application.
As php creates all your environment for each request, this is a lot of heavy lifting for php to do, and probably most
of your object graph won't be used anyway.

This package helps you by giving you proxies instead of real objects.

For a way better explanation of this, [read what @Ocramius has to say about it](http://ocramius.github.io/presentations/proxy-pattern-in-php)
 or head to the [ProxyManager documentation](http://ocramius.github.io/ProxyManager/html-docs/)

## Usage
Laravel's architecture is not flexible on the IoC container: The `Illuminate\Foundation\Application` object
extends the `Illuminate\Container\Container` and that makes it hard to swap out.

This package provides two extensions, namely of `Application` and `Container`. You probably won't need both.

Also, this package provides a way to decide _what_ objects will be proxied by the IoC container, through the 
`Specification` pattern:

```php
// Proxy all the things!
$specification = new Proxyvel\Specifications\ProxyEverything;

// Proxy by the given namespaces
$specification = new Proxyvel\Specifications\ProxyNamespace([
    'App\Services',
    'App\Repositories'
]);

// Proxy only the given cases / class names
$specification = new Proxyvel\Specifications\ProxyCases([
    // You can always proxy Laravel's services by using the key Laravel sets
    'db',
    // Proxy some concrete classes
    'App\Services\FooService',
    // And some interfaces
    'App\Contracts\FooRepositoryInterface'
]);

// Proxy by regular expression (powerful, but usually complex)
$specification = new Proxyvel\Specifications\ProxyByRegExp([
    '/Interface$/', '/^Abstract/'
]);

// Combine multiple specifications
$specification = new Proxyvel\Specifications\ProxyCollection([
    new Proxyvel\Specifications\ProxyCases(/* ... */),
    new Proxyvel\Specifications\ProxyNamespace(/* ... */),
]);

// Define by negation (for those of you who see the glass half-empty)
$specification = new Proxyvel\Specifications\ProxyNegator(
    new Proxyvel\Specifications\ProxyNamespace('App\Entities')
);
```

### Usage in a Laravel project
There's no `ServiceProvider` here. You'll need to edit your `bootstrap/start.php` file, and replace the `$app`
variable with this package's `Application`:

```php
// in bootstrap/start.php 
$app = new Proxyvel\Application(
    // Example Specification, build the one you need here
    new Proxyvel\Specifications\ProxyEverything,
    // Only instances of AbstractLazyFactory are accepted for now
    new ProxyManager\Factory\LazyLoadingValueHolderFactory
);
```

In a Laravel project, every instance of `Container` is resolved with the initial `Application`, so that's the
only thing you'll ever need.

### Usage outside of a Laravel project
If you use Laravel's `Container` outside of a Laravel project, you'll need to instantiate this package's `Container`
extension instead.

```php
// Wherever you first instantiate it
$container = new Proxyvel\Container(
    // Example Specification, build the one you need here
    new Proxyvel\Specifications\ProxyEverything,
    // Only instances of AbstractLazyFactory are accepted for now
    new ProxyManager\Factory\LazyLoadingValueHolderFactory
);
```

Because of Liskov's substitution principle, this package's extension can be used in any place the `Container` is 
expected.