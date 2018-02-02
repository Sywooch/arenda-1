<?php
namespace tests\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('admin');

        expect_not(User::findIdentity(999));
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('admin'));
        expect_not(User::findByUsername('not-admin'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('admin');
        expect_that($user->validateAuthKey('OjF4oXLUbbbq7ugyb1M1BWnFQ3swNok3'));
        expect_not($user->validateAuthKey('OjF4oXLUbbbq7ugyb1M1BWnFQ3swNok'));

        expect_that($user->validatePassword('123qwe'));
        expect_not($user->validatePassword('123qw'));
    }

}
