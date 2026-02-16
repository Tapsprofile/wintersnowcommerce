    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <?php if (is_active_sidebar('footer-widget-area')) : ?>
                    <?php dynamic_sidebar('footer-widget-area'); ?>
                <?php endif; ?>
            </div>
            
            <div class="footer-bottom">
                <p class="copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
                </p>
                
                <nav class="footer-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class' => 'footer-menu',
                        'container' => false,
                        'fallback_cb' => false,
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
