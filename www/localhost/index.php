<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>程序版本信息</title>
    <style>@charset "UTF-8";body{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Oxygen,Ubuntu,Cantarell,Fira Sans,Droid Sans,Helvetica Neue,sans-serif;line-height:1.4;max-width:800px;margin:20px auto;padding:0 10px;color:#363636;background:#fff;text-rendering:optimizeLegibility}button,input,textarea{transition:background-color .1s linear,border-color .1s linear,color .1s linear,box-shadow .1s linear,transform .1s ease}h1{font-size:2.2em;margin-top:0}h1,h2,h3,h4,h5,h6{margin-bottom:12px}h1,h2,h3,h4,h5,h6,strong{color:#000}b,h1,h2,h3,h4,h5,h6,strong,th{font-weight:600}blockquote{border-left:4px solid rgba(0,150,191,.67);margin:1.5em 0;padding:.5em 1em;font-style:italic}blockquote>footer{margin-top:10px;font-style:normal}address,blockquote cite{font-style:normal}a[href^=mailto]:before{content:"📧 "}a[href^=tel]:before{content:"📞 "}a[href^=sms]:before{content:"💬 "}button,input[type=button],input[type=checkbox],input[type=submit]{cursor:pointer}input:not([type=checkbox]):not([type=radio]),select{display:block}button,input,select,textarea{color:#000;background-color:#efefef;font-family:inherit;font-size:inherit;margin-right:6px;margin-bottom:6px;padding:10px;border:0;border-radius:6px;outline:0}button,input:not([type=checkbox]):not([type=radio]),select,textarea{-webkit-appearance:none}textarea{margin-right:0;width:100%;box-sizing:border-box;resize:vertical}button,input[type=button],input[type=submit]{padding-right:30px;padding-left:30px}button:hover,input[type=button]:hover,input[type=submit]:hover{background:#ddd}button:focus,input:focus,select:focus,textarea:focus{box-shadow:0 0 0 2px rgba(0,150,191,.67)}button:active,input[type=button]:active,input[type=checkbox]:active,input[type=radio]:active,input[type=submit]:active{transform:translateY(2px)}button:disabled,input:disabled,select:disabled,textarea:disabled{cursor:not-allowed;opacity:.5}::-webkit-input-placeholder{color:#949494}:-ms-input-placeholder{color:#949494}::-ms-input-placeholder{color:#949494}::placeholder{color:#949494}a{text-decoration:none;color:#0076d1}a:hover{text-decoration:underline}code,kbd{background:#efefef;color:#000;padding:5px;border-radius:6px}pre>code{padding:10px;display:block;overflow-x:auto}img{max-width:100%}hr{border:0;border-top:1px solid #dbdbdb}table{border-collapse:collapse;margin-bottom:10px;width:100%}td,th{padding:6px;text-align:left}th{border-bottom:1px solid #dbdbdb}tbody tr:nth-child(2n){background-color:#efefef}::-webkit-scrollbar{height:10px;width:10px}::-webkit-scrollbar-track{background:#efefef;border-radius:6px}::-webkit-scrollbar-thumb{background:#d5d5d5;border-radius:6px}::-webkit-scrollbar-thumb:hover{background:#c4c4c4}</style>
</head>
<body>
<?php
echo '<h3><a href="/tools/adminer.php">数据库管理</a></h3>';
echo '<h2>程序版本信息</h2>';
echo '<ul>';
echo '<li>Nodejs版本：10.16.0</li>';
echo '<li>Nginx版本：', $_SERVER['SERVER_SOFTWARE'], '</li>';
echo '<li>MySQL服务器版本：', getMysqlVersion(), '</li>';
echo '<li>Redis服务器版本：', getRedisVersion(), '</li>';
echo '<li>PHP版本：', PHP_VERSION, '</li>';
echo '</ul>';

echo '<h2>已安装的php扩展</h2>';
printExtensions();

/**
 * 获取MySQL版本
 */
function getMysqlVersion()
{
    if (extension_loaded('PDO_MYSQL')) {
        try {
            $dbh = new PDO('mysql:host=mysql;dbname=mysql', 'root', $_SERVER['MYSQL_ROOT_PASSWORD']??'');
            $sth = $dbh->query('SELECT VERSION() as version');
            $info = $sth->fetch();
        } catch (PDOException $e) {
            if(strpos($e->getMessage(), 'getaddrinfo failed: Name ')){
                return "Mysql 没有启动";
            }
            return $e->getMessage();
        }
        return $info['version'];
    } else {
        return 'PDO_MYSQL 扩展未安装 ×';
    }

}

/**
 * 获取Redis版本
 */
function getRedisVersion()
{
    if (extension_loaded('redis')) {
        try {
            $redis = new Redis();
            $redis->connect('redis', 6379);
            $redis->auth($_SERVER['REDIS_PASSWORD'] ?? '');
            /** @var array $info */
            $info = $redis->info();
            return $info['redis_version'];
        } catch (Exception $e) {
            if(strpos($e->getMessage(), 'Name does not resolve')){
                return "Redis 没有启动";
            }
            return $e->getMessage();
        }
    } else {
        return 'Redis 扩展未安装 ×';
    }
}

/**
 * 获取已安装扩展列表
 */
function printExtensions()
{
    echo '<ol>';
    foreach (get_loaded_extensions() as $i => $name) {
        echo "<li>", $name, '=', phpversion($name), '</li>';
    }
    echo '</ol>';
}
?>

</body>
</html>
