<?php
namespace Datavis\Form\Element;

use Laminas\Form\Element\Number;
use Laminas\InputFilter\InputProviderInterface;

/**
 * By default, Laminas sets Number elements as required. This makes it optional.
 */
class OptionalNumber extends Number implements InputProviderInterface
{
    public function getInputSpecification() : array
    {
        return [
            'name' => $this->getName(),
            'required' => false,
            'validators' => [],
            'filters' => [],
        ];
    }
}
