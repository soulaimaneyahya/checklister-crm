<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\MenuService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserPermissionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public $user;
    public $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->john();
        $this->admin = $this->admin();
    }

    public function test_can_register_and_see_welcome_page()
    {
        $response = $this->actingAs($this->user)->get('welcome');
        $response->assertStatus(200);
    }

    public function test_cannot_access_admin_menu_items()
    {
        $this->actingAs($this->user);

        $menu = (new MenuService())->get_menu();
        $this->assertCount(0, $menu['admin_menu']);

        $response = $this->get('admin/check_list_groups/create');
        $response->assertStatus(403);

        $response = $this->post('admin/check_list_groups', [
            'name' => 'Checklist group',
            'description' => 'lorem ipsum dolor sit ament'
        ]);
        $response->assertStatus(403);

        $response = $this->get('admin/pages/1/edit');
        $response->assertStatus(403);

        $response = $this->get('admin/users');
        $response->assertStatus(403);
    }
}
