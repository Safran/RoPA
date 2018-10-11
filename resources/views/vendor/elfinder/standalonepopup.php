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
        <link rel="stylesheet" type="text/css" href="<?= asset($dir . '/css/elfinder.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= asset($dir . '/css/theme.css') ?>">

        <!-- elFinder JS (REQUIRED) -->
        <script src="<?= asset($dir . '/js/elfinder.min.js') ?>"></script>

        <?php if ($locale)
        { ?>
            <!-- elFinder translation (OPTIONAL) -->
            <script src="<?= asset($dir . "/js/i18n/elfinder.$locale.js") ?>"></script>
        <?php } ?>
        <!-- Include jQuery, jQuery UI, elFinder (REQUIRED) -->

        <script type="text/javascript">
            $().ready(function () {
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
                    dialog: {width: 900, modal: true, title: 'Select a file'},
                    resizable: false,
                    commandsOptions: {
                        getfile: {
                            oncomplete: 'destroy'
                        }
                    },
                    getFileCallback: function (file) {
                        window.parent.processSelectedFile(file.url, '<?= $input_id?>');
                        parent.jQuery.colorbox.close();
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
