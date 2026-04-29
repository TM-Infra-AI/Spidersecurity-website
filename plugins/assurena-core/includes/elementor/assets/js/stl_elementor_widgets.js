(function( $ ) {
    "use strict";

    jQuery(window).on('elementor/frontend/init', function (){
        if ( window.elementorFrontend.isEditMode() ) {
            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-blog.default',
                function( $scope ){ 
                    assurena_parallax_video();
                    assurena_blog_masonry_init();
                    assurena_carousel_slick(); 
                }
            );            
          

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-carousel.default',
                function( $scope ){ 
                    assurena_carousel_slick();  
                }
            );            

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-portfolio.default',
                function( $scope ){ 
                    assurena_isotope();
                    assurena_carousel_slick();  
                    assurena_scroll_animation();
                }
            );            

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-events.default',
                function( $scope ){ 
                    assurena_isotope();
                	assurena_carousel_slick();  
                    assurena_scroll_animation();
                    assurena_events_masonry_init();
                }
            );

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-progress-bar.default',
                function( $scope ){ 
                    assurena_progress_bars_init();  
                }
            ); 

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-testimonials.default',
                function( $scope ){ 
                	assurena_carousel_slick();  
                }
            );

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-toggle-accordion.default',
                function( $scope ){ 
                    assurena_accordion_init();  
                }
            ); 

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-team.default',
                function( $scope ){ 
                    assurena_isotope();
                    assurena_carousel_slick();  
                    assurena_scroll_animation();
                }
            );

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-tabs.default',
                function( $scope ){ 
                    assurena_tabs_init();  
                }
            ); 

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-clients.default',
                function( $scope ){ 
                	assurena_carousel_slick();  
                }
            );

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-image-layers.default',
                function( $scope ){ 
                	assurena_img_layers();  
                }
            );

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-video-popup.default',
                function( $scope ){ 
                    assurena_videobox_init();  
                }
            );            

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-countdown.default',
                function( $scope ){ 
                	assurena_countdown_init();  
                }
            );

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-time-line-vertical.default',
                function( $scope ){ 
                	assurena_init_timeline_appear();  
                }
            );


            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-image-comparison.default',
                function( $scope ){ 
                	assurena_image_comparison();  
                }
            );

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-counter.default',
                function( $scope ){ 
                	assurena_counter_init();  
                }
            );

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-header-menu.default',
                function( $scope ){ 
                    assurena_menu_lavalamp(); 
                    assurena_ajax_mega_menu();
                }
            );            

            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-header-search.default',
                function( $scope ){ 
                    assurena_search_init(); 
                }
            );            
            window.elementorFrontend.hooks.addAction( 'frontend/element_ready/stl-header-side_panel.default',
                function( $scope ){ 
                    assurena_side_panel_init(); 
                }
            );

        }
    });

})( jQuery );

