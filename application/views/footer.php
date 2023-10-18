   <script>
      CKEDITOR.replace('editor', {
         filebrowserUploadUrl: '/ohkr/api_upload_photo',
         filebrowserUploadMethod: 'form'
      });

      //datatable
      let dataTable = $('#datatable').DataTable({
         "paging": false,
         "ordering": true,
         "info": true,
         "bFilter": true,
         "pageLength": 100,
         "dom": "lrtip" //to hide default search box but search feature is not disabled
      });


      $(document).ready(function() {
         $('.multiple-select').select2();


         $('#myCustomSearchBox').keyup(function() {
            dataTable.search($(this).val())
               .draw(); // this  is for customized searchbox with datatable search feature.
         });

         //custom search
         let dTable = $('#dt').DataTable({
            // scrollY: '56vh',
            // scrollCollapse: true,
            paging: false,
            ordering: true,
            info: false,
            bFilter: true,
            pageLength: 100,
            dom: "lrtip" //to hide default search box but search feature is not disabled
         });

         $('#myCustomSearchBox').keyup(function() {
            dTable.search($(this).val())
               .draw(); // this  is for customized searchbox with datatable search feature.
         });
      });
   </script>
   </body>

   </html>