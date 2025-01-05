<?php
    $html_dm=showdm($dsdm);
    $hmtl_sp_lienquan=showsp($splienquan);
    extract($spchitiet);
?>
<div class="containerfull">
        <div class="bgbanner">SẢN PHẨM CHI TIẾT</div>
    </div>
<section class="containerfull">
        <div class="container">
            <div class="boxleft mr2pt menutrai">
                <h1>DANH MỤC</h1><br><br>
                <?= $html_dm?>
            </div>
            <div class="boxright">
                <h1>SẢN PHẨM CHI TIỂT</h1><br>
                <div class="containerfull mr30">
                    <div class="col6 imgchitiet">
                        <img src="layout/images/<?=$img?>" alt="">
                    </div>
                    <div class="col6 textchitiet">
                        <h2><?=$name?></h2>
                        <p><?=$price?>Đ</p>                        
                        <form action="index.php?pg=addcart" method="post">
                            <input type="hidden" name="name" value=" <?=$name?>" >
                            <input type="hidden" name="img" value=" <?=$img?>">
                            <input type="hidden" name="price" value="<?=$price?>">
                            <input type="hidden" name="soluong" value="1">
                            <button type="submit" name="addcart">Đặt hàng</button>
                        </form>
                        
                    </div>

                </div>
                <hr>
                <h1>SẢN PHẨM LIÊN QUAN</h1>   
                 <div class="containerfull mr30">
                    <?=$hmtl_sp_lienquan;?>
            </div>


        </div>
    </section>