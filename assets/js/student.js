document.addEventListener("DOMContentLoaded", function(event) {
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId)

        // Validate that all variables exist
        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener('click', () => {
                // Show navbar
                nav.classList.toggle('show')
                // Change icon
                toggle.classList.toggle('bx-x')
                // Add padding to body
                bodypd.classList.toggle('body-pd')
                // Add padding to header
                headerpd.classList.toggle('body-pd')
            })
        }
    }

    showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')
    const linkColor = document.querySelectorAll('.nav_link')

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove(  'active'))
            this.classList.add('active')
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink))

    const navLinks = document.querySelectorAll('.nav_link');
    // header text
    const linkTitleElement = document.querySelectorAll('.link-title');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const title = this.getAttribute('data-title');
            linkTitleElement.textContent = title;

            const contents = document.querySelectorAll('.content');
            contents.forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(targetId).classList.add('active');
        });
    });

    /*===== HIDE SIDEBAR ON LINK CLICK =====*/
    const hideSidebar = () => {
        const nav = document.getElementById('nav-bar');
        if (nav.classList.contains('show')) {
            nav.classList.remove('show');
            document.getElementById('header-toggle').classList.remove('bx-x');
            document.getElementById('body-pd').classList.remove('body-pd');
            document.getElementById('header').classList.remove('body-pd');
        }
    };

    document.querySelectorAll('.nav_link').forEach(link => {
        link.addEventListener('click', hideSidebar);
    });

    /*===== CLOSE BUTTON TOGGLE SIDEBAR =====*/
    const closeBtn = document.getElementById('nav-close-btn');
    closeBtn.addEventListener('click', () => {
        const nav = document.getElementById('nav-bar');
        nav.classList.remove('show');
        document.getElementById('header-toggle').classList.remove('bx-x');
        document.getElementById('body-pd').classList.remove('body-pd');
        document.getElementById('header').classList.remove('body-pd');
    });

});




/*
*
*
*  ***********   PERSONAL DETAILS FROM  ************
*
*/

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';

    function applyValidation(forms) {
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    }

    var personalDetailsForms = document.querySelectorAll('.personal-details-form');
    applyValidation(personalDetailsForms);

    var addressForms = document.querySelectorAll('.address-form');
    applyValidation(addressForms);

    var basicDetailForm = document.querySelectorAll('.basic-details-form');
    applyValidation(basicDetailForm);

    var parentsDetails = document.querySelectorAll('.parents-details-form');
    applyValidation(parentsDetails);

    var academicDetails = document.querySelectorAll('.academic-details-form');
    applyValidation(academicDetails);

})();
