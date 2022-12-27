/**
/**
 *  Document   : renegotiation/Search.js
 *  Author     : TeknodataSystems
**/
var id = 0;
$(function () {

    var schedule = $(".schedule").DataTable({
        "language": {
            "url": "/vendor/datatables/Spanish.json"
        },
        responsive: true,
        dom: "Bfrtip",
        searching: false,
        ajax: {
          url: "/renegotiation/list_schedule",
          type: "POST"
        },
        drawCallback: function () {
            $('[data-toggle="tooltip"]').tooltip();
         },
    });

    $('#history').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever');
        id = recipient;
        table.ajax.reload();
      });

return(false);
});
