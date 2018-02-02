function openModalAttributesMapForm($btn, $modalId) {
    var $modal = $($modalId);
    $modal.modal().show();
    $('input,textarea', $modal).each(function () {
        $(this).val('');
    });
    $('select', $modal).each(function () {
        var $default = $(this).data('default');
        var $select = $(this);
        $('option', $(this)).each(function () {
            if ($(this).val() == $default) {
                $(this).attr('selected', 'selected');
                $select.val($(this).val());
            }
        });
    });
}
/**
 * 
 * delete attribute
 * @param object $btn
 * @returns {undefined}
 */
function deleteAttributeMapItem($btn) {
    yii.confirm('Удалить атрибут? (также удаляются все его дочерние записи)', function () {
        var $data = $btn.data();
        $.ajax({
            async: true,
            url: $data.url,
            type: 'post',
            error: function (xhr) {
                mes(xhr.responseText, 'error');
            }
        }).done(function ($r) {
            var $response = JSON.parse($r);
            if ($response.result == 'success') {
                $.pjax.reload({container: "#attributesMapList"});  //Reload GridView
            }
            mes($response.message, $response.result);
        });
    });
}

/**
 * save attribute
 * @param object $btn
 * @returns {undefined}
 */
function saveAttributesMapValues($btn) {
    var $data = $btn.data();
    $.ajax({
        async: true,
        url: $data.url,
        type: 'post',
        data: {data: $('#' + $data.form).serialize()},
        error: function (xhr) {
            mes(xhr.responseText, 'error', 1000);
        }
    }).done(function ($r) {
        var $response = JSON.parse($r);
        if ($response.result == 'success') {
            $('body').removeClass('modal-open');
            $('.modal-backdrop.fade.in').remove();
            $('#' + $data.modal).modal().hide();
            $.pjax.reload({container: "#attributesMapList"});  //Reload GridView
        }
        mes($response.message, $response.result);
        console.log($response);
    });
}

/**
 * populate form with model values
 * @param object $btn
 * @returns {undefined}
 */
function updateAttributeMapItem($btn) {
    var $data = $btn.data();
    $.each($data.model, function ($k, $v) {
        var $modal = $('#attributeMapManagerModal');
        var $input = $('*[id*=' + $k + ']', $modal);
        $input.val($v);
        $input.trigger('change');
        $('.saveAttributesMapFormModal', $modal).data('url', $data.url);
        $modal.modal().show();
    });
}

/**
 * group with selector
 * @param object $el
 * @returns {undefined}
 */
function swithGroupWithDropDown($el) {
    var $data = $el.data();
    if ($data.group == $el.val()) {
        $('.group-with-container').slideDown();
    } else {
        $('.group-with-container').slideUp();
    }
}

/**
 * prevent self parent
 * @param {type} $el
 * @returns {undefined}
 */
function disableSelfParent($el) {
    var $id = $el.val();
    $('#attributesmap-group_with option, #attributesmap-parent option').removeAttr('disabled');
    $('#attributesmap-group_with option[value="' + $id + '"], #attributesmap-parent option[value="' + $id + '"]').attr('disabled', 'disabled');
    
//    mes($id);
}