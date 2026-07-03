

class MaxMiniApp {
    constructor(web_app) {
        this.max_route_action = '/api/v1/max/action';
        this.webApp = web_app;
        this.maxInit();
    }

    maxInit() {
        const nameBlock = document.getElementById("name");
        if (this.webApp.initDataUnsafe.user) {
            nameBlock.textContent = this.webApp.initDataUnsafe.user.first_name + ' !!!';
            // window.WebApp.close();
            this.action('main');
        } else {
            nameBlock.textContent = 'Undefined';
        }
    }

    action(action, data = []) {
        $.ajax({
            async: true,
            type: 'POST',
            url: max_route_action,
            data: {
                action: action,
                data: data,
                init_data: window.WebApp.initDataUnsafe,
                platform: window.WebApp.platform
            }
        }).done(function (resp) {
            if (resp.status) {
                document.getElementById("app").innerHTML = resp.body
            }
        });
    }

    test() {
        alert(123);
    }
}

$(function() {
    const max = new MaxMiniApp(window.WebApp);
});
