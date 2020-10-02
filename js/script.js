$(document).ready(function() {
    $('.date').mask('00/00/0000');
  
    $('.next-step').click(function(){
        var step = $('.step.active').next('.step');
            $('.step.active').removeClass('active');
            $(step).addClass('active'); 
    });
});