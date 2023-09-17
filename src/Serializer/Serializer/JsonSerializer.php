<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer\Serializer;

use Blacktrs\DataTransformer\Serializer\ObjectSerializerInterface;
use Blacktrs\DataTransformer\{Fieldable, Valuable};

use function json_encode;

class JsonSerializer implements ObjectSerializerInterface
{
    use Fieldable;
    use Valuable;

    private bool $includePrivateProperties = false;

    /**
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $originSerializer
     */
    public function serialize(object $object, string|ObjectSerializerInterface|null $originSerializer = null): string
    {
        $arraySerializer = new ArraySerializer();

        return json_encode(
            $arraySerializer
                ->setIncludePrivateProperties($this->includePrivateProperties)
                ->serialize($object, $originSerializer),
            JSON_THROW_ON_ERROR
        );
    }

    public function setIncludePrivateProperties(bool $includePrivateProperties): self
    {
        $this->includePrivateProperties = $includePrivateProperties;

        return $this;
    }
}
