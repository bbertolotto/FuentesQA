/**
/**
 *  Document   : renegotiation/Monitor.js
 *  Author     : TeknodataSystems
**/
var id = 0;
$(function () {
    var table = $(".dataTablesMonitor").DataTable({
        responsive: true,
        dom: "Bfrtip",
        searching: false,
        ajax: {
          url: "/renegotiation/monitortable",
          type: "POST",
          data: function (d) {
            d.tipo = id;
          },
        },
        drawCallback: function () {},
      });

    $('#history').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever');
        id = recipient;
        table.ajax.reload();

      });
});
