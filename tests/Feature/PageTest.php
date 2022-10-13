<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit()
    {
        $admin = $this->admin();
        $this->actingAs($admin);
        $page = $this->createDummyPage();

        $response = $this->get("/admin/pages/{$page->id}/edit");
        $response->assertSeeText("Edit Page ({$page->title})");
        $response->assertSeeText('Page Title');
        $response->assertSeeText('Content');
        $response->assertSeeText($page->title);
        $response->assertSeeText($page->content);
    }

    public function test_update_valid()
    {
        $admin = $this->admin();
        $this->actingAs($admin);
        $page = $this->createDummyPage();
        // assert
        $this->assertDatabaseHas('pages', [
            'title' => 'Lorem ipsum.',
            'content' => 'Lorem ipsum dolor sit amet.'
        ]);
        $params = [
            'title' => 'Update Lorem ipsum.',
            'content' => 'Update Lorem ipsum dolor sit amet.'
        ];
        $this->put("/admin/pages/{$page->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('alert-warning')
            ->assertRedirect("/admin/pages/{$page->id}/edit");

        $this->assertEquals(session('alert-warning'), 'Page Updated');
        $this->assertDatabaseMissing('pages', [
            'title' => 'Lorem ipsum.',
            'content' => 'Lorem ipsum dolor sit amet.'
        ]);
        $this->assertDatabaseHas('pages', [
            'title' => 'Update Lorem ipsum.',
            'content' => 'Update Lorem ipsum dolor sit amet.'
        ]);
    }
}
