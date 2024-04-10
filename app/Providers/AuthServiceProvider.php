<?php namespace App\Providers;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use GSVnet\Permissions\PermissionCache;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // User::class => UserPolicy::class // Disabled for now
    ];

    protected array $permissions;

    /**
     * @var PermissionCache $cache
     */
    protected $cache; 

    /**
     * Register any authentication / authorization services.
     *
     * @param PermissionCache $cache
     * 
     * @return void
     */
    public function boot(PermissionCache $cache)
    {
        $this->registerPolicies();

        $this->cache = $cache;
        $this->permissions = config('permissions.general') + config('permissions.entity-specific');

        foreach (config('permissions.general') as $permission => $criteria) {
            Gate::define($permission, function (User $user) use ($permission) {
                return $this->has($user, $permission);
            });
        }

        // Register entity-specific permissions here
        Gate::define('thread.manage', function (User $user, Thread $thread = null) {
            return ($thread && $user->id == $thread->author_id) || $this->has($user, 'thread.manage');
        });

        Gate::define('thread.like', function (User $user, Thread $thread) {
            return $user->id != $thread->author_id || $this->has($user, 'thread.like');
        });

        Gate::define('reply.manage', function (User $user, Reply $reply) {
            return $user->id == $reply->author_id || $this->has($user, 'reply.manage');
        });

        Gate::define('reply.like', function (User $user, Reply $reply) {
            return $user->id != $reply->author_id || $this->has($user, 'reply.like');
        });

        // User details
        Gate::define('user.manage.address', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.address');
        });

        Gate::define('user.manage.birthday', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.birthday');
        });

        Gate::define('user.manage.business', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.business');
        });

        Gate::define('user.manage.email', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.email');
        });

        Gate::define('user.manage.gender', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.gender');
        });

        Gate::define('user.manage.name', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.name');
        });

        Gate::define('user.manage.parents', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.parents');
        });

        Gate::define('user.manage.password', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.password');
        });

        Gate::define('user.manage.phone', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.phone');
        });

        Gate::define('user.manage.photo', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.photo');
        });

        Gate::define('user.manage.study', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.study');
        });

        Gate::define('formerMember.manage.year', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'formerMember.manage.year');
        });

        Gate::define('user.manage.receive_newspaper', function (User $user, User $member) {
            return $user->id == $member->id || $this->has($user, 'user.manage.receive_newspaper');
        });
    }

    public function has(User $user, $permission)
    {
        // Return result away if the permission has already been looked up
        if ($this->cache->has($user, $permission))
            return $this->cache->get($user, $permission);

        // Cache the result for further use
        return $this->cache->set($user, $permission, $this->hasPermission($user, $permission));
    }

    private function hasPermission(User $user, $permission)
    {
        // Get the permission's criteria
        $criteria = $this->permissions[$permission];

        // If no criteria are given, grant access right away
        if (count($criteria) == 0)
            return true;

        // Check if type criteria is matched
        if (array_key_exists('type', $criteria) and $this->checkTypeCriteria($user, $criteria['type']))
            return true;

        // Check if committee criteria is matched
        if (array_key_exists('committee', $criteria) and $this->checkCommitteeCriteria($user, $criteria['committee']))
            return true;

        // Check senate criteria
        if (array_key_exists('senate', $criteria) and $this->checkSenateCriteria($user))
            return true;

        // If none of the criteria is matched, return false
        return false;
    }

    private function checkTypeCriteria(User $user, array $criteria)
    {
        // Return true if user has one of the criteria
        return in_array($user->type, $criteria);
    }

    private function checkCommitteeCriteria(User $user, array $committees)
    {
        // Find in how many of the given committees the user is in
        return $user->activeCommittees()->whereIn('unique_name', $committees)->count() > 0;
    }

    public function checkSenateCriteria(User $user)
    {
        // Check if the user is active in a senate
        return $user->activeSenate->count() > 0;
    }
}
