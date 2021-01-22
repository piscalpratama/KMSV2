<!-- DataTables -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(document).ready(function(){
      var dataTable = $('#dataTable').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
              url:"<?=base_url('Admin/Master/Hadits/Json2')?>",
              type:"POST"
          },
          "columnDefs":[
              {
                  "targets":[0, 7, 7],  // sesuaikan order table dengan jumlah column
                  "orderable":true,
              },
          ],
      });
  });
</script>
<script>
  $(document).ready(function(){
      var dataTable = $('#dataTable2').DataTable({
          "processing":true,
          "serverSide":true,
          "order":[],
          "ajax":{
              url:"<?=base_url('Admin/Master/Hadits/Json3')?>",
              type:"POST"
          },
          "columnDefs":[
              {
                  "targets":[0, 7, 7],  // sesuaikan order table dengan jumlah column
                  "orderable":true,
              },
          ],
      });
  });
</script>
