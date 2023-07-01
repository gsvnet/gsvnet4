<?php 

use GSVnet\Users\UserType as UserType;

/**
 * Permission configuration
 * Permissions are configured such that if a user has one of the
 * then the user has the permission
 */
return [
    /**
     * General permissions don't require checks with respect to the specific entity
     * For instance: permission to manage committees or photos
     */
    'general' => [
        'ads.hide' => [
            'type' => [UserType::MEMBER, UserType::REUNIST]
        ],

        'member-or-reunist' => [
            'type' => [UserType::MEMBER, UserType::REUNIST]
        ],

        'user.become-member' => [
            'type' => [UserType::VISITOR]
        ],

        'users.show' => [
            'type' => [UserType::MEMBER, UserType::REUNIST],
        ],

        'users.manage' => [
            'committee' => ['webcie', 'malversacie'],
            'senate' => true
        ],

        'committees.manage' => [
            'committee' => ['webcie'],
            'senate' => true
        ],

        'committees.show-novcie' => [
            'type' => [UserType::MEMBER, UserType::REUNIST]
        ],

        'photos.show-private' => [
            'type' => [UserType::MEMBER]
        ],

        'photos.manage' => [
            'committee' => ['webcie', 'reebocie', 'prescie'],
            'senate' => true
        ],

        'docs.show' => [
            'type' => [UserType::MEMBER]
        ],

        'docs.manage' => [
            'type' => [UserType::MEMBER]
        ],

        'docs.publish' => [
            'committee' => ['webcie'],
            'senate' => true
        ],

        'dropbox.show' => [
            'type' => [UserType::MEMBER]
        ],

        'events.show-private' => [
            'type' => [UserType::MEMBER, UserType::REUNIST],
        ],

        'events.manage' => [
            'type' => [UserType::MEMBER],
        ],

        'events.publish' => [
            'committee' => ['webcie', 'prescie'],
            'senate' => true
        ],

        'senates.show' => [
            'type' => [UserType::MEMBER, UserType::REUNIST]
        ],

        'senates.manage' => [
            'committee' => ['webcie'],
            'senate' => true
        ],

        'admin.show' => [
            'type' => [UserType::MEMBER, UserType::REUNIST]
        ],

        'admin' => [
            'committee' => ['webcie']
        ],

        'users.edit-profile' => [
            'type' => ['potential', UserType::MEMBER, UserType::REUNIST, UserType::EXMEMBER, UserType::INTERNAL_COMMITTEE]
        ],

        'threads.show-private' => [
            'type' => [UserType::MEMBER, UserType::INTERNAL_COMMITTEE]
        ],

        'threads.show-internal' => [
            'type' => [UserType::MEMBER, UserType::REUNIST, UserType::INTERNAL_COMMITTEE]
        ],

        'extension.manage' => [
            'committee' => ['webcie']
        ]
    ],

    /**
     * Entity specific permissions are derived from the entity: for instance, a user
     * can change his own profile, but not someone else's. Or one cannot like his or her
     * own forum topic or reply. The exact restrictions are set in \GSV\Providers\AuthServiceProvider
     */
    'entity-specific' => [
        'thread.manage' => [
            'committee' => ['webcie'],
            'senate' => true
        ],

        'thread.like' => [],

        'reply.manage' => [
            'committee' => ['webcie'],
            'senate' => true
        ],

        'reply.like' => [],

        'user.manage.address' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.birthday' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.business' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.email' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.gender' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.name' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.parents' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.password' => [
            'committee' => ['webcie', 'novcie', 'malversacie'],
            'senate' => true
        ],
        'user.manage.phone' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.photo' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.year' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'formerMember.manage.year' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.study' => [
            'committee' => ['webcie', 'novcie', 'malversacie', 'jaarbundelcommissie'],
            'senate' => true
        ],
        'user.manage.receive_newspaper' => [
            'committee' => ['webcie', 'malversacie'],
            'senate' => true
        ]
    ],
];