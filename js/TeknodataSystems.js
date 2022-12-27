/*
 *  Document   : TeknodataSystems.js
 *  Author     : TeknodataSystems
 */

var Teknodata = function() {
    return {

        processShow: function() {
          e = document.getElementById("processing");e.style.display = "";
        },
        processHide: function() {
          e = document.getElementById("processing");e.style.display = "none";
        },

        swal_basic_message: function(message) {

            Swal.fire(message);
        },

        swal_title_message: function(title, message, format){

            Swal.fire(
              title,
              message,
              format
            );

        },

        call_ajax: function(url, formData, ASYNC, AFORM, THIS){

          if(THIS!=""){
              $(THIS).prop('disabled', true);
          }
          if(AFORM){

              $.ajax( {
                  url: url, type: "POST", dataType: "json", data : formData, async: ASYNC, cache: false,
                  contentType: false, processData: false,
                  beforeSend: function(){ Teknodata.processShow(); }, complete:function() { Teknodata.processHide(); },
                  success: function(response, status, xhr){

                      if(response.retorno==600){

                          Teknodata.swal_title_message('Error!', response.descRetorno, 'question');
                          result = false;

                      }else{

                        result = response;
                      }

                  },
                  error: function(jqXHR, textStatus, errorThrown) {

                      Teknodata.swal_title_message('Error!', textStatus, 'error');
                      result = false;
                  }
              });


          }else{


              $.ajax( {
                  url: url, type: "POST", dataType: "json", data : formData, async: ASYNC, cache: false,
                  beforeSend: function(){ Teknodata.processShow(); }, complete:function() { Teknodata.processHide(); },
                  success: function(response, status, xhr){

                      if(response.retorno==600){

                          Teknodata.swal_title_message('Error!', response.descRetorno, 'question');
                          result = false;

                      }else{

                        result = response;

                      }

                  },
                  error: function(jqXHR, textStatus, errorThrown) {

                      Teknodata.swal_title_message('Error!', textStatus, 'error');
                      result = false;
                  }
              });

          }

          if(THIS!=""){
              $(THIS).prop('disabled', false);
          }
          return result;

        },
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
        validateRut: function(input) {
          var sRUT=Teknodata.clear2(input);var sDV="";
          if(sRUT=="-"){return(true);}
          if(sRUT.length<5){return(false);}
          if(sRUT.indexOf("-")<0){sDV=sRUT.substr(-1);sRUT=sRUT.substr(0,sRUT.length -1);}
          else{var arrayRUT = sRUT.split("-");sRUT = arrayRUT[0];sDV = arrayRUT[1];}
          if(Teknodata.calcDV(Teknodata.clear1(sRUT))!=sDV){return(false);}else{return(true);}
        },
        validateRange: function(input,min,max) {
          num = input.replace(/\./g,'');
          num = num.toString().replace(/\$/g,'');
          if(num==""){return(false);};
          if(!isNaN(num)){
            if(parseInt(num)<min){return(false);}
            if(parseInt(num)>max){return(false);}
            return(true);
          }
          return(false);
        },

        masked_nroRut(nroRut) {

          num = nroRut.value.replace(/[.-]/g, ''); num = num.substr(0,num.length -1);
          if(isNaN(num)) { nroRut.value=""; }

          nroRut.value=nroRut.value.replace(/[.-]/g, '').replace( /^(\d{1,2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4').replace(/[k]/g,'K')
          if(nroRut.value.indexOf("KK")>=0) { nroRut.value="";}

        },

        enter_onlyRut: function(evt) {

          var code = evt.which ? evt.which : evt.keyCode;
          //code == 107 => "k" code == 75 => "K" code == 45 => "-" code == 48 => "."
          if (code == 13) { Client.get_ClientByRut(); } else if (code == 8 ) { return true; } else if (code == 107 ) { return true; } else if (code == 75) { return true; } else if (code >= 48 && code <= 57) { return true; } else { return false; }

        },

        serial_onlyRut: function(evt) {

          var code = evt.which ? evt.which : evt.keyCode;
          // code==8 backspace code >= 48 and code <=57 solo números
          if (code == 46) return true; else if (code == 97) return true; else if (code == 65) return true; else if (code == 8) { return true; } else if (code >= 48 && code <= 57) { return true; } else { return false; }

        },
        masked_onlyRut: function(evt) {

          var code = evt.which ? evt.which : evt.keyCode;
          //code == 107 => "k" code == 75 => "K" code == 45 => "-" code == 48 => "."
          if (code == 8 ) { return true; } else if (code == 107 ) { return true; } else if (code == 75) { return true; } else if (code >= 48 && code <= 57) { return true; } else { return false; }

        },
        masked_onlyNumber: function(evt) {

          var code = evt.which ? evt.which : evt.keyCode;
          // code==8 backspace code >= 48 and code <=57 solo números
          if (code == 8) { return true; } else if (code >= 48 && code <= 57) { return true; } else { return false; }

        },
        validateName: function(e){
/*
 *          tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 8) return true;
            patron = /[A-Za-zñÑ-áéíóúÁÉÍÓÚ\s\t-]/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
*/
            var strFilter = /^[A-Za-zƒŠŒŽšœžŸÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèé êëìíîïðñòóôõöøùúûüýþÿ]*$/;
            var chkVal = e.value;
            if (!strFilter.test(chkVal)) { return false; } else {return true; }

        },
        maskMoney: function(val) {
          num = val.toString().replace(/\./g,'');
          if(num==""){return(false);}
          if(!isNaN(num)){
          num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
          num = num.split('').reverse().join('').replace(/^[\.]/,'');
          return("$"+num);
          }
          else{
            return("$"+input.value.replace(/[^\d\.]*/g,''));
          }
        },
        formatMoneda: function(input) {
          num = input.value.replace(/\./g,'');
          num = num.toString().replace(/\$/g,'');
          if(num==""){return(false);}
          if(!isNaN(num)){
          num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
          num = num.split('').reverse().join('').replace(/^[\.]/,'');
          input.value = "$"+num;
          }
          else{
            input.value = "$"+input.value.replace(/[^\d\.]*/g,'');
          }
        },
        sortTable: function(column, tabid) {


          switch (tabid)
          {
              case 1:
                  tabid="tabAutoriza";
                  break;
              case 2:
                  tabid="tabPagos";
                  break;
              case 3:
                  tabid="tabDevolucion";
                  break;
              case 4:
                  tabid="tabCuotas";
                  break;
              case 5:
                  tabid="tabCargos";
                  break;
              case 6:
                  tabid="tabVentas";
                  break;
              case 7:
                  tabid="tabEECC";
                  break;
              default:
                  tabid="tabAutoriza";
          }

          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById(tabid);
          switching = true;
          dir = "asc";

          while (switching) {
              switching = false;
              rows = table.rows;
              for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[column];
                y = rows[i + 1].getElementsByTagName("TD")[column];
                if (dir == "asc") {
                  if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                  }
                } else if (dir == "desc") {
                  if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                  }
                }
              }
              if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;
              } else {
                if (switchcount == 0 && dir == "asc") {
                  dir = "desc";
                  switching = true;
                }
              }
            }
          }

    };
}();


/*
jQuery Redirect v1.1.3
Copyright (c) 2013-2018 Miguel Galante
Copyright (c) 2011-2013 Nemanja Avramovic, www.avramovic.info
Licensed under CC BY-SA 4.0 License: http://creativecommons.org/licenses/by-sa/4.0/
This means everyone is allowed to:
Share - copy and redistribute the material in any medium or format
Adapt - remix, transform, and build upon the material for any purpose, even commercially.
Under following conditions:
Attribution - You must give appropriate credit, provide a link to the license, and indicate if changes were made. You may do so in any reasonable manner, but not in any way that suggests the licensor endorses you or your use.
ShareAlike - If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.
*/
;(function ($) {
  'use strict';

  //Defaults configuration
  var defaults = {
    url: null,
    values: null,
    method: "POST",
    target: null,
    traditional: false,
    redirectTop: false
  };

  /**
  * jQuery Redirect
  * @param {string} url - Url of the redirection
  * @param {Object} values - (optional) An object with the data to send. If not present will look for values as QueryString in the target url.
  * @param {string} method - (optional) The HTTP verb can be GET or POST (defaults to POST)
  * @param {string} target - (optional) The target of the form. "_blank" will open the url in a new window.
  * @param {boolean} traditional - (optional) This provides the same function as jquery's ajax function. The brackets are omitted on the field name if its an array.  This allows arrays to work with MVC.net among others.
  * @param {boolean} redirectTop - (optional) If its called from a iframe, force to navigate the top window.
  *//**
  * jQuery Redirect
  * @param {string} opts - Options object
  * @param {string} opts.url - Url of the redirection
  * @param {Object} opts.values - (optional) An object with the data to send. If not present will look for values as QueryString in the target url.
  * @param {string} opts.method - (optional) The HTTP verb can be GET or POST (defaults to POST)
  * @param {string} opts.target - (optional) The target of the form. "_blank" will open the url in a new window.
  * @param {boolean} opts.traditional - (optional) This provides the same function as jquery's ajax function. The brackets are omitted on the field name if its an array.  This allows arrays to work with MVC.net among others.
  * @param {boolean} opts.redirectTop - (optional) If its called from a iframe, force to navigate the top window.
  */
  $.redirect = function (url, values, method, target, traditional, redirectTop) {
    var opts = url;
    if (typeof url !== "object") {
      var opts = {
        url: url,
        values: values,
        method: method,
        target: target,
        traditional: traditional,
        redirectTop: redirectTop
      };
    }

    var config = $.extend({}, defaults, opts);
    var generatedForm = $.redirect.getForm(config.url, config.values, config.method, config.target, config.traditional);
    $('body', config.redirectTop ? window.top.document : undefined).append(generatedForm.form);
    generatedForm.submit();
    generatedForm.form.remove();
  };

  $.redirect.getForm = function (url, values, method, target, traditional) {
    method = (method && ["GET", "POST", "PUT", "DELETE"].indexOf(method.toUpperCase()) !== -1) ? method.toUpperCase() : 'POST';

    url = url.split("#");
    var hash = url[1] ? ("#" + url[1]) : "";
    url = url[0];

    if (!values) {
      var obj = $.parseUrl(url);
      url = obj.url;
      values = obj.params;
    }

    values = removeNulls(values);

    var form = $('<form>')
      .attr("method", method)
      .attr("action", url + hash);


    if (target) {
      form.attr("target", target);
    }

    var submit = form[0].submit;
    iterateValues(values, [], form, null, traditional);

    return { form: form, submit: function () { submit.call(form[0]); } };
  }

  //Utility Functions
    /**
     * Url and QueryString Parser.
     * @param {string} url - a Url to parse.
     * @returns {object} an object with the parsed url with the following structure {url: URL, params:{ KEY: VALUE }}
     */
  $.parseUrl = function (url) {

    if (url.indexOf('?') === -1) {
      return {
        url: url,
        params: {}
      };
    }
    var parts = url.split('?'),
      query_string = parts[1],
      elems = query_string.split('&');
    url = parts[0];

    var i, pair, obj = {};
    for (i = 0; i < elems.length; i += 1) {
      pair = elems[i].split('=');
      obj[pair[0]] = pair[1];
    }

    return {
      url: url,
      params: obj
    };
  };

  //Private Functions
  var getInput = function (name, value, parent, array, traditional) {
    var parentString;
    if (parent.length > 0) {
      parentString = parent[0];
      var i;
      for (i = 1; i < parent.length; i += 1) {
        parentString += "[" + parent[i] + "]";
      }

      if (array) {
        if (traditional)
          name = parentString;
        else
          name = parentString + "[" + name + "]";
      } else {
        name = parentString + "[" + name + "]";
      }
    }

    return $("<input>").attr("type", "hidden")
      .attr("name", name)
      .attr("value", value);
  };

  var iterateValues = function (values, parent, form, isArray, traditional) {
    var i, iterateParent = [];
    Object.keys(values).forEach(function (i) {
      if (typeof values[i] === "object") {
        iterateParent = parent.slice();
        iterateParent.push(i);
        iterateValues(values[i], iterateParent, form, Array.isArray(values[i]), traditional);
      } else {
        form.append(getInput(i, values[i], parent, isArray, traditional));
      }
    });
  };

  var removeNulls = function (values) {
    var propNames = Object.getOwnPropertyNames(values);
    for (var i = 0; i < propNames.length; i++) {
      var propName = propNames[i];
      if (values[propName] === null || values[propName] === undefined) {
        delete values[propName];
      } else if (typeof values[propName] === 'object') {
        values[propName] = removeNulls(values[propName]);
      } else if (values[propName].length < 1) {
        delete values[propName];
      }
    }
    return values;
  };
}(window.jQuery || window.Zepto || window.jqlite));
