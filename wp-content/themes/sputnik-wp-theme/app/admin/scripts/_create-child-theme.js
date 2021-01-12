(function($) {
    $(document).ready(function() {
        function copyChildTheme() {
            const data = {
                'action': 'create_sputnik_wp_theme_child'
            };

            $.ajax({
                type: "post",
                dataType: "json",
                url: ajaxurl,
                data: data,
                success: function (response) {
                  if (response.type === "success") {
                      alert(response.message);

                      location.reload();
                  }
                },
            });
        }

        if($('.themes .theme')) {
            const sputnikTheme = $('.themes div[data-slug="sputnik-wp-theme"]');
            const sputnikThemeChild = $('.themes div[data-slug="sputnik-wp-theme-child"]');

            if(sputnikThemeChild.length == 0) {
                const sputnikChildThemeButton = $('<button id="js-create-child-theme" title="Utwórz motyw">Utwórz motyw <span>SPUTNIK WP THEME CHILD</span></button>');

                sputnikChildThemeButton.on('click', copyChildTheme);

                sputnikTheme.after(sputnikChildThemeButton);
            }
        }
    });
})(jQuery);