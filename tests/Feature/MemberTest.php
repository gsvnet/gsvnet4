<?php

namespace Tests\Feature;

use App\Models\User;
use GSVnet\Newsletters\NewsletterList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery\MockInterface;

class MemberTest extends TestCase
{
    /**
     * Test whether we can change a user's name.
     */
    public function test_name_can_be_changed(): void
    {
        // Changing a member's name will invoke the subscribeTo method on
        // the NewsletterList interface, but we don't want this method to
        // activate during testing (because it will try to communicate with 
        // the Mailchimp server). That's why we mock it.
        $this->mock(NewsletterList::class, function (MockInterface $mock) {
            $mock->shouldReceive("subscribeTo")->zeroOrMoreTimes();
        });
        
        $manager = User::factory()->create();

        // Might be a member, might be a potential
        $user = User::factory()
            ->profileType()
            ->hasProfile(1, function (array $attributes, User $user) {
                return ['year_group_id' => 1];
            })
            ->create();

        $initials = "J.J.";
        $firstname = "Jan";
        $middlename = "van";
        $lastname = "Jansen";

        $response = $this->actingAs($manager)
                         ->put('admin/leden/'.$user->id.'/naam', [
                            "initials" => "J.J.",
                            "firstname" => "Jan",
                            "middlename" => "van",
                            "lastname" => "Jansen",
                         ]);

        // These requests always redirect to UsersController@show
        $response->assertStatus(302);

        // Retrieve user from database and check that the update worked
        $user = User::find($user->id);
        $this->assertEquals($initials, $user->profile->initials);
        $this->assertEquals($firstname, $user->firstname);
        $this->assertEquals($middlename, $user->middlename);
        $this->assertEquals($lastname, $user->lastname);
    }
}
