<?php

namespace Acme\App\Repository\Hydration;

use Zend\Hydrator\Strategy\StrategyInterface;

class DateTimeStrategy implements StrategyInterface
{
    /**
     * @inheritdoc
     */
    public function extract($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function hydrate($value)
    {
        if (!($value instanceof \DateTime)) {
            $value = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
        }
        return $value;
    }
}