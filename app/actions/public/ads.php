<?php

class ads{
    public function detail(){
        extract($_POST);
        $ret = $this->fetchRow("newsId = '{$p}'");
        return json_encode($ret);
    }
}