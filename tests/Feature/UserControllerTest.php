<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     //test view ada ?
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }
    //tes  seesion guest and user 
    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->get('/login')
            ->assertRedirect("/");
    }
    //tes login user ada tidak
    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "khannedy",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "khannedy");
    }
    //tes user sudah login
    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->post('/login', [
            "user" => "khannedy",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "khannedy"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }
}
