     $.fn.dataTableExt.afnFiltering.push(
  function( oSettings, aData, iDataIndex ) {
    var iFini = document.getElementById('desde').value;
    var iFfin = document.getElementById('hasta').value;
    var iStartDateCol = 8;
    var iEndDateCol = 8;

    iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
    iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);
    console.log(iFini);

    var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
    var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

    if ( iFini === "" && iFfin === "" )
    {
      return true;
    }
    else if ( iFini <= datofini && iFfin === "")
    {
      return true;
    }
    else if ( iFfin >= datoffin && iFini === "")
    {
      return true;
    }
    else if (iFini <= datofini && iFfin >= datoffin)
    {
      return true;
    }
    return false;
  }
);