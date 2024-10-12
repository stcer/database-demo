<?php

require 'vendor/autoload.php';

use think\facade\Db;

// 数据库配置信息设置（全局有效）
Db::setConfig([
    // 默认数据连接标识
    'default'     => 'mysql',
    // 数据库连接信息
    'connections' => [
        'mysql' => [
            // 数据库类型
            'type'     => 'mysql',
            // 主机地址
            'hostname' => '192.168.0.178',
            // 用户名
            'username' => 'root',
            'password' => 'root',
            // 数据库名
            'database' => 'test_ms',
            // 数据库编码默认采用utf8
            'charset'  => 'utf8',
            // 数据库表前缀
            'prefix'   => '',
            // 数据库调试模式
            'debug'    => true,
        ],
    ],
]);


Db::setLog(function ($type, $log) {
    var_dump($log);
});

use think\Model;
class ThinkTest extends Model
{
    protected $table = 'test';

    public function detail()
    {
        return $this->hasOne(ThinkTestDetail::class, 'pid');
    }
}

class ThinkTestDetail extends Model
{
    protected $table = 'test_detail';

    public function test()
    {
        return $this->belongsTo(ThinkTest::class);
    }
}

$data = ThinkTest
    ::with('detail')
    ->where('id', '>', 1)
//    ::hasWhere('detail',  function($query) {
////        $query->where('info', 'like', 'think%');
//    })
    ->limit(3)
    ->select();
foreach ($data as $item)
{
    var_dump($item->toArray());
    var_dump($item->detail->toArray());
}

var_dump(
    $logs = Db::getDbLog()
);

