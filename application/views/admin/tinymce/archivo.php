<!DOCTYPE HTML> 
<head>
<link rel="stylesheet" type="text/css" media="screen" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" ></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>elfinder/css/elfinder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>elfinder/css/theme.css"/>
 
<script src="<?php echo base_url(); ?>elfinder/js/elfinder.min.js"></script>

 
<script>
    var FileBrowserDialogue = {
        mySubmit: function (URL) {
          top.tinymce.activeEditor.windowManager.getParams().setUrl(URL);
          top.tinymce.activeEditor.windowManager.close();
        }
      }
       
    var base_url = '<?php echo base_url()?>';
    $().ready(function() {
        var elf = $('#file-manager').elfinder({
            url : base_url + 'admin/multimedia/media_ajax',
            getFileCallback: function(file) {
              
            FileBrowserDialogue.mySubmit(file);
          }
        }).elfinder('instance');
    });
</script>
</head>
<body
<div id="file-manager"></div>
</body>
</html>