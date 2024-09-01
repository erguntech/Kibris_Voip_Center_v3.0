<?php

return [
    'session' => 'last_activity_time',
    'timeout' => 180,
    'event' => JulioMotol\AuthTimeout\Events\AuthTimedOut::class,
];
