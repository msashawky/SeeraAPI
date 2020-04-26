<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrganizationWebsiteRepositoryInterface{
    public function getWebsiteData($domain);



}
