Constants Collection
=====================

Простой PHP класс, позволяющий создавать наборы констант, назначать им различные свойства, получать массивы свойств и констант.

### Установка

    composer require fsmdev/constants-collection

### Использование

#### Набор констант

Унаследуйте свой класс от **Fsmdev\ConstantsCollection\ConstantsCollection** и определите константы.

```php
use Fsmdev\ConstantsCollection\ConstantsCollection;

class PostStatus extends ConstantsCollection
{
    const EDITED = 1;
    const PUBLISHED = 2;
    const DELETED = 3;
}
```
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

Для получения массива всех значений констант используйте метод **valuesArray**

    valuesArray () : array

#### Свойства

Для каждой константы можно задать именованные свойства. Для этого в классе необходимо определить функцию, построенную по маске **properties + CamelCase имя свойства**. Метод должен возвращать массив, ключами которого являются значения констант, а значениями являются значения свойств.

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

Получить свойство значения константы можно с помощью статического метода **property**
    
    property ( mixed $value [, string $property = 'name' ] ) : mixed
    
Пример использования в Blade:
    
```blade
Status:
<span class="{{ PostStatus::property($post->status, 'indicator_class') }}">
    {{ PostStatus::property($post->status) }}
</span>
```
Получить массив свойств можно с помощью статического метода **propertiesArray**

    propertiesArray ( [ string $property = 'name' ] ) : array

#### Получение значения по свойству

    value ( mixed $value [, string $property = 'name' ] ) : mixed
    
```php
$status = PostStatus::value('Edited');
```
