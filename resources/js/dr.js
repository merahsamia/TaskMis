$(document).ready(function() {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');

        // Vérifier la direction du texte
        if ($('html').attr('dir') === 'rtl') {
            // Ajuster la position du bouton
            $(this).css('float', 'left');
        }
    });

    $('#navbarCollapse').on('click', function () {
        $('#navbarSupportedContent').toggleClass('collapse');

        // Vérifier la direction du texte
        if ($('html').attr('dir') === 'rtl') {
            // Ajuster la position du bouton navbarCollapse si nécessaire
            $(this).css('float', 'right'); // Par exemple, vous pouvez ajuster la position du bouton navbarCollapse pour le mode RTL
        }
    });
});
