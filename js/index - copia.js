//http://techbrij.com/html-table-row-grouping-jquery

$(function() {  
//Created By: Brij Mohan
//Website: http://techbrij.com
function groupTable($rows, startIndex, total)
{
		if (total === 0){
		return;
		}
		var i , currentIndex = startIndex, count=1, lst=[];
		var tds = $rows.find('td:eq('+ currentIndex +')');

		//-------------------------------------------------
		/* str = JSON.stringify(tds);
		str = JSON.stringify(tds, null, 4); // (Optional) beautiful indented output.
		console.log(str); // Logs output to dev tools console.
		*/
		//-------------------------------------------------
		var ctrl = $(tds[0]);

		lst.push($rows[0]);
		for (i=1;i<=tds.length;i++){
		if (ctrl.text() ==  $(tds[i]).text()){
		/*--------------------------------------------------------------------
		str = JSON.stringify(ctrl);
		str = JSON.stringify(ctrl, null, 4); // (Optional) beautiful indented output.
		console.log(str); // Logs output to dev tools console.
		alert(ctrl.text() + "<<<>>>" + $(tds[i]).text());
		
		*///-----------------------------------------------	
		count++;
		$(tds[i]).addClass('deleted');
		lst.push($rows[i]);
		}
		else{
		if (count>1){
		ctrl.attr('rowspan',count);
		groupTable($(lst),startIndex+1,total-1)
		}
		count=1;
		lst = [];
		ctrl=$(tds[i]);
		lst.push($rows[i]);
		}
		}
}

// 
var totalColumns = $("#myTable tr:first-child").children().length;// total columnas
groupTable($('#myTable tr:has(td)'),0,totalColumns);
$('#myTable .deleted').remove();
});