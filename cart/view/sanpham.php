<?php
    $html_dm=showdm($dsdm);
    $html_dssp=showsp($dssp);
?>
<!-- <div class="containerfull">
        <div class="bgbanner">SẢN PHẨM</div>
    </div> -->

    <section class="containerfull">
        <div class="container">
            <div class="boxleft mr2pt menutrai">
                <h1>DANH MỤC</h1><br><br>
                <?=$html_dm?>
            </div>
                         
             <div class="boxright">
                <h1>SẢN PHẨM</h1><br>
                <div class="containerfull mr30">
                    <?=$html_dssp;?>
                </div>
            </div>  


        </div>
    </section>