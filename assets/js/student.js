document.addEventListener("DOMContentLoaded", function(event) {
    // Show Navbar Function
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);

        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener('click', () => {
                nav.classList.toggle('show');
                toggle.classList.toggle('bx-x');
                bodypd.classList.toggle('body-pd');
                headerpd.classList.toggle('body-pd');
            });
        }
    };

    showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

    // Navigation Link Active Color
    const linkColor = document.querySelectorAll('.nav_link');

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink));

    // Navigation Links for Form Sections
    const navLinks = document.querySelectorAll('.nav_link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');

            const contents = document.querySelectorAll('.content');
            contents.forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(targetId).classList.add('active');
        });
    });

    // Hide Sidebar on Link Click
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

    // Close Button Toggle Sidebar
    const closeBtn = document.getElementById('nav-close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            const nav = document.getElementById('nav-bar');
            nav.classList.remove('show');
            document.getElementById('header-toggle').classList.remove('bx-x');
            document.getElementById('body-pd').classList.remove('body-pd');
            document.getElementById('header').classList.remove('body-pd');
        });
    }

    // Form Navigation
    const forms = document.querySelectorAll('.content');
    const nextButtons = document.querySelectorAll('.next-button');
    const previousButtons = document.querySelectorAll('.previous-button');

    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentForm = this.closest('.content');
            const nextForm = currentForm.nextElementSibling;
            if (nextForm && nextForm.classList.contains('content')) {
                currentForm.classList.remove('active');
                nextForm.classList.add('active');
            }
        });
    });

    previousButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentForm = this.closest('.content');
            const previousForm = currentForm.previousElementSibling;
            if (previousForm && previousForm.classList.contains('content')) {
                currentForm.classList.remove('active');
                previousForm.classList.add('active');
            }
        });
    });

    // Example form validation logic (if required)
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
});
