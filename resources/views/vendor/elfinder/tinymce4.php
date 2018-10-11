<!DOCTYPE html>
<html lang="<?= app()->getLocale() ?>">
    <head>
        <meta charset="utf-8">
        <title>elFinder 2.0</title>

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" href="{{ asset('/ckeditor/css/jquery-ui.css') }}" />
        <script src="{{ asset('/ckeditor/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/ckeditor/js/jquery-ui.min.js') }}"></script>


        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/elfinder.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= asset($dir.'/css/theme.css') ?>">

        <!-- elFinder JS (REQUIRED) -->
        <script src="<?= asset($dir.'/js/elfinder.min.js') ?>"></script>

        <?php if($locale){ ?>
            <!-- elFinder translation (OPTIONAL) -->
            <script src="<?= asset($dir."/js/i18n/elfinder.$locale.js") ?>"></script>
        <?php } ?>
        
        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript">
            var FileBrowserDialogue = {
                init: function() {
                    // Here goes your code for setting your custom things onLoad.
                },
                mySubmit: function (URL) {
                    // pass selected file path to TinyMCE
                    parent.tinymce.activeEditor.windowManager.getParams().setUrl(URL);

                    // close popup window
                    parent.tinymce.activeEditor.windowManager.close();
                }
            };

            $().ready(function() {
                var elf = $('#elfinder').elfinder({
                    // set your elFinder options here
                    <?php if($locale){ ?>
                        lang: '<?= $locale ?>', // locale
                    <?php } ?>
                    customData: { 
                        _token: '<?= csrf_token() ?>'
                    },
                    url: '<?= route("elfinder.connector") ?>',  // connector URL
                    soundPath: '<?= asset($dir.'/sounds') ?>',
                    getFileCallback: function(file) { // editor callback
                        FileBrowserDialogue.mySubmit(file.url); // pass selected file path to TinyMCE
                    }
                }).elfinder('instance');
            });
        </script>
    </head>
    <body>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
