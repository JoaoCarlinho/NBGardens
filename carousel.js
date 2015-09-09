var i = 0; 
var image = new Array();

// LIST OF IMAGES 
image[0] = "images/nbWebBanner.jpg"; 
image[1] = "images/1.jpg"; 
image[2] = "images/2.jpg";
image[3] = "images/3.jpg";
image[4] = "images/4.jpg"; 
image[5] = "images/5.jpg"; 
image[6] = "images/6.jpg";
image[7] = "images/7.jpg";
image[8] = "images/8.jpg"; 
image[9] = "images/9.jpg";
image[10] = "images/10.jpg";

var k = image.length - 1;

var link= new Array();   
// LIST OF LINKS 
//link[0] = "camps/summer_fun.html"; 
//link[1] = "camps/sum_fun_options.html"; 
//link[2] = "camps/summer_fun.html";
//link[3] = "/about/club_philosophy.html";

    function slide(x)
    {
        i = i + x;
        var pic = document.getElementById('imagen');
        //var hyper = document.getElementById('slide_link');
        
        if (i == image.length)
            {i = 0;}
        
        if (i < 0) 
            {i = image.length-1;}
        
        pic.src= image[i];
        //hyper.href = link[i];
    };

window.setInterval
(
    function() 
        {
        var pic = document.getElementById('imagen');
        //var hyper = document.getElementById('slide_link');
        
        i++;
        if (i == image.length) 
            {i = 0;}
        
        if (i < 0) 
            {i = image.length - 1;}
        
        pic.src= image[i];
        //hyper.href = link[i];
        },3000
);