<?php

/**
 * 分页类
 * created by kuangzw
 */
class Pagination
{
    /**
     * 内部属性
     */
    private $pageName = "page"; //page标签，用来控制url页。比如说xxx.php?PB_page=2中的PB_page
    private $totalpage = 0; //总页数
    private $url = ""; //url地址头
    private $offset = 0; //
    private $total = 0; // 记录总数
    private $pageLength = PAGINATION_PAGELENGTH; // 显示分页栏数
    private $nowindex = PAGINATION_PAGEFIRST; //当前页
    private $pagenum = PAGINATION_PAGENUM; // 每页显示

    /**
     * constructor构造函数
     * @param array $array ['total'],$array['perpage'],$array['nowindex'],$array['url'],$array['ajax']...
     */
    public function __construct($total) {
        $this->_setNowIndex(); //设置当前页
        $this->_setUrl(); //设置链接地址
        $this->totalpage = ceil($total / $this->pagenum);
        $this->offset = ($this->nowindex - 1) * $this->pagenum;
        $this->total = $total;
    }

    /**
     * 控制分页显示风格
     */
    public function show() {
        return '<div class="article" style="padding:5px 20px 2px 20px; background:none; border:0;">' . $this->initPage() . "</div>";
    }

    /**************************************************第二部分*************************************************/

    /*----------------private function (私有方法)-----------------------------------------------------------*/
    /**
     * 新分页 TODO
     */
    private function initPage() {
        if ($this->total == 0 || $this->total == 1 || $this->total <= $this->pagenum) return ''; //如果总数为0，不显示分页

        $this->totalpage = ceil($this->total / $this->pagenum); //总页数
        $showPageLength = $this->totalpage > $this->pageLength ? $this->pageLength : $this->totalpage;//需要显示的分页数

        $str = '<p>Page 1 of 2 <span class="butons">'; //分页头
        $str .= $this->nowindex == $this->totalpage ? '<a href="javascript:void(0);">&raquo;</a>' : '<a href="' . $this->_getUrl($this->totalpage) . '">&raquo;</a>';

        if ($this->nowindex == 1) { // 页面1
            $i = $this->nowindex;
        } elseif ($this->nowindex == $this->totalpage && $this->totalpage < $this->pageLength) { //页码小于规定页数
            $i = 1;
        } else {
            if ($this->nowindex == $this->totalpage) {
                $showPageLength = $this->totalpage;
                $i = $this->nowindex - $this->pageLength + 1;
            } else {
                $showPageLength = $this->nowindex + (ceil($this->pageLength / 2) - 1);
                $i = $this->nowindex - (ceil($this->pageLength / 2) - 1);
                if ($i <= 0) {// 如果出现其实页为0的时候,强制+1
                    $beyondLength = 1 - $i;
                    $i = 1;
                    $showPageLength = $showPageLength + $beyondLength > $this->pageLength ? $this->totalpage : $showPageLength + $beyondLength;
                }
                if ($showPageLength > $this->totalpage) {// 如果出现尾页大于总页数的时候，强制-1
                    $beyondLength = $showPageLength - $this->totalpage;
                    $showPageLength = $this->totalpage;
                    $i = $i - $beyondLength <= 0 ? 1 : $i - $beyondLength;
                }
            }
        }
        while ($showPageLength >= $i) {
            if ($this->nowindex == $showPageLength) {
                $str .= '<a href="javascript:void(0);" class="active">' . $showPageLength . '</a>';
            } else {
                $str .= '<a href="' . $this->_getUrl($showPageLength) . '">' . $showPageLength . '</a>';
            }
            $showPageLength--;
        }
        $str .= $this->nowindex == 1 ? '<a href="javascript:void(0);">&laquo;</a>' : '<a href="' . $this->_getUrl(1) . '">&laquo;</a>';
        $str .= '</span></p>';
        return $str;
    }

    /**
     * 设置url头地址
     * @return boolean
     */
    private function _setUrl() {
        //自动获取
        if (empty ($_SERVER ['QUERY_STRING'])) {
            //不存在QUERY_STRING时
            $this->url = $_SERVER ['REQUEST_URI'] . "?" . $this->pageName . "=";
        } else {
            $page_get = $_GET;
            $tmp = "";
            foreach ($page_get as $key => $val) {
                if ($key != "PB_Page_Select" && $key != $this->pageName) {
                    $tmp .= "&" . $key . "=" . $val;
                }
            }
            $tmp = trim($tmp, "&");
            $tmpS = explode("?", $_SERVER ['REQUEST_URI']);
            $this->url = $tmpS [0] . "?" . $tmp . '&' . $this->pageName . '=';
        } //end if
    }

    /**
     * 设置当前页面
     *
     */
    private function _setNowIndex($nowindex = null) {
        if (empty ($nowindex)) {
            //系统获取
            if (isset ($_GET [$this->pageName])) {
                $this->nowindex = intval($_GET [$this->pageName]);
                if (trim($this->nowindex) == "" || trim($this->nowindex) == 0) {
                    $this->nowindex = 1;
                }
            }
        } else {
            //手动设置
            $this->nowindex = intval($nowindex);
        }
    }

    /**
     * 为指定的页面返回地址值
     *
     * @param int $pageno
     * @return string $url
     */
    private function _getUrl($pageno = 1) {
        return $this->url . $pageno;
    }
}