<?php
/**
 * Z-Engine framework
 *
 * @copyright Copyright 2019, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 */

namespace ZEngine;

use FFI\CData;

class ObjectEntry extends ReflectionClass
{
    public HashTable $properties;

    private CData $pointer;

    public function __construct(CData $pointer)
    {
        $this->pointer = $pointer;
        // TODO: Maybe just break this inheritance and keep this separate from ObjectEntry
        parent::__construct((string) (new StringEntry($this->pointer->ce->name)));
        if ($this->pointer->properties !== null) {
            $this->properties = new HashTable($this->pointer->properties);
        }
    }

    /**
     * Returns an object handle, this should be equal to spl_object_id
     *
     * @see spl_object_id()
     */
    public function getHandle(): int
    {
        return $this->pointer->handle;
    }

    public function __debugInfo()
    {
        $info = [
            'handle' => $this->getHandle(),
            'class'  => $this->getName()
        ];
        if (isset($this->properties)) {
            $info['properties'] = $this->properties;
        }

        return $info;
    }
}