//
// GK Speakers Widget
//
jQuery(window).load(function () {
    jQuery(document).find('.widget_gk_speakers').each(function (i, widget) {
        new GK_Speakers(jQuery(widget));
    });
});

function GK_Speakers(widget) {
    this.$G = null;
    this.current_offset = 0;
    this.anim_interval = 0;
    this.current = 0;
    this.total = 0;
    this.items = [];
    this.availableItems = null;
    this.hover = false;
    this.current_offset = 0;
    this.anim_interval = parseInt(widget.find('.gkw-speakers').attr('data-animinterval'),10);
    this.anim_speed = parseInt(widget.find('.gkw-speakers').attr('data-animspeed'),10);
    this.current = 4;
    this.total = widget.find('.gkw-rest-speakers .gkw-speaker').length;

    // if there is more than 5 slides
    if (this.total > 5) {
        // prepare handlers
        this.items[0] = widget.find('.gkw-speakers-small-left .gkw-speaker-small').first();
        this.items[1] = widget.find('.gkw-speakers-small-left .gkw-speaker-small').first().next();
        this.items[2] = widget.find('.gkw-speakers .gkw-speaker-big').first();
        this.items[3] = widget.find('.gkw-speakers-small-right .gkw-speaker-small').first();
        this.items[4] = widget.find('.gkw-speakers-small-right .gkw-speaker-small').first().next();
        // 
        this.availableItems = widget.find('.gkw-rest-speakers .gkw-speaker');
        //
        var $this = this;
        //
        jQuery(this.items).each(function (i, el) {
            jQuery(el).removeClass('speaker-hide');
        });
        // run the animation
        setTimeout(function () {
            $this.gkChangeSpeakers();
        }, this.anim_interval + 400);

        jQuery(this.items).each(function (i, el) {
            jQuery(el).mouseenter(function () {
                $this.hover = true;
            });

            jQuery(el).mouseleave(function () {
                $this.hover = false;
            });
        });
    } else {
        // prepare handlers
        this.items[0] = widget.find('.gkw-speakers-small-left .gkw-speaker-small').first();
        this.items[1] = widget.find('.gkw-speakers-small-left .gkw-speaker-small').first().next();
        this.items[2] = widget.find('.gkw-speakers .gkw-speaker-big').first();
        this.items[3] = widget.find('.gkw-speakers-small-right .gkw-speaker-small').first();
        this.items[4] = widget.find('.gkw-speakers-small-right .gkw-speaker-small').first().next();

        jQuery(this.items).each(function (i, el) {
            jQuery(el).removeClass('speaker-hide');
        });
    }
}

GK_Speakers.prototype.gkChangeSpeakers = function () {
    //
    var $this = this;
    //
    if (!this.hover) {
        // hide speakers
        jQuery(this.items).each(function (i, el) {
            jQuery(el).addClass('speaker-hide');
        });

        if (this.current < this.total - 1) {
            this.current += 1;
        } else {
            this.current = 0;
        }

        setTimeout(function () {
            var IDs = [0, 0, 0, 0, 0];
            IDs[4] = $this.current;
            totalOffset = $this.total;

            IDs[3] = ($this.current - 1 < 0) ? --totalOffset : $this.current - 1;
            IDs[2] = ($this.current - 2 < 0) ? --totalOffset : $this.current - 2;
            IDs[1] = ($this.current - 3 < 0) ? --totalOffset : $this.current - 3;
            IDs[0] = ($this.current - 4 < 0) ? --totalOffset : $this.current - 4;

            jQuery($this.items[0]).html(jQuery($this.availableItems[IDs[0]]).html());
            jQuery($this.items[1]).html(jQuery($this.availableItems[IDs[1]]).html());
            jQuery($this.items[2]).html(jQuery($this.availableItems[IDs[2]]).html());
            jQuery($this.items[3]).html(jQuery($this.availableItems[IDs[3]]).html());
            jQuery($this.items[4]).html(jQuery($this.availableItems[IDs[4]]).html());
        }, 600);

        // show speakers
        setTimeout(function () {
            jQuery($this.items).each(function (i, el) {
                jQuery(el).removeClass('speaker-hide');
            });
        }, this.anim_speed + 750);
    }
    //
    setTimeout(function () {
        $this.gkChangeSpeakers();
    }, this.anim_interval + 800);
};