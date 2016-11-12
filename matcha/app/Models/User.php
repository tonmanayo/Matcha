<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'age',
        'address',
        'birthday',
        'country',
        'email',
        'gender',
        'interests',
        'name',
        'password',
        'phone_number',
        'surname',
        'username',
        'work_education'
    ];

    public function setPassword($password)
    {
        $this::update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function updateProfile(
        $address,
        $age,
        $birthday,
        $country,
        $gender,
        $interests,
        $name,
        $phone_number,
        $surname,
        $work_education
    )
    {
        $this::update([
            'address' => $address,
            'age' => $age,
            'birthday' => $birthday,
            'country' => $country,
            'gender' => $gender,
            'interests' => $interests,
            'name' => $name,
            'phone_number' => $phone_number,
            'surname' => $surname,
            'work_education' => $work_education
        ]);
    }
}
