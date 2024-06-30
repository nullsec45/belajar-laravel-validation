<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormControllerTest extends TestCase
{
   public function testLoginSuccess(): void{
        $response=$this->post("/form/login",[
            "username" => "admin",
            "password" => "rahasia"
        ]);

        $response->assertStatus(200);
   }

   public function testLoginFailed(): void{
        $response=$this->post("/form/login",[
            "username" => "",
            "password" => ""
        ]);

        $response->assertStatus(302);
   }
}
