<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * @test
     * @group auth
     */
    public function 회원_가입을_한다()
    {
        $userData = $this->getUserData();

        $response = $this->json('POST', route('auth.join'), $userData);

        $response->assertCreated();

        // 등록된 데이터가 모두 일치하는지 확인
        collect($userData)->each(function ($data, $key) use ($response) {
            if ($key !== 'password') {
                $response->assertJsonPath($key, $data);
            }
        });
    }

    /**
     * @test
     * @group auth
     */
    public function 회원가입_이름이_없거나_형식이_틀린경우_검증()
    {
        $this->validateCheck('name');
        $this->validateCheck('name', '이름에특문은안됩니다!!!');
        $this->validateCheck('name', '이름에숫자는안됩니다123');
    }

    /**
     * @test
     * @group auth
     */
    public function 회원가입_별명이_없거나_형식이_틀린경우_검증()
    {
        $this->validateCheck('nickname');
        $this->validateCheck('nickname', 'testAA');
        $this->validateCheck('nickname', 'test11');
        $this->validateCheck('nickname', '한글');
    }

    /**
     * @test
     * @group auth
     */
    public function 회원가입_전화번호가_없거나_형식이_틀린경우_검증()
    {
        $this->validateCheck('phone');
        $this->validateCheck('phone', '010-1234-1234');
        $this->validateCheck('phone', '숫자로만작성되어야합니다');
        $this->validateCheck('phone', 'onlyInteger');
    }

    /**
     * @test
     * @group auth
     */
    public function 회원가입_이메일_없는_경우와_형식이_틀린경우_검증()
    {
        $this->validateCheck('email');
        $this->validateCheck('email', 'test');
    }

    /**
     * @test
     * @group auth
     */
    public function 회원가입_비밀번호_특문_숫자_경우_검증()
    {
        $this->validateCheck('password', 'passwordpassword12');
        $this->validateCheck('password', 'passwordpassword!!');
    }

    /**
     * 회원 form return
     * @return array
     */
    private function getUserData(): array
    {
        $userData = User::factory()->make()
            ->setHidden([])->toArray();

        $userData['password'] = '!password1';

        return $userData;
    }

    /**
     * 필수 항목 검증용
     * @param $columnName
     * @param  null  $value
     */
    private function validateCheck($columnName, $value = null)
    {
        $userData = $this->getUserData();
        $userData[$columnName] = $value;

        $response = $this->json('POST', route('auth.join'), $userData);

        $response->assertJsonValidationErrors($columnName);
    }
}
