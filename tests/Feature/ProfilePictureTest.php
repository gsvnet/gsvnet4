<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilePictureTest extends TestCase
{
    /** @test */
    public function user_can_update_profile_picture()
    {
        // $this->withoutExceptionHandling();

        // Only members and reunists can access the admin
        $user = User::factory()
            ->memberReunistType()
            ->hasProfile(1, function (array $attributes, User $user) {
                return ['year_group_id' => 1];
            })
            ->create();

        $this->actingAs($user);

        Storage::fake('local');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->put("admin/leden/$user->id/foto", [
            'photo_path' => $file,
        ]);

        // $response->dump();

        $response->assertRedirect("admin/users/$user->id");

        $user->refresh();

        // Ensure the profile picture has been stored
        $this->assertNotNull($user->profile->photo_path);

        // Assert the profile picture exists in storage
        Storage::disk('local')->assertExists($user->profile->photo_path);

        // Clean up
        Storage::disk('local')->delete($user->profile->photo_path);
    }

    /** @test */
    public function profile_picture_is_required()
    {
        // Only members and reunists can access the admin
        $user = User::factory()
            ->memberReunistType()
            ->hasProfile(1, function (array $attributes, User $user) {
                return ['year_group_id' => 1];
            })
            ->create();

        $this->actingAs($user);

        $response = $this->put("admin/leden/$user->id/foto", [
            // No profile picture provided
        ]);

        $response->assertSessionHasErrors('photo_path');
    }
}
