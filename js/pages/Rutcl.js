/*
 *  Document   : TeknodataSystems.js
 *  Author     : TeknodataSystems
 */

var TeknodataCedula = function() {
    return {
        clear1: function(sVALUE) {
          sVALUE = sVALUE.replace(/\./g, "").replace(/\,/g, "").replace(/\-/g, "");
          return(sVALUE);
        },
        clear2: function(sVALUE) {
          sVALUE = sVALUE.replace(/\./g, "").replace(/\,/g, "").replace(/\_/g, "");
          return(sVALUE);
        },
        calcDV: function(sRUT) {
          var is_continue = true;varSUMA=0;
          for(i=2;is_continue;i++){varSUMA += (sRUT%10)*i;sRUT = parseInt((sRUT /10));i=(i==7)?1:i;is_continue = (sRUT == 0)?false:true;}
          var varRESTO = varSUMA%11; var dvOK = 11-varRESTO;
          if(dvOK==10){dvOK="K";}if(dvOK==11){dvOK="0";}
          return(dvOK);
        },
        validate: function(input) {
          var sRUT=Rutcl.clear2(input);var sDV="";
          if(sRUT=="-"){return(true);}
          if(sRUT.length<5){return(false);}
          if(sRUT.indexOf("-")<0){sDV=sRUT.substr(-1);sRUT=sRUT.substr(0,sRUT.length -1);}
          else{var arrayRUT = sRUT.split("-");sRUT = arrayRUT[0];sDV = arrayRUT[1];}
          if(Rutcl.calcDV(Rutcl.clear1(sRUT))!=sDV){return(false);}else{return(true);}
        }

    };
}();

var TeknodataMonto = function() {
    return {
        validate: function(input) {
          var sRUT=Rutcl.clear2(input);var sDV="";
          if(sRUT=="-"){return(true);}
          if(sRUT.length<5){return(false);}
          if(sRUT.indexOf("-")<0){sDV=sRUT.substr(-1);sRUT=sRUT.substr(0,sRUT.length -1);}
          else{var arrayRUT = sRUT.split("-");sRUT = arrayRUT[0];sDV = arrayRUT[1];}
          if(Rutcl.calcDV(Rutcl.clear1(sRUT))!=sDV){return(false);}else{return(true);}
        }
    };
}();
