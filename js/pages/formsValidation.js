/*
 *  Document   : formsValidation.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Forms Validation page
 */

var FormsValidation = function() {
    return {
        init: function() {
            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */
            var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            $.validator.addMethod("rutcl", function( value, element ) {
            return this.optional( element ) || eregex.test( value );
            });
            alert("value:"+value);

            $('#form-validation').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'div',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                unhighlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    // You can use the following if you would like to highlight with green color the input after successful validation!
                    e.closest('.form-group').removeClass('has-success has-error').addClass('has-success'); //e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
                    e.closest('.help-block').remove();
                },
                rules: {
                    val_username: {required: true, minlength: 3},
                    val_email: {required: true, email: true},
                    val_password: {required: true, minlength: 5},
                    val_confirm_password: {required: true, equalTo: '#val_password'},
                    val_bio: {required: true, minlength: 5},
                    val_skill: {required: true},
                    val_website: {required: true,url: true},
                    val_digits: {required: true, digits: true},
                    val_number: {required: true,number: true},
                    masked_rut_client: {required: true, equals: true},
                    val_range: {required: true,range: [1, 1000]},
                    val_terms: {required: true}
                },
                messages: {
                    val_username: {required: 'Please enter a username',minlength: 'Your username must consist of at least 3 characters'},
                    val_email: 'Please enter a valid email address',
                    val_password: {required: 'Please provide a password',minlength: 'Your password must be at least 5 characters long'},
                    val_confirm_password: {required: 'Please provide a password',minlength: 'Your password must be at least 5 characters long',equalTo: 'Please enter the same password as above'},
                    val_bio: 'Don\'t be shy, share something with us :-)',
                    val_skill: 'Please select a skill!',
                    val_website: 'Please enter your website!',
                    val_digits: 'Please enter only digits!',
                    val_number: 'Please enter a number!',
                    val_range: 'Please enter a number between 1 and 1000!',
//                    masked_num_sav: 'Please enter a number between 1 and 1000!',
                    masked_rut_client: {required:'Debe ingresar RUT', number:'Digito Verificador no corresponde a RUT ingresado!'},
                    val_terms: 'You must agree to the service terms!'
                }
            });
            // Initialize Masked Inputs
            // a - Represents an alpha character (A-Z,a-z)
            // 9 - Represents a numeric character (0-9)
            // * - Represents an alphanumeric character (A-Z,a-z,0-9)
            $('#masked_num_sav').mask('9999-9999');
            $('#masked_rut_client').mask('99.999.999-*');
            $('#masked_credit_card').mask('9999-9999-9999-9999');
            $('#masked_renta_client').mask('999.999.999');
            $('#masked_date').mask('99/99/9999');
            $('#masked_date2').mask('99-99-9999');
            $('#masked_phone').mask('(999) 999-9999');
            $('#masked_phone_ext').mask('(999) 999-9999? x99999');
            $('#masked_taxid').mask('99-9999999');
            $('#masked_ssn').mask('999-99-9999');
            $('#masked_pkey').mask('a*-999-a999');
        }
    };
}();

/*
 *  Document   : formsValidation.js
 *  Author     : TeknodataSystems
 *  Description: Valida Número Cédula identidad Nacional Chile -> RUT formato 12479692-K
 */
function evalRUT(input){
    var sRUT=input.value;var sDV="";
    if(input.value==""){return(false);}
    if(sRUT.indexOf("-")<0){sDV=sRUT.substr(-1);sRUT=sRUT.substr(0,sRUT.length -1);}
    else{var arrayRUT = sRUT.split("-");sRUT = arrayRUT[0];sDV = arrayRUT[1];}
    input.value = format(sRUT.concat(sDV),1);
    if(calcRUTDV(format(sRUT,2))!=sDV){return(false);}else{return(true);}
}
function calcRUTDV(sRUT){var is_continue = true;varSUMA=0;
  for(i=2;is_continue;i++){varSUMA += (sRUT%10)*i;sRUT = parseInt((sRUT /10));i=(i==7)?1:i;is_continue = (sRUT == 0)?false:true;}
  var varRESTO = varSUMA%11; var dvOK = 11-varRESTO;
  if(dvOK==10){return ("K");}
  if(dvOK==11){return ("0");}
  return(dvOK);
}
function format(sVALUE,nFORMAT){
/*nFORMAT=1 Mascara visulizar RUT (12.479.692-K)*/
if(nFORMAT==1&&sVALUE.length>1){sVALUE = format(sVALUE,2);
  var sDV=sVALUE.substr(-1);sVALUE=sVALUE.substr(0,sVALUE.length -1);
  sVALUE = sVALUE.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
  sVALUE = sVALUE.split('').reverse().join('').replace(/^[\.]/,'');
  sVALUE = sVALUE.concat("-",sDV);}
/*nFORMAT=2 Mascara elimina todos los caracteres (".,-"\)*/
if(nFORMAT==2){sVALUE = sVALUE.replace(/\./g, "").replace(/\,/g, "").replace(/\-/g, "");}
return(sVALUE);
}
//function onfocusin(input){input.value=input.value.replace(/\./g, "").replace(/\,/g, "").replace(/\-/g, "");}
