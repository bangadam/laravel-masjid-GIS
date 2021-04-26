<?php

namespace Tests\Unit\Policies;

use App\Models\Ruvid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class RuvidPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_ruvid()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Ruvid));
    }

    /** @test */
    public function user_can_view_ruvid()
    {
        $user = $this->createUser();
        $ruvid = Ruvid::factory()->create();
        $this->assertTrue($user->can('view', $ruvid));
    }

    /** @test */
    public function user_can_update_ruvid()
    {
        $user = $this->createUser();
        $ruvid = Ruvid::factory()->create();
        $this->assertTrue($user->can('update', $ruvid));
    }

    /** @test */
    public function user_can_delete_ruvid()
    {
        $user = $this->createUser();
        $ruvid = Ruvid::factory()->create();
        $this->assertTrue($user->can('delete', $ruvid));
    }
}
