<?php if ( ! defined('PATH_BASEURL')) exit('No direct script access allowed');

/**
 * 自定义 md5 加密算法
 * @author      lensic [mhy]
 * @link        http://www.lensic.cn/
 * @copyright   Copyright (c) 2013 - , lensic [mhy].
 *
 * @access   public
 * @param    string   需加密的字符串
 * @return   string   加密后的字符串
 */
function str_md5($str)
{
    $length = count($str);
    $last = $length - 1;
    return md5(base64_encode($str[0]) . md5($str) . base64_encode($str[$last]));
}

/* End of file my_md5_helper.php */
/* Location: ./application/helpers/my_md5_helper.php */