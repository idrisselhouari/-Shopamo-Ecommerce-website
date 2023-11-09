            var Mainimg=document.getElementById("MainImg");
            var smallImg=document.getElementsByClassName("small-img");
            var text;
            smallImg[0].onclick=function(){
                text=Mainimg.src;
                Mainimg.src=smallImg[0].src;
                smallImg[0].src=text;
            }
            smallImg[1].onclick=function(){
                text=Mainimg.src;
                Mainimg.src=smallImg[1].src;
                smallImg[1].src=text;
            }
            smallImg[2].onclick=function(){
                text=Mainimg.src;
                Mainimg.src=smallImg[2].src;
                smallImg[2].src=text;
            }
            smallImg[3].onclick=function(){
                text=Mainimg.src;
                Mainimg.src=smallImg[3].src;
                smallImg[3].src=text;
            }