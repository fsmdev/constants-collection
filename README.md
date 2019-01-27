Constants Collection
=====================

[English](https://github.com/fsmdev/constants-collection/blob/master/README.md) | [Русский](https://github.com/fsmdev/constants-collection/blob/master/README.RU.md)

A simple PHP class that allows you to create collections of constants, assign them properties, get arrays of properties and constants.

### Installation

    composer require fsmdev/constants-collection

### Usage

#### Constants collection

Inherit your class from **Fsmdev\ConstantsCollection\ConstantsCollection** and define constants.

```php
use Fsmdev\ConstantsCollection\ConstantsCollection;

class PostStatus extends ConstantsCollection
{
    const EDITED = 1;
    const PUBLISHED = 2;
    const DELETED = 3;
}
```

Examples:

```php
$post = new Post();
$post->status = PostStatus::PUBLISHED;
```
```php
class Post
{
    public function isPublished()
    {
        return $this->status == PostStatus::PUBLISHED;
    }
}
```

To get an array of constants use the method **valuesArray**

    valuesArray () : array

#### Properties

Named properties can be set for each constant. To do this, it is necessary to define a function in the class that is built according to the mask: **properties + PropertyName (camel case)**. The method must return an array whose keys are the values of the constants, and the values are the values of the properties.

```php
# class PostStatus

protected static function propertiesName()
{
    return [
        self::EDITED => 'Edited',
        self::PUBLISHED => 'Published',
        self::DELETED => 'Deleted',
    ];
}

protected static function propertiesIndicatorClass()
{
    return [
        self::EDITED => 'text-warning',
        self::PUBLISHED => 'text-success',
        self::DELETED => 'text-danger',
    ];
}
```

Properties can be obtained using the static method **property**
    
    property ( mixed $value [, string $property = 'name' ] ) : mixed
    
Example (Blade):
    
```blade
Status:
<span class="{{ PostStatus::property($post->status, 'indicator_class') }}">
    {{ PostStatus::property($post->status) }}
</span>
```
You can get an array of properties using the static method **propertiesArray**

    propertiesArray ( [ string $property = 'name' ] ) : array

#### Getting value by property

    value ( mixed $value [, string $property = 'name' ] ) : mixed
    
```php
$status = PostStatus::value('Edited');
```

### Packagist.org

<https://packagist.org/packages/fsmdev/constants-collection>
