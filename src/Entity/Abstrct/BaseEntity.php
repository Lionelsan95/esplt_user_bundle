<?php

namespace App\Entity\Abstrct;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

abstract class BaseEntity
{
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    protected $createdAt;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Gedmo\Timestampable]
    protected $updatedAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}