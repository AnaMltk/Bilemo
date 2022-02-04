<?php

namespace App\Representation;

use JMS\Serializer\Annotation as Serializer;


class Products 
{
    /**
     * @Serializer\Groups({"list_product"})
     * @Serializer\Type("array<App\Entity\Product>")
     */
    public $data;

    public function __construct(array $pager)
    {
       $this->data = $pager;
    }
    
} 