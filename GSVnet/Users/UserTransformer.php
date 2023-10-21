<?php namespace GSVnet\Users;

use App\Models\User;
use GSVnet\Core\Enums\GenderEnum;

class UserTransformer {

    /**
     * Mapping fron GenderEnum case _values_ to title (e.g., 'Amica').
     * @var array<int, string>
     */
    public $genderMap;

    public function __construct() {
        // Enum cases can (currently) not function as array keys
        $this->genderMap = [
            GenderEnum::FEMALE->value => 'Amica',
            GenderEnum::MALE->value => 'Amice',
            GenderEnum::NONBINARY->value => 'Amicum'
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    public function newsletterSubscribeInformation(User $user)
    {
        if ($user->profile && ! is_null($user->profile->gender)) {
            $titel = $this->genderMap[$user->profile->gender->value];
        } else {
            $titel = 'Amice of amica';
        }

        list($year, $group) = ($user->profile && $user->profile->yearGroup)
            ? [$user->profile->yearGroup->year, $user->profile->yearGroup->name]
            : [0, ''];

        return [
            'FNAME' => $user->firstname,
            'LNAME' => $user->present()->fullLastname,
            'TITEL' => $titel,
            'TITEL_LOW' => strtolower($titel),
            'JAAR' => $year,
            'VERBAND' => $group,
        ];
    }
}