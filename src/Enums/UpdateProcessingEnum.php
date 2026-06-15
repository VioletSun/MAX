<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

/**
 * Data processing statuses
 */
enum UpdateProcessingEnum: int
{
    case Backlog = -1;
    case InProgress = 0;
    case Completed = 1;
    case Failed = 2;
    case FurtherRevision = 3;

}
