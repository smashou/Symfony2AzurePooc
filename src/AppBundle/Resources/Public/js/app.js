;jQuery(function () {
    'use-strict';

    $.fn.collection = function () {
        $(this).each(function onEachDataPrototypeDiv(pos) {
            var $div = $(this);
            var index = $(this).data('count');
            var $addButtons = $('.collection_add').eq(pos);
            var prototype = $(this).data('prototype');

            var bindRemove = function () {
                $div.find('.collection_remove').each(function onEachDeleteButton () {
                    $(this).unbind('click').bind('click', removeForm);
                });
            };

            var addForm = function () {
                console.log("test");
                var $form = $(prototype.replace(/__name__/g, index));
                $div.append($form);
                $div.attr('data-count', index++);

                bindRemove();
            };

            var removeForm = function () {
                $(this).parent().remove();
            };

            bindRemove();
            $addButtons.click(addForm);
        });
    };

    $('div[data-prototype]').collection();
});
