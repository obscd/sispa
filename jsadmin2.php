<script>
	function numeral(num)
	{
		<?php 
		$pen="num";
		echo "document.getElementById('la_suma_de').value=".$pen.";";?>
		
	}
	//pagina,form,idsalida
	
	function nre(str,strb,sal)
	{
		
		if(str=='documentos')
		{
		document.getElementById('registrar').style.visibility="hidden";
		document.getElementById("status").innerHTML = "CARGANDO ARCHIVO AL SERVIDOR";
		}
		menerror="Error todos los campos son obligatorios";
		urr=str+".php";
		urfr="form."+strb;
		dest="#"+sal;
		var formData = new FormData($(urfr)[0]);
				$.ajax({
					type: "POST",
					url: urr,
					data: formData,
                	contentType: false,
                	processData: false,
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
    function documentos(url,id,sal)
        {                       
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                    document.getElementById(sal).innerHTML = xmlhttp.responseText;
                
            }
            str=url+".php?cod="+id;            
            xmlhttp.open("GET",str,true);
            xmlhttp.send();
        }
    </script>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="../build/js/custom.min.js"></script>
    <script src="../js/index.js">		</script>