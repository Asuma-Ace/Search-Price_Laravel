$(function() {
//「各条件」をあらかじめ非表示
  $('.result_item').css('display', 'none');

//「詳細条件」をクリックし展開、開いていれば閉じる
  $('.menu').click(function() {
    var $arrow = $(this).find('.menu_arrow');
    if ($arrow.hasClass('open')) {
      $arrow.removeClass('open');
      $(this).next().slideToggle(300);
      $(this).toggleClass("active");
    } else {
      $arrow.addClass('open');
      $(this).next().slideToggle(300);
      $(this).toggleClass("active");
    }
  });

  $(".btn-gnavi").on("click", function(){
    // ハンバーガーメニューの位置を設定
    var rightVal = 0;
    if($(this).hasClass("open")) {
        // 位置を移動させメニューを開いた状態にする
        rightVal = -300;
        // メニューを開いたら次回クリック時は閉じた状態になるよう設定
        $(this).removeClass("open");
    } else {
        // メニューを開いたら次回クリック時は閉じた状態になるよう設定
        $(this).addClass("open");
    }

    $("#global-navi").stop().animate({
        right: rightVal
    }, 200);
  });

});
