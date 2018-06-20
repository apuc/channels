/**
 * Created by apuc0 on 19.06.2018.
 */
document.addEventListener('DOMContentLoaded', function(){
    //add
    $('.interlocutors__user').on('click', function () {
        var name = $(this).data('user-name');
        var id = $(this).data('user-id');
        var input = document.createElement('input');
        $(input).attr('type', 'hidden');
        $(input).attr('value', id);
        $(input).attr('id', 'input_user_' + id);
        $(input).attr('name', 'channelMembers[]');
        $('#membersInput').append($(input));
        $('#members').append('<span>'+name+' <a href="#" class="delMem" data-id="'+id+'"><img src="/img/icons/cross.png" alt="delete"></a></span>');
        $(this).remove();
    });

    $(document).on('click', '.delMem', function () {
        var id = $(this).data('id');
        $('#input_user_' + id).remove();
        $(this).parent().remove();
    });

    var up = new Uploader();
    var param = yii.getCsrfParam();
    var token = yii.getCsrfToken();

    up.init({
        btnSelect: '#channelAddPhoto',
        itemContainer: '#wrapperCont',
        fileInput: '#channelAddPhotoInput',
        itemWrapper: '.channelItemImg',
        itemImg: '.channelImg',
        uploadUrl: '/ajax/default/channel-ava',
        directlyUpload: true,
        //itemsCount: 1,
        uploadOnprogress: function (progress, item) {
            //console.log(progress);
            //console.log(item);
        },
        uploadSuccess: function (response, e, item) {
            console.log(e);
        },
        beforeUpload: function (item, formData) {
            formData.append(param, token);
        },
        maxSizeError: function (name, size) {
            console.log('Файл слишком большой', name, Math.round((size / 1024 / 1024)*100)/100 + ' мб.' );
        }
    });
});