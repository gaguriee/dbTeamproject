<?php include $_SERVER['DOCUMENT_ROOT']."/db.php"; ?>
<!doctype html>
<head>
<meta charset="UTF-8">
<title>중고플랫폼 통합 서비스</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="main_area" style="width: 1000px; position: relative;"> 
<?php 
  
  //검색된 키워드 받아오기 

  if(isset($_GET['page'])){
    $page = $_GET['page'];
    $search_keyword = $_COOKIE['search'];
      }else{
        $page = 1;
        $search_keyword = $_GET['search'];
      }
?>

<?php 
$total_price= 0;
$count= 0;

$sql2 = qr("select * from product where title like '%$search_keyword%' ");  //극단값 제거 전 
while($product = $sql2->fetch_array()){ //result set으로부터 record 하나씩 return

$price = $product['price'];


if(is_numeric($price)&&(int)$price!=0){
    $total_price+= $price;     //가격 총합 구하기
    $count+=1; // 결과값 개수 구하기
    
}
 
  } ?>

<h4 style="margin-top:30px;"><a href="/main.php">HOME</a></h4> 

<div style="padding-top:50px; width:parent; height:50px; margin:auto ">
  <h2 style="margin-top:8px; float:left">'<?php echo $search_keyword; ?>'
  <?php 
    
    if($count != 0)
    {echo '의 현재 시세는 ';
        
    } else {
     echo '에 대한 검색결과가 존재하지 않습니다.';   
    }
   ?> 
</h2>
  <h1 style="color:red; float:left; margin-left: 5px "> <?php
  
  if($count != 0)
    {
        // $result = sprintf('%0.0f', $total_price/$count);
        // echo ''.number_format($result).''; //극단값 제거 전 시세

 
        $start = floor($count*0.05); //전체 결과에서 가격 오름차순으로 나열했을 때 하위 5% 이상 값부터 가져올 수 있도록 함(>5%)
        $number = floor($count*0.9)+1; //전체 결과에서 가격 오름차순으로 나열했을 때 상위 5% 이하 값부터 가져올 수 있도록 함(<95%)


        $sql2 = qr("select * from product where title like '%$search_keyword%' order by price limit $start, $number  ");  // 극단값 제거
        $total_price= 0;
        $count= 0;
        while($product = $sql2->fetch_array()){ //result set으로부터 record 하나씩 return

        $price = $product['price'];
        if(is_numeric($price)&&(int)$price!=0){
            $total_price+= $price;     // 가격 총합 다시 구하기
            $count+=1;  // 결과값 개수 다시 구하기
            
        }
        
        }
        $result = sprintf('%0.0f', $total_price/$count); // 시세 결과값 소수점 제외
        
        echo ''.number_format($result).''; //극단값 제거 후 시세

    } else {  
    }

    ?> </h1>

<h2 style="margin-top:8px; float:left; margin-left: 5px "> <?php
  if($count != 0)
    {echo '원 입니다.';
        
    } else {  
    }

    ?> </h2>

</div>




<h4 style="color:gray; ">상품명을 자세히 입력할수록 더 정확한 시세를 확인할 수 있습니다.</h4>


  <div id="search_box">
      <form action="search_result.php" method="get">
      <input type="text" placeholder="검색어 입력" name="search" size="50" required="required"/> <button>검색</button>
    </form>
  </div>

  <h5 style="color:red; ">최신순</h5>
  <h5 ><a href="/search_result2.php?search=<?php echo $search_keyword?>">낮은가격순</a></h5> 

    <table class="list-table">
    <thead>
          <tr>
          <th width="100">이미지</th>
                <th width="500">제목</th>
                <th width="100">가격</th>
                <th width="120">사이트</th>
                <th width="100">작성일</th>
            </tr>
        </thead>
        <?php
        
                    $sql =  qr("select newtb.* from (select * from product where title like '%$search_keyword%' order by price limit $start, $number) as newtb ");
                    // 극단값을 제거한 테이블로부터 모든 값을 가져옴
                    $row_num = mysqli_num_rows($sql);
                    $maximum = 10; //한 리스트에 최대 나올 수 있는 값
                    $pagenum = 5; //한 화면에서 보여줄 페이지 개수 

                    $block_num = ceil($page/$pagenum);
                    $block_start = (($block_num - 1) * $pagenum) + 1; 
                    $block_end = $block_start + $pagenum - 1; 

                    $total_page = ceil($row_num / $maximum); 
                    if($block_end > $total_page) $block_end = $total_page; 
                    $total_block = ceil($total_page/$pagenum); 
                    $start_num = ($page-1) * $maximum; 

                    $sql2 = qr("select newtb.* from (select * from product where title like '%$search_keyword%' order by price limit $start, $number) as newtb order by published_at limit $start_num, $maximum ");  
                    // 극단값을 제거한 테이블로부터 각 페이지에 들어갈 결과값만 가져옴 (페이징)
                    // 극단값을 제거한 테이블 최신 순으로

                    while($product = $sql2->fetch_array()){


                    setcookie('search',$search_keyword); //페이지가 넘어갈 때 검색값을 전달
                    ?>
                        <tbody>
                                <tr>
                                <td width="120"><img width="100" src="<?php echo $product['image']; ?>"></td>
                                <td width="540"><a href="<?php echo $product['article_url']; ?>"><?php echo $product['title']; ?></a></td>
                                <td width="120"><?php echo $product['price']?></td>
                                <td width="120"><?php echo $product['site_name']?></td>
                                <td width="100"><?php echo $product['published_at']?></td>
                                </tr>
                    </tbody>

                    <?php } ?>
    </table>



   <div id="page_num" sytle="height: 200px; padding-bottom: 100px; margin: 0px">
      <ul>
        <?php
        //페이징

          if($page <= 1)
          { 
            echo "<li class='first'>처음</li>"; 
          }else{
            echo "<li><a href='?page=1'>처음</a></li>"; 
          }
          if($page <= 1)
          { 
            
          }else{
          $pre = $page-1; 
            echo "<li><a href='?page=$pre'>이전</a></li>";
          }
          for($i=$block_start; $i<=$block_end; $i++){ 
    
            if($page == $i){  
              echo "<li class='first'>[$i]</li>"; 
            }else{
              echo "<li><a href='?page=$i'>[$i]</a></li>";
            }
          }
          if($block_num >= $total_block){ 
          }else{
            $next = $page + 1; 
            echo "<li><a href='?page=$next'>다음</a></li>"; 
          }
          if($page >= $total_page){ 
            echo "<li class='first'>마지막</li>"; 
          }else{
            echo "<li><a href='?page=$total_page'>마지막</a></li>";
          }
        ?>
      </ul>
    </div>
        

</div>
</body>
</html>