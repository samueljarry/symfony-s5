<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\YourEntity; // Remplacez YourEntity par le nom de votre entité

class EntitySavedEvent extends Event
{
    private $entity;

    public function __construct(YourEntity $entity)
    {
        $this->entity = $entity;
    }

    public function getEntity()
    {
        return $this->entity;
    }
}