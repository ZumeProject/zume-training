<footer class="footer" role="contentinfo">
    <div id="inner-footer" class="grid-x">
        <div class="medium-1 cell"></div>
        <div class="medium-10 cell center">

            <p class="source-org copyright hide-for-small-only" style="padding-top:50px; opacity:.3;">
                <span>
                    <a href="https://www.facebook.com/zumeproject" target="_blank" rel="noopener"><img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/images/facebook-square.svg" style="height: 23px" title="Facebook"></a>
                    <a href="https://twitter.com/zumeproject" target="_blank" rel="noopener"><img src="<?php echo esc_attr( get_template_directory_uri() ); ?>/assets/images/twitter-square.svg" style="height: 23px" title="Twitter"></a>
                </span> &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Zúme
            </p>
            <br><br><br>
        </div>
        <div class="medium-1 cell"></div>
    </div> <!-- end #inner-footer -->
</footer> <!-- end .footer -->
</div>  <!-- end .main-content -->
</div> <!-- end .off-canvas-wrapper -->


<!-- language selector modal -->
<div id="language-menu-reveal" class="reveal" data-reveal data-v-offset="0">
    <h3><img src="<?php echo zume_images_uri() ?>language.svg" style="width:25px;height:25px;" /> <?php esc_html_e("Language", 'zume' ) ?></h3>
    <hr>
    <table class="hover" id="language-table">
        <?php
        global $post;
        $post_slug = $post->post_name;
        $lang = zume_language_file();
        foreach( $lang as $item ){
            if ( 'en' === $item['code'] ) {
                $url = site_url();
            } else {
                $url = site_url() . '/' . $item['code'] . '/';
            }
            ?>
            <tr class="language-selector" data-url="<?php echo $url ?>" data-value="<?php echo $item['code'] ?>" id="row-<?php echo $item['code'] ?>">
                <td><?php echo $item['nativeName'] ?></td>
                <td><?php echo $item['enDisplayName'] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <script>
        jQuery(document).ready(function($){
            $('.language-selector').on('click', function(e){
                let lang = $(this).data('value')
                let url = $(this).data('url')
                $('.language-selector:not(#row-'+lang+')').fadeTo("fast", 0.33)
                window.location = url
            })
        })
    </script>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php wp_footer(); ?>

<?php
/**
 * Enable Zendesk by setting this variable to true at the top of the template or page.
 */
global $zendesk_enable;
if ( ! empty( $zendesk_enable )  && ( is_user_logged_in() || 'template-zume-login.php' !== basename( get_page_template() ) ) ) : ?>
<!-- Start of Zendesk Widget script -->
<script>/*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","zume.zendesk.com");/*]]>*/</script>
<!-- End of Zendesk Widget script -->
<?php endif; ?>




</body>
</html> <!-- end page -->
