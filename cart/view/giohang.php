<?php
    function get_tongdonhang() {
        $tong=0;
        foreach($_SESSION['giohang'] as $sp){
            extract($sp);
            $tt = (int)$price * (int)$soluong;
            $tong += $tt;
       } 
       return $tong;
    }
?>