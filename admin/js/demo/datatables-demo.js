// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable( {
            "lengthMenu": [[-1, 10, 25, 50 ], ["All", 10, 25, 50 ]]
          } );
});


// $(document).ready( function() {
//   *      $('#example').dataTable( {
//   *        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
//   *      } );
//   *    } );