<footer class="footer" role="contentinfo">
    <div id="inner-footer" class="grid-x">
        <div class="medium-1 cell"></div>
        <div class="medium-10 cell">
            <p class="source-org copyright">
                <span>
                    <a href="https://www.facebook.com/zumeproject" target="_blank" rel="noopener"><img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/images//facebook-square.svg" style="height: 23px" title="Facebook"></a>
                    <a href="https://twitter.com/zumeproject" target="_blank" rel="noopener"><img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/images/twitter-square.svg" style="height: 23px" title="Twitter"></a>
                </span> &copy; <?php echo esc_html( date( 'Y' ) ); ?> Zúme Project
            </p>
            <nav role="navigation">
                <?php zume_footer_links(); ?>
            </nav>
            <br><br><br>
        </div>
        <div class="medium-1 cell"></div>
    </div> <!-- end #inner-footer -->
</footer> <!-- end .footer -->
</div>  <!-- end .main-content -->
</div> <!-- end .off-canvas-wrapper -->
<?php wp_footer(); ?>
</body>
</html> <!-- end page -->
