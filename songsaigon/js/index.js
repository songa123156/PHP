$(document).ready(() => {
  $(".panel-top").hover(() => {
    animateTop();
  });
  $(".panel-top").click(() => {
    animateTop();
  });
  $(".panel-bottom").hover(() => {
    animateBottom();
  });
  $(".panel-bottom").click(() => {
    animateBottom();
  });

  $(".panel-body").hover(() => {
    $(".image-box").stop().animate({ backgroundPositionY: "50%" }, 1000);
    $("#marker").stop().animate({ top: "200px", left: "270px" }, 1000);
  });

  function animateTop() {
    $(".image-box").stop().animate({ backgroundPositionY: "0%" }, 1000);
    $("#marker").stop().animate({ top: "60px", left: "90px" }, 1000);
  }
  function animateBottom() {
    $(".image-box").stop().animate({ backgroundPositionY: "100%" }, 1000);
    $("#marker").stop().animate({ top: "420px", left: "560px" }, 1000);
  }

  $(".intro-title").hover(
    () => {
      $(".logos img").addClass("bounce-effect");
    },
    () => {
      $(".logos img").removeClass("bounce-effect");
    }
  );
});
