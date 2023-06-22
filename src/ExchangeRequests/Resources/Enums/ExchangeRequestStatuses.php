<?php

namespace Src\ExchangeRequests\Resources\Enums;

enum ExchangeRequestStatuses: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CLOSED = 'closed';
}
