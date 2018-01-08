$(window).load(function(){
    $('header i').click(function(){
        $('#nva').toggleClass('action');
        $('#view').toggleClass('action');
    });
    $('#nva i').click(function(){
        $('#nva').removeClass('action');
        $('#view').removeClass('action');
    });
    $('.veidostart i').click(function(){
        $('.veido').html('');
        $('.veido').hide();
        var veidoIndex = $(this).index('.veidostart i');
        var veidoUrl = $('.veieo-list-cont img.vPic').eq(veidoIndex).attr('veidoUrl');
        $('.veido').eq(veidoIndex).show();
        $('.veido').eq(veidoIndex).html('<video src="'+veidoUrl+'" width="100%" height="100%" autoplay="true" controls="controls"></video>');
    });

});