<?php /** Logged in */ if ( is_user_logged_in() ) : ?>

    <hr>
    <div class="grid-x grid-margin-x grid-margin-y">
        <div class="small-12 small-centered cell center">
            You are logged in.<br>
            This concept comes from session 5 of  <a href="#">Zume Training</a><br>
            <a href="<?php echo zume_dashboard_url( ) ?>" class="button large">Return to Training</a> <a href="" class="button large">Start Session 5</a>
        </div>
    </div>

<?php endif; ?>

<?php /** Not logged in */ if ( ! is_user_logged_in() ) : ?>

    <hr>
    <div class="grid-x grid-margin-x grid-margin-y">
        <div class="small-12 small-centered cell center">
            You've heard the concept. We challenge you to live it, share it, and train others!<br>
            You should log in.
        </div>
    </div>

<?php endif; ?>
