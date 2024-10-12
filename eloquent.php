<?php
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Db;
use Illuminate\Database\Eloquent\Builder;

$db = new Db;
$db->addConnection([
    'driver' => 'mysql',
    'host' => '192.168.0.178',
    'database' => 'test_ms',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$db->getConnection()->enableQueryLog();
//$capsule->setEventDispatcher(new Dispatcher(new Container));
$db->setAsGlobal();
$db->bootEloquent();

/**
 * Class Test
 * @inheritDoc
 */
class Test extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'test';

    public function detail()
    {
        return $this->hasOne(TestDetail::class, 'pid');
    }

    public function images()
    {
        return $this->hasMany(TestImg::class, 'test_id', 'id');
    }
}

class TestImg extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'test_img';
}

class TestDetail extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'test_detail';

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}

$tests = Test
    ::where('id', '>', 1)
//    ::has('detail', '>=', 1)
//    ->with([
//        'detail' => function ($query){
//            $query->where('pid', '>', 0);
//        }
//    ])
    ->whereHas('detail', function (Builder $query) {
        $query->where('info', 'like', 'update%');
    }, '>=', 1)
    ->get();

//
// SELECT *
// FROM `expo_meeting`
// JOIN `expo_meeting_admin` ON (`expo_meeting`.`id` = `expo_meeting_admin`.`meeting_id`)
// WHERE `phone` = 13558758764 and eid = 1 and enable = 1
// LIMIT 0, 10

foreach ($tests as $info) {
    var_dump($info['id']);
    var_dump($info->detail->toArray());
    foreach ($info->images as $img) {
        var_dump($img->toArray());
    }
}

$test = Test::find(26);
$detail = $test->detail()->where('pid', '>', 0)->get();
foreach ($detail as $info) {
    var_dump($info['pid']);
}

// 打印sql
foreach (Db::getQueryLog() as $sql) {
    var_dump($sql['query']);
}
