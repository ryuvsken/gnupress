<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$listall = '';
$colspan = 9;

$options = get_option(G5_OPTION_KEY);
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    생성된 게시판수 <?php echo number_format($total_count) ?>개
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="bo_table"<?php echo g5_get_selected($sfl, "bo_subject", true); ?>>TABLE</option>
    <option value="bo_subject"<?php echo g5_get_selected($sfl, "bo_subject"); ?>>제목</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit button">

</form>

<?php if ($is_admin == 'super') { ?>
<div class="btn_add01 btn_add">
    <a href="<?php echo add_query_arg( array('page'=>'g5_board_form') );?>" id="bo_add" class="button">게시판 추가</a>
</div>
<?php } ?>

<form name="fboardlist" id="fboardlist" action="<?php echo g5_form_action_url(admin_url("admin.php?page=g5_board_list"));?>" onsubmit="return fboardlist_submit(this);" method="post">
<?php wp_nonce_field( 'bbs_list_admin' ); ?>
<input type="hidden" name="g5_admin_post" value="bbs_list_update" />
<input type="hidden" name="sst" value="<?php echo esc_attr( $sst ); ?>">
<input type="hidden" name="sod" value="<?php echo esc_attr( $sod ); ?>">
<input type="hidden" name="sfl" value="<?php echo esc_attr( $sfl ); ?>">
<input type="hidden" name="stx" value="<?php echo esc_attr( $stx ); ?>">
<input type="hidden" name="page" value="<?php echo esc_attr( $page ); ?>">

<div class="bootstrap" id="no-more-tables">
    <table class="table-bordered table-striped table-condensed">
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">게시판 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="g5_check_all(this.form)">
        </th>
        <th scope="col"><?php echo g5_subject_sort_link('bo_table') ?>TABLE</a></th>
        <th scope="col"><?php echo g5_subject_sort_link('bo_skin', '', 'desc') ?>스킨</a></th>
        <th scope="col"><?php echo g5_subject_sort_link('bo_subject') ?>제목</a></th>
        <th scope="col">읽기P<span class="sound_only">포인트</span></th>
        <th scope="col">쓰기P<span class="sound_only">포인트</span></th>
        <th scope="col">댓글P<span class="sound_only">포인트</span></th>
        <th scope="col">다운P<span class="sound_only">포인트</span></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
    foreach($rows as $row){
        $modify_url = add_query_arg( array('page'=>'g5_board_form', 'w'=>'u', 'bo_table'=>$row['bo_table'] ) ); //수정 버튼 url
        $one_update = '<a href="'.$modify_url.'">수정</a>';
        $one_copy = '<a href="./board_copy.php?bo_table='.$row['bo_table'].'" class="board_copy" target="win_board_copy">복사</a>';
        $bbs_direct_url = '';
        
        if( $g5_get_page_id = g5_get_page_id(G5_NAME."-".$row['bo_table']) ){     //게시판이 적용된 페이지가 존재한다면
            $bbs_direct_url = add_query_arg( array( 'bo_table'=>$row['bo_table'] ), get_permalink($g5_get_page_id) );
        }
        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo g5_get_text($row['bo_subject']) ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td>
            <input type="hidden" name="board_table[<?php echo $i ?>]" value="<?php echo $row['bo_table'] ?>">
            <?php if( $bbs_direct_url ){ ?>
                <a href="<?php echo $bbs_direct_url; ?>">
            <?php } ?>
            <?php echo $row['bo_table'] ?>
            <?php if( $bbs_direct_url ){ ?>
                </a>
            <?php } ?>
        </td>
        <td>
            <label for="bo_skin_<?php echo $i; ?>" class="sound_only">스킨</label>
            <?php echo g5_get_skin_select('board', 'bo_skin_'.$i, "bo_skin[$i]", $row['bo_skin']); ?>
        </td>
        <td>
            <label for="bo_subject_<?php echo $i; ?>" class="sound_only">게시판 제목<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="bo_subject[<?php echo $i ?>]" value="<?php echo g5_get_text($row['bo_subject']) ?>" id="bo_subject_<?php echo $i ?>" required class="required frm_input bo_subject full_input" size="10">
        </td>
        <td class="td_numsmall">
            <label for="bo_read_point_<?php echo $i; ?>" class="sound_only">읽기 포인트</label>
            <input type="text" name="bo_read_point[<?php echo $i ?>]" value="<?php echo $row['bo_read_point'] ?>" id="bo_read_point_<?php echo $i; ?>" class="frm_input" size="2">
        </td>
        <td class="td_numsmall">
            <label for="bo_write_point_<?php echo $i; ?>" class="sound_only">쓰기 포인트</label>
            <input type="text" name="bo_write_point[<?php echo $i ?>]" value="<?php echo $row['bo_write_point'] ?>" id="bo_write_point_<?php echo $i; ?>" class="frm_input" size="2">
        </td>
        <td class="td_numsmall">
            <label for="bo_comment_point_<?php echo $i; ?>" class="sound_only">댓글 포인트</label>
            <input type="text" name="bo_comment_point[<?php echo $i ?>]" value="<?php echo $row['bo_comment_point'] ?>" id="bo_comment_point_<?php echo $i; ?>" class="frm_input" size="2">
        </td>
        <td class="td_numsmall">
            <label for="bo_download_point_<?php echo $i; ?>" class="sound_only">다운 포인트</label>
            <input type="text" name="bo_download_point[<?php echo $i ?>]" value="<?php echo $row['bo_download_point'] ?>" id="bo_download_point_<?php echo $i; ?>" class="frm_input" size="2">
        </td>

        <td class="td_mngsmall">
            <?php echo $one_update ?>
            <?php echo $one_copy ?>
        </td>
    </tr>
    <?php
    $i++;
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="button">
    <?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="button">
    <?php } ?>
</div>

</form>

<script>
function fboardlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>