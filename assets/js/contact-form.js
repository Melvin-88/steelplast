( function () {
    'use strict';

    // ── Validation helpers ────────────────────────────────────────

    function isValidEmail( val ) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( val );
    }

    function showError( field, msg ) {
        const wrap = field.closest( '.sp-form-field' );
        if ( ! wrap ) return;
        wrap.classList.add( 'sp-has-error' );
        const errEl = wrap.querySelector( '.sp-form-error' );
        if ( errEl ) errEl.textContent = msg;
    }

    function clearError( field ) {
        const wrap = field.closest( '.sp-form-field' );
        if ( ! wrap ) return;
        wrap.classList.remove( 'sp-has-error' );
        const errEl = wrap.querySelector( '.sp-form-error' );
        if ( errEl ) errEl.textContent = '';
    }

    function validateForm( form, itiInstance ) {
        const nameInput  = form.querySelector( '[name="sp_name"]' );
        const emailInput = form.querySelector( '[name="sp_email"]' );
        const phoneInput = form.querySelector( '[name="sp_phone"]' );
        const globalErr  = form.querySelector( '.sp-form-global-error' );

        let valid = true;

        // Name required
        if ( ! nameInput.value.trim() ) {
            showError( nameInput, spContact.i18n.nameRequired );
            valid = false;
        } else {
            clearError( nameInput );
        }

        // Email or phone — at least one required
        const emailVal   = emailInput.value.trim();
        const phoneVal   = phoneInput.value.trim();
        const emailFilled = emailVal !== '';
        const phoneFilled = phoneVal !== '';

        if ( ! emailFilled && ! phoneFilled ) {
            showError( emailInput, spContact.i18n.emailOrPhone );
            clearError( phoneInput );
            valid = false;
        } else {
            if ( emailFilled && ! isValidEmail( emailVal ) ) {
                showError( emailInput, spContact.i18n.emailInvalid );
                valid = false;
            } else {
                clearError( emailInput );
            }

            if ( phoneFilled && itiInstance && ! itiInstance.isValidNumber() ) {
                showError( phoneInput, spContact.i18n.phoneInvalid );
                valid = false;
            } else {
                clearError( phoneInput );
            }
        }

        if ( globalErr ) globalErr.textContent = '';
        return valid;
    }

    // ── AJAX submit ───────────────────────────────────────────────

    function submitForm( form, itiInstance ) {
        const btn       = form.querySelector( '.sp-contact-btn' );
        const successEl = form.querySelector( '.sp-form-success' );
        const globalErr = form.querySelector( '.sp-form-global-error' );
        const data      = new FormData( form );

        // Replace raw phone value with full international number
        if ( itiInstance ) {
            const phoneInput = form.querySelector( '[name="sp_phone"]' );
            if ( phoneInput && phoneInput.value.trim() ) {
                data.set( 'sp_phone', itiInstance.getNumber() );
            }
        }

        data.append( 'action', 'sp_contact_submit' );
        btn.disabled = true;

        fetch( spContact.ajaxUrl, {
            method: 'POST',
            body: data,
            credentials: 'same-origin',
        } )
            .then( ( r ) => r.json() )
            .then( ( res ) => {
                if ( res.success ) {
                    form.reset();
                    if ( itiInstance ) itiInstance.setNumber( '' );
                    if ( successEl ) successEl.hidden = false;
                    btn.disabled = false;
                } else {
                    const msg = res.data && res.data.message ? res.data.message : spContact.i18n.serverError;
                    if ( globalErr ) globalErr.textContent = msg;
                    btn.disabled = false;
                }
            } )
            .catch( () => {
                if ( globalErr ) globalErr.textContent = spContact.i18n.serverError;
                btn.disabled = false;
            } );
    }

    // ── Init single form ──────────────────────────────────────────

    function initForm( form ) {
        const phoneInput = form.querySelector( '[name="sp_phone"]' );
        let itiInstance  = null;

        if ( phoneInput && window.intlTelInput ) {
            itiInstance = window.intlTelInput( phoneInput, {
                initialCountry:       'ua',
                strictMode:           true,
                separateDialCode:     true,
                formatOnDisplay:      true,
                countrySearch:        true,
                placeholderNumberType:'MOBILE',
                loadUtilsOnInit:      false,
            } );
        }

        form.addEventListener( 'submit', function ( e ) {
            e.preventDefault();
            if ( ! validateForm( form, itiInstance ) ) return;
            submitForm( form, itiInstance );
        } );

        form.querySelectorAll( '.sp-form-input' ).forEach( function ( input ) {
            input.addEventListener( 'input', function () {
                clearError( input );
            } );
        } );
    }

    // ── Init all forms ────────────────────────────────────────────

    function init() {
        document.querySelectorAll( '.sp-contact-form' ).forEach( initForm );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', init );
    } else {
        init();
    }
} )();
