<?
    $pagetitle = "법인 리스트";
    include "../lib/header.php";
    include "../lib/nav.php";
    include "../lib/side_co.php";


	if(!$member[user_id])Error("로그인 후 이용해 주세요.");

$page_size=10;

$page_list_size = 10;
$no = $_GET[no];
if (!$no || $no < 0) $no=0;

// 데이터베이스에서 페이지의 첫번째 글($no)부터
// $page_size 만큼의 글을 가져온다.
$query = "SELECT * FROM co ORDER BY co_no DESC LIMIT $no, $page_size";

$result = mysql_query($query, $conn);

// 총 게시물 수 를 구한다.
$result_count=mysql_query("SELECT count(*) FROM co", $conn);
$result_row=mysql_fetch_row($result_count);
$total_row = $result_row[0];
//결과의 첫번째 열이 count(*) 의 결과다.

# 총 페이지 계산
if ($total_row <= 0) $total_row = 0;
$total_page = ceil($total_row / $page_size);

# 현재 페이지 계산
$current_page = ceil(($no+1)/$page_size);
?>

<div class="main">

<div class="main_title">법 인 리 스 트</div>

<table id="list01">
  <thead>

  <tr>
  	<th scope="cols">번호</th>
  	<th scope="cols">회 사 명</th>
  	<th scope="cols">대 표 자</th>
    <th scope="cols">사업자등록번호</th>
  	<th scope="cols">우편번호</th>
    <th scope="cols">주소</th>
    <th scope="cols">전화번호</th>
  </tr>
  </thead>

<?
while($row=mysql_fetch_array($result))
{
?>

<tr>
	<td>
		<a href="co_read.php?co_no=<?=$row[co_no]?>&no=<?=$no?>">
		<?=$row[co_no]?></a>
	</td>

	<td>
		<a href="co_read.php?co_no=<?=$row[co_no]?>&no=<?=$no?>">
		<?=strip_tags($row[co_name], '<b><i>');?></a>
	</td>

	<td>
		<a href="co_read.php?co_no=<?=$row[co_no]?>&no=<?=$no?>">
		<?=strip_tags($row[co_boss], '<b><i>');?></a>
	</td>
	<td>
		<a href="co_read.php?co_no=<?=$row[co_no]?>&no=<?=$no?>">
		<?=strip_tags($row[co_num], '<b><i>');?></a>
	</td>
	<td>
    <a href="co_read.php?co_no=<?=$row[co_no]?>&no=<?=$no?>">
		<?=strip_tags($row[co_post], '<b><i>');?></a>
	</td>
  <td>
    <a href="co_read.php?co_no=<?=$row[co_no]?>&no=<?=$no?>">
		<?=strip_tags($row[co_adr], '<b><i>');?></a>
	</td>
  <td>
		<a href="co_read.php?co_no=<?=$row[co_no]?>&no=<?=$no?>">
		<?=strip_tags($row[co_pho], '<b><i>');?></a>
  </td>
</tr>

<?
}
mysql_close($conn);
?>

</table>

<br>
<?
$start_page = floor(($current_page - 1) / $page_list_size)
				* $page_list_size + 1;

# 페이지 리스트의 마지막 페이지가 몇 번째 페이지인지 구하는 부분이다.
$end_page = $start_page + $page_list_size - 1;

if ($total_page < $end_page) $end_page = $total_page;
if ($start_page >= $page_list_size) {
	# 이전 페이지 리스트값은 첫 번째 페이지에서 한 페이지 감소하면 된다.
	# $page_size 를 곱해주는 이유는 글번호로 표시하기 위해서이다.

	$prev_list = ($start_page - 2)*$page_size;
	echo "<a href=\"$PHP_SELF?no=$prev_list\">&laquo;</a>\n";
}

# 페이지 리스트를 출력
for ($i=$start_page;$i <= $end_page;$i++) {
	$page= ($i-1) * $page_size;// 페이지값을 no 값으로 변환.
	if ($no!=$page){ //현재 페이지가 아닐 경우만 링크를 표시
		echo "<a href=\"$PHP_SELF?no=$page\">";
	}

	echo "<button class='btn_s bt10'>$i</button>"; //페이지를 표시

	if ($no!=$page){
		echo "</a>";
	}
}

# 다음 페이지 리스트가 필요할때는 총 페이지가 마지막 리스트보다 클 때이다.
# 리스트를 다 뿌리고도 더 뿌려줄 페이지가 남았을때 다음 버튼이 필요할 것이다.
if($total_page > $end_page)
{
	$next_list = $end_page * $page_size;
	echo "<a href=$PHP_SELF?no=$next_list>&raquo;</a><p>";
}
?>


</div>
</div>
</main>


<?
      include('../lib/footer.php');
 ?>
