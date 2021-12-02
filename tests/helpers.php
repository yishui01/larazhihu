<?php

function create($class, $attributes = [], $times = null)
{
    return $class::factory()->count($times)->create($attributes);
}

// 只创建模型不写到数据库
function make($class, $attributes = [], $times = null)
{
    return $class::factory()->count($times)->make($attributes);
}
