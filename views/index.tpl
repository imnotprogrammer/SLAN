<html>
<body>
<style>

    #slan{
	width:150px;
	height:150px;
	margin:40px auto;
	}
    #circle_bot{  
    background-color:green;  
    width: 150px;  
    height: 150px;  
    margin: 0px 0 0 0px;  
    border-radius: 50%;  
    }  
    #circle_mid {  
    background-color:yellow;  
    width: 100px;  
    height: 100px;  
    margin: -125px 0 0 25px;  
    border-radius: 50%;  
	text-align:center;
	line-height:100px;

    }  
  #info_display{
      margin:20px auto;
	  height:20px;
	  text-align:center;
	  letter-spacing:4px;
	  font-weight:bold;
	  font-size:18px;
  }

</style> 
<div id="slan"> 
    <div id="circle_bot"></div>  
    <div id="circle_mid">  
	   <strong>SLAN 2.0</strong><br>
    </div>  
</div>
<div id="info_display">{$infomation}</div>
</body>
</html>