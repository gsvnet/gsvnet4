<?php

namespace GSVnet\Senates;

enum SenateFunction: int {
    case PRAESES = 1;
    case ABACTIS = 2;
    case FISCUS = 3;
    case ASSESSOR_PRIMUS = 4;
    case ASSESSOR_SECUNDUS = 5;
}
