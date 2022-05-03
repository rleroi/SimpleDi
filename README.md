# SimpleDi
Simple dependency injection

Uses phpdoc's `@property` to automatically inject missing properties.

## Usage:
```php
/**
 * @property \App\World $world
 **/
class MyClass {
  function hello() {
    // 'world' property is automatically injected as a new \App\World()
    var_dump($this->world);
  }
}
```

### Singleton

```php
/**
 * @property \App\World $world
 **/
class MyClass {
  function __construct() {
    // create an instance that should be injected every time for \App\World
    $world = new \App\World();
    SimpleDiService::singleton(\App\World::class, $world);
  }

  function hello() {
    // 'world' property is automatically injected as the \App\World
    // instance defined previously in SimpleDiService::singleton();
    var_dump($this->world);
  }
}
```

### Bind

```php
/**
 * @property \App\World $world
 **/
class MyClass {
  function __construct() {
    // Create a callback that returns an instance that should be injected for \App\World
    SimpleDiService::bind(\App\World::class, fn () => new \App\World());
  }

  function hello() {
    // 'world' property is automatically injected as defined previously in SimpleDiService::bind();
    var_dump($this->world);
  }
}
```
