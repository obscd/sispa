
	function numeral(num)
	{
		<?php 
		$pen="num";
		echo "document.getElementById('la_suma_de').value=".$pen.";";?>
	}
	//pagina,form,idsalida
	function nre(str,strb,sal)
	{
		menerror="failure";
		urr=str+".php";
		urfr="form."+strb;
		dest="#"+sal;
				$.ajax({
					type: "POST",
					url: urr,
					data: $(urfr).serialize(),
					success: function(msg){
						$(dest).html(msg)
						$("#form-content").modal('hide');	
					},
					error: function(){
						alert(menerror);
					}
				})
				
		
	}
	function ventana(ht,str,sal) 
	{
		if(str=='delete')
		{
			str=document.getElementById('focus').value;
		}
	//	alert(str);
  //document.getElementById("buss").value=str;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(sal).innerHTML = xmlhttp.responseText;
            }
        }
		str=ht+".php?item="+str;
        xmlhttp.open("GET",str,true);
        xmlhttp.send();
    }
	function ventana_option(ht,str,sal,stra) 
	{
		if(stra==null)
		{
			
		}
	else{
		str=str+"&p="+stra+"&c="+document.getElementById(stra).value;
		}
	//	alert(str);
  //document.getElementById("buss").value=str;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(sal).innerHTML = xmlhttp.responseText;
            }
        }
		str=ht+".php?item="+str;
        xmlhttp.open("GET",str,true);
        xmlhttp.send();
    }
	function caja(ht,str,sal) 
	{ 
		if(str=='delete')
		{
			str=document.getElementById('focus').value;
		}
	//	alert(str);
  //document.getElementById("buss").value=str;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById(sal).value = xmlhttp.responseText;
            }
        }
		str=ht+".php?item="+str;
        xmlhttp.open("GET",str,true);
        xmlhttp.send();
    }
	function myFunction() 
	{
    window.print();
	}