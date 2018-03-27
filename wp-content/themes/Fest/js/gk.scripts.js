/**
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
(function () {
    "use strict";
    jQuery.cookie = function (key, value, options) {

        // key and at least value given, set cookie...
        if (arguments.length > 1 && String(value) !== "[object Object]") {
            options = jQuery.extend({}, options);

            if (value === null || value === undefined) {
                options.expires = -1;
            }

            if (typeof options.expires === 'number') {
                var days = options.expires,
                    t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }

            value = String(value);

            return (document.cookie = [
                encodeURIComponent(key), '=',
                options.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }

        // key and possibly options given, get cookie...
        options = value || {};
        var result, decode = options.raw ? function (s) {
                return s;
            } : decodeURIComponent;
        return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
    };

    /**
     *
     * Template scripts
     *
     **/

    // onDOMLoadedContent event
    jQuery(document).ready(function () {
        // Back to Top Scroll
        jQuery('#gk-top-link').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        // Thickbox use
        jQuery(document).ready(function () {
            if (typeof tb_init !== "undefined") {
                tb_init('div.wp-caption a'); //pass where to apply thickbox
            }
        });
        // style area
        if (jQuery('#gk-style-area')) {
            jQuery('#gk-style-area div').each(function () {
                jQuery(this).find('a').each(function () {
                    jQuery(this).click(function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                        changeStyle(jQuery(this).attr('href').replace('#', ''));
                    });
                });
            });
        }
        // font-size switcher
        if (jQuery('#gk-font-size') && jQuery('#gk-mainbody')) {
            var current_fs = 100;
            jQuery('#gk-mainbody').css('font-size', current_fs + "%");

            jQuery('#gk-increment').click(function (e) {
                e.stopPropagation();
                e.preventDefault();

                if (current_fs < 150) {
                    jQuery('#gk-mainbody').animate({
                        'font-size': (current_fs + 10) + "%"
                    }, 200);
                    current_fs += 10;
                }
            });

            jQuery('#gk-reset').click(function (e) {
                e.stopPropagation();
                e.preventDefault();

                jQuery('#gk-mainbody').animate({
                    'font-size': "100%"
                }, 200);
                current_fs = 100;
            });

            jQuery('#gk-decrement').click(function (e) {
                e.stopPropagation();
                e.preventDefault();

                if (current_fs > 70) {
                    jQuery('#gk-mainbody').animate({
                        'font-size': (current_fs - 10) + "%"
                    }, 200);
                    current_fs -= 10;
                }
            });
        }

        // Function to change styles

        function changeStyle(style) {
            var file = $GK_TMPL_URL + '/css/' + style;
            jQuery('head').append('<link rel="stylesheet" href="' + file + '" type="text/css" />');
            jQuery.cookie($GK_TMPL_NAME + '_style', style, {
                expires: 365,
                path: '/'
            });
        }

        // Responsive tables
        jQuery('article section table').each(function (i, table) {
            table = jQuery(table);
            var heads = table.find('thead th');
            var cells = table.find('tbody td');
            var heads_amount = heads.length;
            // if there are the thead cells
            if (heads_amount) {
                var cells_len = cells.length;
                for (var j = 0; j < cells_len; j++) {
                    var head_content = jQuery(heads.get(j % heads_amount)).text();
                    jQuery(cells.get(j)).html('<span class="gk-table-label">' + head_content + '</span>' + jQuery(cells.get(j)).html());
                }
            }
        });
    });


    // Template animations
    Array.prototype.shuffle = function () {
        var len = this.length;
        var i = len;
        while (i--) {
            var p = parseInt(Math.random() * len, 10);
            var t = this[i];
            this[i] = this[p];
            this[p] = t;
        }
    };

    jQuery(window).load(function () {
        jQuery('.gk-animation').each(function (i, el) {
            new GKAnimation(jQuery(el));
        });

        if (jQuery('.gk-sponsors').length) {
            var sponsorsLoaded = false;

            jQuery(window).scroll(function () {
                if (!sponsorsLoaded) {
                    var currentPosition = jQuery(window).scrollTop();
                    var sponsorsWrap = jQuery('.gk-sponsors').first();
                    if (currentPosition + jQuery(window).height() - 200 >= sponsorsWrap.offset().top) {
                        var elements = [];

                        for (var i = 0; i < sponsorsWrap.find('div').first().find('a').length; i++) {
                            elements.push(i);
                        }

                        elements.shuffle();

                        var sponsorsArray = sponsorsWrap.find('div').first().find('a');

                        for (var j = 0; j < elements.length; j++) {
                            new GKAnimateSponsor(sponsorsArray, elements, j);
                        }

                        sponsorsLoaded = true;
                    }
                }
            });
        }

        if (jQuery('.page-event').length && jQuery('.gk-sponsors-wrap').length) {
            var sponsors = jQuery('.gk-sponsors-wrap');
            var logos = [];
            //
            sponsors.each(function (i, el) {
                jQuery(el).find('a').each(function (j, elm) {
                    logos.push(elm);
                });
            });
            //
            var j = 0;
            jQuery(logos).each(function (x, elm) {
                new GKAnimateSponsorLogo(elm, j);
                j++;
            });
        }

        setTimeout(function () {
            if (jQuery('.gk-jscounter').length) {
                jQuery('.gk-jscounter').each(function (i, el) {
                    new GKCounter(jQuery(el));
                });
            }
        }, 250);
    });

    var GKAnimateSponsorLogo = function (logo, i) {
        setTimeout(function () {
            jQuery(logo).addClass('active');
        }, i * 65);
    };

    var GKAnimateSponsor = function (sponsorsArray, elements, j) {
        setTimeout(function () {
            var sponsor = jQuery(sponsorsArray[elements[j]]);
            sponsor.addClass('active');
        }, j * 50);
    };

    function GKAnimation(element) {
        //
        this.elements = null;
        this.elementsProperties = [];
        this.wrapper = null;
        this.wrapperArea = null;
        this.wrapperHeight = null;
        this.wrapperWrap = null;
        // set the main parallax wrapper
        this.wrapper = element;
        // set the wrapper height
        this.wrapperHeight = parseInt(this.wrapper.attr('data-height'), 10);
        // set the wrapper wrap
        this.wrapperWrap = this.wrapper.find('div').first();
        // show the area
        this.show();
    }
    // Show the parallax area
    GKAnimation.prototype.show = function () {
        var $this = this;
        this.wrapper.addClass('loaded');
        this.wrapperWrap.css('overflow', 'visible');

        // set the elements
        this.initElements();

        this.wrapperWrap.animate({
            'height': this.wrapperHeight
        }, 300, function () {
            $this.wrapper.addClass('displayed');
        });
    };
    // Initialize the objects inside parallax area
    GKAnimation.prototype.initElements = function () {
        var elements = this.wrapperWrap.children();
        var animationStack = [];
        //
        elements.each(function (i, element) {
            element = jQuery(element);
            //
            var delay = element.attr('data-delay') || 500;
            var time = element.attr('data-time') || 500;
            var start = {};
            var end = {};

            if (element.attr('data-start')) {
                start = jQuery.parseJSON(element.attr('data-start').replace(new RegExp("'", 'g'), '"'));
                end = jQuery.parseJSON(element.attr('data-end').replace(new RegExp("'", 'g'), '"'));
                //
                element.css(start);
            }
            //
            animationStack.push([element, end, time, delay]);
        });
        //
        var $this = this;
        //
        jQuery.each(animationStack, function (i, animation) {
            $this.animate(animation);
        });
    };
    // Animation function connected with the onScroll Window event
    GKAnimation.prototype.animate = function (animation) {
        setTimeout(function () {
            animation[0].animate(animation[1], animation[2]);

            if (animation[0].hasClass('gk-scale-up')) {
                animation[0].removeClass('gk-scale-up');
            }
        }, animation[3]);
    };


    function GKCounter(el) {
        this.final = null;
        this.element = null;
        this.finalText = '';
        this.dcount = null;
        this.hcount = null;
        this.mcount = null;
        this.scount = null;
        this.tempDays = 0;
        this.tempHours = 0;
        this.tempMins = 0;
        this.tempSecs = 0;
        // set the element handler
        this.element = el;
        // get the date and time
        var dateEnd = this.element.attr('data-dateend');
        var timeEnd = this.element.attr('data-timeend');
        // parse the date and time
        dateEnd = dateEnd.split('-');
        timeEnd = timeEnd.split(':');
        // get the timezone of the date
        var dateTimezone = -1 * parseInt(this.element.attr('data-timezone'), 10) * 60;
        // calculate the final date timestamp
        this.final = Date.UTC(dateEnd[2], (dateEnd[1] * 1) - 1, dateEnd[0], timeEnd[0], timeEnd[1]);
        //
        // calculate the final date according to user timezone
        //
        // - get the user timezone
        var tempd = new Date();
        var userTimezone = tempd.getTimezoneOffset();
        var newTimezoneOffset = 0;
        // if the timezones are equal - do nothing, in the other case we need calculations:
        if (dateTimezone !== userTimezone) {
            newTimezoneOffset = userTimezone - dateTimezone;
            // calculate new timezone offset to miliseconds
            newTimezoneOffset = newTimezoneOffset * 60 * 1000;
        }
        // calculate the new final time according to time offset
        this.final = this.final + newTimezoneOffset;

        //
        // So now we know the final time - let's calculate the base time for the counter:
        //

        // create the new date object
        var d = new Date();
        // calculate the current date timestamp
        var current = Date.UTC(d.getFullYear(), d.getMonth(), d.getDate(), d.getHours(), d.getMinutes(), d.getSeconds());

        //
        // calculate the difference between the dates
        //
        var diff = this.final - current;

        // if the difference is smaller than 3 seconds - then the counting was ended
        if (diff < 30 * 1000) {
            this.finalText = this.element.html();
            this.element.html('');
            this.countingEnded();
        } else {
            // in other case - let's calculate the difference in the days, hours, minutes and seconds
            var leftDays = 0;
            var leftHours = 0;
            var leftMinutes = 0;
            var leftSeconds = 0;

            leftDays = Math.floor((1.0 * diff) / (24 * 60 * 60 * 1000));

            var tempDiff = diff - (leftDays * 24 * 60 * 60 * 1000);
            leftHours = Math.floor(tempDiff / (60 * 60 * 1000));
            tempDiff = tempDiff - (leftHours * 60 * 60 * 1000);
            leftMinutes = Math.floor(tempDiff / (60 * 1000));
            tempDiff = tempDiff - (leftMinutes * 60 * 1000);
            leftSeconds = Math.floor(tempDiff / 1000);
            // initialize the structure
            this.initCounter();
            // set the counter handlers
            this.dcount = this.element.find('.gk-jscounter-days strong').first();
            this.hcount = this.element.find('.gk-jscounter-hours strong').first();
            this.mcount = this.element.find('.gk-jscounter-min strong').first();
            this.scount = this.element.find('.gk-jscounter-sec strong').first();
            // run the initial animation
            this.tick();
        }
    }

    // function used to create the counter structure
    GKCounter.prototype.initCounter = function () {
        // init the structure
        this.finalText = this.element.html();
        // get the texts translations (if available)
        var dtext = this.element.attr('data-daystext') || "days";
        var htext = this.element.attr('data-hourstext') || "hours";
        var mtext = this.element.attr('data-mintext') || "min.";
        var stext = this.element.attr('data-sectext') || "sec.";
        //
        this.element.html('<div class="gk-jscounter-days"><strong>00</strong><small>' + dtext + '</small></div><div class="gk-jscounter-hours"><strong>00</strong><small>' + htext + '</small></div><div class="gk-jscounter-min"><strong>00</strong><small>' + mtext + '</small></div><div class="gk-jscounter-sec"><strong>00</strong><small>' + stext + '</small></div>');
    };

    // function used to tick the counter ;-)
    GKCounter.prototype.tick = function () {
        // create the new date object
        var d = new Date();
        // calculate the current date timestamp
        var current = Date.UTC(d.getFullYear(), d.getMonth(), d.getDate(), d.getHours(), d.getMinutes(), d.getSeconds());
        //
        // calculate the difference between the dates
        //
        var diff = this.final - current;

        // if the difference is smaller than 1 second - then the counting was ended
        if (diff < 1 * 1000) {
            this.countingEnded();
        } else {
            // in other case - let's calculate the difference in the days, hours, minutes and seconds
            var leftDays = 0;
            var leftHours = 0;
            var leftMinutes = 0;
            var leftSeconds = 0;

            leftDays = Math.floor((1.0 * diff) / (24 * 60 * 60 * 1000));
            var tempDiff = diff - (leftDays * 24 * 60 * 60 * 1000);
            leftHours = Math.floor(tempDiff / (60 * 60 * 1000));
            tempDiff = tempDiff - (leftHours * 60 * 60 * 1000);
            leftMinutes = Math.floor(tempDiff / (60 * 1000));
            tempDiff = tempDiff - (leftMinutes * 60 * 1000);
            leftSeconds = Math.floor(tempDiff / 1000);

            this.dcount.text(((leftDays < 10) ? '0' : '') + leftDays);
            this.hcount.text(((leftHours < 10) ? '0' : '') + leftHours);
            this.mcount.text(((leftMinutes < 10) ? '0' : '') + leftMinutes);
            this.scount.text(((leftSeconds < 10) ? '0' : '') + leftSeconds);

            var $this = this;

            setTimeout(function () {
                $this.tick();
            }, 1000);
        }
    };

    // function used when the time is up ;-)
    GKCounter.prototype.countingEnded = function () {
        // set the H3 element with the final text
        this.element.html('<h3>' + this.finalText + '</h3>');
    };
})();