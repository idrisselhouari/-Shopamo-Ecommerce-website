  $(document).ready(function(){
    $("#productList").click(function(){
        $("#categoriesSousList").hide();
        $("#productSousList").fadeToggle();
    });
  });
  $(document).ready(function(){
    $("#categoriesList").click(function(){
        $("#productSousList").hide();
        $("#categoriesSousList").fadeToggle();
    });
  });

 function show(){
    $("#categoriesSousList").hide();
    $("#productSousList").hide();
    document.getElementById('aside_bar').classList.toggle('active'); 
  } 