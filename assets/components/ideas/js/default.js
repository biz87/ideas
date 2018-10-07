$(document).on('click', '.ideasTabsNav a', function(e){
    e.preventDefault();

    var tab = $(this).data('tab');

    $('.ideasTabsNav a').each(function(){
        if($(this).data('tab') == tab){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });

    $('.ideasTab').each(function(){
        if($(this).data('tab') == tab){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });
});