# Data transformer

The modern PHP library for converting arrays into objects and vice-versa.

## Installation

`composer require blacktrs/data-transformer`

## Configuration

By default, the library will try to resolve `public` properties and match the with array fields. 
The transformer is trying to find an object property with equal name as array field. 
In case, if object missing such fields, the transformer converts array keys into camel case.
However, it is possible to configure needed properties with attributes.

## Attributes

### `DataField`
This attribute is applicable to properties. By this attribute you can configure the behavior for each property you need

The following parameters can be specified:
* `string|null $nameIn` Field name in an input array to map with the property
* `string|null $nameOut` Field name in an output array to fill with the property data
* `ValueResolverInterface|class-string<ValueResolverInterface>|null $valueResolver` Custom value resolver to convert property data in a needed way
* `array<key,value> $valueResolverArguments` Additional arguments passed into value resolver
* `TransformerInterface|class-string<TransformerInterface>|null $objectTransformer` Custom property transformer to achieve more control in case if object passed
* `bool $ignoreTransform` Skip property while transforming an array into the object
* `bool $ignoreSerialize` Skip property while serializing an object into array

### `DataObject`
This attribute is applicable to classes and allows to use custom object serializer while converting object into other form

The following parameters can be specified:
* `ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $objectTransformer` Custom object serializer

## Examples

### Convert the array into the object

```php
class RequestObject
{
    public readonly int $id;
    public readonly string $email;
    public readonly string $name;
    #[\Blacktrs\DataTransformer\Attribute\DataField(valueResolver: \Blacktrs\DataTransformer\Value\DateTimeValueResolver::class)]
    public readonly \DateTime $date;
}

$requestPayload = ['id' => 1, 'email' => 'some.email@example.com', 'name' => 'John Doe', 'date' => '2023-06-01 10:10:10'];

$transformer = new \Blacktrs\DataTransformer\Transformer\Transformer();
$requestObject = $transformer->transform(RequestObject::class, $requestPayload);

echo $requestObject->id; // 1
echo $requestObject->email; // some.email@example.com
echo $requestObject->name; // John Doe
echo $requestObject->date->format('Y-m-d'); // 2023-06-01
```

### Convert the object into the array

```php
class ResponseObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $name
    ) {
    }
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