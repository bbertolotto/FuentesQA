/**
 *  Document   : Search.js
 *  Author     : TeknodataSystems
**/

var Jsonn = function() {
    return {
      evalXML: function(response) {
        try {
            JSON.parse(response);
        } catch (e) {
            Alert.showAlert(e);console.error(e);return(false);
        }
        return(true);
      },
      parse: function(response) {
        return(JSON.parse(response));
      }
    };
}();

var Client = function() {
    return {
        init: function() {
            var ourl="http://desarrollo.solventa.maximoerp.com/CallWS/consolidate";
            $('#body-modal-search').load(ourl,function(response, status, xhr){
                if(status == "success") {
                    if(Jsonn.evalXML(response)){
                        response = Jsonn.parse(response);
                        if(response['retorno']!="000"){
                          Alert.showSearch("",response['html']);
                        }
                    }
                }else{
                    Alert.showError(response);
                }
                return(true);
            });
        },
    };
}();
$(function(){ Client.init(); });
