// var rpr = document.querySelectorAll('#remessaPaperRec')

for(const rpr of document.querySelectorAll('.remessaPaperRec')){
  // console.log(rpr)
  function getPFD(){
    var parentFooterDiv = rpr.children[1]
    // console.log(parentFooterDiv)
    parentFooterDiv.classList.toggle('activeParentFooterDiv')
    //
  }
  

  rpr.addEventListener('mouseenter', ()=>{
    getPFD()
  })

  rpr.addEventListener('mouseleave', ()=>{
    getPFD()
  })
}


for(const printBtn of document.querySelectorAll('.printRemessaRecGrouped')){
       
  printBtn.addEventListener('click', ()=>{
      var idBtn = printBtn.getAttribute('id')
      var printData = document.querySelector(`#parentMainDiv${idBtn}`);
      newWin = window.open("");
      newWin.document.write(printData.outerHTML);
      newWin.print();
      window.location = "remessaDocs.php"
      newWin.close();
  })
}