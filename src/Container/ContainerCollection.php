<?php

namespace Boxmeup\Container;

use Cjsaylor\Domain\Collection;

class ContainerCollection extends Collection
{
    public function get($id)
    {
        $items = $this->getItems();

        return isset($items[$id]) ? $items[$id] : null;
    }

    public function add(Container $container)
    {
        $this->getItems()[$container['id']] = $container;
    }

}
