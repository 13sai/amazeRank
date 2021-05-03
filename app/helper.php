<?php

use App\Services\PromotionCodeGen;

function message_to_dingding($message)
{
    try {
        $data = array('msgtype' => 'text', 'text' => array('content' => $message));
        $post_string = json_encode($data);

        $remote_server = 'https://oapi.dingtalk.com/robot/send?access_token=dfa1bafb4fc13ef6312c126c71a7694da479d1923b52c0b1c290d9cea1954528';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
        // curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    } catch (\Exception $e) {

    }
}


/**
 * @param $startDate
 * @param $endDate
 * @return array
 */
function getDateRange($startDate, $endDate)
{
    $days = ($endDate - $startDate) / 86400 + 1;
    $date = [];
    for ($i = 0; $i < $days; $i++) {
        $date[] = date('Y-m-d', $startDate + (86400 * $i));
    }
    return $date;
}

/**
 * 获取每周第一天
 * @param $t
 * @return false|string
 */
function getWeekStart($t)
{
    $w = date('w', $t) - 1;
    if ($w < 0) {
        $t = $t - 6*86400;
    } else {
        $t = $t  - $w*86400;
    }

    return date('Ymd', $t);
}

/**
 * 判断是不是周末
 * @param $date
 * @return bool
 */
function isWeekend($date)
{
    $timeStamp = strtotime($date);
    if ((date('w', $timeStamp) == 6) || (date('w', $timeStamp) == 5)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 判断一组日期星期是否在某些时段内，都不在返回false，否则true
 * @param $dateArr
 * @param array $week
 * @return bool
 */
function checkRangeDateIsWeek($dateArr, $week = [5, 6])
{
    foreach ($dateArr as $date) {
        $timeStamp = strtotime($date);
        if (in_array(date('w', $timeStamp), $week)) {
            return true;
        }
    }

    return false;
}

/**
 * $str 原始中文字符串
 * $encoding 原始字符串的编码，默认GBK
 * $prefix 编码后的前缀，默认"&#"
 * $postfix 编码后的后缀，默认";"
 */
function unicodeEncode($str, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
    $str = mb_convert_encoding($str,$encoding,"UTF-8");
    $arrstr = str_split($str, 2);
    $unistr = '';
    for($i = 0, $len = count($arrstr); $i < $len; $i++) {
        $dec = hexdec(bin2hex($arrstr[$i]));
        $unistr .= $prefix . $dec . $postfix;
    }
    return $unistr;
}

/**
 * $str Unicode编码后的字符串
 * $decoding 原始字符串的编码，默认GBK
 * $prefix 编码字符串的前缀，默认"&#"
 * $postfix 编码字符串的后缀，默认";"
 */
function unicodeDecode($unistr, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
    $arruni = explode($prefix, $unistr);
    $unistr = '';
    for($i = 1, $len = count($arruni); $i < $len; $i++) {
        if (strlen($postfix) > 0) {
            $arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
        }
        $temp = intval($arruni[$i]);
        $unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
    }
    return mb_convert_encoding($unistr,"UTF-8", $encoding);
//    return iconv('UCS-2', $encoding, $unistr);
}

/**
 * 获取时间文本
 * @param $time
 * @return string
 */
function getDateText($time)
{
    $num = time() - $time;
    if ($num >= 86400) {
        return '1天前';
    }

    if ($num >= 3600) {
        return floor($num/3600).'小时前';
    }

    if ($num >= 60) {
        return floor($num/60).'分钟前';
    }

    return '1分钟前';
}

/**
 * 获取重合的日期天数
 * @param $st1
 * @param $et1
 * @param $st2
 * @param $et2
 * @return array
 */
function getUnionDate($st1, $et1, $st2, $et2)
{
    $s = max($st1, $st2);
    $e = min($et1, $et2);

    if ($s > $e) {
        return [0, 0, 0];
    }

    return [($e - $s)/86400 + 1, ($s - $st1)/86400, ($e - $st1)/86400];
}

function getTimeDiff($time1, $time2)
{
    $arr1 = explode(':', $time1);
    $arr2 = explode(':', $time2);
    return ($arr1[1] - $arr2[1] + 60*($arr1[0] - $arr2[0]))*60;
}

/**
 *  生成订单号
 *
 * @param string $prefix
 * @return string
 */
function generateNo($prefix = '')
{
    return $prefix.date('YmdHis') . random_int(1000, 9999);
}


function generateRandStr($uniquid = '', $prefix = '')
{
    return $prefix.strtoupper(substr(md5(uniqid('', true)), 8, 16));
}

/**
 * 导出CSV文件
 * @param $data
 * @param array $head
 * @param $filename
 */
function exportCsv($data, $head = [],  $filename)
{
    // 拼接文件信息，这里注意两点
    // 1、字段与字段之间用逗号分隔开
    // 2、行与行之间需要换行符

    $fileData = '';
    if (!empty($head)) {
        foreach ($head as $k=>$v) {
            $fileData = utfToGbk($v).',';
        }

        $fileData .= "\n";
    }

    foreach ($data as $value) {
        $temp = '';
        foreach ($value as $v) {
            $temp .= $v.',';
        }
        $fileData .= utfToGbk($temp) . "\n";
    }

    // 头信息设置
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=" . $filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $fileData;
    exit;
}


/**
 * 字符转换（utf-8 => GBK）
 */
function utfToGbk($data)
{
    return iconv('utf-8', 'GBK', $data);
}

/**
 * 字体换行
 * @param $str
 * @param int $break
 * @return string
 */
function wordBreak($str, $break = 24)
{
    $res  = '';
    $len = mb_strlen($str);

    $i = 0;
    while ($i<$len) {
        $res .= mb_substr($str, $i, $break, 'UTF-8').'\r\n';
        $i+=$break;
    }

    return $res;
}
