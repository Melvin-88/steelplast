( function () {
    'use strict';

    const steps = document.querySelector( '.sp-collab__steps' );
    if ( ! steps ) return;

    const observer = new IntersectionObserver(
        function ( entries ) {
            if ( entries[ 0 ].isIntersecting ) {
                setTimeout( function () {
                    steps.classList.add( 'sp-collab__steps--animated' );
                }, 400 );
                observer.disconnect();
            }
        },
        { threshold: 0.3 }
    );

    observer.observe( steps );
} )();
