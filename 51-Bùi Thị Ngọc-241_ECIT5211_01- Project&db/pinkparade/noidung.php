
        <?php
			if(isset($_GET['xem'])){
				$tam=$_GET['xem'];
			}else{
				$tam='';
				}
				if($tam=='chitiet'){
				include('./pages/product_detail.php');
			}else if($tam=='cart'){
				include('./pages/cart.php');
			}else if($tam=='trangchu'){
				include('./pages/trangchu.php');
            }else if($tam=='sanpham'){
				include('./pages/sanpham.php');
			}else if($tam=='ketqua'){
				include('./pages/search_results.php');
            }elseif($tam=='dangnhap'){
				include('./pages/dangnhap.php');
			}elseif($tam=='dangky'){
				include('./pages/dangky.php');
            }elseif($tam=='thanhtoan'){
				include('./pages/thanhtoan.php');
			}else
					include('./pages/trangchu.php');
				
			?>
        </div>
    </div>
    <div class="clear"></div>