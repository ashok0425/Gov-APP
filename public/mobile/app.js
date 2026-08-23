/**
 * Mobile web app behaviour — the browser stand-ins for the Flutter widgets:
 * CarouselSlider, showModalBottomSheet, the paginated ListView and Share.
 */
(function () {
    'use strict';

    /* ------------------------------------------------------------ carousel
       CustomSlider: infinite loop, 5s autoplay, 800ms ease, tappable dots.
       The first slide is cloned onto the end so the loop always slides
       forward — even a single banner keeps auto-scrolling. */
    function initCarousel(root) {
        var track = root.querySelector('.carousel-track');
        var dots = Array.prototype.slice.call(root.querySelectorAll('.carousel-dot'));
        var count = track.children.length;
        if (!count) return;

        track.appendChild(track.children[0].cloneNode(true));

        var index = 0;
        var timer = null;

        function render(anim) {
            track.classList.toggle('no-anim', anim === false);
            track.style.transform = 'translateX(' + -index * 100 + '%)';
            dots.forEach(function (dot, i) {
                dot.classList.toggle('is-active', i === index % count);
            });
        }

        function go(next) {
            index = next > count || next < 0 ? (next + count) % count : next;
            render(true);

            // Landed on the clone: snap back to the real first slide once
            // the 800ms slide has finished, so the next tick moves forward.
            if (index === count) {
                setTimeout(function () {
                    if (index !== count) return;
                    index = 0;
                    render(false);
                }, 850);
            }
        }

        function start() {
            stop();
            timer = setInterval(function () {
                go(index + 1);
            }, 5000);
        }

        function stop() {
            if (timer) clearInterval(timer);
            timer = null;
        }

        dots.forEach(function (dot, i) {
            dot.addEventListener('click', function () {
                go(i);
                start();
            });
        });

        // Horizontal swipe, same direction as the native slider.
        var startX = null;
        var startY = null;

        function swallow(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        root.addEventListener(
            'touchstart',
            function (e) {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                stop();
            },
            { passive: true },
        );

        root.addEventListener(
            'touchend',
            function (e) {
                if (startX === null) return;
                var dx = e.changedTouches[0].clientX - startX;
                var dy = e.changedTouches[0].clientY - startY;
                if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
                    go(dx < 0 ? index + 1 : index - 1);
                    // Slides can be links (breaking news); swallow the click
                    // the browser fires after the swipe so it doesn't navigate.
                    root.addEventListener('click', swallow, { capture: true, once: true });
                }
                startX = null;
                start();
            },
            { passive: true },
        );

        // Pause while the page is in the background so slides don't pile up.
        document.addEventListener('visibilitychange', function () {
            document.hidden ? stop() : start();
        });

        render(false);
        start();
    }

    /* -------------------------------------------------------- bottom sheet
       Drives both the menu sheet and the palika contact sheet.             */
    function initSheet(sheetId, scrimId, openerId) {
        var sheet = document.getElementById(sheetId);
        var scrim = document.getElementById(scrimId);
        var opener = document.getElementById(openerId);
        if (!sheet || !scrim || !opener) return;

        function open() {
            sheet.classList.add('is-open');
            scrim.classList.add('is-open');
        }

        function close() {
            sheet.classList.remove('is-open');
            scrim.classList.remove('is-open');
        }

        opener.addEventListener('click', open);
        scrim.addEventListener('click', close);

        // Drag the sheet down to dismiss it, like enableDrag: true. Only the
        // handle drags, so a scrollable sheet body still scrolls.
        var dragStart = null;
        var handle = sheet.querySelector('.sheet-handle') || sheet;

        handle.addEventListener(
            'touchstart',
            function (e) {
                dragStart = e.touches[0].clientY;
            },
            { passive: true },
        );

        handle.addEventListener(
            'touchmove',
            function (e) {
                if (dragStart === null) return;
                var dy = e.touches[0].clientY - dragStart;
                if (dy > 0) sheet.style.transform = 'translate(-50%, ' + dy + 'px)';
            },
            { passive: true },
        );

        handle.addEventListener(
            'touchend',
            function (e) {
                if (dragStart === null) return;
                var dy = e.changedTouches[0].clientY - dragStart;
                sheet.style.transform = '';
                if (dy > 90) close();
                dragStart = null;
            },
            { passive: true },
        );

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') close();
        });
    }

    /* ------------------------------------------------------ infinite scroll
       Mirrors _onScroll in news_screen.dart: fetch the next page at the end. */
    function initInfiniteList() {
        var list = document.getElementById('infinite-list');
        if (!list) return;

        var sentinel = document.getElementById('infinite-sentinel');
        var page = parseInt(list.dataset.page, 10) || 1;
        var hasMore = list.dataset.hasMore === 'true';
        var loading = false;

        if (!hasMore) {
            if (sentinel) sentinel.remove();
            return;
        }

        function load() {
            if (loading || !hasMore) return;
            loading = true;
            page += 1;

            var url = list.dataset.url + (list.dataset.url.indexOf('?') === -1 ? '?' : '&') + 'page=' + page;

            fetch(url, { headers: { Accept: 'application/json' } })
                .then(function (r) {
                    return r.json();
                })
                .then(function (data) {
                    list.insertAdjacentHTML('beforeend', data.html);
                    hasMore = data.hasMore;
                    loading = false;
                    if (!hasMore && sentinel) sentinel.remove();
                })
                .catch(function () {
                    // Say so when the network is gone; the next scroll retries.
                    page -= 1;
                    loading = false;
                    if (sentinel && !navigator.onLine) {
                        sentinel.innerHTML = '<p class="state-hint" style="padding:12px 0">इन्टरनेट जडान छैन — No internet connection</p>';
                    }
                });
        }

        if ('IntersectionObserver' in window && sentinel) {
            new IntersectionObserver(
                function (entries) {
                    if (entries[0].isIntersecting) load();
                },
                { rootMargin: '200px' },
            ).observe(sentinel);
        } else {
            var scroller = document.querySelector('.scroll-area') || window;
            scroller.addEventListener('scroll', function () {
                var el = scroller === window ? document.documentElement : scroller;
                if (el.scrollTop + el.clientHeight >= el.scrollHeight - 200) load();
            });
        }
    }

    /* --------------------------------------------------------------- share */
    function initShare() {
        var btn = document.getElementById('share-app');
        if (!btn) return;

        btn.addEventListener('click', function () {
            var url = btn.dataset.url;
            var text = 'Check out this app: ' + url;

            if (navigator.share) {
                navigator.share({ title: 'Try this app!', text: text, url: url }).catch(function () {});
                return;
            }

            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function () {
                    toast('Link copied');
                });
                return;
            }

            window.open(url, '_blank');
        });
    }

    /* --------------------------------------------------------------- toast */
    function toast(message) {
        var el = document.createElement('div');
        el.textContent = message;
        el.style.cssText =
            'position:fixed;left:50%;bottom:88px;transform:translateX(-50%);background:#323232;' +
            'color:#fff;padding:10px 16px;border-radius:4px;z-index:200;font-size:14px;';
        document.body.appendChild(el);
        setTimeout(function () {
            el.remove();
        }, 2200);
    }

    /* ------------------------------------------------------- image fallback
       Stands in for CachedNetworkImage's errorWidget.                       */
    function initImageFallbacks() {
        document.querySelectorAll('img[data-fallback]').forEach(function (img) {
            img.addEventListener('error', function handle() {
                img.removeEventListener('error', handle);
                img.src = img.dataset.fallback;
            });
        });
    }

    /* ------------------------------------------------- responsive iframes */
    function initEmbeds() {
        document.querySelectorAll('.rich iframe').forEach(function (frame) {
            if (frame.parentElement.classList.contains('video-embed')) return;
            var wrap = document.createElement('div');
            wrap.className = 'video-embed';
            frame.parentNode.insertBefore(wrap, frame);
            wrap.appendChild(frame);
        });

        // Wide tables scroll on their own rather than stretching the page.
        document.querySelectorAll('.rich table').forEach(function (table) {
            if (table.parentElement.classList.contains('table-scroll')) return;
            var wrap = document.createElement('div');
            wrap.className = 'table-scroll';
            table.parentNode.insertBefore(wrap, table);
            wrap.appendChild(table);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.carousel').forEach(initCarousel);
        initSheet('contact-sheet', 'contact-scrim', 'contact-open');
        initInfiniteList();
        initShare();
        initImageFallbacks();
        initEmbeds();
    });
})();
