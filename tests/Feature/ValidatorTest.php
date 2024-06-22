<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\{Log, App};
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator as AdditionalValidator;


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

    public function testMultipleValidationRules(){
        App::setLocale("id");
        
        $data=[
            "username" => "fajar",
            "password" => "rama"
        ];

        $rules=[
            "username" => "required|email|max:100",
            "password" => ["required","min:10","max:20"]
        ];

        $validator=Validator::make($data, $rules);
        self::assertNotNull($validator);
        
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message=$validator->getMessageBag();

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorValidData(){
        $data=[
            "username" => "admin@ramafajar.com",
            "password" => "rahasia",
            "admin" => true,
            "others" => "xxxxx"
        ];

        $rules=[
            "username" => "required|email|max:100",
            "password" => "required|min:6|max:120"
        ];

        $validator=Validator::make($data, $rules);
        self::assertNotNull($validator);

        try{
            $valid=$validator->validate();
            Log:info(json_encode($valid, JSON_PRETTY_PRINT));
        }catch(ValidationException $exception){
            self::assertNotNull($exception->validator);
            $message=$exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));

        }
    }

    public function testValidatorInlineMessage(){
        App::setLocale("id");
        
        $data=[
            "username" => "fajar",
            "password" => "rama"
        ];

        $rules=[
            "username" => "required|email|max:100",
            "password" => ["required","min:10","max:20"]
        ];

        $messages=[
            "required" => ":attribute harus diisi",
            "email" => ":attribute harus berupa email",
            "min" => ":attribute minimal :min karakter",
            "max" => ":attribute maximal :max karakter",
        ];

        $validator=Validator::make($data, $rules);
        self::assertNotNull($validator);
        
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message=$validator->getMessageBag();

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testAdditionalValidation(){
        App::setLocale("id");
        
        $data=[
            "username" => "fajar",
            "password" => "fajar"
        ];

        $rules=[
            "username" => "required|email|max:100",
            "password" => ["required","min:10","max:20"]
        ];

        $messages=[
            "required" => ":attribute harus diisi",
            "email" => ":attribute harus berupa email",
            "min" => ":attribute minimal :min karakter",
            "max" => ":attribute maximal :max karakter",
        ];

        $validator=Validator::make($data, $rules);
        $validator->after(function(AdditionalValidator $validator){
            $data=$validator->getData();
            if($data["username"] == $data["password"]){
                $validator->errors()->add("password", "Password tidak boleh sama dengan username.");
            }
        });

        self::assertNotNull($validator);
        
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message=$validator->getMessageBag();

        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }
}
