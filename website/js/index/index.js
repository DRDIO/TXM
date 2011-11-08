$(function() {
    $('#txm-index-splash a').mouseenter(function() {
        var self = $(this);
        $('.txm-index-splash-clone').remove();

        self
            .clone()
            .appendTo('#txm-index-splash')
            .addClass('txm-index-splash-clone')
            .position({
                my: 'center',
                at: 'center',
                of: self,
                offset: '0 -3'
            });
    });

    $('#txm-index-splash')
        .mouseleave(function() {
            $('.txm-index-splash-clone').remove();
        });
});