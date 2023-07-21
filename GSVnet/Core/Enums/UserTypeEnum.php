<?php

namespace GSVnet\Core\Enums;

enum UserTypeEnum: int {
    case VISITOR = 0;
    case POTENTIAL = 1;
    case MEMBER = 2;
    case REUNIST = 3;
    case INTERNAL_COMMITTEE = 4;
    case EXMEMBER = 5;
}
