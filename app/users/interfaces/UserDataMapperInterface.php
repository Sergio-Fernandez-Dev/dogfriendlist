<?php 

namespace App\Users\Interfaces;

use App\Users\User;

interface UserDataMapperInterface
{
    public function find($param);
    public function insert(User $user);
    public function update(User $user);
    public function delete(User $user);
}

?>