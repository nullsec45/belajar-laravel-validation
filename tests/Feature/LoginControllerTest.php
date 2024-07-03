<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function testFormSuccess(): void{
        $response=$this->post("/form",[
            "username" => "admin",
            "password" => "rahasia"
        ]);

        $response->assertStatus(200);
   }

   public function testFormFailed(): void{
        $response=$this->post("/form",[
            "username" => "",
            "password" => ""
        ]);

        $response->assertStatus(302);
   }
}
