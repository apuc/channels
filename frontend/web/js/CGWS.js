/**
 * Created by apuc0 on 18.04.2018.
 */
function CGWS(options) {

    this.init = function (options) {

        var defaultOptions = {
            url: '',
            onopen: function () {
                alert("Соединение установлено.");
            },
            onclose: function (event) {
                if (event.wasClean) {
                    alert('Соединение закрыто чисто');
                } else {
                    alert('Обрыв соединения'); // например, "убит" процесс сервера
                }
                console.log(event);
                alert('Код: ' + event.code + ' причина: ' + event.reason);
            },
            onmessage: function (event) {
                alert("Получены данные " + event.data);
            },
            onerror: function (error) {
                alert("Ошибка " + error.message);
            }
        };

        this.options = setOptions(defaultOptions, options);

        this.socket = new WebSocket(this.options.url);

        this.socket.onopen = this.options.onopen;

        this.socket.onclose = this.options.onclose;

        this.socket.onmessage = this.options.onmessage;

        this.socket.onerror = this.options.onerror;
    };

    this.sendMsg = function (msg) {
        this.socket.send(msg);
    };

    function setOptions(defaultOptions, options) {
        var finalParams = defaultOptions;
        for (var key in options) {
            if (options.hasOwnProperty(key)) {
                if (options[key] !== undefined) {
                    finalParams[key] = options[key];
                }
            }
        }

        return finalParams;
    };
}