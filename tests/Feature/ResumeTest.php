<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResumeTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        $data = array_merge([
            'personal' => ['name' => 'Ana Souza', 'title' => 'Dev'],
            'experiences' => [],
            'education' => [],
            'skills' => ['PHP', 'Laravel'],
            'projects' => [],
            'languages' => [],
        ], $overrides);

        return [
            'title' => 'Meu currículo',
            'template' => 'modern',
            'payload' => json_encode($data),
        ];
    }

    public function test_landing_page_loads(): void
    {
        $this->get('/')->assertOk()->assertSee('Devfolio');
    }

    public function test_builder_requires_authentication(): void
    {
        $this->get(route('resumes.create'))->assertRedirect(route('login'));
        $this->post(route('resumes.store'), $this->payload())->assertRedirect(route('login'));
    }

    public function test_builder_page_loads_for_authenticated_user(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('resumes.create'))->assertOk();
    }

    public function test_user_can_create_a_resume(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('resumes.store'), $this->payload());

        $resume = Resume::first();

        $this->assertNotNull($resume);
        $this->assertSame($user->id, $resume->user_id);
        $this->assertSame('Ana Souza', $resume->data['personal']['name']);
        $this->assertSame(8, strlen($resume->slug));
        $response->assertRedirect(route('resumes.show', $resume));
    }

    public function test_name_is_required(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->post(route('resumes.store'), $this->payload(['personal' => ['name' => '']]));

        $response->assertSessionHasErrors('data.personal.name');
        $this->assertDatabaseCount('resumes', 0);
    }

    public function test_template_must_be_valid(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->post(route('resumes.store'), array_merge($this->payload(), ['template' => 'fancy']));

        $response->assertSessionHasErrors('template');
    }

    public function test_index_shows_only_own_resumes(): void
    {
        $user = User::factory()->create();
        $mine = Resume::factory()->for($user)->create(['title' => 'Meu CV']);
        $other = Resume::factory()->create(['title' => 'CV alheio']);

        $this->actingAs($user)->get(route('resumes.index'))
            ->assertOk()
            ->assertSee('Meu CV')
            ->assertDontSee('CV alheio');
    }

    public function test_user_cannot_edit_others_resume(): void
    {
        $resume = Resume::factory()->create(); // de outro dono

        $this->actingAs(User::factory()->create())
            ->get(route('resumes.edit', $resume))
            ->assertForbidden();
    }

    public function test_public_show_and_print_pages_load_without_auth(): void
    {
        $resume = Resume::factory()->create();

        $this->get(route('resumes.show', $resume))->assertOk()->assertSee($resume->data['personal']['name']);
        $this->get(route('resumes.print', $resume))->assertOk();
    }

    public function test_owner_can_update_a_resume(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->for($user)->create();

        $this->actingAs($user)->put(route('resumes.update', $resume), $this->payload([
            'personal' => ['name' => 'Nome Atualizado'],
        ]))->assertRedirect(route('resumes.show', $resume));

        $this->assertSame('Nome Atualizado', $resume->fresh()->data['personal']['name']);
    }

    public function test_owner_can_delete_a_resume(): void
    {
        $user = User::factory()->create();
        $resume = Resume::factory()->for($user)->create();

        $this->actingAs($user)->delete(route('resumes.destroy', $resume))
            ->assertRedirect(route('resumes.index'));
        $this->assertDatabaseCount('resumes', 0);
    }
}
