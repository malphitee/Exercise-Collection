<?php

require __DIR__.'/vendor/autoload.php';

$events = json_decode(file_get_contents(__DIR__.'/data.json'),true);

//常规解法
$eventTypes = [];
$score = 0;

foreach ($events as $event ){
    $eventTypes[] = $event['type'];
}

foreach ($eventTypes as $eventType){
    switch ($eventType){
        case 'PushEvent':
            $score+=5;
            break;
        case 'CreateEvent':
            $score+=4;
            break;
        case 'IssueEvent':
            $score+=3;
            break;
        case 'IssueCommentEvent':
            $score+=2;
            break;
        default:
            $score+=1;
            break;
    }
}

//进阶解法

// pluck 获取所有集合中给定键的值  map 遍历整个集合并将每一个数值传入给定的回调函数

$score = collect($events)->pluck('type')
                ->map(function ($eventType){
                    switch ($eventType){
                        case 'PushEvent':
                            return 5;
                        case 'CreateEvent':
                            return 4;
                        case 'IssueEvent':
                            return 3;
                        case 'IssueCommentEvent':
                            return 2;
                        default:
                            return 1;
                    }
                })->sum();


//改为数组方式配置
$score = collect($events)->pluck('type')
                ->map(function ($eventType){
                    return collect([
                    'PushEvent' => 5,
                    'CreateEvent' => 4,
                    'IssueEvent' => 3,
                    'IssueCommentEvent' => 2
                    ])->get($eventType,1);
                    }
                )->sum();




echo $score;
