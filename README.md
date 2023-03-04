# Data transformer

The modern PHP library for converting arrays into objects and vice-versa. 

## Installation

`composer require blacktrs/data-transformer`

## Configuration

By default, the library will try to resolve public properties and match the with array fields.
However, it is possible to configure needed properties with attributes.

### Attributes

## Examples

### Convert the array into the object

```php
class RequestObject
{
    public readonly int $id;
    public readonly string $email;
    public readonly string $name;
}

$requestPayload = ['id' => 1, 'email' => 'some.email@example.com', 'name' => 'John Doe'];

$transformer = new \Blacktrs\DataTransformer\Transformer\ObjectTransformer();
$requestObject = $transformer->transform(RequestObject::class, $requestPayload);

echo $requestObject->id; // 1
```

### Convert the object into the array

```php
class ResponseObject
{
    public readonly int $id;
    public readonly string $email;
    public readonly string $name;
}

$responseObject = new ResponseObject(
    id: 1, 
    email: 'some.email@example.com', 
    name: 'John Doe'
);

$serializer = new \Blacktrs\DataTransformer\Serializer\ObjectSerializer();
$responseArray = $serializer->serialize($responseObject);

echo $responseArray['id']; // 1
```