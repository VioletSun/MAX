const max_route_action = '/api/v1/max/action';

function maxInit() {
    if (window.WebApp) {
        // alert(window.WebApp.initData.user);
        document.getElementById("name").textContent = window.WebApp.initDataUnsafe.user.first_name;
        setTimeout(function () {
            window.WebApp.close();
        }, 3000)
        // document.getElementById("text").textContent = window.WebApp.initData.user;
        $.ajax({
            async: true,
            type: 'POST',
            url: max_route_action,
            data: window.WebApp.initDataUnsafe
        }).done(function (resp) {
            //
        });
    } else {
        $.ajax({
            async: true,
            type: 'POST',
            url: max_route_action,
            data: {
                WebApp: 'not found'
            }
        }).done(function (resp) {
            //
        });
    }
}
$(function() {
    maxInit();
});
