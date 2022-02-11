<?php

namespace App\Representation;

use JMS\Serializer\Annotation as Serializer;


class Users 
{
    /**
     * @Serializer\Groups({"list_user"})
     * @Serializer\Type("array<App\Entity\User>")
     */
    public $data;

    public function __construct(array $pager)
    {
       $this->data = $pager;
    }
    
} 