<link rel="shortcut icon" type="image/png" href="../Images/logo.png"/>

<!-- <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script> -->

<link rel="stylesheet" href="../CSS/bootstrap.min.css">
<link rel="stylesheet" href="../CSS/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="../CSS/slider-style.css" />
<link  rel="stylesheet" href="../CSS/notify-metro.css"/>
<link rel="stylesheet" href="../CSS/style.css">

<script type="text/javascript" src="../JS/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../JS/bootstrap.min.js"></script>
<script type="text/javascript" src="../JS/modernizr.custom.28468.js"></script>
<noscript>
  <link rel="stylesheet" type="text/css" href="../CSS/nojs.css" />
</noscript>
<script type="text/javascript" src="../JS/jquery.js"></script>
<script type="text/javascript" src="../JS/jquery.cslider.js"></script>
<script type="text/javascript" src="../JS/notify.js"></script>
<script type="text/javascript" src="../JS/notify-metro.js"></script>

<!-- Chart.js  -->
<script type="text/javascript" src="../JS/charts/Chart.bundle.js"></script>
<script type="text/javascript" src="../JS/charts/utils.js"></script>

<!-- TinyMCE 
<script type="text/javascript" src="../JS/tinymce/js/tinymce/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
-->

<!-- DataTables -->
<link href="../CSS/dataTables.bootstrap.css" rel="stylesheet">
<link href="../CSS/dataTables.responsive.css" rel="stylesheet">
<link href="../CSS/sb-admin-2.css" rel="stylesheet">
<link href="../CSS/font-awesome.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../JS/metisMenu.min.js"></script>
<script type="text/javascript" src="../JS/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../JS/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="../JS/dataTables.responsive.js"></script>
<script type="text/javascript" src="../JS/sb-admin-2.js"></script>

<!-- Slider Background movement -->
<script type="text/javascript">
  $(function() {
  
    $('#da-slider').cslider({
      autoplay  : true,
      bgincrement : 500
    });
  
  });
</script>

<!-- DATA TABLE manager/article.php -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[ 0, "asc" ]],
            "columnDefs": [{"orderable": false, "targets": [2, 3]}],
            responsive: true
        });
    });
</script>
<!-- DATA TABLE manager/foods.php -->
<script>
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "order": [[ 0, "asc" ]],
            "columnDefs": [{"orderable": false, "targets": 7}],
            responsive: true
        });
    });
</script>



<!-- Froala Text Editor -->
<link rel="stylesheet" href="../CSS/froala/font-awesome.min.css">
<link rel="stylesheet" href="../CSS/froala/froala_editor.css">
<link rel="stylesheet" href="../CSS/froala/froala_style.css">
<link rel="stylesheet" href="../CSS/froala/codemirror.min.css">
<link rel="stylesheet" href="../CSS/froala/plugins/code_view.css">
<link rel="stylesheet" href="../CSS/froala/plugins/image_manager.css">
<link rel="stylesheet" href="../CSS/froala/plugins/image.css">
<link rel="stylesheet" href="../CSS/froala/plugins/table.css">
<link rel="stylesheet" href="../CSS/froala/plugins/video.css">
<script type="text/javascript" src="../JS/froala/codemirror.min.js"></script>
<script type="text/javascript" src="../JS/froala/xml.min.js"></script>
<script type="text/javascript" src="../JS/froala/froala_editor.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/align.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/code_view.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/draggable.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/image.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/link.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/lists.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/table.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/video.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/url.min.js"></script>
<script type="text/javascript" src="../JS/froala/plugins/entities.min.js"></script>

<script>
    $(function(){
      $('#edit')
        .on('froalaEditor.initialized', function (e, editor) {
          $('#edit').parents('form')
        })
        .froalaEditor({
          enter: $.FroalaEditor.ENTER_P, 
          placeholderText: null,
          heightMin: 300})
    });
</script>

<script>
    $(function(){
      $('#edit-2')
        .on('froalaEditor.initialized', function (e, editor) {
          $('#edit-2').parents('form')
        })
        .froalaEditor({
          toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'insertTable', 'html'],
          toolbarButtonsMD: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'insertTable', 'html'],
          toolbarButtonsSM: ['undo', 'redo' , '-', 'bold', 'italic', 'underline'],
          toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic', 'underline'],
          enter: $.FroalaEditor.ENTER_P, 
          placeholderText: null,
          heightMin: 300})
    });
</script>