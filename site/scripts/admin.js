$(document).ready(function(){
    $("#table tr:not(:first)").click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');    
    })
});
