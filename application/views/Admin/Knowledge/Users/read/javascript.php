<!-- DataTables -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(document).ready(function(){
      var dataTable = $('#dataTable').DataTable({
          "processing":true,
          "serverSide":true,
          "ajax":{
              url:"<?=base_url('Admin/Knowledge/Users/Json')?>",
              type:"POST"
          },
          "columnDefs":[
              {
                  "targets":[0, 5, 5],  // sesuaikan order table dengan jumlah column
                  "orderable":true,
              },
          ],
      });
  });
</script>