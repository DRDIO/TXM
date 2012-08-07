$(function() {
    $('.block ul a')
        .mouseenter(function() {
            $('.clone').remove();

            var self  = $(this);
            var clone = $('<div />', { 'class': 'clone' });

            self
                .clone()
                .css({'width': self.width()})
                .appendTo(clone);

            clone
                .appendTo(self)
                .css({
                    'border-left': (self.width() * 0.025 + 0) + 'px solid rgba(0,0,0,0.25)',
                    'border-right': (self.width() * 0.025 + 0) + 'px solid rgba(0,0,0,0.25)',
                    'border-top': (self.height() * 0.025 + 0) + 'px solid rgba(0,0,0,0.25)',
                    'border-bottom': (self.height() * 0.025 + 0) + 'px solid rgba(0,0,0,0.25)'
                })
                .position({
                    my: 'center',
                    at: 'center',
                    of: self
                });
        })
        .mouseleave(function() {
            $('.clone').remove();
        });
});
