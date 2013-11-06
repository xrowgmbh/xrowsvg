/**
 * jQuery Browser
 *
 * Description:   Get some information about the current used browser,
 *                its operating system and its available plugins.
 * Version:       10.12.02 (based on original jquery.browser)
 * Date:          2010-12-02
 * Copyright:     (c) 2010 Michael Keck
 *                http://www.michaelkeck.de/
 * License:       Dual licensed under the MIT or GPL Version 2 licenses.
 */
(function($) {

    if (typeof($.browser) === 'undefined' || !$.browser) {
        var browser = {};
        $.extend(browser);
    }

    /**
     * Check the current used useragent and return its informations
     * @return $.browser
     */
    $.browserTest = function (a, z) {
        /* Plugins to Check */
        var l = {
                flash:        { activex: 'ShockwaveFlash.ShockwaveFlash', plugin: /flash/gim },
                java:         { activex: navigator.javaEnabled(),         plugin: /java/gim },
                pdf:          { activex: 'PDF.PdfCtrl',                   plugin: /adobe\s?acrobat/gim },
                quicktime:    { activex: 'QuickTime.QuickTime',           plugin: /quicktime/gim },
                realplayer:   { activex: 'RealPlayer',                    plugin: /realplayer/gim },
                silverlight:  { activex: ['AgControl.AgControl'],         plugin: /silverlight/gim },
                shockwave:    { activex: 'SWCtl.SWCtl',                   plugin: /shockwave/gim  },
                windowsmedia: { activex: 'WMPlayer.OCX',                  plugin: /(windows\smedia)|(Microsoft)/gim }
                /**
                 * You can add more plugins to check.
                 * Example:
                 *     nameoftheplugin : { activex: MixedSearch, plugin: MixedSearch }
                 * Info:
                 *     activex    searches after Microsoft ActiveX in Ineternet Explorer
                 *     plugin     seraches after a Plugin in other browsers, like Gecko, WebKit, Khtml, Opera ...
                 */
            };

        /* Default Vars */
        var u = 'unknown', ua = (navigator.userAgent || navigator.vendor || window.opera), x = 'X';

        /* Check Plugins */
        var p = function(p) {
                if (window.ActiveXObject) {
                    try {
                        new ActiveXObject(l[p].activex);
                        $.browser[p] = true;
                    } catch(e) {
                        $.browser[p] = false;
                    }
                } else {
                    $.each(navigator.plugins, function() {
                        if (this.name.match(l[p].plugin)) {
                            $.browser[p] = true;
                            return false;
                        } else {
                            $.browser[p] = false;
                        }
                    });
                }
            };

        /* Search and Replace */
        var m = function (r, h) {
                for (var i = 0; i < h.length; i = i + 1) {
                    r = r.replace(h[i][0], h[i][1]);
                }
                return r;
            };

        /* Get name, version and className of the current used Browser */
        var c = function (i, a, b, c) {
                var r = {
                    name: m((a.exec(i) || [u, u])[1], b)
                }, t = '';
                r[r.name] = true;
                r.version = (c.exec(i) || [x, x, x, x])[3];

                if (r.name.match(/safari/) && r.version > 400) {
                    r.version = '2.0';
                }
                if (r.name === 'presto') {
                    r.version = ($.browser.version > 9.27) ? 'futhark' : 'linear_b';
                }
                t = r.version;
                if (r.version.indexOf('.') !== -1) {
                    t = r.version.split('.');
                    if (t.length < 1) {
                        t = r.version + '.0';
                    } else {
                        t = t[0] + '.' + t[1];
                    }
                }
                r.version = (r.version !== x) ? (r.version + '').substr(0, 1) : x;
                r.cssname = r.name + r.version;
                r.version = parseFloat(t, 10) || 0;
                return r;
            };

        /* Pregmatch the name of the browser */
        a = (a.match(/Opera|Navigator|Minefield|KHTML|Chrome/)
                ? m(a, [[/(Firefox|MSIE|KHTML,\slike\sGecko|Konqueror)/, ''], ['Chrome Safari', 'Chrome'], ['KHTML', 'Konqueror'], ['Minefield', 'Firefox'], ['Navigator', 'Netscape']])
                : a
            ).toLowerCase();

        /* Store the name, version and classname of the browser in $.browser */
		$.browser = $.extend(
            (!z) ? $.browser : {}, c(a,
                /(camino|chrome|firefox|netscape|konqueror|lynx|msie|opera|safari)/,
                [],
                /(camino|chrome|firefox|netscape|netscape6|opera|version|konqueror|lynx|msie|safari)(\/|\s)([a-z0-9\.\+]*?)(\;|dev|rel|\s|$)/
            )
        );

        /* Store the render-engine of the browser in $.layout */
		$.layout = c(a,
            /(gecko|konqueror|msie|opera|webkit)/,
            [['konqueror', 'khtml'], ['msie', 'trident'], ['opera', 'presto']],
            /(applewebkit|rv|konqueror|msie)(\:|\/|\s)([a-z0-9\.]*?)(\;|\)|\s)/
        );

        /* Store the operating system in $.os */
		$.os = { name: (/(win|mac|linux|sunos|solaris|iphone|ipad|ipod)/.exec(navigator.platform.toLowerCase()) || [u])[0].replace('sunos', 'solaris') };

        /**
         * Check if the browser has a touchscreen and can support it
         */
        $.browser.hastouch = ('ontouchstart' in window) ? true : false;

        /**
         * Check if device is an iThing device or browser is
         * running on an iThing.
         * $.browser.ithing = true, if its an iPad, iPhone or iPod
         */
        $.browser.ithing = (!!(navigator.userAgent.match(/iPad/i) !== null || navigator.userAgent.match(/iPhone/i) !== null || navigator.userAgent.match(/iPod/i) !== null) || $.os.name == 'ipad' || $.os.name == 'iphone' || $.os.name == 'ipod') ? true : false;

        /**
         * Check if device is a mobile device or browser is
         * running on a mobile device.
         * Note: if $.browser.ithing == true  then  $.browser.mobile = true
         */
        $.browser.mobile = (/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(ua) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(ua.substr(0,4)) || $.browser.ithing);

        /**
         * Check if we have on a mobile device with a touch screen
         * Note: if $.browser.ithing == true
         *       or $.browser.hastouch == true
         *       then $.browser.touch = true
         */
        $.browser.touch = (($.browser.mobile && ($.browser.hastouch || $.browser.ithing)) ? true : false);

        /**
         * Get the absolute url of the current
         * window.location.href object or an
         * optional given path
         * and store it in $.browser.hostpath
         * @param  {string} p  [optional pathname]
         * @return {string} absolute url
         */
        $.browser.realpath = function(p) {
            var a = [], b = [], r = window.location.href, t = '', x = 0;
            if (p) {
                t = (p + '').replace('\\', '/');
                if (t.indexOf('://') !== -1) {
                    x = 1;
                }
                if (!x) {
                    t = r.substring(0, r.lastIndexOf('/') + 1) + t;
                }
            } else {
                t = r.substring(0, r.lastIndexOf('/') + 1);
            }
            a = t.split('/');
            for (var k in a) {
                if (a[k] == '.') {
                    continue;
                }
                if (a[k] == '..') {
                    if (b.length > 3) {
                        b.pop();
                    }
                }
                else {
                    if ((b.length < 2) || (a[k] !== '')) {
                        b.push(a[k]);
                    }
                }
            }
            if (p) {
                return b.join('/');
            }
            $.browser.hostpath = b.join('/');
        };


        /**
         * Get the base filename of the current window.location.href object
         * and store it in $.browser.basename.
         */
        $.browser.basename = (function() {
            var r = window.location.href;
            r = r.substring(r.lastIndexOf('/') + 1, r.length);
            $.browser.filename = r;
            if (r.lastIndexOf('?') !== -1) {
                r = r.substring(0, r.lastIndexOf('?'));
            } else if (r.lastIndexOf('#') !== -1) {
                r = r.substring(0, r.lastIndexOf('#'));
            }
            return r;
        })();


        /**
         * This function extracts all required informations
         * from a file.
         * Example:
         *     // your document.location.href would return
         *     // http://www.domain.com/page/media/fotos/index.html
         *     var fileinfo = $.browser.fileinfo('media/fotos/myfoto.jpg');
         *     // would be
         *     fileinfo = {
         *         basename : 'myfoto.jpg',
         *         dirname  : '/media/fotos',
         *         filename : 'myfoto',
         *         filetype : 'jpg',
         *         filelink : 'http://www.domain.com/page/media/fotos/myfoto.jpg'
         *         realpath : '/page/media/fotos'
         *     };
         * @param {string} file to check
         */
        $.browser.fileinfo = function(f) {
            var r = { 'basename': null, 'dirname' : null, 'filename': null, 'filetype': null, 'filelink': null, 'pathlink': null, 'realpath': null }, p = $.browser.hostpath, h = $.browser.hostaddr;
            if (!f) {
                f = window.location.href;
            }
            r.basename = f;
            if (f.indexOf('/') !== -1) {
                r.basename = f.substring(f.lastIndexOf('/') + 1, f.length);
            }
            r.filename = r.basename;
            if (r.basename.indexOf('.') !== -1) {
                r.filetype = r.basename.substring(r.basename.lastIndexOf('.') + 1, r.basename.length);
                r.filename = r.basename.substring(0, r.filename.length - r.filetype.length -1);
            }
            r.filelink = $.browser.realpath(f);
            r.pathlink = r.filelink.substring(0, r.filelink.lastIndexOf('/'));
            r.dirname  = r.pathlink.replace(p, '').substring(0, r.pathlink.lastIndexOf('/'));
            r.realpath = r.pathlink.replace(h, '').substring(0, r.pathlink.lastIndexOf('/'));
            if (r.dirname.substring(0, 1) !== '/') {
                r.dirname = '/' + r.dirname;
            }
            if (r.realpath.substring(0, 1) !== '/') {
                r.realpath = '/' + r.realpath;
            }
            return r;
        };


        /**
         * Checking, if the browser support some CSS3-definitions
         */
        $.browser.css3 = (function(e) {
            e = e || document.documentElement;
            var c = {
                'borderRadius' : 'border-radius',
                'borderImage'  : 'border-image',
                'boxShadow'    : 'box-shadow',
                'opacity'      : 'opacity',
                'overflowX'    : 'overflow-x',
                'overflowY'    : 'overflow-y',
                'textShadow'   : 'text-shadow'
            };
            var f = false, r = [], s = e.style, m = ['Moz', 'Webkit', 'Khtml', 'O', 'Ms'];
            for (var p in c) {
                var n = p, a = false;
                /* test standard property first */
                if (typeof(s[p]) == 'string') {
                    r[n] = [c[n].toLowerCase()];
                    f = true;
                    a = true;
                }
                /* test vendor specific properties */
                else {
                    /* capitalize */
                    p = p.charAt(0).toUpperCase() + p.slice(1);
                    for (var i = 0, l = m.length; i < l; i++) {
                        var t = m[i] + p;
                        if (typeof(s[t]) == 'string') {
                            r[n] = ['-' + m[i].toLowerCase() + '-' + c[n].toLowerCase()];
                            f = true;
                            a = true;
                        }
                    }
                }
                if (a !== true) {
                    r[n] = false;
                }
            }
            if (f) {
                return r;
            } else {
                return false;
            }
        })();


        /* Check browsers HTML5-support */
        $.browser.html5 = (typeof(HTMLVideoElement) !== undefined && typeof(HTMLAudioElement) !== undefined && typeof(HTMLCanvasElement) !== undefined) ? true : false;

        /* Protocol like 'http://' or 'https://' */
        $.browser.protocol = ((window.location.href.indexOf('://') !== -1) ? $.browser.protocol = window.location.href.substring(0, window.location.href.indexOf('://') + 3) : $.browser.protocol = 'file://');

        /* Real Hostname (without the 'www.') */
        $.browser.host = window.location.hostname.toLowerCase().replace(/(www.|ftp.|ftps.|mail.|mailto.|imap.|smtp.|pop.|pop3.)/gi, '');

        /* Original Hostname (perhabs with the 'www.') */
        $.browser.hostname = window.location.hostname.toLowerCase();

        /* Host-Address */
        $.browser.hostaddr = $.browser.protocol + $.browser.hostname + '/';

        /* Get the realpath of the current window.location.href */
        $.browser.realpath();

        /* Get the base filename of the current window.location.href  */
        $.browser.basename;

        /* Browser viewport */
        //$.browser.innerWidth  = $.browser.viewWidth  = (window.innerWidth || self.innerWidth || (document.documentElement && document.documentElement.clientWidth) || document.body.clientWidth);
        //$.browser.innerHeight = $.browser.viewHeight = (window.innerHeight || self.innerHeight || (document.documentElement && document.documentElement.clientHeight) || document.body.clientHeight);

        /* Available screen resultion of the current system browser running in */
        $.browser.screenWidth  = (screen.width || 0);
        $.browser.screenHeight = (screen.height || 0);

        /* Check Plugins */
        $.each(l, function(i, n) { p(i); });

	};

    /**
     * Init the browser check
     */
	$.browserTest(navigator.userAgent);

    /**
     * Compatibility for some other Plugins made by
     * Michael Keck (http://www.michaelkeck.de/)
     */
    //$.usragnt = $.browser;

    /**
     * DEBUGGING
     * --------------------------------------------
     *
     * var dbg = '';
     * for (var b in $.browser) {
     *    if (typeof($.browser[b]) == 'function') {
     *       continue;
     *   }
     *   if (typeof($.browser[b]) !== 'object') {
     *       dbg += b + '\t: ' + $.browser[b] + '\n';
     *   } else {
     *       dbg += b + ': ' + (($.browser[b]) ? true : false) + '\n';
     *       for (var bb in $.browser[b]) {
     *           dbg += '\t  ' + b + '.' + bb + '\t= ' + $.browser[b][bb] + '\n';
     *       }
     *   }
     * }
     * alert(dbg);
     */

})(jQuery);