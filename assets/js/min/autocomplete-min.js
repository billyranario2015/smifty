$(function(){var t=3;$("#jobname").keyup(function(){var a=$("#jobname").val();a.length>=t&&$.ajax({dataType:"json",type:"post",url:"/ajax/autocomplete.php",data:{keyword:a},success:function(t){$("#foodsearchresults").empty().show(),$.each(t,function(t,a){$("#foodsearchresults").append($("<option></option>").attr({value:a.id,"data-restaurant":a.name,"data-amount":a.amount,"data-name":a.foodname}).text(a.foodname))}),$("#foodsearchresults option").click(function(t){t.preventDefault(),$(".foodactions").show();var a=$(this).val(),o=$(this).attr("data-restaurant"),e=$(this).attr("data-amount"),n=$(this).attr("data-name");$(".resta .val").text(o),$(".name .val").text(n),$(".amount .val").text(e),$("#foodactions button").attr("data-target",a)}),$("#foodactions button").click(function(t){var a=$(this).attr("data-intent"),o=$(this).attr("data-target");console.log(o),"delete"==a&&$.ajax({type:"post",dataType:"json",url:"/ajax/dashboard-actions.php",data:{foodid:o},success:function(t){console.log(o),$("#foodsearchresults option[value="+o+"]").remove()}})})},error:function(t){console.log("error"+t)}})})});