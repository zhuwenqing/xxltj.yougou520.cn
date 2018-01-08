   /**
    * 更换微信号
    */
   arr_wx = ['aa', 'cc'];
   //arr_wx = ['Am311534','Am311535','Am311530','Am311519','eir2018']; 
   var wx_index = Math.floor((Math.random() * arr_wx.length));
   var stxlwx = arr_wx[wx_index];

   $(function() {
       $("img.lazy").lazyload({
           effect: "fadeIn",

       });
   });

   $(window).load(function() {
       $('.wxbtn').click(function() {
           $('.alert').css('display', 'flex');
       });
       $('.close').click(function() {
           $('.alert').css('display', 'none');
       });
   });


   $(document).ready(function() {
       $(".btn1").click(function() {

           $("#wx").show();
           $("#zhezhao").show();
       });
   });

   $(document).ready(function() {
       $(".close").click(function() {
           $("#wx").hide();
           $("#zhezhao").hide();
       });
   });

   $(document).ready(function() {
       $(".dianjiaceshi").click(function() {
           $("#ceshikuang").show();
           $(".btnother").hide();
       });
   });
   $(document).ready(function() {
       $(".close1").click(function() {
           $("#ceshikuang").hide();
           $(".btnother").show();
       });
   });






   $(document).ready(function() {
       $(".onequestion li").click(function() {
           $(".onequestion").hide();
           $(".twoquestion").show();
       });
   });
   $(document).ready(function() {
       $(".twoquestion li").click(function() {
           $(".twoquestion").hide();
           $(".threequestion").show();
       });
   });
   $(document).ready(function() {
       $(".threequestion li").click(function() {
           $(".threequestion").hide();
           $(".fourquestion").show();
       });
   });
   $(document).ready(function() {
       $(".fourquestion li").click(function() {
           $(".fourquestion").hide();
           $(".fivequestion").show();
       });
   });
   $(document).ready(function() {
       $(".fivequestion li").click(function() {
           $(".fivequestion").hide();
           $(".sixquestion").show();
       });
   });
   $(document).ready(function() {
       $(".sixquestion li").click(function() {
           $(".sixquestion").hide();
           $(".servenquestion").show();
       });
   });
   $(document).ready(function() {
       $(".servenquestion li").click(function() {
           $(".servenquestion").hide();
           $(".eightquestion").show();
       });
   });
   $(document).ready(function() {
       $(".eightquestion li").click(function() {
           $(".eightquestion").hide();
           $(".result").show();
       });
   });