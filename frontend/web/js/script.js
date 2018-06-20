/**
 * Created by apuc0 on 22.04.2018.
 */
document.addEventListener('DOMContentLoaded', function(){

    // var cgws = new CGWS();
    // cgws.init({
    //     url: "ws://194.247.179.153:8765",
    //     onmessage: function (event) {
    //         console.log("Получены данные " + event.data);
    //     }
    // });

    var channel = new Channel();
    channel.init({
        userId: userId,
        chatId: chatId,
        partnerId: partnerId,
        socket: {
            class: new CGWS(),
            url: "ws://127.0.0.1:2346/?user_id=" + userId,
            onmessage: function (event) {
                console.log("Получены данные " + event.data);
            }
        }
    });

    var startD = document.getElementById('startDialog');
    if(startD){
        startD.onclick = function (e) {
            var userId = document.getElementById('partnerId');
            if(userId.value){
                document.location.href = '/pers/' + userId.value;
            }
        };
    }


});
