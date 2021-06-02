<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?=site_path();?>dist/bootstrap-4.5.3-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?=site_path();?>dist/fontawesome-free-5.15.1-web/css/all.min.css" />
        <link rel="stylesheet" href="<?=site_path();?>dist/bootstrap-select-1.13.9/dist/css/bootstrap-select.min.css" />
        <link rel="stylesheet" href="<?=site_path();?>dist/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css" />
        <link rel="stylesheet" href="<?=site_path();?>css/style.css?v=383075116" />
        <title>{{SITE_TITLE}}</title>
        <script src="<?=site_path();?>dist/jquery-3.5.1.min.js"></script>
        <script src="<?=site_path();?>dist/bootstrap-4.5.3-dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?=site_path();?>dist/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js"></script>
        <script src="<?=site_path();?>dist/bootstrap-select-1.13.9/dist/js/i18n/defaults-pt_BR.js"></script>
        <script src="<?=site_path();?>dist/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="<?=site_path();?>dist/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
        <script src="<?=site_path();?>dist/jquery.priceformat.min.js"></script>
        <script src="<?=site_path();?>dist/sigx.mini.js"></script>
        <script src="<?=site_path();?>dist/moment.min.js"></script>
        <script src="<?=site_path();?>dist/moment-with-locales.min.js"></script>
        <script src="<?=site_path();?>dist/jquery.mask.min.js"></script>
        <script src="<?=site_path();?>js/main.js?v=663547052"></script>
    </head>
    <body>
        <div class="site">
            <?php display_header();?>
            <main>
                <div class="container">
                    <div class="col-12">
                        <h1 class="display-4">{{SITE_TITLE}}</h1>
                    </div>
                </div>
                {{SITE_BODY}}
            </main>
        </div>
    </body>
</html>