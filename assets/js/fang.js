// 禁止右键
document.oncontextmenu=new Function("return false") 
// 禁止选取
document.onselectstart=new Function("return false") 

// 防止iframe镜像
this.top.location !== this.location && (this.top.location = this.location);

//禁止F1-F12
function testKeyDown(event) 
 {   
  if ((event.keyCode == 112)  || //屏蔽 F1 
   (event.keyCode == 113)  || //屏蔽 F2 
   (event.keyCode == 114)  || //屏蔽 F3 
   (event.keyCode == 115)  || //屏蔽 F4 
   (event.keyCode == 116)  || //屏蔽 F5
   (event.keyCode == 117)  || //屏蔽 F6 
   (event.keyCode == 118)  || //屏蔽 F7 
   (event.keyCode == 119)  || //屏蔽 F8 
   (event.keyCode == 120)  || //屏蔽 F9 
   (event.keyCode == 121)  || //屏蔽 F10 
   (event.keyCode == 122)  || //屏蔽 F11 
   (event.ctrlKey && event.shiftKey && event.keyCode==73)  || //屏蔽 F11 
   (event.keyCode == 123))    //屏蔽 F12 
  { 
   event.keyCode = 0;   
   event.returnValue = false; 
  } 
 } 
 document.onkeydown = function(){testKeyDown(event);} 
 
//禁止ctrl组合键
$(function(){  
  
    document.addEventListener('keydown', function(e){  
         e = window.event || e;  
         var keycode = e.keyCode || e.which;       
  
         if(e.ctrlKey && keycode == 87){   //屏蔽Ctrl+w    
            e.preventDefault();  
            window.event.returnValue = false;    
         }  
  
         if(e.ctrlKey && keycode == 82){   //Ctrl + R   
            e.preventDefault();   
            window.event.returnValue= false;   
         }                     
         if(e.ctrlKey && keycode== 83){ //Ctrl + S    
            e.preventDefault();  
            window.event.returnValue= false;       
         }  
		 
         if(e.ctrlKey && keycode== 85){ //Ctrl + u    
            e.preventDefault();  
            window.event.returnValue= false;       
         }  
		 
         if(e.ctrlKey && keycode== 65){ //Ctrl + A    
            e.preventDefault();  
            window.event.returnValue= false;       
         } 
		 
         if(e.ctrlKey && keycode== 70){ //Ctrl + F    
            e.preventDefault();  
            window.event.returnValue= false;       
         } 
		 
         if(e.ctrlKey && keycode== 74){ //Ctrl + G    
            e.preventDefault();  
            window.event.returnValue= false;       
         } 
  
         if(e.ctrlKey && keycode == 72){   //Ctrl + H   
            e.preventDefault();  
            window.event.returnValue= false;   
         }  
         if(e.ctrlKey && keycode == 74){   //Ctrl + J  
            e.preventDefault();   
            window.event.returnValue= false;   
         }  
         if(e.ctrlKey && keycode == 75){   //Ctrl + K   
            e.preventDefault();  
            window.event.returnValue= false;   
         }  
         if(e.ctrlKey && keycode == 78){   //Ctrl + N  
            e.preventDefault();  
            window.event.returnValue= false;   
         }          
    });  
});  
    //如果用户在工具栏调起开发者工具，那么判断浏览器的可视高度和可视宽度是否有改变，如有改变则关闭本页面 
    var h = window.innerHeight,w=window.innerWidth; 
    window.onresize = function () { 
        if (h!= window.innerHeight||w!=window.innerWidth){ 
            window.close(); 
            window.location = "about:blank"; 
        } 
    } 