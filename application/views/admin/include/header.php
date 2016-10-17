<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>

        <title>PersonalizedCoins Admin - Dashboard</title>

        <meta charset="utf-8" />
        <meta name="description" content="" />
        <meta name="author" content="" />		
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="<?php echo base_url() ?>assets/tinymce/tinymce.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/all.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/stylesheets/jquery-ui-1.8.13.custom.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/stylesheets/dashboard.css" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/javascripts/all.js"></script>

        


        <!--        	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>-->

        <!--[if gte IE 9]>
        <link rel="stylesheet" href="stylesheets/ie9.css" type="text/css" />
        <![endif]-->

        <!--[if gte IE 8]>
        <link rel="stylesheet" href="stylesheets/ie8.css" type="text/css" />
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <div id="header">
                <h1><a href="<?php echo site_url() ?>admin/dashboard/">Canvas Admin</a></h1>		

                <a href="javascript:;" id="reveal-nav">
                    <span class="reveal-bar"></span>
                    <span class="reveal-bar"></span>
                    <span class="reveal-bar"></span>
                </a>
            </div> <!-- #header -->
<!--            <script>
                CKEDITOR.replace('editor1', {
                    fullPage: true,
                    allowedContent: true,
                    filebrowserBrowseUrl : '<?php //echo base_url().'admin/ex_cont/elfinder_init';   ?>'
                });
            </script>-->
            >
            <script type="text/javascript">
                function elFinderBrowser(field_name, url, type, win) {
                    tinymce.activeEditor.windowManager.open({
                        file: '<?php echo base_url() ?>admin/multimedia/archivos',
                        title: 'Archive Media',
                        width: 900,
                        height: 450,
                        resizable: 'yes'
                    }, {
                        setUrl: function(url) {

                            win.document.getElementById(field_name).value = url;
                        }
                    });
                    return false;
                }


            </script>
            <script>
                tinymce.init({
                    selector: ".ckeditor",
                    theme: "modern",
                    file_browser_callback: elFinderBrowser,
                    plugins: [
                        "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "table contextmenu directionality emoticons template textcolor paste fullpage textcolor",
                        "link image code"
                    ],
                    toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
                    toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | inserttime preview | forecolor backcolor",
                    toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",
                    menubar: false,
                    toolbar_items_size: 'small',
                    style_formats: [
                        {title: 'Bold text', inline: 'b'},
                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                        {title: 'Table styles'},
                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                    ],
                    templates: [
                        {title: 'Test template 1', content: 'Test 1'},
                        {title: 'Test template 2', content: 'Test 2'}
                    ]


                });
                tinymce.init({
                    selector: '.ckeditor',
                    plugins: 'link image code',
                    relative_urls: false,
                });
            </script>
            <div id="file-manager"></div>