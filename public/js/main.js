$( document ).ready(function() {
    $('.delete-btn-modal').click(function () {
        let productId = $(this).data('product_id');
        let href = $('#delete-link').attr('href');
        $('#delete-link').attr('href', href + '/' + productId);
    });


    $('.search').change(function () {
        let searchString = $('.search').val();
        window.location.href = $('.search').data('url') + '/' + searchString;
    });

    $('.add-property').click(function () {
        let propertyKey = $('.input-group').length;

        $('.new-properties').after('<div class="form-group input-group">\n' +
            '<input type="text" class="form-control"\n' +
            '       name="property['+propertyKey+'][name]">\n' +
            '\n' +
            '\n' +
            '<input type="text" class="form-control"\n' +
            '       name="property['+propertyKey+'][value]">\n' +
            '<input type="button" value="X" class="btn btn-danger delete-property">' +
            '</div>')
    });

    $('body').on('click', '.delete-property', function () {
        $(this).parent().remove();
    });
});

