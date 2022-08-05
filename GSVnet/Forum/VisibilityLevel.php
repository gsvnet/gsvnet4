<?php

namespace GSVnet\Forum;

enum VisibilityLevel: int {
    case PRIVATE = 0; // Only current members
    case INTERNAL = 1; // Current members and reunists
    case PUBLIC = 2; // Everyone
}
