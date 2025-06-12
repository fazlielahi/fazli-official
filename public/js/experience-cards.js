$(function () {
    $('.material-card').materialCard({
        icon_close: 'fa-chevron-left',
        icon_open: 'fa-regular fa-eye',
        icon_spin: 'fa-spin-fast',
        card_activator: 'click'
    });

    //        $('.active-with-click .material-card').materialCard();

    window.setTimeout(function () {
        $('.material-card:eq(1)').materialCard('open');
    }, 2000);

    $('.material-card').on('shown.material-card show.material-card hide.material-card hidden.material-card', function (event) {
        console.log(event.type, event.namespace, $(this));
    });

});