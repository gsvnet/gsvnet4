<?php namespace GSVnet\Users;

use App\Models\User;
use GSVnet\Core\Enums\GenderEnum;

class UserTransformer {

    static $genderMap = [
        GenderEnum::FEMALE => 'Amica',
        GenderEnum::MALE => 'Amice',
        GenderEnum::NONBINARY => 'Amicum'
    ];

    /**
     * @param User $user
     * @return array
     */
    public function newsletterSubscribeInformation(User $user)
    {
        if ($user->profile && ! is_null($user->profile->gender)) {
            $titel = self::$genderMap[$user->profile->gender];
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