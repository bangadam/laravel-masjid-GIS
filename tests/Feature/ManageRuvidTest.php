<?php

namespace Tests\Feature;

use App\Models\Ruvid;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageRuvidTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_ruvid_list_in_ruvid_index_page()
    {
        $ruvid = Ruvid::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('ruvids.index');
        $this->see($ruvid->title);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Ruvid 1 title',
            'description' => 'Ruvid 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_ruvid()
    {
        $this->loginAsUser();
        $this->visitRoute('ruvids.index');

        $this->click(__('ruvid.create'));
        $this->seeRouteIs('ruvids.create');

        $this->submitForm(__('ruvid.create'), $this->getCreateFields());

        $this->seeRouteIs('ruvids.show', Ruvid::first());

        $this->seeInDatabase('ruvids', $this->getCreateFields());
    }

    /** @test */
    public function validate_ruvid_title_is_required()
    {
        $this->loginAsUser();

        // title empty
        $this->post(route('ruvids.store'), $this->getCreateFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_ruvid_title_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // title 70 characters
        $this->post(route('ruvids.store'), $this->getCreateFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_ruvid_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('ruvids.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Ruvid 1 title',
            'description' => 'Ruvid 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_ruvid()
    {
        $this->loginAsUser();
        $ruvid = Ruvid::factory()->create(['title' => 'Testing 123']);

        $this->visitRoute('ruvids.show', $ruvid);
        $this->click('edit-ruvid-'.$ruvid->id);
        $this->seeRouteIs('ruvids.edit', $ruvid);

        $this->submitForm(__('ruvid.update'), $this->getEditFields());

        $this->seeRouteIs('ruvids.show', $ruvid);

        $this->seeInDatabase('ruvids', $this->getEditFields([
            'id' => $ruvid->id,
        ]));
    }

    /** @test */
    public function validate_ruvid_title_update_is_required()
    {
        $this->loginAsUser();
        $ruvid = Ruvid::factory()->create(['title' => 'Testing 123']);

        // title empty
        $this->patch(route('ruvids.update', $ruvid), $this->getEditFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_ruvid_title_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $ruvid = Ruvid::factory()->create(['title' => 'Testing 123']);

        // title 70 characters
        $this->patch(route('ruvids.update', $ruvid), $this->getEditFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_ruvid_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $ruvid = Ruvid::factory()->create(['title' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('ruvids.update', $ruvid), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_ruvid()
    {
        $this->loginAsUser();
        $ruvid = Ruvid::factory()->create();
        Ruvid::factory()->create();

        $this->visitRoute('ruvids.edit', $ruvid);
        $this->click('del-ruvid-'.$ruvid->id);
        $this->seeRouteIs('ruvids.edit', [$ruvid, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('ruvids', [
            'id' => $ruvid->id,
        ]);
    }
}
