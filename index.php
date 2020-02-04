<?php
        require 'core.php';

        $ShoudlDoJob = FALSE;
        $AnyError = [];

        if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['url'] ) && !empty( $_POST['url'] ) ) {

                $url = $_POST['url'];
                $term = NULL;
                $ShoudlDoJob = TRUE;

                // define term
                if( isset( $_POST['term'] ) && !empty( $_POST['term'] ) ) {
                        $term = $_POST['term'];
                }

                // define access to target location
                if (!CheckDestination($url)) {
                        $ShoudlDoJob = FALSE;
                        $AnyError[] = 'Destination not reachable.';
                }

        }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Downloader :)</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
       <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.3.0/dist/css/uikit.min.css" />

        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.3.0/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.3.0/dist/js/uikit-icons.min.js"></script>
    </head>
    <body>
        <div class="uk-container uk-container-center uk-margin-top">
                <!-- navbar -->
                <nav class="uk-navbar-container uk-margin" uk-navbar>
                        <div class="uk-navbar-left">
                                <a class="uk-navbar-item uk-logo" href="">Home</a>
                        </div>
                        <div class="uk-navbar-right">
                                <ul class="uk-navbar-nav">
                                <li>
                                <a href="https://github.com/arbazargani/GetLinkByTerm">
                                <span class="uk-icon uk-margin-small-right" uk-icon="icon: github"></span>
                                </a>
                                </li>
                                </ul>
                        </div>
                </nav>
                <!-- end of navbar -->
                <div class="uk-card uk-card-default uk-card-body uk-margin-top">
                    <h3 class="uk-card-title">
                            <p>
                                <span uk-icon="icon: cog"></span> Settings
                            </p>
                    </h3>
                    <div class="container">
                        <form method="POST">
                                <input class="uk-input uk-width-1-3" type="text" name="url" placeholder="Target url">
                                <input class="uk-input uk-width-1-3" type="text" name="term" placeholder="Filter term">
                                <button class="uk-button uk-button-secondary uk-width-auto">Apply</button>
                        </form>
                    </div>
                    <hr>
                    <div class="contaniner uk-padding-small">
                        <?php if($ShoudlDoJob): ?>
                        <ol>
                                <?php $data = DoJob($url, $term); ?>
                                <?php foreach ($data as $key => $value): ?>
                                        <li><?php echo $value; ?></li>
                                <?php endforeach;   ?>
                        </ol>
                        <script>
                                UIkit.notification({
                                    message: '<?php echo count($data); ?> items fetched.',
                                    status: 'primary',
                                    pos: 'bottom-right',
                                    timeout: 5000
                                });
                        </script>
                        <?php else: ?>
                                <?php if(count($AnyError) == 0): ?>
                                        <div class="uk-alert-primary" uk-alert>
                                            <p>Please add target url to start.</p>
                                        </div>
                                <?php else: ?>
                                        <div class="uk-alert-danger" uk-alert>
                                            <?php foreach($AnyError as $error): ?>
                                                <p><?php echo $error; ?></p>
                                            <?php endforeach; ?>
                                        </div>
                                <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
    </body>
</html>