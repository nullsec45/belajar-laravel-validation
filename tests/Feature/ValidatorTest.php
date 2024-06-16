<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ValidatorTest extends TestCase
{
    public function testValidator(){
        $data=[
            "username" => "admin",
            "password" => "12345"
        ];

        $rules=[
            "username" => "required",
            "password" => "required"
        ];

        $validator=Validator::make($data, $rules);
        self::assertNotNull($validator);
        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());
    }

    public function testValidatorInvalid(){
        $data=[
            "username" => "",
            "password" => ""
        ];

        $rules=[
            "username" => "required",
            "password" => "required"
        ];

        $validator=Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());
        self::assertTrue($validator->fails());

        $message=$validator->getMessageBag();
        $message->get("username");
        $message->get("password");

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorException(){
        $data=[
            "username" => "",
            "password" => ""
        ];

        $rules=[
            "username" => "required",
            "password" => "required"
        ];

        $validator=Validator::make($data, $rules);
        self::assertNotNull($validator);

        try{
            $validator->validate();
            self::fail("ValidationException Not Thrown");
        }catch(ValidationException $exception){
            self::assertNotNull($exception->validator);
            $message=$exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));

        }


    }
}
