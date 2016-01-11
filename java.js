function checkAll(field)
{
  for(i = 0; i < field.elements.length; i++)
     field[i].checked = true ;
}

function uncheckAll(field)
{
 for(i = 0; i < field.elements.length; i++)
    field[i].checked = false ;
}

function Confirm(link,text) 
{
  if (confirm(text))
     window.location=link
}

  function delConfirm(obj){
	var status=false;
	for(var i=0 ; i < obj.elements.length ; i++ ){
		if(obj[i].type=='checkbox'){
			if(obj[i].checked==true){
				status=true;
			}
		}
	}
	if(status==false){
		alert('กรุณาเลือกข้อมูลที่ต้องการลบ.');
		return false;
	}else{
		if(confirm('คุณมั่นใจในการลบข้อมูล?')){
			return true;
		}else{
			return false;
		}
	}
}