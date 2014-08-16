<?php

namespace Boxmeup\Container;

use Cjsaylor\Domain\CollectionEntity;
use Boxmeup\Schema\SchemaValidatable;
use Boxmeup\Schema\SchemaSerializable;
use Boxmeup\Schema\DefaultEntitySchemaValidate;
use Boxmeup\Util\SlugifyTrait;
use Boxmeup\User\User;
use Boxmeup\Location\Location;

class Container extends CollectionEntity implements SchemaValidatable, SchemaSerializable
{
    use DefaultEntitySchemaValidate, SlugifyTrait;

    /**
	 * Add a ContainerItem to the Container collection.
	 *
	 * @param ContainerItem $item
	 * @return void
	 */
    public function add(ContainerItem $item)
    {
        $this->getItems()[] = $item;
    }

    /**
	 * Handle slugifying the object if the name is set.
	 *
	 * @param string $name
	 */
    public function setName($name)
    {
        $this->data['name'] = $name;
        if (empty($this['slug'])) {
            $this->data['slug'] = $this->slugify('name');
        }
    }

    /**
	 * Get total number of items in the container.
	 *
	 * @return integer
	 */
    public function getItemCount()
    {
        $total = 0;
        foreach ($this as $item) {
            $total += $item['quantity'];
        }

        return $total;
    }

    /**
	 * Required schema for containers.
	 *
	 * @return string[]
	 */
    public function getRequiredSchema()
    {
        return [
            'user', 'name'
        ];
    }

    /**
	 * Serialize to array specific to schema formatting.
	 *
	 * @return array
	 * @todo implement location.
	 */
    public function schemaSerialize()
    {
        $out = [
            'id' => $this['id'],
            'user_id' => $this['user'] instanceof User ? $this['user']['id'] : null,
            'location_id' => $this['location'] instanceof Location ? $this['location']['id'] : null,
            'name' => $this['name'],
            'slug' => $this['slug'],
            'container_item_count' => isset($this['container_item_count']) ? $this['container_item_count'] : 0,
            'created' => isset($this['created']) ? $this['created'] : date('Y-m-d H:i:s')
        ];
        $out['modified'] = isset($this['modified']) ? $this['modified'] : $out['created'];

        return $out;
    }
}
