<?php
/**
 * 分页器
 * @version 191106
 * @author Yue
 */
namespace yueool\phplib;

class Pager{

    public $dataSum = 0;//数据总数
    public $dataPerPage = 0;//每页数据
    public $curPageNum = 1;//当前页数

    public $pageSum = 0;
    public $prevPageNum = 0;
    public $nextPageNum = 0;

    public $offset = 0;
    public $curPageDataSum = 0;
    public $limitSql = '';

    /**
     * Pager constructor.
     * @param $dataSum 数据总数
     * @param $dataPerPage 每页数据
     * @param int $curPageNum 当前页数
     */
    public function __construct($dataSum, $dataPerPage, $curPageNum = 1){

        //数据总数
        $this->dataSum = intval($dataSum);
        if($this->dataSum <= 0){
            throw new \RuntimeException("数据总数不能为空");
        }

        //每页数据
        $this->dataPerPage = intval($dataPerPage);
        if($this->dataPerPage <= 0){
            throw new \RuntimeException("每页数据不能为空");
        }

        //当前页数
        $this->curPageNum = intval($curPageNum);
        if($this->curPageNum <= 0){
            $this->curPageNum = 1;
        }

        $this->init();
    }

    /**
     * 分页显示,初始化
     */
    public function init(){

        //计算总页数
        $this->pageSum = ceil($this->dataSum / $this->dataPerPage);

        //修正当前页
        if($this->curPageNum > $this->pageSum)$this->curPageNum = $this->pageSum;

        //计算OFFSET
        $this->offset = ($this->curPageNum -1) * $this->dataPerPage;

        //余数
        $remainder = $this->dataSum % $this->dataPerPage;
        $this->curPageDataSum = ($this->curPageNum == $this->pageSum && $remainder != 0) ? $remainder : $this->dataPerPage;

        //计算上一页和下一页
        $this->prevPageNum = $this->curPageNum > 1 ? $this->curPageNum - 1 : 1;
        $this->nextPageNum = $this->curPageNum < $this->pageSum ? $this->curPageNum + 1 : $this->pageSum;

        $this->limitSql = ($this->offset == 0) ? ' LIMIT '.$this->curPageDataSum : ' LIMIT '.$this->offset.", ".$this->curPageDataSum;
    }

}