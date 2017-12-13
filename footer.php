<footer class="footer" role="contentinfo">
    <div id="inner-footer" class="grid-x">
        <div class="medium-1 cell"></div>
        <div class="medium-10 cell">
            <nav role="navigation">
				<?php zume_footer_links(); ?>
            </nav>

            <!--<p class="source-org copyright">
                &copy; <?php
/*	            // @codingStandardsIgnoreStart
                esc_html_e( date( 'Y' ), 'zume' )
	            // @codingStandardsIgnoreEnd
                */?>
                <?php /*bloginfo( 'name' ); */?>.
            </p>-->
        </div>
        <div class="medium-1 cell"></div>
    </div> <!-- end #inner-footer -->
</footer> <!-- end .footer -->
</div>  <!-- end .main-content -->
</div> <!-- end .off-canvas-wrapper -->
<?php wp_footer(); ?>
</body>
</html> <!-- end page -->
