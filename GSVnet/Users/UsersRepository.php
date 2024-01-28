<?php namespace GSVnet\Users;

use App\Models\User;
use Carbon\Carbon;
use GSVnet\Core\BaseRepository;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class UsersRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
    
    public function byId($id) : User
    {
        return User::findOrFail($id);
    }

    public function byIdWithProfileAndYearGroup($id)
    {
        return User::with('profile.yearGroup')->findOrFail($id);
    }

    public function parentsWithProfileAndYearGroup(User $user)
    {
        return $user->parents()->with('profile.yearGroup')->get();
    }

    public function childrenWithProfileAndYearGroup(User $user)
    {
        return $user->children()->with('profile.yearGroup')->get();
    }

    /**
     * @param $id
     * @return User
     */
    public function memberOrFormerByIdWithProfile($id)
    {
        return User::whereIn('type',
            [UserTypeEnum::MEMBER, UserTypeEnum::REUNIST, UserTypeEnum::EXMEMBER, UserTypeEnum::POTENTIAL])->with('profile.yearGroup', 'profile.regions')->findOrFail($id);
    }

    /**
     * Get all users
     *
     * @return Collection
     */
    public function all()
    {
        return User::orderBy('lastname', 'ASC')
            ->orderBy('firstname', 'ASC')
            ->get();
    }

    public function byType(UserTypeEnum $type): Collection
    {
        return User::where('type', $type)
            ->orderBy('lastname', 'ASC')
            ->orderBy('firstname', 'ASC')
            ->get();
    }

    /**
     * Get paginated users
     *
     * @param int $amount
     */
    public function paginate($amount)
    {
        return User::orderBy('lastname', 'ASC')->paginate($amount);
    }

    public function paginateWhereType($type, $amount)
    {
        return User::orderBy('lastname', 'ASC')
            ->orderBy('firstname', 'ASC')
            ->where('type', $type)
            ->paginate($amount);
    }

    public function paginateLatestPotentials($amount)
    {
        return User::orderBy('created_at', 'DESC')
            ->where('type', UserTypeEnum::POTENTIAL)
            ->paginate($amount);
    }

    public function paginateFormerMembersWithProfile($amount)
    {
        return User::orderBy('lastname', 'ASC')
            ->orderBy('firstname', 'ASC')
            ->where('type', UserTypeEnum::REUNIST)
            ->with('profile')
            ->paginate($amount);
    }

    public function paginateMembersWithProfile($amount)
    {
        return User::orderBy('lastname', 'ASC')
            ->orderBy('firstname', 'ASC')
            ->where('type', UserTypeEnum::MEMBER)
            ->with('profile')
            ->paginate($amount);
    }

    public function getAllByType($type)
    {
        return User::with('profile.yearGroup')
            ->orderBy('lastname', 'ASC')
            ->orderBy('firstname', 'ASC')
            ->where('type', $type)
            ->get();
    }

    public function getAllVerifiedByType($type)
    {
        return User::with('profile.yearGroup')->where('type', $type)->where('verified', true)->get();
    }

    public function getAllVerifiedAndAliveByType($type)
    {
        return User::with('profile.yearGroup')->whereHas('profile', function ($query) {
            // Filter people that are alive.
            $query->where('alive', true);
        })->where('type', $type)->where('verified', true)->get();
    }

    public function paginateLatelyRegistered($amount)
    {
        return User::orderBy('created_at', 'DESC')->paginate($amount);
    }

    public function paginateLatestRegisteredGuests($amount)
    {
        return User::orderBy('created_at', 'DESC')
            ->where('type', UserTypeEnum::VISITOR)
            ->paginate($amount);
    }

    public function allOfYearGroup($yearGroupId)
    {
        return User::with('profile')
            ->whereIn('type', [UserTypeEnum::REUNIST, UserTypeEnum::MEMBER])
            ->whereHas('profile', function ($query) use ($yearGroupId) {
                $query->where('year_group_id', $yearGroupId);
            })->orderBy('lastname')->orderBy('firstname')->get();
    }

    public function filterExistingIds(array $ids)
    {
        return User::whereIn('id', $ids)->lists('id');
    }

    public function isEmailAddressTaken($email, $excludeId)
    {
        return $this->model->where('email', $email)
            ->where('id', '<>', $excludeId)
            ->count() > 0;
    }

    /**
     * Create user
     *
     * @param array $input
     * @return User
     */
    public function create(array $input)
    {
        return $user = User::create(array(
            'firstname' => $input['register-firstname'],
            'middlename' => $input['register-middlename'],
            'lastname' => $input['register-lastname'],
            'email' => $input['register-email'],
            'username' => $input['register-username'],
            'password' => bcrypt($input['register-password']),
            'type' => $input['type'],
        ));
    }

    /**
     * Delete User
     *
     * @param int $id
     * @return User
     * @TODO: delete all user members references
     */
    public function delete($id)
    {
        $user = $this->byId($id);
        $user->delete();

        return $user;
    }

    /**
     *   Activate user's account
     */
    public function activateUser(User $user)
    {
        $user->approved = true;
        $user->save();

        return $user;
    }

    /**
     *   Accept user's membership
     *   This method sets the user's type to member
     */
    public function acceptMembership(User $user)
    {
        if (!$user->isPotential()) {
            throw new \Exception;
        }

        $user->type = UserTypeEnum::MEMBER;
        $user->save();

        return $user;
    }

    public function mostPostsPreviousMonth($num = 20)
    {
        return Cache::remember('most-posts-prev-month', 24 * 60, function () use ($num) {
            $now = (new Carbon)->subMonth();
            $from = $now->format('Y-m-01 00:00:00');
            $to = $now->format('Y-m-t 23:59:59');
            $users = User::select(\DB::raw('count(forum_replies.author_id) as num, users.id, users.username, users.type, users.firstname, users.middlename, users.lastname'))
                ->join('forum_replies', 'users.id', '=', 'forum_replies.author_id')
                ->groupBy('forum_replies.author_id')
                ->whereBetween('forum_replies.created_at', [$from, $to])
                ->orderBy('num', 'DESC')
                ->take($num)
                ->get();

            return [
                'from' => Carbon::parse($from),
                'to' => Carbon::parse($to),
                'users' => $users
            ];
        });
    }

    public function mostPostsPreviousWeek($num = 20)
    {
        return Cache::remember('most-posts-prev-week', 24 * 60, function () use ($num) {
            $pastWeek = (new Carbon)->subWeek();
            $dayOfWeek = $pastWeek->dayOfWeek;

            $from = $pastWeek->subDays($dayOfWeek)->format('Y-m-d 00:00:00');
            $to = $pastWeek->addDays(6)->format('Y-m-d 23:59:59');
            $users = User::select(\DB::raw('count(forum_replies.author_id) as num, users.id, users.type, users.username, users.firstname, users.middlename, users.lastname'))
                ->join('forum_replies', 'users.id', '=', 'forum_replies.author_id')
                ->groupBy('forum_replies.author_id')
                ->whereBetween('forum_replies.created_at', [$from, $to])
                ->orderBy('num', 'DESC')
                ->take($num)
                ->get();

            return [
                'from' => Carbon::parse($from),
                'to' => Carbon::parse($to),
                'users' => $users
            ];
        });
    }

    public function mostPostsAllTime($num = 250)
    {
        return Cache::remember('most-posts-all-time', 24 * 60, function () use ($num) {
            return User::select(\DB::raw('count(forum_replies.author_id) as num, users.id, users.type, users.username, users.firstname, users.middlename, users.lastname'))
                ->join('forum_replies', 'users.id', '=', 'forum_replies.author_id')
                ->groupBy('forum_replies.author_id')
                ->orderBy('num', 'DESC', 'users.lastname')
                ->take($num)
                ->get();
        });
    }

    public function postsAllTimeUser($userid)
    {
        return User::select(\DB::raw('count(forum_replies.author_id) as num, users.id, users.type, users.username, users.firstname, users.middlename, users.lastname'))
            ->join('forum_replies', 'users.id', '=', 'forum_replies.author_id')
            ->groupBy('forum_replies.author_id')
            ->where('users.id', $userid)
            ->first();
    }

    public function topicsAllTimeUser($userid)
    {
        return User::select(\DB::raw('count(DISTINCT forum_replies.thread_id) as num, users.id, users.type, users.username, users.firstname, users.middlename, users.lastname'))
            ->join('forum_replies', 'users.id', '=', 'forum_replies.author_id')
            ->groupBy('forum_replies.author_id')
            ->where('users.id', $userid)
            ->first();
    }
    

    public function postsAllTimeUserRank($activeUser)
    {
        $users = User::select(\DB::raw('count(forum_replies.author_id) as num, users.id, users.type, users.username, users.firstname, users.middlename, users.lastname'))
            ->join('forum_replies', 'users.id', '=', 'forum_replies.author_id')
            ->groupBy('forum_replies.author_id')
            ->orderBy('num', 'DESC', 'users.lastname')
            ->get();
        
        $rank = 1;
        foreach ($users as $user) {
            if ($user->id == $activeUser->id) {
                break;
            }
            $rank++;
        }
        return $rank;
    }

    public function getSICRecipients()
    {
        return User::with('profile')->whereHas('profile', function ($query) {
            // Filter on people who want to receive SIC
            $query->where('receive_newspaper', true);
        })->where('users.type', UserTypeEnum::MEMBER)->get();
    }
}