<?php namespace WUserApi\UserApi\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'username' => $this->username,
            'email' => $this->email,
            'permissions' => $this->permissions,
            'last_login' => $this->last_login,
            'last_seen' => $this->last_seen,
            'activated_at' => $this->activated_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'is_activated' => $this->is_activated,
            'is_guest' => $this->is_guest,
            'is_superuser' => $this->is_superuser,
        ];
    }
}
