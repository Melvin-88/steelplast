( function () {
    'use strict';

    var grid = document.querySelector( '.sp-faq__grid' );
    if ( ! grid ) return;

    grid.addEventListener( 'click', function ( e ) {
        var toggle = e.target.closest( '.sp-faq__toggle' );
        if ( ! toggle ) return;

        var item = toggle.closest( '.sp-faq__item' );
        if ( ! item ) return;

        var isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';
        var answer = document.getElementById( toggle.getAttribute( 'aria-controls' ) );

        toggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
        item.classList.toggle( 'is-open', ! isOpen );
        if ( answer ) {
            answer.setAttribute( 'aria-hidden', String( isOpen ) );
        }
    } );
} )();
