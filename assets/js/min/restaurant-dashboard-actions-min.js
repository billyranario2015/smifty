$(function(){var a=3;$("#jobname").keyup(function(){var t=$("#jobname").val();t.length>=a&&$.ajax({dataType:"json",type:"post",url:"/ajax/autocomplete.php",data:{keyword:t,usertype:"restaurant"},success:function(a){""==a?($("#emptyfood").show(),$("#add-a-food").show()):($("#foodsearchresults").empty().show(),$.each(a,function(a,t){$("#foodsearchresults").append($("<option></option>").attr({value:t.id,"data-restaurant":t.name,"data-amount":t.amount,"data-name":t.foodname}).text(t.foodname))}),$("#foodactions button").click(function(a){var t=$(this).attr("data-intent"),o=$(this).attr("data-target");"delete"==t&&$.ajax({type:"post",dataType:"json",url:"/ajax/dashboard-actions.php",data:{foodid:o,intent:"delete"},success:function(a){$("#foodsearchresults option[value="+o+"]").remove(),$(".foodactions").hide(),$("#foodsearchresults").hide(),$("#jobname").val(""),$("#foodalert").show().text("Food item successfully deleted")},error:function(a){}})}),$("#foodsearchresults option").click(function(a){a.preventDefault(),$(".foodactions").show();var t=$(this).val(),o=$(this).attr("data-restaurant"),e=$(this).attr("data-amount"),n=$(this).attr("data-name");$(".resta .val").text(o),$(".name .val").text(n),$(".amount .val").text(e),$("#foodactions button").attr("data-target",t)}))},error:function(a){console.log(a.responseText)}})}),$("#add-a-food").click(function(a){var t=$("#jobname").val();$("#newfoodbox").show(),$("#newfoodname").val(t),$.ajax({type:"post",dataType:"json",url:"/ajax/dashboard-actions.php",data:{intent:"getrestaurants"},success:function(a){},error:function(a){}})}),$("#add-food-form").submit(function(a){a.preventDefault();var t={name:$("#newfoodname").val(),restaurant:$("#restaurantlist").val(),amount:$("#foodamount").val(),vegetarian:$("#vegetarian").find(":checked").val(),available:$("#available").find(":checked").val()};$.ajax({type:"post",dataType:"json",url:"/ajax/dashboard-actions.php",data:{intent:"addnewfood",dataform:t},encode:!0,success:function(a){$("#newfoodbox").hide(),$("#emptyfood").hide(),$("#jobname").val(""),$("#foodalert").show().text("Food item successfully added to the database")},error:function(a){}})})});