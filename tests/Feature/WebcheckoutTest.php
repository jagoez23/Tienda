<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Request\GetInformationRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebcheckoutTest extends TestCase
{
   public function testItCanGetInformationRequest()
   {
       $request = (new GetInformationRequest())->auth();
       /*dd($request);*/
       $this->assertArrayHasKey( key:'auth', $request);
       $this->assertArrayHasKey( key:'login',$request['auth']);
       $this->assertArrayHasKey( key:'tranKey',$request['auth']);
       $this->assertArrayHasKey( key:'nonce',$request['auth']);
       $this->assertArrayHasKey( key:'seed',$request['auth']);


   }
}
