function syncAttributesGroup($el) {
    var $data = $el.data();
    var $group = $data.attributeGroupWith;
    if ($group > 0) {
        var $other = $('*[data-attribute-group-with=' + $group + ']').not($el);
        $other.each(function () {
            if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                $(this).prop('checked', false);
            } else {
                $(this).val('');
            }

            var $cData = $(this).data();
            var $id = $cData.id;

            var $childs = $('*[data-attribute-parent=' + $id + ']');
            $childs.each(function () {
                if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                    $(this).prop('checked', false);
                } else {
                    $(this).val('');
                }
            });

        });
    }
    $el.prop('checked', true);
}