<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface AclRepositoryInterface{

    public function validateLogin(Request $request);
    public function validateUserRegister(Request $request);
    public function storeUser(Request $request);
    public function validateChangePassword(Request $request);
    public function authenticateUser(Request $request);
    public function changePassword(Request $request);
    public function refreshToken($token);


}
