<?php

namespace Tests\Unit\Models;

use App\User;
use App\Models\Ruvid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class RuvidTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_ruvid_has_title_link_attribute()
    {
        $ruvid = Ruvid::factory()->create();

        $title = __('app.show_detail_title', [
            'title' => $ruvid->title, 'type' => __('ruvid.ruvid'),
        ]);
        $link = '<a href="'.route('ruvids.show', $ruvid).'"';
        $link .= ' title="'.$title.'">';
        $link .= $ruvid->title;
        $link .= '</a>';

        $this->assertEquals($link, $ruvid->title_link);
    }

    /** @test */
    public function a_ruvid_has_belongs_to_creator_relation()
    {
        $ruvid = Ruvid::factory()->make();

        $this->assertInstanceOf(User::class, $ruvid->creator);
        $this->assertEquals($ruvid->creator_id, $ruvid->creator->id);
    }
}
