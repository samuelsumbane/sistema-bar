
document.querySelector("#backupbtn").addEventListener('click', ()=>{
    $.ajax({
         url: "backup.php",
         method: "POST",
         data:{action:"realizarbackup"},
         success: function(data){
             if(data != "403"){
                 backupFeitoComSucesso(data)
             }else{
                 erroAoFazerBackup()
             }
            
         }, error:function(){
             erroAoFazerBackup()
         }
     }) 
 })



const selectPro = ()=>{var action = "selectallrecordsP";$.ajax({url: "barAction.php",method: "POST",data:{action:action},dataType: "json",success: function(data){for(var i=0; i < data.length;i++){var np = data[i]["producto"];var pl = data[i]["pesoliquido"];var code = data[i]["barcode"] ?? data[i]["codigo"];var arr = `${np} - ${pl} - ${code}`;var dat = [arr];document.getElementById("mainCbarCode").innerHTML += `<div><input type="checkbox" name="EProCheck" id="EProCheck" value="${dat}"/> &nbsp<label>${dat}</label></div>`}}, error:function(){alert('Houve um erro desconhecido')}})};selectPro();var counter = 0;$('#clearButton').click(()=>{document.querySelector('#maindiv').innerHTML = ""});var counter = 0;$('#barCodeDivDef').on('submit', '#generateBarCodeForm', function(e){e.preventDefault();for(const i of document.querySelectorAll("#EProCheck")){if(i.checked == true){counter++;var Epro = i.value.split(' - ');var proname = Epro[0];var propl = Epro[1];var procode = Epro[2];document.querySelector('#maindiv').innerHTML += `<div style='width:30%;height:auto;margin-top:30px;display:flex;flex-direction:column;'><div style='width:100%;height:25%;display:flex'><p style="width:70%;font-size:12px;margin-top:auto;">${proname}</p><p style='margin-left:calc(auto - 20%);font-size:12px;margin-top:auto;'>${propl}</p></div><div style='width:100%;height:80%;display:flex'><svg id='probarcode${counter}'></svg></div></div>`;





JsBarcode(`#probarcode${counter}`, procode,{
    width:1,
    height: 30,
    displayValue: false,
    margin:2,
    marginBottom:0,
    background:"#f7f7f709",
    lineColor:"#0000ff"
}); i.checked = false
}}});$('#vstockdef').keyup(()=>{var vstockdef = $('#vstockdef').val();var ptext = document.querySelector('#alertDefError');var action = "saveLimiteInfe";if(vstockdef != ""){ptext.classList.add('hiddenP');$.ajax({url: "barAction.php",method: "POST",data: {vstockdef: vstockdef, action: action},success: function(data){}, error: function(){alert("Houve um erro desconhecido!")}})}else{ptext.classList.remove('hiddenP')}});$('#searchProbc').keyup(()=>{var searchValue = $('#searchProbc').val();var action = "filterStock";if (searchValue.length == 0){document.getElementById("mainCbarCode").innerHTML = "";selectPro()}else{document.getElementById("mainCbarCode").innerHTML = "";$.ajax({url: "barAction.php",method: "POST",data: {searchValue: searchValue, action: action},dataType: "json",success: function(data){for(var i=0; i < data.length;i++){var np = data[i]["producto"];var pl = data[i]["pesoliquido"];var code = data[i]["barcode"] ?? data[i]["codigo"];var arr = `${np} - ${pl} - ${code}`;var dat = [arr];document.getElementById("mainCbarCode").innerHTML += `<div><input type="checkbox" name="EProCheck" id="EProCheck" value="${dat}"/> &nbsp<label>${dat}</label></div>`}}, error: function(){alert("Houve um erro desconhecido!")}})}});$("#sAllProbc").click(()=>{for(const i of document.querySelectorAll("#EProCheck")){i.checked = true}})
