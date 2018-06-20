/**
 * Created by apuc0 on 18.04.2018.
 */
function Channel() {

    this.init = function (options) {
        var defaultOptions = {
            socket: {
                class: null,
                url: '',
                onopen: function () {
                    //alert("Соединение установлено.");
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
            },
            userId: null,
            chatId: null,
            partnerId: null,
            box: '#app',
            leftSidebar: '#interlocutors__list',
            sidebarItem: '.interlocutors__user',
            subMenu: '#menu__submenu',
            mainContent: '#channelContent',
            msgBox: '#chat__body',
            msgArea: '#chat__input-hidden',
            msgAreaHidden: '#chat__input-hidden_',
            msgBtn: '#chat__send-btn',
            btnActionMenu: '#menu__hamburger',
            getMsgTpl: function (data) {
                return '<div class="chat__message chat__msg-from-' + data.class + '"><div class="chat__user"><img src="/img/icons/user2.png" alt="icon interlocutor" class="chat__user-icon"><span class="chat__msg-time">' + data.date + '</span></div><div class="chat__msg-text">' + data.text + '</div></div>';
                //return '<div class="msgBox_item ' + data.class + '"><div>' + data.user + ' ' + data.date + '</div><div>' + data.text + '</div></div>';
            },
            beforeSend: function (msg) {
                //console.log(msg);
            }
        };

        this.options = setOptions(defaultOptions, options);

        this.box = this.getElement(this.options.box);
        this.leftSidebar = this.getElement(this.options.leftSidebar);
        this.mainContent = this.getElement(this.options.mainContent);
        this.msgBox = this.getElement(this.options.msgBox);
        if (this.msgBox){
            this.msgBox.scrollTop = this.msgBox.scrollHeight;
        }
        this.msgArea = this.getElement(this.options.msgArea);
        this.msgAreaHidden = this.getElement(this.options.msgAreaHidden);
        if(this.msgArea){
            this.msgArea.onkeydown = this.msgAreaKD.bind(this);
        }
        this.msgBtn = this.getElement(this.options.msgBtn);
        this.btnActionMenu = this.getElement(this.options.btnActionMenu);
        this.setToggle();

        if(this.msgBtn){
            this.msgBtn.onclick = this.sendMsg.bind(this);
        }

        if (this.options.socket.class !== null) {
            this.options.socket.class.init({
                url: this.options.socket.url,
                onmessage: this.onmessage.bind(this),
                onopen: this.onopen.bind(this)
            });
        }
    };

    this.sendMsg = function (e) {
        this.options.beforeSend(this.msgArea.value);
        var msg = {
            action: 'sendMsg',
            userId: this.options.userId,
            chatId: this.options.chatId,
            partnerId: this.options.partnerId,
            msg: this.msgArea.innerHTML
        };
        this.options.socket.class.sendMsg(JSON.stringify(msg));
        this.msgArea.value = '';
    };

    this.onmessage = function (event) {
        var data = JSON.parse(event.data);
        for (var i = 0; i < data.length; i++) {
            if (this.options.chatId !== null) {
                if (parseInt(data[i].chatId) === this.options.chatId) {
                    console.log(data[i]);
                    this.addMsgToBox({
                        user: data[i].fromUser,
                        date: data[i].dt_text,
                        class: parseInt(data[i].from) === this.options.userId ? 'my' : 'interlocutor',
                        text: data[i].textMsg
                    });
                }
            }
            if (this.options.partnerId !== null) {
                if ((parseInt(data[i].to) === this.options.userId && parseInt(data[i].from) === this.options.partnerId)
                    || (parseInt(data[i].to) === this.options.partnerId && parseInt(data[i].from) === this.options.userId)) {
                    this.addMsgToBox({
                        user: data[i].fromUser,
                        date: data[i].dt_text,
                        class: parseInt(data[i].userId) === this.options.userId ? 'my' : 'interlocutor',
                        text: data[i].textMsg
                    });
                }
            }
        }
        //console.log(data);
    };

    this.onopen = function () {
        this.options.socket.onopen();
    };

    this.addMsgToBox = function (data) {
        var msgTpl = this.options.getMsgTpl(data);
        this.msgBox.append(this.createHtmlFromText(msgTpl));
        this.msgBox.scrollTop = this.msgBox.scrollHeight;
    };

    this.createHtmlFromText = function (text) {
        var d = document.createElement('div');
        d.innerHTML = text;
        return d.firstChild;
    };

    this.msgAreaKD = function (e) {
        //var span = this.msgArea.querySelector('span');
        // if (e.keyCode === 13 && !e.ctrlKey) {
        //     this.sendMsg();
        //     return false;
        // }
        if (e.keyCode === 13 && e.ctrlKey) {
            //console.log(this.msgArea.querySelector('span'));
            //span.innerHTML += "\n";
            this.sendMsg();
            this.msgArea.innerHTML = '';
            return false;
        }
        this.msgAreaHidden.value = this.msgArea.innerHTML;
        //return false;
    };

    this.toggle = function (e) {
        var el = this.getElement('#' + e.target.getAttribute('data-toggle-target'));
        var display;
        if(e.target.hasAttribute('data-display-target')){
            display = e.target.getAttribute('data-display-target');
        }
        else {
            display = 'block';
        }
        var style = getComputedStyle(el);
        if (style.display === 'none') {
            el.style.display = display;
        }
        else {
            el.style.display = 'none';
        }
    };

    this.setToggle = function () {
        var arr = this.getElementsByAttr('data-toggle-target');
        for (var i = 0; i < arr.length; i++) {
            arr[i].onclick = this.toggle.bind(this);
        }
    };

    function setOptions(defaultOptions, options) {
        var finalParams = defaultOptions;
        for (var key in options) {
            if (typeof options[key] === "object" && key !== "class") {
                finalParams[key] = setOptions(finalParams[key], options[key]);
            }
            else {
                if (options.hasOwnProperty(key)) {
                    if (options[key] !== undefined) {
                        finalParams[key] = options[key];
                    }
                }
            }
        }

        return finalParams;
    }

    this.getElement = function (el) {
        var thisElement;
        if (el[0] === '#') {
            thisElement = document.getElementById(el.slice(1));
        }
        else {
            thisElement = document.getElementsByClassName(el.slice(1));
        }
        return thisElement;
    };

    this.getElementsByAttr = function (attr) {
        var elems = document.getElementsByTagName('*');
        var arr = [];
        for (var i = 0; elems.length; i++) {
            if(typeof elems[i] === "object"){

                if (elems[i].hasAttribute(attr)) {
                    arr.push(elems[i]);
                }
            }
            else {
                break;
            }
        }
        return arr;
    };
}