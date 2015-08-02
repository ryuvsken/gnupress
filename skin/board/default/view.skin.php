<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
wp_enqueue_script( $bo_table.'-view-skin-js', $board_skin_url.'/js/view.skin.js' );
?>

<!-- 게시물 읽기 시작 { -->
<div id="bo_v_table"><?php echo $board['bo_subject']; ?></div>

<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h1 id="bo_v_title">
            <?php
            if ($category_name) echo $view['ca_name'].' | '; // 분류 출력 끝
            echo g5_cut_str(g5_get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
    </header>

    <section id="bo_v_info">
        <h2><?php _e('Page info', 'gnupress');?></h2>
        <?php _e('author', 'gnupress');?> <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
        <span class="sound_only"><?php _e('date', 'gnupress');?></span><strong><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
        <?php _e('hit', 'gnupress');?><strong><?php echo number_format($view['wr_hit']) ?></strong>
        <?php _e('comment', 'gnupress');?><strong><?php echo number_format($view['wr_comment']) ?></strong>
    </section>

    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
    ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo esc_url( $view['file'][$i]['href'] ); ?>" class="view_file_download no-ajaxy">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?><?php _e('downloads', 'gnupress');    //회 다운로드?></span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    if (implode('', $view['link'])) {
     ?>
     <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2><?php _e('Related Links', 'gnupress'); //관련링크?></h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = g5_cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo esc_url( $view['link_href'][$i] ); ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="<?php _e('Related Links', 'gnupress'); //관련링크?>">
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?><?php _e('connected', 'gnupress'); //연결?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>

    <!-- 게시물 상단 버튼 시작 { -->
    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo esc_url( $prev_href ); ?>" class="btn_b01"><?php _e('Prev', 'gnupress'); //이전?></a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo esc_url( $next_href ); ?>" class="btn_b01"><?php _e('Next', 'gnupress'); //이전?></a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo esc_url( $update_href ); ?>" class="btn_b01"><?php _e('Modify', 'gnupress'); //수정?></a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo esc_url( $delete_href ); ?>" class="btn_b01" onclick="gnupress.del(this.href); return false;"><?php _e('Delete', 'gnupress'); //삭제?></a></li><?php } ?>
            <?php if ($copy_href) { ?><li><a href="<?php echo esc_url( $copy_href ); ?>" class="btn_admin no-ajaxy" onclick="board_move(this.href); return false;"><?php _e('Copy', 'gnupress'); //복사?></a></li><?php } ?>
            <?php if ($move_href) { ?><li><a href="<?php echo esc_url( $move_href ); ?>" class="btn_admin no-ajaxy" onclick="board_move(this.href); return false;"><?php _e('Move', 'gnupress'); //이동?></a></li><?php } ?>
            <?php if ($search_href) { ?><li><a href="<?php echo esc_url( $search_href ); ?>" class="btn_b01"><?php _e('Search', 'gnupress'); //검색?></a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01"><?php _e('List', 'gnupress'); //목록?></a></li>
            <?php if ($reply_href) { ?><li><a href="<?php echo esc_url( $reply_href ); ?>" class="btn_b01"><?php _e('Reply', 'gnupress'); //목록?></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo esc_url( $write_href ); ?>" class="btn_b02"><?php _e('Write', 'gnupress'); //목록?></a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title"><?php _e('Article', 'gnupress'); //본문?></h2>

        <?php

        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";
            
            foreach((array) $view['file'] as $view_file ){
                if( !isset($view_file['view']) ) continue;
                //echo $view_file['view'];
                echo g5_get_view_thumbnail($view_file['view'], $board['bo_image_width']);
            }

            echo "</div>\n";
        }

         ?>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"><?php echo g5_get_view_thumbnail($view['content'],  $board['bo_image_width']); ?></div>
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <!-- 스크랩 추천 비추천 시작 { -->
        <?php if ($scrap_href || $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($scrap_href) { ?><a href="<?php echo esc_url( $scrap_href ); ?>" target="_blank" class="btn_b01" onclick="gnupress.win_scrap(this.href); return false;"><?php _e('scrap', 'gnupress'); //스크랩?></a><?php } ?>
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo esc_url( $good_href ) ?>" id="good_button" class="btn_b01" target="_blank"><?php _e('recommend', 'gnupress'); //추천?> <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good"></b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo esc_url( $nogood_href ) ?>" id="nogood_button" class="btn_b01" target="_blank"><?php _e('nonrecommend', 'gnupress'); //비추천?>  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span><?php _e('recommend', 'gnupress'); //추천?> <strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span><?php _e('nonrecommend', 'gnupress'); //비추천?> <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- } 스크랩 추천 비추천 끝 -->
    </section>

    <?php
    if( count($tag_array) ){   //태그가 존재한다면
        echo "<div class=\"bo-tags bo-tags-view\">";
        foreach( $tag_array as $term ){
            if( empty($term) ) continue;
    ?>
        <a href="<?php echo $term['href']?>"><?php echo $term['name'];?></a>
    <?php
        }
        echo "</div>";
    }
    ?>

    <?php
    // 코멘트 입출력
    include_once(G5_DIR_PATH.'bbs/view_comment.php');
    ?>

    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
function view_file_download(){
    var othis = this;
    (function($){
        if(!gnupress.is_member) {
            alert("<?php _e('You are not allowed to download attachments.', 'gnupress');?>\n<?php _e('If you are a member, please login.', 'gnupress');?>");
            return false;
        }

        var msg = "<?php echo sprintf(__('Download attachments deducted %s Points) points.', 'gnupress'), number_format($board['bo_download_point']));?>\n\n<?php _e('Points are deducted only once per post and do not duplicate deducted download again the next bout', 'gnupress');?>\n\n<?php _e('Do you want to download anyway?', 'gnupress');?>";

        if(confirm(msg)) {
            var href = $(othis).attr("href")+"&js=on";
            $(this).attr("href", href);
            window.open( href );
        }

        return false;
    })(jQuery);
}
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}

function excute_good($el, $tx)
{
    (function($){
        $.post(
            $el.attr("href"),
            { action: "good", use_ajax : 1, wr_id : <?php echo $wr_id ?>, 'bo_table' : "<?php echo $bo_table ?>" },
            function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                if(data.count) {
                    $el.find("strong").text(gnupress.number_format(String(data.count)));
                    if($tx.attr("id").search("nogood") > -1) {
                        $tx.text("<?php _e('Dislike this post.', 'gnupress');?>");
                        $tx.fadeIn(200).delay(2500).fadeOut(200);
                    } else {
                        $tx.text("<?php _e('Like this post.', 'gnupress');?>");
                        $tx.fadeIn(200).delay(2500).fadeOut(200);
                    }
                }
            }, "json"
        );
    })(jQuery);
}
</script>
<!-- } 게시글 읽기 끝 -->