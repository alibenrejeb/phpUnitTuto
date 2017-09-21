<?php
namespace App\Service;

use App\Connection;

class AdvertService
{
    //protected $conn;

    /**
     * AdvertService constructor.
     */
    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function getAllAdvert()
    {
        return $this->conn->fetchAll('oc_advert');
    }
}